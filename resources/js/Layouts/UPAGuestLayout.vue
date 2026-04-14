<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { Facebook, Instagram, Linkedin, Youtube, Mail, Phone, MapPin, Send } from 'lucide-vue-next';
import ThemeToggle from '@/Components/UPA/ThemeToggle.vue';

defineProps({
    title: String,
});
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
                    <div class="hidden md:flex items-center space-x-8">
                        <Link :href="route('home')" prefetch class="text-sm font-semibold transition-colors" :class="route().current('home') ? 'text-primary dark:text-white border-b-2 border-primary pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">Home</Link>
                        <a href="/#about" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">About Us</a>
                        <Link :href="route('organization')" prefetch class="text-sm font-semibold transition-colors" :class="route().current('organization') ? 'text-primary dark:text-white border-b-2 border-primary pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">Organization</Link>
                        <Link :href="route('partners')" prefetch class="text-sm font-semibold transition-colors" :class="route().current('partners') ? 'text-primary dark:text-white border-b-2 border-primary pb-1' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">Partners</Link>
                        <a href="/#services" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Services</a>
                        <a href="/#projects" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Projects</a>
                        <a href="/#faq" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">FAQ</a>
                    </div>

                    <!-- Login & Theme -->
                    <div class="flex items-center space-x-4">
                        <ThemeToggle />

                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-primary pt-20 pb-10 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                                <img src="/images/logo-upr.png" alt="UPR Logo" class="w-7 h-7" />
                            </div>
                            <span class="text-2xl font-bold">UPA TIK UPR</span>
                        </div>
                        <p class="text-slate-300 text-sm leading-relaxed">Pusat Inovasi Teknologi dan Informasi Universitas Palangka Raya. Melayani civitas akademika dengan solusi digital terintegrasi.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-secondary hover:text-primary transition-all"><Facebook class="w-5 h-5" /></a>
                            <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-secondary hover:text-primary transition-all"><Instagram class="w-5 h-5" /></a>
                            <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-secondary hover:text-primary transition-all"><Youtube class="w-5 h-5" /></a>
                            <a href="#" class="p-2 bg-white/10 rounded-lg hover:bg-secondary hover:text-primary transition-all"><Linkedin class="w-5 h-5" /></a>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xl font-bold mb-6">Contact Us</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start space-x-3 text-slate-300">
                                <MapPin class="w-5 h-5 text-secondary shrink-0" />
                                <span class="text-sm">Gedung UPA TIK, Kampus UPR Tanjung Nyaho, Palangka Raya, Kalimantan Tengah.</span>
                            </li>
                            <li class="flex items-center space-x-3 text-slate-300">
                                <Phone class="w-5 h-5 text-secondary shrink-0" />
                                <span class="text-sm">+62 (536) 322-1234</span>
                            </li>
                            <li class="flex items-center space-x-3 text-slate-300">
                                <Mail class="w-5 h-5 text-secondary shrink-0" />
                                <span class="text-sm">upt.tik@upr.ac.id</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xl font-bold mb-6">Useful Links</h4>
                        <ul class="space-y-3 text-slate-300 text-sm">
                            <li><a href="/#home" class="hover:text-secondary transition-colors italic">Home</a></li>
                            <li><a href="/#about" class="hover:text-secondary transition-colors italic">About Us</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors italic">SIAKAD UPR</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors italic">PPID UPR</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors italic">Library Online</a></li>
                            <li><a href="#" class="hover:text-secondary transition-colors italic">Staff Portal</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xl font-bold mb-6">Newsletter</h4>
                        <p class="text-slate-300 text-sm mb-4">Dapatkan update terkini seputar layanan TIK.</p>
                        <div class="flex space-x-2">
                            <input type="email" placeholder="Email address" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-sm focus:ring-secondary focus:border-secondary" />
                            <button class="p-3 bg-secondary text-primary rounded-xl font-bold"><Send class="w-5 h-5" /></button>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-slate-400 text-xs font-medium uppercase tracking-[0.2em]">
                    <p>&copy; 2026 UPA TIK Universitas Palangka Raya. All Rights Reserved.</p>
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <a href="#" class="hover:text-white">Privacy Policy</a>
                        <a href="#" class="hover:text-white">Terms of Service</a>
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
</style>
