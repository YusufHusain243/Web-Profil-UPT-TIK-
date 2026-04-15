<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus, Pencil, Trash2, Building2, Cpu, Globe } from 'lucide-vue-next';

const activeCategory = ref('semua');

const categories = [
    { id: 'semua',       label: 'Semua' },
    { id: 'institusi',   label: 'Institusi' },
    { id: 'teknologi',   label: 'Teknologi' },
    { id: 'pemerintah',  label: 'Pemerintah' },
];

const partners = [
    { id: 1, name: 'Kementerian Pendidikan Kebudayaan Riset dan Teknologi', category: 'pemerintah', icon: '🏛️', color: 'from-blue-500 to-blue-700',    desc: 'Kemitraan strategis dalam pengembangan sistem informasi pendidikan tinggi nasional.',         since: '2018', website: 'kemdikbud.go.id' },
    { id: 2, name: 'Telkom Indonesia',                                       category: 'teknologi',  icon: '📡', color: 'from-red-500 to-red-700',      desc: 'Penyediaan infrastruktur jaringan fiber optik dan layanan konektivitas kampus.',              since: '2015', website: 'telkom.co.id' },
    { id: 3, name: 'Universitas Indonesia (UI)',                             category: 'institusi',  icon: '🎓', color: 'from-amber-500 to-yellow-700',  desc: 'Kolaborasi riset dan pengembangan sistem informasi akademik terintegrasi.',                  since: '2020', website: 'ui.ac.id' },
    { id: 4, name: 'Microsoft Indonesia',                                    category: 'teknologi',  icon: '💻', color: 'from-cyan-500 to-blue-700',     desc: 'Program Microsoft Education: lisensi Office 365, Azure cloud, dan pelatihan sertifikasi.',  since: '2019', website: 'microsoft.com/id' },
    { id: 5, name: 'Google Cloud Indonesia',                                 category: 'teknologi',  icon: '☁️', color: 'from-emerald-500 to-teal-700',  desc: 'Google Workspace for Education dan program Google Cloud Skills Boost bagi mahasiswa.',       since: '2021', website: 'cloud.google.com' },
    { id: 6, name: 'Badan Siber dan Sandi Negara (BSSN)',                   category: 'pemerintah', icon: '🔐', color: 'from-slate-500 to-slate-700',   desc: 'Pendampingan keamanan siber dan sertifikasi sistem keamanan informasi kampus.',              since: '2022', website: 'bssn.go.id' },
];

const filtered = computed(() => partners.filter(p => activeCategory.value === 'semua' || p.category === activeCategory.value));

const showModal = ref(false);
const editTarget = ref(null);
const deleteTarget = ref(null);

import { computed } from 'vue';
</script>

<template>
    <Head title="Mitra" />
    <AdminLayout title="Mitra">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Mitra & Kolaborasi</h1>
                <p class="text-slate-500 text-sm mt-0.5">{{ partners.length }} mitra aktif</p>
            </div>
            <button @click="showModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                <Plus class="w-4 h-4" /> Tambah Mitra
            </button>
        </div>

        <!-- Filter -->
        <div class="flex gap-2 mb-6 flex-wrap">
            <button v-for="c in categories" :key="c.id" @click="activeCategory = c.id"
                class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all"
                :class="activeCategory === c.id ? 'bg-primary text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50'">
                {{ c.label }}
            </button>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <div v-for="partner in filtered" :key="partner.id"
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-lg transition-all group">
                <!-- Card header -->
                <div :class="`bg-gradient-to-br ${partner.color} p-5 flex items-center gap-4`">
                    <span class="text-4xl leading-none drop-shadow">{{ partner.icon }}</span>
                    <div class="flex-1 min-w-0">
                        <span class="inline-block text-[9px] font-black uppercase tracking-widest bg-white/20 text-white px-2 py-0.5 rounded mb-1">
                            {{ categories.find(c => c.id === partner.category)?.label }}
                        </span>
                        <p class="font-black text-white text-sm leading-snug line-clamp-2">{{ partner.name }}</p>
                    </div>
                </div>
                <!-- Body -->
                <div class="p-5">
                    <p class="text-slate-500 text-xs leading-relaxed mb-4">{{ partner.desc }}</p>
                    <div class="flex items-center gap-4 text-[10px] font-black uppercase text-slate-400">
                        <span class="flex items-center gap-1"><Building2 class="w-3 h-3" /> Sejak {{ partner.since }}</span>
                        <a :href="`https://${partner.website}`" target="_blank" class="flex items-center gap-1 hover:text-primary transition-colors"><Globe class="w-3 h-3" /> {{ partner.website }}</a>
                    </div>
                </div>
                <!-- Actions -->
                <div class="flex gap-2 px-5 pb-5">
                    <button @click="editTarget = partner" class="flex-1 py-2 text-xs font-bold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors flex items-center justify-center gap-1.5"><Pencil class="w-3.5 h-3.5" /> Edit</button>
                    <button @click="deleteTarget = partner" class="py-2 px-3 text-xs font-bold text-red-500 border border-red-100 rounded-xl hover:bg-red-50 transition-colors flex items-center justify-center gap-1.5"><Trash2 class="w-3.5 h-3.5" /></button>
                </div>
            </div>
        </div>

        <!-- Add / Edit Modal -->
        <div v-if="showModal || editTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">{{ editTarget ? 'Edit Mitra' : 'Tambah Mitra Baru' }}</h2>
                    <button @click="showModal = false; editTarget = null" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Nama Institusi</label>
                        <input type="text" :value="editTarget?.name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Kategori</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option v-for="c in categories.slice(1)" :key="c.id" :value="c.id" :selected="editTarget?.category === c.id">{{ c.label }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Tahun Bergabung</label>
                            <input type="number" :value="editTarget?.since ?? new Date().getFullYear()" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Ikon (Emoji)</label>
                        <input type="text" :value="editTarget?.icon ?? '🏢'" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="🏢" />
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Website</label>
                        <input type="text" :value="editTarget?.website" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" placeholder="contoh.co.id" />
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Deskripsi</label>
                        <textarea rows="3" :value="editTarget?.desc" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="showModal = false; editTarget = null" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="showModal = false; editTarget = null" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Mitra?</h3>
                <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteTarget.name }}</span>" akan dihapus.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
