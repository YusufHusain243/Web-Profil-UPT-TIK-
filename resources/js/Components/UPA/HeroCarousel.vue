<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { ChevronLeft, ChevronRight, ChevronDown } from 'lucide-vue-next';

const slides = [
    {
        tag: "Sistem Akademik",
        title: "SIUBER: Sistem Akademik Terpadu",
        description: "Layanan sistem informasi akademik terintegrasi untuk seluruh siklus perkuliahan, dari registrasi mahasiswa baru hingga wisuda.",
        image: "/images/carousel-siuber.png",
        cta: "Akses SIUBER",
    },
    {
        tag: "Infrastruktur",
        title: "Konektivitas & Wi-Fi Kampus",
        description: "Layanan penyediaan jaringan internet berkecepatan tinggi dan Wi-Fi luas di seluruh area kampus Universitas Palangka Raya.",
        image: "/images/carousel-network.png",
        cta: "Cek Area Wi-Fi",
    },
    {
        tag: "Layanan Web",
        title: "Hosting & Domain Unit",
        description: "Penyediaan layanan web hosting dan domain/subdomain resmi bagi seluruh unit, lembaga, dan fakultas di lingkungan UPR.",
        image: "/images/carousel-hosting.png",
        cta: "Ajukan Hosting",
    },
    {
        tag: "Pengembangan",
        title: "Software & System Development",
        description: "Tim ahli kami siap membantu rancang bangun sistem informasi dan pengembangan aplikasi web/mobile kustom untuk unit Anda.",
        image: "/images/carousel-dev.png",
        cta: "Konsultasi Sistem",
    },
    {
        tag: "Pemeliharaan",
        title: "IT Maintenance & Repair",
        description: "Layanan pemeliharaan rutin perangkat keras, troubleshooting sistem, dan perbaikan infrastruktur IT secara berkala.",
        image: "/images/carousel-maintenance.png",
        cta: "Ajukan Perbaikan",
    },
    {
        tag: "Pusat Bantuan",
        title: "Layanan Terpadu Satu Pintu",
        description: "Portal bantuan teknis terpusat untuk membantu kendala TI Anda. Cepat, tanggap, dan profesional.",
        image: "/images/carousel-support.png",
        cta: "Pusat Bantuan",
    },
    {
        tag: "Komunikasi",
        title: "Email Institusi (@upr.ac.id)",
        description: "Penyediaan dan pengelolaan akun email profesional bagi seluruh civitas akademika Universitas Palangka Raya.",
        image: "/images/carousel-email.png",
        cta: "Aktivasi Email",
    },
    {
        tag: "Produktivitas",
        title: "Lisensi Software (Office 365)",
        description: "Akses resmi ke perangkat lunak produktivitas dunia seperti Microsoft Office 365 bagi mahasiswa dan dosen.",
        image: "/images/carousel-license.png",
        cta: "Cek Lisensi",
    },
    {
        tag: "Keamanan",
        title: "Keamanan Siber & Aset Digital",
        description: "Perlindungan data sensitif dan aset digital universitas melalui sistem keamanan siber yang berlapis dan teruji.",
        image: "/images/carousel_security.png",
        cta: "Info Keamanan",
    }
];

const currentSlide = ref(0);
let interval = null;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length;
};

const goToSlide = (index) => {
    currentSlide.value = index;
};

onMounted(() => {
    interval = setInterval(nextSlide, 6000);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<template>
    <div class="relative w-full h-[650px] md:h-[750px] overflow-hidden bg-slate-900 group">
        <!-- Slides -->
        <div v-for="(slide, index) in slides" :key="index" 
            class="absolute inset-0 transition-all duration-1000 ease-in-out"
            :class="[currentSlide === index ? 'opacity-100 scale-100' : 'opacity-0 scale-105 pointer-events-none']">
            
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-surface dark:from-surface-dark via-transparent to-transparent opacity-60"></div>
            </div>

            <!-- Content -->
            <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center">
                <div class="max-w-2xl animate-in slide-in-from-left-10 fade-in duration-700 delay-300">
                    <span class="inline-block px-4 py-1.5 bg-primary/20 backdrop-blur-md border border-primary/30 text-secondary font-bold text-xs uppercase tracking-widest rounded-full mb-6">
                        {{ slide.tag }}
                    </span>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-[1.1]">
                        {{ slide.title }}
                    </h1>
                    <p class="text-lg md:text-xl text-slate-300 mb-10 leading-relaxed">
                        {{ slide.description }}
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <button class="px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all text-sm">
                            {{ slide.cta }}
                        </button>
                        <button class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transition-all text-sm">
                            Informasi Lebih Lanjut
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arrows -->
        <div class="absolute inset-y-0 left-4 md:left-8 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
            <button @click="prevSlide" class="p-3 bg-white/10 backdrop-blur-md rounded-2xl text-white hover:bg-primary transition-all">
                <ChevronLeft class="w-6 h-6" />
            </button>
        </div>
        <div class="absolute inset-y-0 right-4 md:right-8 flex items-center opacity-0 group-hover:opacity-100 transition-opacity">
            <button @click="nextSlide" class="p-3 bg-white/10 backdrop-blur-md rounded-2xl text-white hover:bg-primary transition-all">
                <ChevronRight class="w-6 h-6" />
            </button>
        </div>

        <!-- Indicators -->
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 flex space-x-3 z-30">
            <button v-for="(_, index) in slides" :key="index"
                @click="goToSlide(index)"
                class="h-1.5 rounded-full transition-all duration-300"
                :class="[currentSlide === index ? 'w-10 bg-primary' : 'w-4 bg-white/30 hover:bg-white/50']">
            </button>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce">
            <ChevronDown class="w-6 h-6 text-white/50" />
        </div>
    </div>
</template>
