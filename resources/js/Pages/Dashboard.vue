<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    Newspaper, Image, Download, BookOpen, Users, Handshake,
    Activity, TrendingUp, Eye, ArrowUpRight, Clock, CheckCircle,
    AlertCircle, Home, ChevronRight,
} from 'lucide-vue-next';

const stats = [
    { label: 'Berita Dipublikasikan', value: '24', change: '+3 bulan ini', icon: Newspaper,  color: 'bg-blue-50 text-blue-600',    trend: 'up' },
    { label: 'Item Galeri',           value: '12', change: '+2 bulan ini', icon: Image,      color: 'bg-violet-50 text-violet-600', trend: 'up' },
    { label: 'Dokumen Unduhan',       value: '12', change: 'Tidak berubah', icon: Download,  color: 'bg-amber-50 text-amber-600',   trend: 'flat' },
    { label: 'Artikel KB',            value: '8',  change: '+1 bulan ini', icon: BookOpen,   color: 'bg-emerald-50 text-emerald-600',trend: 'up' },
    { label: 'Anggota Tim',           value: '14', change: 'Tidak berubah', icon: Users,     color: 'bg-pink-50 text-pink-600',     trend: 'flat' },
    { label: 'Mitra Aktif',           value: '10', change: '+1 bulan ini', icon: Handshake,  color: 'bg-orange-50 text-orange-600', trend: 'up' },
];

const quickLinks = [
    { label: 'Kelola Homepage',    icon: Home,      route: 'admin.homepage',       desc: 'Hero, statistik, layanan, proyek' },
    { label: 'Tambah Berita',      icon: Newspaper,  route: 'admin.news',          desc: 'Publikasikan artikel baru' },
    { label: 'Upload ke Galeri',   icon: Image,      route: 'admin.gallery',       desc: 'Tambah foto kegiatan' },
    { label: 'Upload Dokumen',     icon: Download,   route: 'admin.downloads',     desc: 'SOP, formulir, panduan' },
    { label: 'Tulis Panduan KB',   icon: BookOpen,   route: 'admin.knowledge-base',desc: 'Tutorial step-by-step' },
    { label: 'Update Organisasi',  icon: Users,      route: 'admin.organization',  desc: 'Tim, visi, misi, sejarah' },
];

const recentActivity = [
    { action: 'Berita dipublikasikan',        subject: 'Peluncuran SIUBER v3.0',         time: '2 jam lalu',   status: 'published' },
    { action: 'Dokumen ditambahkan',          subject: 'SOP Helpdesk Terbaru 2026',       time: '5 jam lalu',   status: 'added' },
    { action: 'Galeri diperbarui',            subject: 'Workshop Microsoft 365 - Dosen',  time: '1 hari lalu',  status: 'updated' },
    { action: 'Artikel KB ditambahkan',       subject: 'Panduan Eduroam Android & iOS',   time: '2 hari lalu',  status: 'added' },
    { action: 'Mitra baru ditambahkan',       subject: 'Google Cloud Indonesia',          time: '3 hari lalu',  status: 'added' },
    { action: 'Status insiden diselesaikan',  subject: 'Gangguan Jaringan Gedung FKIP',   time: '1 minggu lalu',status: 'resolved' },
];

const statusBadge = {
    published: 'bg-emerald-100 text-emerald-700',
    added:     'bg-blue-100 text-blue-700',
    updated:   'bg-amber-100 text-amber-700',
    resolved:  'bg-slate-100 text-slate-600',
};
const statusLabel = {
    published: 'Dipublikasikan',
    added:     'Ditambahkan',
    updated:   'Diperbarui',
    resolved:  'Diselesaikan',
};
</script>

<template>
    <Head title="Dashboard" />
    <AdminLayout title="Dashboard">

        <!-- Welcome bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Selamat Datang 👋</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola seluruh konten website UPA TIK dari sini.</p>
            </div>
            <a :href="route('home')" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                <Eye class="w-4 h-4" /> Pratinjau Website
                <ArrowUpRight class="w-3.5 h-3.5" />
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <div
                v-for="stat in stats"
                :key="stat.label"
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-5 flex flex-col gap-3"
            >
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="stat.color">
                    <component :is="stat.icon" class="w-5 h-5" />
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900 dark:text-white">{{ stat.value }}</div>
                    <div class="text-xs font-semibold text-slate-500 leading-snug mt-0.5">{{ stat.label }}</div>
                </div>
                <div class="text-[10px] font-bold" :class="stat.trend === 'up' ? 'text-emerald-500' : 'text-slate-400'">
                    {{ stat.change }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Quick Actions (2/3) -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6">
                <h2 class="text-base font-black text-slate-800 dark:text-white mb-5">Aksi Cepat</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <Link
                        v-for="ql in quickLinks"
                        :key="ql.route"
                        :href="route(ql.route)"
                        class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-primary/30 hover:bg-primary/5 transition-all group"
                    >
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-primary/20 transition-colors">
                            <component :is="ql.icon" class="w-5 h-5 text-primary" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-primary transition-colors">{{ ql.label }}</div>
                            <div class="text-xs text-slate-400 truncate">{{ ql.desc }}</div>
                        </div>
                        <ChevronRight class="w-4 h-4 text-slate-300 group-hover:text-primary group-hover:translate-x-1 transition-all shrink-0" />
                    </Link>
                </div>
            </div>

            <!-- Recent Activity (1/3) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6">
                <h2 class="text-base font-black text-slate-800 dark:text-white mb-5">Aktivitas Terkini</h2>
                <div class="space-y-4">
                    <div v-for="item in recentActivity" :key="item.subject" class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-primary/30 rounded-full mt-1.5 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300 leading-snug truncate">{{ item.subject }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded" :class="statusBadge[item.status]">{{ statusLabel[item.status] }}</span>
                                <span class="text-[10px] text-slate-400 flex items-center gap-1"><Clock class="w-3 h-3" />{{ item.time }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </AdminLayout>
</template>
