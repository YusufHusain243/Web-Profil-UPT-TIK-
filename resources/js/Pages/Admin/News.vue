<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Plus, Search, Pencil, Trash2, Eye, Star, Tag, Calendar, ChevronDown, Filter } from 'lucide-vue-next';

const search = ref('');
const activeFilter = ref('semua');

const filters = [
    { id: 'semua',      label: 'Semua' },
    { id: 'published',  label: 'Dipublikasikan' },
    { id: 'draft',      label: 'Draf' },
    { id: 'featured',   label: 'Unggulan' },
];

const news = [
    { id: 1, title: 'Peluncuran SIUBER v3.0 dengan Fitur AI Baru',           category: 'Inovasi',    date: '12 Apr 2026', status: 'published', featured: true,  views: 1420 },
    { id: 2, title: 'Workshop Keamanan Siber untuk Mahasiswa Baru',           category: 'Kegiatan',   date: '10 Apr 2026', status: 'published', featured: false, views: 892 },
    { id: 3, title: 'Penandatanganan MoU UPR dengan Google Cloud Indonesia',  category: 'Kemitraan',  date: '5 Apr 2026',  status: 'published', featured: true,  views: 2103 },
    { id: 4, title: 'Upgrade Infrastruktur Jaringan Fiber Optik Kampus',      category: 'Infrastruktur', date: '1 Apr 2026', status: 'draft',    featured: false, views: 0 },
    { id: 5, title: 'Pelatihan Microsoft 365 untuk 85 Dosen UPR',             category: 'Kegiatan',   date: '28 Mar 2026', status: 'published', featured: false, views: 679 },
    { id: 6, title: 'Laporan Kinerja Layanan TIK Kuartal I 2026',             category: 'Laporan',    date: '25 Mar 2026', status: 'draft',     featured: false, views: 0 },
    { id: 7, title: 'Kompetisi Hackathon SIBERAKAD 2026 Resmi Dibuka',        category: 'Kegiatan',   date: '20 Mar 2026', status: 'published', featured: true,  views: 1891 },
    { id: 8, title: 'Pembaruan Kebijakan Keamanan Data Mahasiswa UPR',        category: 'Kebijakan',  date: '15 Mar 2026', status: 'published', featured: false, views: 445 },
];

const filtered = computed(() => news.filter(n => {
    const matchFilter = activeFilter.value === 'semua'
        || (activeFilter.value === 'published' && n.status === 'published')
        || (activeFilter.value === 'draft' && n.status === 'draft')
        || (activeFilter.value === 'featured' && n.featured);
    const matchSearch = !search.value || n.title.toLowerCase().includes(search.value.toLowerCase());
    return matchFilter && matchSearch;
}));

const showModal = ref(false);
const deleteTarget = ref(null);
</script>

<template>
    <Head title="Berita & Inovasi" />
    <AdminLayout title="Berita & Inovasi">

        <!-- Page header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Berita & Inovasi</h1>
                <p class="text-slate-500 text-sm mt-0.5">{{ news.length }} artikel tersimpan</p>
            </div>
            <button @click="showModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                <Plus class="w-4 h-4" /> Tulis Artikel Baru
            </button>
        </div>

        <!-- Filters + Search -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-4 mb-5 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <div class="flex gap-2 flex-wrap">
                <button
                    v-for="f in filters" :key="f.id"
                    @click="activeFilter = f.id"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all"
                    :class="activeFilter === f.id ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                >{{ f.label }}</button>
            </div>
            <div class="relative sm:ml-auto sm:w-64">
                <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input v-model="search" type="text" placeholder="Cari judul artikel..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-slate-50 dark:bg-slate-800" />
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Judul</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden lg:table-cell">Tanggal</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden lg:table-cell">Views</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <tr v-for="item in filtered" :key="item.id" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <Star v-if="item.featured" class="w-3.5 h-3.5 text-amber-400 fill-current shrink-0" />
                                <span class="font-semibold text-slate-800 dark:text-white line-clamp-1">{{ item.title }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell">
                            <span class="px-2.5 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase rounded-lg">{{ item.category }}</span>
                        </td>
                        <td class="px-4 py-4 text-slate-400 text-xs hidden lg:table-cell">
                            <span class="flex items-center gap-1"><Calendar class="w-3 h-3" />{{ item.date }}</span>
                        </td>
                        <td class="px-4 py-4 text-slate-500 text-xs hidden lg:table-cell">
                            <span class="flex items-center gap-1"><Eye class="w-3 h-3" />{{ item.views.toLocaleString('id-ID') }}</span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase"
                                :class="item.status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'">
                                {{ item.status === 'published' ? 'Publik' : 'Draf' }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1 justify-end">
                                <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors"><Eye class="w-4 h-4" /></button>
                                <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                                <button @click="deleteTarget = item" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="filtered.length === 0">
                        <td colspan="6" class="px-6 py-16 text-center text-slate-400 text-sm">Tidak ada artikel ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add/Edit Modal placeholder -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tulis Artikel Baru</h2>
                    <button @click="showModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Judul</label>
                        <input type="text" placeholder="Judul artikel..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Kategori</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option>Inovasi</option><option>Kegiatan</option><option>Kemitraan</option><option>Infrastruktur</option><option>Laporan</option><option>Kebijakan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Status</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option value="draft">Draf</option><option value="published">Publikasikan</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Ringkasan</label>
                        <textarea rows="2" placeholder="Deskripsi singkat..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Konten</label>
                        <textarea rows="5" placeholder="Isi artikel..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="featured" class="w-4 h-4 rounded border-slate-300 text-primary" />
                        <label for="featured" class="text-sm font-semibold text-slate-600">Tandai sebagai unggulan</label>
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="showModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan Artikel</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Artikel?</h3>
                <p class="text-slate-500 text-sm mb-6">Artikel "<span class="font-bold text-slate-700">{{ deleteTarget.title }}</span>" akan dihapus permanen.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
