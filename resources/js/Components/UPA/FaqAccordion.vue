<script setup>
import { ref } from 'vue';
import { ChevronDown, HelpCircle } from 'lucide-vue-next';

const props = defineProps({
    question: String,
    answer: String
});

const isOpen = ref(false);

const toggle = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <div class="mb-4 last:mb-0">
        <button 
            @click="toggle"
            class="w-full flex items-center justify-between p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm transition-all duration-300 group"
            :class="[isOpen ? 'ring-2 ring-primary/20 bg-slate-50 dark:bg-slate-900 border-primary/30' : 'hover:border-primary/50']"
        >
            <div class="flex items-center space-x-4 text-left">
                <div class="p-2 bg-primary/10 rounded-lg text-primary transition-colors group-hover:bg-primary group-hover:text-white">
                    <HelpCircle class="w-5 h-5 font-bold" />
                </div>
                <span class="font-bold text-slate-800 dark:text-slate-200 transition-colors" :class="[isOpen ? 'text-primary dark:text-secondary' : '']">
                    {{ question }}
                </span>
            </div>
            <ChevronDown 
                class="w-5 h-5 text-slate-400 transition-transform duration-500"
                :class="[isOpen ? 'rotate-180 text-primary' : '']"
            />
        </button>
        
        <div 
            class="overflow-hidden transition-all duration-500 bg-white dark:bg-slate-800 rounded-b-2xl border-x border-b border-primary/10 dark:border-slate-700 -mt-2"
            :class="[isOpen ? 'max-h-96 opacity-100 p-8 pt-10' : 'max-h-0 opacity-0 p-0']"
        >
            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm">
                {{ answer }}
            </p>
        </div>
    </div>
</template>
