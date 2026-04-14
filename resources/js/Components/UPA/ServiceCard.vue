<script setup>
import { GraduationCap, Network, Cloud, Server, Code2, Settings, Mail } from 'lucide-vue-next';

defineProps({
    title: String,
    description: String,
    icon: String,
});

const icons = {
    academic: GraduationCap,
    network: Network,
    cloud: Cloud,
    server: Server,
    development: Code2,
    maintenance: Settings,
    workspace: Mail,
};
</script>

<template>
    <div class="group h-full bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm hover:border-primary/50 transition-all duration-300">
        <div class="mb-6 inline-flex p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl text-primary group-hover:bg-primary group-hover:text-white transition-colors duration-300">
            <component :is="icons[icon]" class="w-8 h-8" />
        </div>
        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ title }}</h3>
        <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-sm">
            {{ description }}
        </p>
    </div>
</template>
