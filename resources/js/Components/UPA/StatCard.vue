<script setup>
import { Users, LayoutDashboard, Clock } from 'lucide-vue-next';

defineProps({
    label: String,
    value: String,
    icon: String,
});

const icons = {
    users: Users,
    systems: LayoutDashboard,
    uptime: Clock,
};
</script>

<template>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-primary/10 rounded-xl">
                <component :is="icons[icon]" class="w-6 h-6 text-primary" />
            </div>
            <div>
                <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ value }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ label }}</div>
            </div>
        </div>
    </div>
</template>
