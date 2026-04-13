<script setup>
import { Head } from '@inertiajs/vue3';
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { Mail, Linkedin, Twitter } from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
});

const organization = {
    head: {
        name: "Dr. Ir. Yosef Barita Sarman, S.T., M.T.",
        role: "Kepala UPA TIK",
        image: "https://i.pravatar.cc/300?img=12",
        bio: "Bertanggung jawab atas seluruh arah strategis dan tata kelola teknologi informasi di lingkungan Universitas Palangka Raya."
    },
    secretary: {
        name: "Dewi Sartika, S.Kom., M.T.",
        role: "Sekretaris",
        image: "https://i.pravatar.cc/300?img=5",
        bio: "Mengelola administrasi dan koordinasi internal divisi teknis UPA TIK."
    },
    teams: [
        {
            name: "Dharmawan Putra, M.Cs.",
            role: "Koordinator Tim Infrastruktur",
            image: "https://i.pravatar.cc/300?img=11"
        },
        {
            name: "Siti Aminah, S.T.",
            role: "Koordinator Sistem Informasi",
            image: "https://i.pravatar.cc/300?img=26"
        },
        {
            name: "Budi Santoso, S.Kom.",
            role: "Kepala Keamanan Jaringan",
            image: "https://i.pravatar.cc/300?img=68"
        },
        {
            name: "Anita Wijaya, M.IT.",
            role: "Koordinator Layanan Data",
            image: "https://i.pravatar.cc/300?img=44"
        }
    ]
};
</script>

<template>
    <UPAGuestLayout title="Struktur Organisasi" :canLogin="canLogin">
        <!-- Header -->
        <section class="relative pt-40 pb-20 bg-primary overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2 blur-[100px]"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary rounded-full translate-x-1/2 translate-y-1/2 blur-[100px]"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-secondary font-bold text-xs uppercase tracking-widest rounded-full mb-6 inline-block">Mengenal Kami</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Struktur Organisasi</h1>
                <p class="max-w-2xl mx-auto text-slate-300 text-lg leading-relaxed">
                    Sinergi tim profesional yang berdedikasi untuk mewujudkan ekosistem digital terbaik di Universitas Palangka Raya.
                </p>
            </div>
        </section>

        <!-- Org Chart -->
        <section class="py-24 bg-white dark:bg-slate-900 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Head of Unit -->
                <div class="flex justify-center mb-24 animate-fade-in-up">
                    <div class="max-w-md w-full text-center">
                        <div class="relative inline-block mb-8">
                            <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/40 transition-all duration-500"></div>
                            <img :src="organization.head.image" class="relative w-48 h-48 rounded-full border-4 border-white dark:border-slate-800 shadow-2xl object-cover" alt="Head of Unit" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ organization.head.name }}</h2>
                        <span class="px-4 py-1 bg-primary text-white text-xs font-bold uppercase tracking-widest rounded-full mb-6 inline-block">{{ organization.head.role }}</span>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">{{ organization.head.bio }}</p>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><Mail class="w-5 h-5" /></a>
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><Linkedin class="w-5 h-5" /></a>
                        </div>
                    </div>
                </div>

                <!-- Connectors (Visual Only) -->
                <div class="hidden lg:flex justify-center -mt-16 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="w-0.5 h-16 bg-gradient-to-b from-primary to-transparent opacity-20"></div>
                </div>

                <!-- Secretary -->
                <div class="flex justify-center mb-24 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="max-w-md w-full text-center">
                        <div class="relative inline-block mb-8">
                            <img :src="organization.secretary.image" class="relative w-40 h-40 rounded-full border-4 border-white dark:border-slate-800 shadow-xl object-cover" alt="Secretary" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ organization.secretary.name }}</h2>
                        <span class="px-4 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold uppercase tracking-widest rounded-full mb-4 inline-block">{{ organization.secretary.role }}</span>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><Mail class="w-5 h-5" /></a>
                        </div>
                    </div>
                </div>

                <!-- Tech Teams Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mt-20 animate-fade-in-up" style="animation-delay: 0.5s;">
                    <div v-for="member in organization.teams" :key="member.name" class="text-center group">
                        <div class="mb-6 relative inline-block">
                            <img :src="member.image" class="w-24 h-24 rounded-2xl border-2 border-slate-100 dark:border-slate-700 shadow-lg object-cover group-hover:scale-105 transition-transform" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-primary transition-colors">{{ member.name }}</h3>
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">{{ member.role }}</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Bergabung Bersama Kami?</h2>
                <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                    Kami selalu mencari talenta muda berbakat di bidang IT untuk bergabung dalam program magang atau riset kolaboratif.
                </p>
                <button class="px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all">Hubungi Kami</button>
            </div>
        </section>
    </UPAGuestLayout>
</template>
