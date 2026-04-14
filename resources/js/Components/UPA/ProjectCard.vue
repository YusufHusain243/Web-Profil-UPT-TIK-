<script setup>
import { ExternalLink, Layers } from 'lucide-vue-next';

defineProps({
    title: String,
    category: String,
    image: String,
    url: {
        type: String,
        default: '#'
    },
    description: {
        type: String,
        default: 'Sistem informasi terintegrasi untuk mendukung manajemen operasional dan layanan civitas akademika UPR.'
    },
    status: {
        type: String,
        default: 'Aktif'
    }
});

defineEmits(['clickCard']);
</script>

<template>
    <div 
        @click="$emit('clickCard')"
        class="group relative bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 cursor-pointer"
    >
        <!-- Image Container -->
        <div class="relative h-48 overflow-hidden">
            <img :src="image" :alt="title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            
            <!-- Category Tag -->
            <div class="absolute top-4 left-4">
                <span class="px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-primary dark:text-secondary text-[10px] font-bold uppercase tracking-widest rounded-lg shadow-sm">
                    {{ category }}
                </span>
            </div>
            
            <!-- Status Badge -->
            <div class="absolute bottom-4 right-4">
                <span class="flex items-center space-x-1.5 px-3 py-1 bg-accent/90 text-white text-[10px] font-bold uppercase rounded-lg">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                    <span>{{ status }}</span>
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-slate-50 dark:bg-slate-900 rounded-xl text-primary dark:text-secondary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                    <Layers class="w-5 h-5" />
                </div>
                <a :href="url" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-primary transition-colors">
                    <ExternalLink class="w-5 h-5" />
                </a>
            </div>
            
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                {{ title }}
            </h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 leading-relaxed h-10">
                {{ description }}
            </p>
        </div>

        <!-- Hover Overlay Gradient -->
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary via-secondary to-accent scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
    </div>
</template>
