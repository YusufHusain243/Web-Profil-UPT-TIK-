<script setup>
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { ref, computed } from 'vue';
import { Search, X, ZoomIn, ChevronLeft, ChevronRight, Camera } from 'lucide-vue-next';

const activeCategory = ref('Semua');
const lightboxOpen = ref(false);
const lightboxIndex = ref(0);
const searchQuery = ref('');

const categories = ['Semua', 'Infrastruktur', 'Pengembangan Sistem', 'Workshop & Pelatihan', 'Kolaborasi & Kemitraan', 'Pemeliharaan'];

const galleryItems = [
    {
        id: 1,
        category: 'Infrastruktur',
        title: 'Upgrade Server Pusat Data UPR',
        description: 'Tim infrastruktur melakukan penggantian dan konfigurasi server blade generasi terbaru untuk meningkatkan kapasitas komputasi kampus.',
        date: 'Maret 2026',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80',
        tags: ['Server', 'Data Center', 'Infrastruktur'],
    },
    {
        id: 2,
        category: 'Workshop & Pelatihan',
        title: 'Workshop Keamanan Siber untuk Mahasiswa',
        description: 'Pelatihan keamanan digital yang diikuti oleh 120 mahasiswa dari berbagai fakultas. Membahas proteksi data pribadi dan perlindungan dari serangan siber.',
        date: 'Februari 2026',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1629904853893-c2c8981a1dc5?w=800&q=80',
        tags: ['Cybersecurity', 'Pelatihan', 'Mahasiswa'],
    },
    {
        id: 3,
        category: 'Pemeliharaan',
        title: 'Pemeliharaan Jaringan Fiber Optik Kampus',
        description: 'Kegiatan rutin pengecekan dan pemeliharaan kabel fiber optik yang menghubungkan seluruh gedung di Kampus Tanjung Nyaho.',
        date: 'Januari 2026',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=800&q=80',
        tags: ['Fiber Optik', 'Jaringan', 'Maintenance'],
    },
    {
        id: 4,
        category: 'Pengembangan Sistem',
        title: 'Review Sprint Pengembangan SIUBER v3',
        description: 'Sesi review sprint mingguan tim pengembang dalam peningkatan fitur Sistem Informasi Akademik (SIUBER) untuk tahun ajaran 2026/2027.',
        date: 'April 2026',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80',
        tags: ['SIUBER', 'Development', 'Agile'],
    },
    {
        id: 5,
        category: 'Kolaborasi & Kemitraan',
        title: 'Penandatanganan MoU dengan Google Cloud',
        description: 'Seremonial penandatanganan Memorandum of Understanding antara UPR dan Google Cloud untuk pengembangan infrastruktur cloud kampus.',
        date: 'Maret 2026',
        photographer: 'Dok. Humas UPR',
        image: 'https://images.unsplash.com/photo-1560472355-536de3962603?w=800&q=80',
        tags: ['MoU', 'Google Cloud', 'Kemitraan'],
    },
    {
        id: 6,
        category: 'Infrastruktur',
        title: 'Instalasi Access Point Wi-Fi di Gedung FKIP',
        description: 'Perluasan jaringan Eduroam dengan pemasangan 40 titik access point baru di seluruh lantai Gedung FKIP untuk meningkatkan kecepatan internet mahasiswa.',
        date: 'Februari 2026',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1606904825846-647eb07f5be2?w=800&q=80',
        tags: ['WiFi', 'Eduroam', 'FKIP'],
    },
    {
        id: 7,
        category: 'Workshop & Pelatihan',
        title: 'Pelatihan Microsoft 365 untuk Dosen',
        description: 'Bimtek penggunaan Microsoft Teams, SharePoint, dan OneDrive bagi 85 dosen UPR sebagai bagian dari program digitalisasi pembelajaran.',
        date: 'Januari 2026',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80',
        tags: ['Microsoft 365', 'Dosen', 'Pelatihan'],
    },
    {
        id: 8,
        category: 'Pemeliharaan',
        title: 'Audit Sistem Keamanan Jaringan Semesteran',
        description: 'Tim keamanan siber melakukan penetration testing dan audit menyeluruh terhadap infrastruktur jaringan dan server kampus secara berkala.',
        date: 'Desember 2025',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&q=80',
        tags: ['Security Audit', 'Pentest', 'Keamanan'],
    },
    {
        id: 9,
        category: 'Pengembangan Sistem',
        title: 'Peluncuran Aplikasi Mobile UPR Terbaru',
        description: 'Seremoni soft-launch aplikasi mobile UPR yang mengintegrasikan SIUBER, e-mail institusi, dan layanan kampus dalam satu platform.',
        date: 'November 2025',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&q=80',
        tags: ['Mobile App', 'UPR App', 'Inovasi'],
    },
    {
        id: 10,
        category: 'Kolaborasi & Kemitraan',
        title: 'Kunjungan Teknis ke Data Center Telkom',
        description: 'Kunjungan studi banding tim infrastruktur UPA TIK ke Telkom Data Center Indonesia untuk memperkuat kolaborasi dan adopsi teknologi terkini.',
        date: 'Oktober 2025',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&q=80',
        tags: ['Studi Banding', 'Telkom', 'Data Center'],
    },
    {
        id: 11,
        category: 'Workshop & Pelatihan',
        title: 'Kompetisi Hackathon SIBERAKAD 2025',
        description: 'UPA TIK menyelenggarakan Hackathon 48 jam bertema "Inovasi Digital untuk Kampus Inklusif" yang diikuti 30 tim mahasiswa dari seluruh fakultas.',
        date: 'September 2025',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800&q=80',
        tags: ['Hackathon', 'Kompetisi', 'Inovasi'],
    },
    {
        id: 12,
        category: 'Infrastruktur',
        title: 'Selesainya Pembangunan Ruang Server Baru',
        description: 'Peresmian ruang server baru dengan kapasitas 4x lipat lebih besar, sistem pendinginan presisi, dan redundansi daya ganda UPS.',
        date: 'Agustus 2025',
        photographer: 'Dok. UPA TIK',
        image: 'https://images.unsplash.com/photo-1573164713712-03790a178651?w=800&q=80',
        tags: ['Server Room', 'Infrastruktur', 'Peresmian'],
    },
];

const filteredItems = computed(() => {
    let result = galleryItems;
    if (activeCategory.value !== 'Semua') {
        result = result.filter(i => i.category === activeCategory.value);
    }
    if (searchQuery.value) {
        const q = searchQuery.value.toLowerCase();
        result = result.filter(i =>
            i.title.toLowerCase().includes(q) ||
            i.description.toLowerCase().includes(q) ||
            i.tags.some(t => t.toLowerCase().includes(q))
        );
    }
    return result;
});

const openLightbox = (index) => {
    lightboxIndex.value = index;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    lightboxOpen.value = false;
    document.body.style.overflow = '';
};

const prevImage = () => {
    lightboxIndex.value = (lightboxIndex.value - 1 + filteredItems.value.length) % filteredItems.value.length;
};

const nextImage = () => {
    lightboxIndex.value = (lightboxIndex.value + 1) % filteredItems.value.length;
};
</script>

<template>
    <UPAGuestLayout title="Galeri Kegiatan">
        <!-- Header -->
        <section class="pt-40 pb-20 bg-primary text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-96 h-96 bg-secondary rounded-full translate-x-1/2 -translate-y-1/2 blur-[100px]"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-secondary font-bold text-xs uppercase tracking-widest rounded-full mb-6 inline-block">Jejak Kerja Kami</span>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Galeri Kegiatan</h1>
                <p class="text-slate-300 max-w-2xl mx-auto text-lg leading-relaxed">
                    Sekilas pandang aktivitas dan kerja keras tim UPA TIK di balik layar — dari ruang server hingga ruang kelas.
                </p>

                <!-- Search -->
                <div class="max-w-xl mx-auto mt-10">
                    <div class="relative">
                        <Search class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari kegiatan, tag, atau deskripsi..."
                            class="w-full pl-14 pr-6 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-secondary"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Filter -->
        <section class="sticky top-20 z-30 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap gap-3 justify-center">
                    <button
                        v-for="cat in categories"
                        :key="cat"
                        @click="activeCategory = cat"
                        class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300"
                        :class="activeCategory === cat
                            ? 'bg-primary text-white shadow-lg shadow-primary/20'
                            : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-primary'"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Gallery Grid -->
        <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="filteredItems.length > 0" class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                    <div
                        v-for="(item, index) in filteredItems"
                        :key="item.id"
                        class="break-inside-avoid bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-2xl hover:border-primary/20 transition-all duration-500 group cursor-pointer"
                        @click="openLightbox(index)"
                    >
                        <!-- Image -->
                        <div class="relative overflow-hidden">
                            <img
                                :src="item.image"
                                :alt="item.title"
                                class="w-full object-cover group-hover:scale-110 transition-transform duration-700"
                                loading="lazy"
                            />
                            <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/40 transition-colors duration-500 flex items-center justify-center">
                                <ZoomIn class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow-2xl" />
                            </div>
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1.5 bg-primary/90 backdrop-blur-md text-white text-[10px] font-bold uppercase rounded-lg tracking-wider">{{ item.category }}</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors text-base leading-snug">{{ item.title }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4 leading-relaxed">{{ item.description }}</p>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span
                                    v-for="tag in item.tags"
                                    :key="tag"
                                    class="px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 text-[10px] font-bold rounded-md uppercase tracking-wider"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest border-t border-slate-50 dark:border-slate-700 pt-3">
                                <span class="flex items-center gap-1"><Camera class="w-3 h-3" /> {{ item.photographer }}</span>
                                <span>{{ item.date }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="py-24 text-center">
                    <Camera class="w-20 h-20 text-slate-200 dark:text-slate-800 mx-auto mb-6" />
                    <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-400">Tidak ada foto ditemukan</h3>
                    <p class="text-slate-400 mt-2">Coba gunakan kata kunci atau kategori yang berbeda.</p>
                    <button @click="searchQuery = ''; activeCategory = 'Semua'" class="mt-8 text-primary font-bold hover:underline">Reset Filter</button>
                </div>
            </div>
        </section>

        <!-- Lightbox -->
        <Teleport to="body">
            <Transition name="fade">
                <div
                    v-if="lightboxOpen"
                    class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4"
                    @click.self="closeLightbox"
                >
                    <!-- Close Button -->
                    <button
                        @click="closeLightbox"
                        class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors"
                    >
                        <X class="w-6 h-6 text-white" />
                    </button>

                    <!-- Prev Button -->
                    <button
                        @click="prevImage"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors"
                    >
                        <ChevronLeft class="w-6 h-6 text-white" />
                    </button>

                    <!-- Image & Info -->
                    <div class="max-w-5xl w-full mx-4">
                        <img
                            :src="filteredItems[lightboxIndex]?.image"
                            :alt="filteredItems[lightboxIndex]?.title"
                            class="w-full max-h-[70vh] object-contain rounded-2xl mb-6"
                        />
                        <div class="text-center text-white">
                            <h3 class="text-xl font-bold mb-2">{{ filteredItems[lightboxIndex]?.title }}</h3>
                            <p class="text-slate-400 text-sm">{{ filteredItems[lightboxIndex]?.description }}</p>
                            <p class="text-slate-500 text-xs mt-2 uppercase tracking-wider">{{ filteredItems[lightboxIndex]?.date }} · {{ filteredItems[lightboxIndex]?.photographer }}</p>
                        </div>
                    </div>

                    <!-- Next Button -->
                    <button
                        @click="nextImage"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors"
                    >
                        <ChevronRight class="w-6 h-6 text-white" />
                    </button>

                    <!-- Counter -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/50 text-sm font-medium">
                        {{ lightboxIndex + 1 }} / {{ filteredItems.length }}
                    </div>
                </div>
            </Transition>
        </Teleport>
    </UPAGuestLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
