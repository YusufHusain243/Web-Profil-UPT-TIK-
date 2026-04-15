<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Activity, CheckCircle, AlertTriangle, XCircle, Clock, Plus, Pencil, Trash2, RotateCcw } from 'lucide-vue-next';

const services = ref([
    { id: 1, name: 'SIUBER (Sistem Informasi Akademik)',    status: 'operational',   uptime: '99.8%', responseTime: '124ms', lastCheck: '1 mnt lalu' },
    { id: 2, name: 'Portal Email Institusi',                status: 'operational',   uptime: '99.9%', responseTime: '89ms',  lastCheck: '1 mnt lalu' },
    { id: 3, name: 'Wi-Fi Kampus (Eduroam)',               status: 'degraded',      uptime: '97.2%', responseTime: '340ms', lastCheck: '2 mnt lalu' },
    { id: 4, name: 'VPN Kampus',                           status: 'operational',   uptime: '99.5%', responseTime: '156ms', lastCheck: '1 mnt lalu' },
    { id: 5, name: 'Library Digital (Repository)',         status: 'operational',   uptime: '99.7%', responseTime: '210ms', lastCheck: '1 mnt lalu' },
    { id: 6, name: 'Server Backup & Storage',              status: 'maintenance',   uptime: '—',     responseTime: '—',     lastCheck: '5 mnt lalu' },
    { id: 7, name: 'Sistem Absensi Digital',               status: 'operational',   uptime: '98.9%', responseTime: '180ms', lastCheck: '1 mnt lalu' },
    { id: 8, name: 'Cloud Infrastructure (Azure)',         status: 'operational',   uptime: '99.95%', responseTime: '67ms', lastCheck: '30 dtk lalu' },
]);

const incidents = ref([
    { id: 1, title: 'Gangguan Jaringan Wi-Fi Gedung C',           status: 'investigating', severity: 'medium', started: '2 jam lalu',  desc: 'Tim sedang menginvestigasi penurunan kualitas sinyal Wi-Fi di area Gedung C.' },
    { id: 2, title: 'Maintenance Server Backup Terjadwal',         status: 'maintenance',   severity: 'low',    started: '1 jam lalu',  desc: 'Pemeliharaan rutin server backup dijadwalkan hingga pukul 18.00 WIB.' },
    { id: 3, title: 'Gangguan Akses SIUBER (Resolved)',            status: 'resolved',      severity: 'high',   started: '2 hari lalu', desc: 'Masalah akses SIUBER telah diselesaikan. Layanan kembali normal pukul 14.30 WIB.' },
]);

const statusConfig = {
    operational: { label: 'Operasional',  cls: 'bg-emerald-100 text-emerald-600', icon: CheckCircle,    dot: 'bg-emerald-400' },
    degraded:    { label: 'Terganggu',    cls: 'bg-amber-100 text-amber-600',     icon: AlertTriangle,  dot: 'bg-amber-400 animate-pulse' },
    maintenance: { label: 'Pemeliharaan', cls: 'bg-blue-100 text-blue-600',       icon: Clock,          dot: 'bg-blue-400' },
    outage:      { label: 'Tidak Aktif',  cls: 'bg-red-100 text-red-600',         icon: XCircle,        dot: 'bg-red-500 animate-pulse' },
};

const severityConfig = {
    low:    'bg-slate-100 text-slate-600',
    medium: 'bg-amber-100 text-amber-600',
    high:   'bg-red-100 text-red-600',
};

const incidentStatusConfig = {
    investigating: { label: 'Investigasi', cls: 'bg-amber-100 text-amber-600' },
    maintenance:   { label: 'Pemeliharaan', cls: 'bg-blue-100 text-blue-600' },
    resolved:      { label: 'Selesai',     cls: 'bg-emerald-100 text-emerald-600' },
};

const editService = ref(null);
const addIncidentModal = ref(false);
const deleteTarget = ref(null);

const overallStatus = 'degraded'; // computed from services
const operationalCount = services.value.filter(s => s.status === 'operational').length;
</script>

<template>
    <Head title="Status Sistem" />
    <AdminLayout title="Status Sistem">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Status Sistem</h1>
                <p class="text-slate-500 text-sm mt-0.5">Monitor kondisi real-time semua layanan TIK</p>
            </div>
            <div class="flex gap-2">
                <button class="inline-flex items-center gap-2 px-4 py-2.5 border border-slate-200 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-50 transition-colors">
                    <RotateCcw class="w-4 h-4" /> Refresh
                </button>
                <button @click="addIncidentModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                    <Plus class="w-4 h-4" /> Tambah Insiden
                </button>
            </div>
        </div>

        <!-- Overall Status Banner -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-center gap-3 mb-6">
            <AlertTriangle class="w-6 h-6 text-amber-500 shrink-0" />
            <div>
                <p class="font-black text-amber-700 text-sm">Layanan Terganggu Sebagian</p>
                <p class="text-amber-600 text-xs mt-0.5">{{ operationalCount }} dari {{ services.length }} layanan beroperasi normal.</p>
            </div>
            <span class="ml-auto text-[10px] font-black uppercase tracking-widest text-amber-400">Diperbarui: baru saja</span>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div v-for="(cfg, key) in statusConfig" :key="key" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-4">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-2.5 h-2.5 rounded-full" :class="cfg.dot"></div>
                    <span class="text-xs font-bold text-slate-500">{{ cfg.label }}</span>
                </div>
                <p class="text-2xl font-black text-slate-900 dark:text-white">{{ services.filter(s => s.status === key).length }}</p>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-0.5">Layanan</p>
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden mb-6">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                <h2 class="font-black text-slate-900 dark:text-white text-base">Daftar Layanan</h2>
            </div>
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th class="text-left px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400">Layanan</th>
                        <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                        <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hidden md:table-cell">Uptime</th>
                        <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hidden lg:table-cell">Response</th>
                        <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hidden lg:table-cell">Cek Terakhir</th>
                        <th class="px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <tr v-for="svc in services" :key="svc.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-2.5 h-2.5 rounded-full shrink-0" :class="statusConfig[svc.status]?.dot"></div>
                                <span class="font-bold text-slate-800 dark:text-white text-sm">{{ svc.name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-xl" :class="statusConfig[svc.status]?.cls">
                                {{ statusConfig[svc.status]?.label }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-slate-500 hidden md:table-cell">{{ svc.uptime }}</td>
                        <td class="px-4 py-4 text-sm text-slate-500 hidden lg:table-cell">{{ svc.responseTime }}</td>
                        <td class="px-4 py-4 text-xs text-slate-400 hidden lg:table-cell">{{ svc.lastCheck }}</td>
                        <td class="px-4 py-4 text-right">
                            <button @click="editService = svc" class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Incidents -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                <h2 class="font-black text-slate-900 dark:text-white text-base">Riwayat Insiden</h2>
            </div>
            <div class="divide-y divide-slate-50 dark:divide-slate-800">
                <div v-for="incident in incidents" :key="incident.id" class="p-5 flex items-start gap-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-xl" :class="incidentStatusConfig[incident.status]?.cls">{{ incidentStatusConfig[incident.status]?.label }}</span>
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-xl" :class="severityConfig[incident.severity] ?? severityConfig.low">
                                {{ { low: 'Rendah', medium: 'Sedang', high: 'Tinggi' }[incident.severity] }}
                            </span>
                            <span class="text-[10px] text-slate-400">{{ incident.started }}</span>
                        </div>
                        <p class="font-bold text-slate-800 dark:text-white text-sm mb-1">{{ incident.title }}</p>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ incident.desc }}</p>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                        <button @click="deleteTarget = incident" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Service Modal -->
        <div v-if="editService" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Ubah Status Layanan</h2>
                    <button @click="editService = null" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Nama Layanan</label>
                        <input type="text" :value="editService.name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Status</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label v-for="(cfg, key) in statusConfig" :key="key"
                                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-all"
                                :class="editService.status === key ? 'border-primary bg-primary/5' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" name="status" :value="key" :checked="editService.status === key" class="sr-only" />
                                <div class="w-2.5 h-2.5 rounded-full shrink-0" :class="cfg.dot.split(' ')[0]"></div>
                                <span class="text-xs font-bold text-slate-700">{{ cfg.label }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="editService = null" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="editService = null" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Add Incident Modal -->
        <div v-if="addIncidentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tambah Insiden Baru</h2>
                    <button @click="addIncidentModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Judul Insiden</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Status</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option v-for="(cfg, key) in incidentStatusConfig" :key="key" :value="key">{{ cfg.label }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Tingkat Keparahan</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option value="low">Rendah</option>
                                <option value="medium">Sedang</option>
                                <option value="high">Tinggi</option>
                            </select>
                        </div>
                    </div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Deskripsi</label><textarea rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea></div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="addIncidentModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="addIncidentModal = false" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Insiden?</h3>
                <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteTarget.title }}</span>" akan dihapus.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
