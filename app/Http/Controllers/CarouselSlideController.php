<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarouselSlideRequest;
use App\Http\Requests\UpdateCarouselSlideRequest;
use App\Models\CarouselSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class CarouselSlideController extends Controller
{
    public function store(StoreCarouselSlideRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'image_url']);
        $data['image_path'] = $this->resolveImage($request);

        CarouselSlide::create($data);

        return back()->with('success', 'Slide berhasil ditambahkan.');
    }

    public function update(UpdateCarouselSlideRequest $request, CarouselSlide $carouselSlide): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'image_url']);

        if ($request->hasFile('image') && $request->file('image')->isValid() || $request->filled('image_url')) {
            $this->deleteStoredImage($carouselSlide->image_path);
            $data['image_path'] = $this->resolveImage($request);
        }

        $carouselSlide->update($data);

        return back()->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(CarouselSlide $carouselSlide): RedirectResponse
    {
        $this->deleteStoredImage($carouselSlide->image_path);

        $carouselSlide->delete();

        return back()->with('success', 'Slide berhasil dihapus.');
    }

    public function toggleActive(CarouselSlide $carouselSlide): RedirectResponse
    {
        $carouselSlide->update(['is_active' => ! $carouselSlide->is_active]);

        return back();
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }

    private function resolveImage(StoreCarouselSlideRequest|UpdateCarouselSlideRequest $request): ?string
    {
        $file = $request->file('image');

        if ($file && $file->isValid()) {
            // Use getPathname() instead of getRealPath() — getRealPath() returns false
            // on Windows (Laragon) for PHP temp upload files, causing ValueError.
            $tmpPath = $file->getPathname();

            if ($tmpPath && file_exists($tmpPath) && filesize($tmpPath) > 0) {
                $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                $filename = 'carousel/slide_'.uniqid('', true).'.'.$ext;
                Storage::disk('public')->put($filename, file_get_contents($tmpPath));

                return $filename;
            }
        }

        if ($request->filled('image_url')) {
            return $request->string('image_url')->trim()->toString() ?: null;
        }

        return null;
    }
}
