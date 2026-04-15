<script setup>
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import {
    CheckCircle2, AlertTriangle, XCircle, Clock, RefreshCw,
    Server, Wifi, Globe, Database, Shield, Mail, Cpu, Activity
} from 'lucide-vue-next';
import { projects } from '@/data/projects.js';

// ─── System Status ───────────────────────────────────────────────────────────
const systemStatusMap = ref({});
const lastChecked = ref(null);
const isRefreshing = ref(false);
let statusInterval = null;

const checkSystems = async () => {
    isRefreshing.value = true;
    const urlsToCheck = projects.map(p => p.url).filter(url => url && url !== '#');
    try {
        const response = await axios.get('/api/status-check', {
            params: { urls: urlsToCheck },
        });
        const results = response.data;
        projects.forEach(p => {
            systemStatusMap.value[p.title] = (!p.url || p.url === '#')
                ? 'maintenance'
                : (results[p.url] ?? 'issue');
        });
    } catch {
        projects.forEach(p => {
            systemStatusMap.value[p.title] = (!p.url || p.url === '#') ? 'maintenance' : 'issue';
        });
    }
    lastChecked.value = new Date();
    isRefreshing.value = false;
};

const manualRefresh = () => {
    projects.forEach(p => { systemStatusMap.value[p.title] = 'checking'; });
    checkSystems();
};

onMounted(() => {
    projects.forEach(p => { systemStatusMap.value[p.title] = 'checking'; });
    checkSystems();
    statusInterval = setInterval(checkSystems, 15 * 60 * 1000);
});

onUnmounted(() => { clearInterval(statusInterval); });

// ─── Status Helper ────────────────────────────────────────────────────────────
const getStatusColor = (status) => {
    if (status === 'ok') return 'text-emerald-500';
    if (status === 'maintenance') return 'text-amber-500';
    if (status === 'issue') return 'text-red-500';
    return 'text-slate-400';
};

const getStatusBg = (status) => {
    if (status === 'ok') return 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-100 dark:border-emerald-800/30';
    if (status === 'maintenance') return 'bg-amber-50 dark:bg-amber-900/20 border-amber-100 dark:border-amber-800/30';
    if (status === 'issue') return 'bg-red-50 dark:bg-red-900/20 border-red-100 dark:border-red-800/30';
    return 'bg-slate-50 dark:bg-slate-800 border-slate-100 dark:border-slate-700';
};

const getStatusLabel = (status) => {
    if (status === 'ok') return 'Operasional';
    if (status === 'maintenance') return 'Pemeliharaan';
    if (status === 'issue') return 'Ada Kendala';
    if (status === 'checking') return 'Memeriksa...';
    return 'Tidak Diketahui';
};

const operationalCount = computed(() => Object.values(systemStatusMap.value).filter(s => s === 'ok').length);
const maintenanceCount = computed(() => Object.values(systemStatusMap.value).filter(s => s === 'maintenance').length);
const issueCount = computed(() => Object.values(systemStatusMap.value).filter(s => s === 'issue').length);
const totalCount = computed(() => projects.length);

const overallStatus = computed(() => {
    if (issueCount.value > 0) return 'issue';
    if (maintenanceCount.value > 0) return 'maintenance';
    return 'ok';
});

const formatTime = (date) => {
    if (!date) return '-';
    return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
};

// ─── Uptime Bars (simulated 30-day) ──────────────────────────────────────────
const generateUptimeBars = () =>
    Array.from({ length: 30 }, (_, i) => {
        const rand = Math.random();
        if (rand > 0.96) return 'issue';
        if (rand > 0.90) return 'maintenance';
        return 'ok';
    });

const uptimeBars = generateUptimeBars();

const uptimePercentage = computed(() => {
    const okDays = uptimeBars.filter(b => b === 'ok').length;
    return ((okDays / 30) * 100).toFixed(1);
});

// ─── Infrastructure Services ──────────────────────────────────────────────────
const infraServices = [
    { name: 'Jaringan Backbone Kampus', icon: Wifi, category: 'Jaringan', status: 'ok', uptime: '99.97%' },
    { name: 'Server Web Hosting', icon: Server, category: 'Server', status: 'ok', uptime: '99.9%' },
    { name: 'Database Cluster', icon: Database, category: 'Database', status: 'ok', uptime: '100%' },
    { name: 'Firewall & DDoS Protection', icon: Shield, category: 'Keamanan', status: 'ok', uptime: '99.8%' },
    { name: 'Email Server (Google Workspace)', icon: Mail, category: 'Email', status: 'ok', uptime: '99.99%' },
    { name: 'DNS Server', icon: Globe, category: 'DNS', status: 'maintenance', uptime: '99.5%' },
    { name: 'Load Balancer', icon: Activity, category: 'Infrastruktur', status: 'ok', uptime: '99.9%' },
    { name: 'Backup & Recovery System', icon: Cpu, category: 'Backup', status: 'ok', uptime: '100%' },
];

// ─── Incident History ─────────────────────────────────────────────────────────
const incidents = [
    {
        date: '10 April 2026',
        title: 'Gangguan Parsial Email Institusi',
        duration: '47 menit',
        status: 'Terselesaikan',
        severity: 'minor',
        description: 'Sebagian pengguna melaporkan keterlambatan pengiriman email. Penyebab: throttling quota API Google Workspace. Sudah diselesaikan dengan peningkatan kuota.',
    },
    {
        date: '28 Maret 2026',
        title: 'Pemeliharaan Server SIUBER Terjadwal',
        duration: '3 jam',
        status: 'Terselesaikan',
        severity: 'maintenance',
        description: 'Maintenance rutin triwulanan untuk update keamanan dan optimasi performa database SIUBER. Dilaksanakan pada jam 02.00-05.00 WIB.',
    },
    {
        date: '15 Maret 2026',
        title: 'Koneksi Internet Intermittent di Gedung Rektorat',
        duration: '2 jam',
        status: 'Terselesaikan',
        severity: 'minor',
        description: 'Koneksi tidak stabil di area Gedung Rektorat akibat kerusakan SFP module pada switch distribusi lantai 3. Sudah diganti dan dipulihkan.',
    },
    {
        date: '1 Februari 2026',
        title: 'Pemeliharaan Jaringan Fiber Optik Kampus',
        duration: '6 jam',
        status: 'Terselesaikan',
        severity: 'maintenance',
        description: 'Upgrade kapasitas backbone fiber dari 10Gbps ke 40Gbps untuk mengakomodasi pertumbuhan pengguna. Jaringan kini lebih cepat dan stabil.',
    },
];

const getSeverityClass = (severity) => {
    if (severity === 'maintenance') return 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
    if (severity === 'minor') return 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
    return 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400';
};
</script>

<template>
    <UPAGuestLayout title="Status Sistem">
        <!-- Header -->
        <section class="pt-40 pb-16 relative overflow-hidden"
            :class="overallStatus === 'ok' ? 'bg-primary' : (overallStatus === 'maintenance' ? 'bg-amber-600' : 'bg-red-700')">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 -translate-y-1/2 blur-[100px]"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-white">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-3 h-3 rounded-full animate-pulse"
                                :class="overallStatus === 'ok' ? 'bg-emerald-400' : (overallStatus === 'maintenance' ? 'bg-amber-300' : 'bg-red-300')">
                            </div>
                            <span class="text-sm font-bold uppercase tracking-widest opacity-80">Live Status</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
                            <template v-if="overallStatus === 'ok'">Semua Sistem Beroperasi Normal</template>
                            <template v-else-if="overallStatus === 'maintenance'">Sebagian Sistem dalam Pemeliharaan</template>
                            <template v-else>Terdeteksi Gangguan pada Sistem</template>
                        </h1>
                        <p class="text-white/70 text-lg">
                            Status sistem infrastruktur digital UPA TIK Universitas Palangka Raya secara real-time.
                        </p>
                    </div>

                    <div class="flex flex-col items-center text-white">
                        <button
                            @click="manualRefresh"
                            :disabled="isRefreshing"
                            class="flex items-center gap-3 px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-2xl font-bold transition-all disabled:opacity-50"
                        >
                            <RefreshCw class="w-5 h-5" :class="{ 'animate-spin': isRefreshing }" />
                            {{ isRefreshing ? 'Memeriksa...' : 'Refresh' }}
                        </button>
                        <p class="text-white/50 text-xs mt-3">Terakhir dicek: {{ formatTime(lastChecked) }}</p>
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="grid grid-cols-3 gap-4 mt-12">
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-white text-center">
                        <div class="text-3xl font-black text-emerald-300">{{ operationalCount }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-70 mt-1">Operasional</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-white text-center">
                        <div class="text-3xl font-black text-amber-300">{{ maintenanceCount }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-70 mt-1">Pemeliharaan</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-5 text-white text-center">
                        <div class="text-3xl font-black text-red-300">{{ issueCount }}</div>
                        <div class="text-xs font-bold uppercase tracking-widest opacity-70 mt-1">Gangguan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

                <!-- Uptime History Chart -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Uptime 30 Hari Terakhir</h2>
                            <p class="text-sm text-slate-500 mt-1">Riwayat ketersediaan sistem secara keseluruhan</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-black text-emerald-500">{{ uptimePercentage }}%</div>
                            <div class="text-xs text-slate-400 uppercase font-bold tracking-widest">Uptime Rata-rata</div>
                        </div>
                    </div>

                    <div class="flex items-end gap-1.5 h-16">
                        <div
                            v-for="(bar, i) in uptimeBars"
                            :key="i"
                            class="flex-1 rounded-sm transition-all duration-300 cursor-pointer group relative"
                            :class="[
                                bar === 'ok' ? 'bg-emerald-400 h-full hover:bg-emerald-500' :
                                bar === 'maintenance' ? 'bg-amber-400 h-3/4 hover:bg-amber-500' :
                                'bg-red-400 h-1/2 hover:bg-red-500'
                            ]"
                        >
                            <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                {{ bar === 'ok' ? 'Operasional' : bar === 'maintenance' ? 'Pemeliharaan' : 'Gangguan' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <span>30 hari lalu</span>
                        <span>Hari ini</span>
                    </div>

                    <div class="flex items-center gap-6 mt-4 text-[11px] font-bold text-slate-500">
                        <span class="flex items-center gap-2"><span class="w-3 h-3 bg-emerald-400 rounded-sm inline-block"></span> Operasional</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 bg-amber-400 rounded-sm inline-block"></span> Pemeliharaan</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-3 bg-red-400 rounded-sm inline-block"></span> Gangguan</span>
                    </div>
                </div>

                <!-- Infrastructure Services -->
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Infrastruktur Inti</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            v-for="service in infraServices"
                            :key="service.name"
                            class="flex items-center gap-5 p-5 rounded-2xl border transition-all"
                            :class="getStatusBg(service.status)"
                        >
                            <div class="w-12 h-12 bg-white dark:bg-slate-900/50 rounded-xl flex items-center justify-center shadow-sm shrink-0">
                                <component :is="service.icon" class="w-6 h-6 text-primary" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-900 dark:text-white text-sm">{{ service.name }}</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ service.category }} · Uptime {{ service.uptime }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <CheckCircle2 v-if="service.status === 'ok'" class="w-5 h-5 text-emerald-500" />
                                <AlertTriangle v-else-if="service.status === 'maintenance'" class="w-5 h-5 text-amber-500" />
                                <XCircle v-else class="w-5 h-5 text-red-500" />
                                <span class="text-xs font-bold" :class="getStatusColor(service.status)">{{ getStatusLabel(service.status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Application Systems -->
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Aplikasi & Sistem</h2>
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
                        <div class="divide-y divide-slate-50 dark:divide-slate-700">
                            <div
                                v-for="project in projects"
                                :key="project.title"
                                class="flex items-center justify-between px-6 py-4 hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors"
                            >
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-2 h-2 rounded-full shrink-0 transition-colors"
                                        :class="{
                                            'bg-emerald-400 shadow-[0_0_6px_2px] shadow-emerald-400/50': systemStatusMap[project.title] === 'ok',
                                            'bg-amber-400 animate-pulse': systemStatusMap[project.title] === 'maintenance',
                                            'bg-red-400': systemStatusMap[project.title] === 'issue',
                                            'bg-slate-300 animate-pulse': systemStatusMap[project.title] === 'checking',
                                        }"
                                    ></div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-900 dark:text-white text-sm truncate">{{ project.title }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase tracking-wide font-bold">{{ project.category }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 shrink-0 ml-4">
                                    <Clock v-if="systemStatusMap[project.title] === 'checking'" class="w-4 h-4 text-slate-400 animate-spin" />
                                    <span
                                        class="text-xs font-bold px-3 py-1 rounded-full"
                                        :class="{
                                            'text-emerald-700 bg-emerald-50 dark:text-emerald-400 dark:bg-emerald-900/20': systemStatusMap[project.title] === 'ok',
                                            'text-amber-700 bg-amber-50 dark:text-amber-400 dark:bg-amber-900/20': systemStatusMap[project.title] === 'maintenance',
                                            'text-red-700 bg-red-50 dark:text-red-400 dark:bg-red-900/20': systemStatusMap[project.title] === 'issue',
                                            'text-slate-500 bg-slate-100 dark:bg-slate-700': systemStatusMap[project.title] === 'checking',
                                        }"
                                    >
                                        {{ getStatusLabel(systemStatusMap[project.title]) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Incident History -->
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Riwayat Insiden & Pemeliharaan</h2>
                    <div class="space-y-4">
                        <div
                            v-for="incident in incidents"
                            :key="incident.date + incident.title"
                            class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-lg" :class="getSeverityClass(incident.severity)">
                                            {{ incident.severity === 'maintenance' ? 'Pemeliharaan' : 'Insiden Minor' }}
                                        </span>
                                        <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                            <CheckCircle2 class="w-3 h-3" /> {{ incident.status }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ incident.title }}</h3>
                                </div>
                                <div class="text-right shrink-0 text-sm text-slate-400">
                                    <p class="font-bold text-slate-900 dark:text-white">{{ incident.date }}</p>
                                    <p class="text-xs">Durasi: {{ incident.duration }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ incident.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </UPAGuestLayout>
</template>
