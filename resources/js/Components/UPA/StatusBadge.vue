<script setup>
import { computed } from 'vue';
import { CheckCircle2, AlertCircle, Clock, Loader2 } from 'lucide-vue-next';

const props = defineProps({
    label: String,
    status: {
        type: String,
        default: 'checking', // operational, maintenance, issue, checking
    }
});

const statusConfig = {
    checking: {
        icon: Loader2,
        color: 'text-slate-400',
        bg: 'bg-slate-500/10',
        label: 'Memeriksa...',
        animate: 'animate-spin'
    },
    operational: {
        icon: CheckCircle2,
        color: 'text-accent',
        bg: 'bg-accent/10',
        label: 'Berjalan Baik'
    },
    maintenance: {
        icon: Clock,
        color: 'text-amber-500',
        bg: 'bg-amber-500/10',
        label: 'Pemeliharaan'
    },
    issue: {
        icon: AlertCircle,
        color: 'text-red-500',
        bg: 'bg-red-500/10',
        label: 'Kendala Sistem'
    }
};

const config = computed(() => statusConfig[props.status] || statusConfig.operational);
</script>

<template>
    <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm">
        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ label }}</span>
        <div :class="['flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-bold', config.bg, config.color]">
            <component :is="config.icon" :class="['w-3.5 h-3.5', config.animate]" />
            <span>{{ config.label }}</span>
        </div>
    </div>
</template>
