<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Plus, Search, Pencil, Trash2, Eye, Star, Clock, BookOpen, ChevronRight } from 'lucide-vue-next';

const search = ref('');
const activeCategory = ref('semua');

const categories = [
    { id: 'semua', label: 'Semua' },
    { id: 'email', label: 'Email Institusi' },
    { id: 'wifi', label: 'Wi-Fi & Jaringan' },
    { id: 'siakad', label: 'SIAKAD' },
    { id: 'keamanan', label: 'Keamanan' },
    { id: 'infrastruktur', label: 'Infrastruktur' },
];

const catLabel = (id) => categories.find(c => c.id === id)?.label ?? id;

const articles = [
    { id: 1, category: 'email',         title: 'Cara Setting Email Institusi di Microsoft Outlook',    author: 'Tim TIK UPR',        readTime: '5 menit', views: 1420, rating: 4.8, featured: true,  steps: 5 },
    { id: 2, category: 'wifi',          title: 'Cara Konfigurasi Eduroam di Android & iOS',            author: 'Tim Infrastruktur',  readTime: '4 menit', views: 2318, rating: 4.9, featured: true,  steps: 4 },
    { id: 3, category: 'siakad',        title: 'Panduan Login dan Pengisian KRS di SIUBER',             author: 'Tim Akademik',       readTime: '7 menit', views: 3102, rating: 4.7, featured: true,  steps: 6 },
    { id: 4, category: 'keamanan',      title: 'Cara Mengaktifkan Autentikasi Dua Faktor (2FA)',        author: 'Tim Keamanan',       readTime: '6 menit', views: 987,  rating: 4.8, featured: false, steps: 5 },
    { id: 5, category: 'infrastruktur', title: 'Cara Mengakses VPN Kampus dari Luar Jaringan',         author: 'Tim Infrastruktur',  readTime: '8 menit', views: 765,  rating: 4.6, featured: false, steps: 7 },
    { id: 6, category: 'email',         title: 'Menggunakan Google Meet melalui Akun Institusi',       author: 'Tim TIK UPR',        readTime: '5 menit', views: 1234, rating: 4.7, featured: false, steps: 4 },
    { id: 7, category: 'wifi',          title: 'Troubleshooting Koneksi Eduroam yang Bermasalah',      author: 'Tim Helpdesk',       readTime: '6 menit', views: 890,  rating: 4.5, featured: false, steps: 6 },
    { id: 8, category: 'siakad',        title: 'Panduan Input Nilai Mahasiswa di Portal Dosen',        author: 'Tim Akademik',       readTime: '9 menit', views: 1540, rating: 4.9, featured: true,  steps: 8 },
];

const filtered = computed(() => articles.filter(a => {
    const matchCat = activeCategory.value === 'semua' || a.category === activeCategory.value;
    const matchSearch = !search.value || a.title.toLowerCase().includes(search.value.toLowerCase());
    return matchCat && matchSearch;
}));

const showModal = ref(false);
const deleteTarget = ref(null);
</script>

<template>
    <Head title="Knowledge Base" />
    <AdminLayout title="Knowledge Base">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Knowledge Base</h1>
                <p class="text-slate-500 text-sm mt-0.5">{{ articles.length }} artikel panduan tersimpan</p>
            </div>
            <button @click="showModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                <Plus class="w-4 h-4" /> Tulis Panduan Baru
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
                <input v-model="search" type="text" placeholder="Cari artikel..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-slate-50 dark:bg-slate-800" />
            </div>
        </div>

        <!-- Article list -->
        <div class="space-y-4">
            <div v-for="article in filtered" :key="article.id"
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-5 flex items-start gap-4 hover:border-primary/30 hover:shadow-md transition-all group">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                    <BookOpen class="w-5 h-5 text-primary" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="text-[10px] font-black uppercase tracking-widest text-primary">{{ catLabel(article.category) }}</span>
                        <span v-if="article.featured" class="text-[10px] bg-amber-100 text-amber-600 font-bold px-2 py-0.5 rounded">Populer</span>
                    </div>
                    <h3 class="font-bold text-slate-800 dark:text-white group-hover:text-primary transition-colors leading-snug mb-2">{{ article.title }}</h3>
                    <div class="flex flex-wrap items-center gap-4 text-[10px] font-bold text-slate-400 uppercase">
                        <span class="flex items-center gap-1"><Clock class="w-3 h-3" />{{ article.readTime }}</span>
                        <span class="flex items-center gap-1"><Eye class="w-3 h-3" />{{ article.views.toLocaleString('id-ID') }} views</span>
                        <span class="flex items-center gap-1 text-amber-500"><Star class="w-3 h-3 fill-current" />{{ article.rating }}</span>
                        <span>{{ article.steps }} langkah</span>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <button class="p-1.5 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors"><Eye class="w-4 h-4" /></button>
                    <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                    <button @click="deleteTarget = article" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                </div>
            </div>

            <div v-if="filtered.length === 0" class="py-20 text-center bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                <BookOpen class="w-12 h-12 text-slate-200 mx-auto mb-3" />
                <p class="text-slate-400 font-bold">Tidak ada artikel ditemukan.</p>
            </div>
        </div>

        <!-- Add Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800 sticky top-0 bg-white dark:bg-slate-900 z-10">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tulis Panduan Baru</h2>
                    <button @click="showModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Judul Panduan</label>
                        <input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Kategori</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option v-for="c in categories.slice(1)" :key="c.id" :value="c.id">{{ c.label }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Penulis</label>
                            <input type="text" placeholder="Tim TIK UPR" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Deskripsi</label>
                        <textarea rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                    </div>
                    <!-- Steps -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Langkah-langkah</label>
                            <button class="text-xs font-bold text-primary hover:underline flex items-center gap-1"><Plus class="w-3 h-3" /> Tambah Langkah</button>
                        </div>
                        <div class="space-y-3">
                            <div v-for="n in 2" :key="n" class="flex items-start gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700">
                                <div class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-black shrink-0">{{ n }}</div>
                                <div class="flex-1 space-y-2">
                                    <input type="text" :placeholder="`Judul langkah ${n}`" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                                    <textarea rows="2" :placeholder="`Penjelasan langkah ${n}...`" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                                </div>
                                <button class="p-1.5 text-slate-400 hover:text-red-500 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" class="w-4 h-4 rounded text-primary border-slate-300" />
                        <label class="text-sm font-semibold text-slate-600">Tandai sebagai unggulan</label>
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end sticky bottom-0 bg-white dark:bg-slate-900">
                    <button @click="showModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan Panduan</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Artikel?</h3>
                <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteTarget.title }}</span>" akan dihapus permanen.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
