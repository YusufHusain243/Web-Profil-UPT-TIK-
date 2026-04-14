<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { ChevronLeft, ChevronRight, ChevronDown } from 'lucide-vue-next';

const slides = [
    {
        tag: "Inovasi Digital",
        title: "Pusat Inovasi Teknologi UPR",
        description: "Mendorong keunggulan akademik melalui infrastruktur digital terdepan untuk seluruh civitas akademika.",
        image: "/images/digital-innovation.png",
        cta: "Layanan Kami",
    },
    {
        tag: "Konektivitas",
        title: "Jaringan Kampus Berkecepatan Tinggi",
        description: "Akses Wi-Fi luas dan stabil di seluruh area kampus Tanjung Nyaho untuk mendukung produktivitas Anda.",
        image: "/images/network-infrastructure.png",
        cta: "Cek Coverage",
    },
    {
        tag: "Dukungan Teknis",
        title: "Pelayanan Terpadu Satu Pintu",
        description: "Butuh bantuan IT? Tim ahli kami siap membantu kendala teknis Anda melalui Portal Support TIK.",
        image: "/images/technical-support.png",
        cta: "Ajukan Bantuan",
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
