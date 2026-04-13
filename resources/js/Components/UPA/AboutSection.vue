<script setup>
import { CheckCircle2 } from 'lucide-vue-next';

const values = [
    "Inovasi Digital Berkelanjutan",
    "Infrastruktur Jaringan Handal",
    "Keamanan Siber Tingkat Tinggi",
    "Layanan Pengguna Terintegrasi",
    "Pengembangan Sistem Terpadu",
    "Dukungan Riset & Teknologi"
];
</script>

<template>
    <section class="py-24 bg-white dark:bg-slate-900 transition-colors duration-300 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left: Content -->
                <div class="animate-in slide-in-from-left-10 duration-700">
                    <span class="text-primary dark:text-secondary font-bold text-sm uppercase tracking-[0.2em] mb-4 block">Tentang Kami</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 dark:text-white mb-8 leading-tight">
                        Membangun Masa Depan <br />
                        Digital Universitas
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed mb-8">
                        Unit Pelaksana Akreditasi Teknologi Informasi dan Komunikasi (UPA TIK) adalah pilar utama transformasi digital di Universitas Palangka Raya. Kami berdedikasi untuk menyediakan layanan teknologi terbaik, memastikan konektivitas yang lancar, serta mengembangkan ekosistem akademik yang cerdas dan inovatif.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="value in values" :key="value" class="flex items-center space-x-3 group">
                            <div class="p-1 bg-primary/10 dark:bg-primary/20 rounded-full group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                                <CheckCircle2 class="w-4 h-4 text-primary dark:text-secondary group-hover:text-white" />
                            </div>
                            <span class="text-slate-700 dark:text-slate-300 font-medium text-sm">{{ value }}</span>
                        </div>
                    </div>

                    <div class="mt-12 flex items-center space-x-8">
                        <div class="flex -space-x-3 overflow-hidden">
                            <img v-for="i in 4" :key="i" :src="`https://i.pravatar.cc/100?img=${i+10}`" class="inline-block h-12 w-12 rounded-full ring-4 ring-white dark:ring-slate-900" />
                        </div>
                        <div>
                            <div class="text-slate-900 dark:text-white font-bold">Tim Ahli Profesional</div>
                            <div class="text-slate-500 text-sm">Siap melayani 15,000+ civitas akademika</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Image/Visual -->
                <div class="relative animate-in slide-in-from-right-10 duration-700 delay-200">
                    <div class="absolute -top-10 -right-10 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-secondary/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl skew-y-1 hover:skew-y-0 transition-transform duration-500">
                        <img src="https://images.unsplash.com/photo-1522071823991-b19c77663c17?q=80&w=2070&auto=format&fit=crop" class="w-full h-[500px] object-cover" alt="UPA TIK Team" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8 p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20">
                            <p class="text-white font-medium italic">"Teknologi bukan hanya alat, tapi jembatan menuju keunggulan dunia akademik."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
