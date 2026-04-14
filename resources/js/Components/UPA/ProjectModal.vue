<script setup>
import { X, ExternalLink, Globe, Layers, CheckCircle2 } from 'lucide-vue-next';
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    isOpen: Boolean,
    project: Object,
});

const emit = defineEmits(['close']);

// Close on ESC key
const handleEsc = (e) => {
    if (e.key === 'Escape') emit('close');
};

onMounted(() => window.addEventListener('keydown', handleEsc));
onUnmounted(() => window.removeEventListener('keydown', handleEsc));
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <!-- Backdrop -->
            <div 
                class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"
                @click="emit('close')"
            ></div>

            <!-- Modal Content -->
            <Transition
                enter-active-class="transition duration-300 ease-out delay-75"
                enter-from-class="opacity-0 translate-y-8 scale-95"
                enter-to-class="opacity-100 translate-y-0 scale-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100 translate-y-0 scale-100"
                leave-to-class="opacity-0 translate-y-4 scale-95"
            >
                <div v-if="isOpen" class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/20 dark:border-slate-800">
                    <!-- Close Button -->
                    <button 
                        @click="emit('close')"
                        class="absolute top-6 right-6 z-20 p-2 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full text-white sm:text-slate-400 sm:hover:text-primary transition-all duration-300"
                    >
                        <X class="w-6 h-6" />
                    </button>

                    <!-- Banner / Image -->
                    <div class="relative h-56 sm:h-64 overflow-hidden">
                        <img 
                            :src="project?.image" 
                            :alt="project?.title"
                            class="w-full h-full object-cover"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                        
                        <!-- Header Over Image -->
                        <div class="absolute bottom-8 left-8 right-8">
                            <span class="px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-lg mb-3 inline-block">
                                {{ project?.category }}
                            </span>
                            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                                {{ project?.title }}
                            </h2>
                            <div class="flex items-center space-x-2 text-primary-light text-sm font-semibold">
                                <CheckCircle2 class="w-4 h-4 text-accent" />
                                <span class="text-accent">Sistem Aktif & Terpantau</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="p-8 sm:p-10">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2.5 bg-primary/10 rounded-xl text-primary">
                                <Layers class="w-6 h-6" />
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Deskripsi Layanan</h3>
                        </div>

                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed mb-8">
                                {{ project?.description }}
                            </p>
                        </div>

                        <!-- Footer / Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-slate-100 dark:border-slate-800">
                            <div class="flex items-center space-x-2 text-slate-400">
                                <Globe class="w-4 h-4" />
                                <span class="text-xs font-medium">{{ project?.url !== '#' ? project?.url : 'Internal Network Only' }}</span>
                            </div>
                            <div class="flex items-center space-x-3 w-full sm:w-auto">
                                <button 
                                    @click="emit('close')"
                                    class="flex-1 sm:flex-none px-6 py-3 text-slate-500 hover:text-slate-700 font-bold transition-all"
                                >
                                    Tutup
                                </button>
                                <a 
                                    :href="project?.url" 
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex-1 sm:flex-none flex items-center justify-center space-x-2 px-8 py-3 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold shadow-lg shadow-primary/20 hover:-translate-y-1 transition-all duration-300"
                                >
                                    <span>Buka Aplikasi</span>
                                    <ExternalLink class="w-4 h-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<style scoped>
.prose p {
    white-space: pre-wrap;
}
</style>
