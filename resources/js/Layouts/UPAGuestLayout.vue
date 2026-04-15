<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Facebook, Instagram, Linkedin, Youtube, Mail, Phone, MapPin, Send, ChevronDown, Download, BookOpen, Image, Activity } from 'lucide-vue-next';
import ThemeToggle from '@/Components/UPA/ThemeToggle.vue';

defineProps({
    title: String,
});

const isResourcesOpen = ref(false);
const isMobileOpen = ref(false);

const closeDropdown = () => { isResourcesOpen.value = false; };
const toggleMobile = () => { isMobileOpen.value = !isMobileOpen.value; };
</script>

<template>
    <Head :title="title ? `${title} - UPA TIK UPR` : 'UPA TIK - Universitas Palangka Raya'" />

    <div class="min-h-screen bg-surface dark:bg-surface-dark font-sans transition-colors duration-300">
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <Link href="/" prefetch class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <img src="/images/logo-upr.png" alt="UPR Logo" class="w-7 h-7" />
                        </div>
                        <div>
                            <span class="text-xl font-bold text-primary dark:text-white block leading-none">UPA TIK</span>
                            <span class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Univ. Palangka Raya</span>
                        </div>
                    </Link>

                    <!-- Desktop Nav -->
                    <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                        <Link :href="route('home')" prefetch class="text-sm font-semibold transition-colors" :class="route().current('home') ? 'text-primary dark:text-white border-b-2 border-primary pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">Beranda</Link>
                        <a href="/#about" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Tentang Kami</a>
                        <a href="/#services" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Layanan</a>
                        <a href="/#projects" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Portfolio</a>
                        <a href="/#news" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Berita & Inovasi</a>
                        <a href="/#helpdesk" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Bantuan</a>

                        <!-- Resources Dropdown -->
                        <div class="relative" @mouseenter="isResourcesOpen = true" @mouseleave="closeDropdown">
                            <button class="flex items-center gap-1 text-sm font-semibold transition-colors"
                                :class="route().current('downloads') || route().current('knowledge-base') || route().current('gallery') || route().current('status') ? 'text-primary dark:text-white' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">
                                Sumber Daya
                                <ChevronDown class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': isResourcesOpen }" />
                            </button>
                            <!-- Transparent bridge to prevent mouseleave gap -->
                            <div class="absolute top-full left-0 right-0 h-4"></div>
                            <Transition name="dropdown">
                                <div v-if="isResourcesOpen" class="absolute top-full left-1/2 -translate-x-1/2 mt-4 w-60 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700 p-2 z-50">
                                    <Link :href="route('downloads')" prefetch
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-primary/5 dark:hover:bg-slate-700/50 transition-colors group"
                                        :class="route().current('downloads') ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-slate-300'">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 group-hover:bg-primary/10 transition-colors shrink-0">
                                            <Download class="w-4 h-4 text-primary" />
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Pusat Unduhan</div>
                                            <div class="text-[10px] text-slate-400 font-normal">SOP, Formulir & Panduan</div>
                                        </div>
                                    </Link>
                                    <Link :href="route('knowledge-base')" prefetch
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-primary/5 dark:hover:bg-slate-700/50 transition-colors group"
                                        :class="route().current('knowledge-base') ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-slate-300'">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 group-hover:bg-primary/10 transition-colors shrink-0">
                                            <BookOpen class="w-4 h-4 text-primary" />
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Knowledge Base</div>
                                            <div class="text-[10px] text-slate-400 font-normal">Tutorial step-by-step</div>
                                        </div>
                                    </Link>
                                    <Link :href="route('gallery')" prefetch
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-primary/5 dark:hover:bg-slate-700/50 transition-colors group"
                                        :class="route().current('gallery') ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-slate-300'">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-slate-100 dark:bg-slate-700 group-hover:bg-primary/10 transition-colors shrink-0">
                                            <Image class="w-4 h-4 text-primary" />
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Galeri Kegiatan</div>
                                            <div class="text-[10px] text-slate-400 font-normal">Foto tim & aktivitas</div>
                                        </div>
                                    </Link>
                                    <div class="mx-2 my-1 border-t border-slate-100 dark:border-slate-700"></div>
                                    <Link :href="route('status')" prefetch
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold hover:bg-primary/5 dark:hover:bg-slate-700/50 transition-colors group"
                                        :class="route().current('status') ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-slate-300'">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-emerald-50 dark:bg-emerald-900/20 shrink-0 relative">
                                            <Activity class="w-4 h-4 text-emerald-500" />
                                            <span class="absolute -top-0.5 -right-0.5 w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm">Status Sistem</div>
                                            <div class="text-[10px] text-emerald-500 font-bold">● Semua Operasional</div>
                                        </div>
                                    </Link>
                                </div>
                            </Transition>
                        </div>

                        <!-- Separator line -->
                        <div class="w-px h-6 bg-slate-200 dark:bg-slate-800 mx-2"></div>

                        <Link :href="route('organization')" prefetch class="text-sm font-semibold transition-colors" :class="route().current('organization') ? 'text-primary dark:text-white border-b-2 border-primary pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">Organisasi</Link>
                        <Link :href="route('partners')" prefetch class="text-sm font-semibold transition-colors" :class="route().current('partners') ? 'text-primary dark:text-white border-b-2 border-primary pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">Mitra</Link>
                    </div>

                    <!-- Login & Theme -->
                    <div class="flex items-center space-x-4">
                        <ThemeToggle />

                        <!-- Mobile Menu Toggle -->
                        <button @click="toggleMobile" class="md:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <div class="w-5 space-y-1.5">
                                <span class="block h-0.5 bg-slate-700 dark:bg-slate-300 transition-all" :class="{ 'rotate-45 translate-y-2': isMobileOpen }"></span>
                                <span class="block h-0.5 bg-slate-700 dark:bg-slate-300 transition-all" :class="{ 'opacity-0': isMobileOpen }"></span>
                                <span class="block h-0.5 bg-slate-700 dark:bg-slate-300 transition-all" :class="{ '-rotate-45 -translate-y-2': isMobileOpen }"></span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <Transition name="mobile-menu">
                <div v-if="isMobileOpen" class="md:hidden border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-4 space-y-1">
                    <Link :href="route('home')" prefetch @click="isMobileOpen = false"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        Beranda
                    </Link>
                    <a href="/#about" @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Tentang Kami</a>
                    <a href="/#services" @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Layanan</a>
                    <a href="/#projects" @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Portfolio</a>
                    <a href="/#news" @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Berita & Inovasi</a>
                    <a href="/#helpdesk" @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Bantuan</a>
                    <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Sumber Daya</div>
                    <Link :href="route('downloads')" prefetch @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <Download class="w-4 h-4" /> Pusat Unduhan
                    </Link>
                    <Link :href="route('knowledge-base')" prefetch @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <BookOpen class="w-4 h-4" /> Knowledge Base
                    </Link>
                    <Link :href="route('gallery')" prefetch @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <Image class="w-4 h-4" /> Galeri Kegiatan
                    </Link>
                    <Link :href="route('status')" prefetch @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <Activity class="w-4 h-4" /> Status Sistem <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse ml-1"></span>
                    </Link>
                    <div class="px-4 py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lainnya</div>
                    <Link :href="route('organization')" prefetch @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Organisasi</Link>
                    <Link :href="route('partners')" prefetch @click="isMobileOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">Mitra</Link>
                </div>
            </Transition>
        </nav>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white">
            <!-- Top wave decoration -->
            <div class="h-1 bg-gradient-to-r from-secondary via-white/30 to-secondary opacity-30"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Main Footer Grid -->
                <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">

                    <!-- Col 1: Brand -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center ring-1 ring-white/20">
                                <img src="/images/logo-upr.png" alt="UPR Logo" class="w-8 h-8" />
                            </div>
                            <div>
                                <div class="text-xl font-extrabold leading-none">UPA TIK</div>
                                <div class="text-[10px] text-secondary font-bold uppercase tracking-widest">Universitas Palangka Raya</div>
                            </div>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Pusat Inovasi Teknologi dan Informasi Universitas Palangka Raya — melayani civitas akademika dengan solusi digital terintegrasi.
                        </p>
                        <!-- Social Icons -->
                        <div class="flex gap-2.5">
                            <a href="#" aria-label="Facebook" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-200">
                                <Facebook class="w-4 h-4" />
                            </a>
                            <a href="#" aria-label="Instagram" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-200">
                                <Instagram class="w-4 h-4" />
                            </a>
                            <a href="#" aria-label="Youtube" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-200">
                                <Youtube class="w-4 h-4" />
                            </a>
                            <a href="#" aria-label="LinkedIn" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-secondary hover:text-primary transition-all duration-200">
                                <Linkedin class="w-4 h-4" />
                            </a>
                        </div>
                        <!-- Status Badge -->
                        <Link :href="route('status')" class="inline-flex items-center gap-2 px-3 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <span class="text-xs font-bold text-emerald-400">Semua Sistem Operasional</span>
                        </Link>
                    </div>

                    <!-- Col 2: Navigasi -->
                    <div>
                        <h5 class="text-xs font-black uppercase tracking-[0.15em] text-secondary mb-5">Navigasi</h5>
                        <ul class="space-y-3">
                            <li><Link :href="route('home')" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Beranda</Link></li>
                            <li><a href="/#about" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Tentang Kami</a></li>
                            <li><a href="/#services" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Layanan</a></li>
                            <li><a href="/#projects" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Portfolio</a></li>
                            <li><a href="/#helpdesk" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Bantuan</a></li>
                            <li><Link :href="route('organization')" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Struktur Organisasi</Link></li>
                            <li><Link :href="route('partners')" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Mitra</Link></li>
                        </ul>
                    </div>

                    <!-- Col 3: Sumber Daya + Sistem -->
                    <div>
                        <h5 class="text-xs font-black uppercase tracking-[0.15em] text-secondary mb-5">Sumber Daya</h5>
                        <ul class="space-y-3 mb-8">
                            <li><Link :href="route('downloads')" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Pusat Unduhan</Link></li>
                            <li><Link :href="route('knowledge-base')" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Knowledge Base</Link></li>
                            <li><Link :href="route('gallery')" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Galeri Kegiatan</Link></li>
                        </ul>
                        <h5 class="text-xs font-black uppercase tracking-[0.15em] text-secondary mb-5">Sistem UPR</h5>
                        <ul class="space-y-3">
                            <li><a href="https://sia.upr.ac.id" target="_blank" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>SIUBER / SIAKAD</a></li>
                            <li><a href="https://portal-dosen.upr.ac.id" target="_blank" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Portal Dosen</a></li>
                            <li><a href="https://portal-mahasiswa.upr.ac.id" target="_blank" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Portal Mahasiswa</a></li>
                            <li><a href="https://upr.ac.id" target="_blank" class="text-slate-300 hover:text-white text-sm transition-colors flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-white/20 group-hover:bg-secondary rounded-full transition-colors shrink-0"></span>Website UPR</a></li>
                        </ul>
                    </div>

                    <!-- Col 4: Kontak + Newsletter -->
                    <div>
                        <h5 class="text-xs font-black uppercase tracking-[0.15em] text-secondary mb-5">Hubungi Kami</h5>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start gap-3 text-slate-300">
                                <MapPin class="w-4 h-4 text-secondary shrink-0 mt-0.5" />
                                <span class="text-sm leading-relaxed">Gedung UPA TIK, Kampus UPR Tanjung Nyaho, Palangka Raya, Kalimantan Tengah.</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-300">
                                <Phone class="w-4 h-4 text-secondary shrink-0" />
                                <a href="tel:+625363221234" class="text-sm hover:text-white transition-colors">+62 (536) 322-1234</a>
                            </li>
                            <li class="flex items-center gap-3 text-slate-300">
                                <Mail class="w-4 h-4 text-secondary shrink-0" />
                                <a href="mailto:upt.tik@upr.ac.id" class="text-sm hover:text-white transition-colors">upt.tik@upr.ac.id</a>
                            </li>
                        </ul>
                        <h5 class="text-xs font-black uppercase tracking-[0.15em] text-secondary mb-4">Buletin</h5>
                        <p class="text-slate-400 text-xs mb-3">Dapatkan update terkini layanan TIK.</p>
                        <div class="flex gap-2">
                            <input type="email" placeholder="email@upr.ac.id" class="flex-1 min-w-0 px-3 py-2.5 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-secondary" />
                            <button class="px-3 py-2.5 bg-secondary text-primary rounded-xl hover:bg-secondary-light transition-colors shrink-0">
                                <Send class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-white/10"></div>

                <!-- Bottom Bar -->
                <div class="py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-6 text-xs text-slate-400">
                        <span class="font-medium">&copy; {{ new Date().getFullYear() }} UPA TIK Universitas Palangka Raya.</span>
                        <span class="hidden sm:block w-px h-3 bg-white/10"></span>
                        <span class="text-slate-500">Hak Cipta Dilindungi.</span>
                    </div>
                    <div class="flex items-center gap-5 text-xs text-slate-400">
                        <a href="#" class="hover:text-white transition-colors font-medium">Kebijakan Privasi</a>
                        <span class="w-px h-3 bg-white/10"></span>
                        <a href="#" class="hover:text-white transition-colors font-medium">Syarat & Ketentuan</a>
                        <span class="w-px h-3 bg-white/10"></span>
                        <a href="https://upr.ac.id" target="_blank" class="hover:text-white transition-colors font-medium">upr.ac.id</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
.page-fade-enter-active,
.page-fade-leave-active {
    transition: all 0.4s ease-in-out;
}

.page-fade-enter-from {
    opacity: 0;
    transform: translateY(10px);
}

.page-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

.dropdown-enter-active,
.dropdown-leave-active {
    transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
    opacity: 0;
    transform: translateY(-8px) translateX(-50%);
}

.dropdown-enter-to {
    transform: translateY(0) translateX(-50%);
}

.mobile-menu-enter-active,
.mobile-menu-leave-active {
    transition: all 0.3s ease;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
