<script setup>
import { useDark, useToggle } from '@vueuse/core';
import { Sun, Moon } from 'lucide-vue-next';

const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
    <button
        @click="toggleDark()"
        class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-primary transition-all duration-300 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white"
        title="Toggle Theme"
    >
        <span class="sr-only">Toggle Theme</span>
        
        <!-- Sun icon for dark mode -->
        <Sun
            v-if="isDark"
            class="h-5 w-5 animate-in zoom-in duration-300"
        />
        
        <!-- Moon icon for light mode -->
        <Moon
            v-else
            class="h-5 w-5 animate-in zoom-in duration-300"
        />
    </button>
</template>
