<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Plus, Search, Pencil, Trash2, Download, FileText, File, FileSpreadsheet, Presentation, Star, Calendar, ArrowDown } from 'lucide-vue-next';

const search = ref('');
const activeCategory = ref('semua');

const categories = [
    { id: 'semua', label: 'Semua' },
    { id: 'sop', label: 'SOP' },
    { id: 'formulir', label: 'Formulir' },
    { id: 'panduan', label: 'Panduan' },
    { id: 'kebijakan', label: 'Kebijakan' },
    { id: 'laporan', label: 'Laporan' },
];

const typeConfig = {
    pdf:  { icon: FileText,        badge: 'bg-red-100 text-red-600' },
    docx: { icon: File,            badge: 'bg-blue-100 text-blue-600' },
    xlsx: { icon: FileSpreadsheet, badge: 'bg-emerald-100 text-emerald-600' },
    pptx: { icon: Presentation,   badge: 'bg-orange-100 text-orange-600' },
};

const files = [
    { id: 1,  category: 'sop',      title: 'SOP Helpdesk & Layanan Teknis',           type: 'pdf',  size: '1.2 MB', date: '2024-03-10', downloads: 384,  featured: true  },
    { id: 2,  category: 'sop',      title: 'SOP Pengelolaan Infrastruktur Jaringan',  type: 'pdf',  size: '2.5 MB', date: '2024-01-20', downloads: 215,  featured: false },
    { id: 3,  category: 'formulir', title: 'Formulir Permohonan Akun Sistem',         type: 'docx', size: '145 KB', date: '2024-02-15', downloads: 928,  featured: true  },
    { id: 4,  category: 'formulir', title: 'Formulir Serah Terima Perangkat IT',      type: 'docx', size: '98 KB',  date: '2024-01-05', downloads: 301,  featured: false },
    { id: 5,  category: 'panduan',  title: 'Panduan Penggunaan E-Learning UPR',       type: 'pdf',  size: '3.8 MB', date: '2024-03-22', downloads: 1542, featured: true  },
    { id: 6,  category: 'panduan',  title: 'Panduan Koneksi Wi-Fi Kampus',            type: 'pdf',  size: '1.1 MB', date: '2024-02-28', downloads: 2103, featured: true  },
    { id: 7,  category: 'panduan',  title: 'Panduan Setting Email Institusi',         type: 'pdf',  size: '870 KB', date: '2024-01-18', downloads: 1890, featured: false },
    { id: 8,  category: 'kebijakan',title: 'Kebijakan Keamanan Informasi UPR',       type: 'pdf',  size: '560 KB', date: '2023-12-01', downloads: 410,  featured: false },
    { id: 9,  category: 'kebijakan',title: 'Kebijakan Penggunaan Aset TIK',          type: 'pdf',  size: '430 KB', date: '2023-11-15', downloads: 295,  featured: false },
    { id: 10, category: 'laporan',  title: 'Laporan Kinerja UPA TIK 2023',           type: 'pdf',  size: '5.2 MB', date: '2024-01-31', downloads: 178,  featured: false },
    { id: 11, category: 'laporan',  title: 'Data Statistik Penggunaan Jaringan 2023',type: 'xlsx', size: '1.8 MB', date: '2024-02-05', downloads: 142,  featured: false },
    { id: 12, category: 'panduan',  title: 'Presentasi Orientasi Layanan TIK',       type: 'pptx', size: '6.4 MB', date: '2024-02-20', downloads: 672,  featured: false },
];

const filtered = computed(() => files.filter(f => {
    const matchCat = activeCategory.value === 'semua' || f.category === activeCategory.value;
    const matchSearch = !search.value || f.title.toLowerCase().includes(search.value.toLowerCase());
    return matchCat && matchSearch;
}));

const showModal = ref(false);
const deleteTarget = ref(null);
const formatDate = (s) => new Date(s).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
</script>

<template>
    <Head title="Pusat Unduhan" />
    <AdminLayout title="Pusat Unduhan">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Pusat Unduhan</h1>
                <p class="text-slate-500 text-sm mt-0.5">{{ files.length }} dokumen tersimpan</p>
            </div>
            <button @click="showModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                <Plus class="w-4 h-4" /> Upload Dokumen
            </button>
        </div>

        <!-- Filter + Search -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-4 mb-5 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <div class="flex gap-2 flex-wrap">
                <button v-for="c in categories" :key="c.id" @click="activeCategory = c.id"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all"
                    :class="activeCategory === c.id ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                    {{ c.label }}
                </button>
            </div>
            <div class="relative sm:ml-auto sm:w-64">
                <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input v-model="search" type="text" placeholder="Cari dokumen..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-slate-50 dark:bg-slate-800" />
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th class="text-left px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Dokumen</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden md:table-cell">Tipe</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden lg:table-cell">Ukuran</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden lg:table-cell">Unduhan</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider hidden md:table-cell">Tanggal</th>
                        <th class="text-left px-4 py-4 text-xs font-black text-slate-400 uppercase tracking-wider">Unggulan</th>
                        <th class="px-4 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <tr v-for="file in filtered" :key="file.id" class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" :class="typeConfig[file.type].badge.replace('text-', 'bg-').replace('600','100')">
                                    <component :is="typeConfig[file.type].icon" class="w-4 h-4" :class="typeConfig[file.type].badge.split(' ')[1]" />
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 dark:text-white line-clamp-1">{{ file.title }}</div>
                                    <span class="text-[10px] font-black uppercase px-1.5 py-0.5 rounded" :class="typeConfig[file.type].badge">{{ file.type }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 hidden md:table-cell">
                            <span class="text-[10px] font-black uppercase px-2 py-1 rounded-lg capitalize" :class="typeConfig[file.type].badge">{{ file.category }}</span>
                        </td>
                        <td class="px-4 py-4 text-slate-400 text-xs hidden lg:table-cell">{{ file.size }}</td>
                        <td class="px-4 py-4 text-slate-500 text-xs hidden lg:table-cell">
                            <span class="flex items-center gap-1"><ArrowDown class="w-3 h-3" />{{ file.downloads.toLocaleString('id-ID') }}</span>
                        </td>
                        <td class="px-4 py-4 text-slate-400 text-xs hidden md:table-cell">{{ formatDate(file.date) }}</td>
                        <td class="px-4 py-4">
                            <span v-if="file.featured" class="text-amber-400"><Star class="w-4 h-4 fill-current" /></span>
                            <span v-else class="text-slate-200"><Star class="w-4 h-4" /></span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1 justify-end">
                                <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                                <button @click="deleteTarget = file" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="filtered.length === 0">
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400 text-sm">Tidak ada dokumen ditemukan.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Upload Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Upload Dokumen</h2>
                    <button @click="showModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-8 text-center hover:border-primary/50 transition-colors cursor-pointer">
                        <Download class="w-10 h-10 text-slate-300 mx-auto mb-3" />
                        <p class="text-sm font-bold text-slate-500">Klik atau seret file ke sini</p>
                        <p class="text-xs text-slate-400 mt-1">PDF, DOCX, XLSX, PPTX — maks. 20MB</p>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Judul Dokumen</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Deskripsi</label>
                        <textarea rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Kategori</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option v-for="c in categories.slice(1)" :key="c.id" :value="c.id">{{ c.label }}</option>
                            </select>
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 rounded text-primary border-slate-300" />
                                <span class="text-sm font-semibold text-slate-600">Tandai unggulan</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="showModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Upload & Simpan</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Dokumen?</h3>
                <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteTarget.title }}</span>" akan dihapus permanen.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
