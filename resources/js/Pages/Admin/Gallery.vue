<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Plus, Search, Pencil, Trash2, Tag, Calendar, Image as ImageIcon } from 'lucide-vue-next';

const search = ref('');
const activeCategory = ref('Semua');

const categories = ['Semua', 'Infrastruktur', 'Pengembangan Sistem', 'Workshop & Pelatihan', 'Kolaborasi & Kemitraan', 'Pemeliharaan'];

const items = [
    { id: 1,  category: 'Infrastruktur',          title: 'Upgrade Server Pusat Data UPR',                date: 'Maret 2026',     photographer: 'Dok. UPA TIK', tags: ['Server', 'Data Center'],   image: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=200&q=60' },
    { id: 2,  category: 'Workshop & Pelatihan',    title: 'Workshop Keamanan Siber untuk Mahasiswa',     date: 'Februari 2026',  photographer: 'Dok. UPA TIK', tags: ['Cybersecurity', 'Pelatihan'], image: 'https://images.unsplash.com/photo-1629904853893-c2c8981a1dc5?w=200&q=60' },
    { id: 3,  category: 'Pemeliharaan',            title: 'Pemeliharaan Jaringan Fiber Optik Kampus',    date: 'Januari 2026',   photographer: 'Dok. UPA TIK', tags: ['Fiber Optik', 'Jaringan'],   image: 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=200&q=60' },
    { id: 4,  category: 'Pengembangan Sistem',     title: 'Review Sprint Pengembangan SIUBER v3',        date: 'April 2026',     photographer: 'Dok. UPA TIK', tags: ['SIUBER', 'Dev'],             image: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=200&q=60' },
    { id: 5,  category: 'Kolaborasi & Kemitraan',  title: 'Penandatanganan MoU dengan Google Cloud',     date: 'Maret 2026',     photographer: 'Dok. Humas',   tags: ['MoU', 'Google Cloud'],       image: 'https://images.unsplash.com/photo-1560472355-536de3962603?w=200&q=60' },
    { id: 6,  category: 'Infrastruktur',           title: 'Instalasi Access Point Wi-Fi FKIP',           date: 'Februari 2026',  photographer: 'Dok. UPA TIK', tags: ['WiFi', 'Eduroam'],           image: 'https://images.unsplash.com/photo-1606904825846-647eb07f5be2?w=200&q=60' },
];

const filtered = computed(() => items.filter(i => {
    const matchCat = activeCategory.value === 'Semua' || i.category === activeCategory.value;
    const matchSearch = !search.value || i.title.toLowerCase().includes(search.value.toLowerCase());
    return matchCat && matchSearch;
}));

const showModal = ref(false);
const deleteTarget = ref(null);
</script>

<template>
    <Head title="Galeri Kegiatan" />
    <AdminLayout title="Galeri Kegiatan">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Galeri Kegiatan</h1>
                <p class="text-slate-500 text-sm mt-0.5">{{ items.length }} foto tersimpan</p>
            </div>
            <button @click="showModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                <Plus class="w-4 h-4" /> Tambah Foto
            </button>
        </div>

        <!-- Category filter + search -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-4 mb-5 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
            <div class="flex gap-2 flex-wrap">
                <button v-for="c in categories" :key="c" @click="activeCategory = c"
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all"
                    :class="activeCategory === c ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                    {{ c }}
                </button>
            </div>
            <div class="relative sm:ml-auto sm:w-64">
                <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                <input v-model="search" type="text" placeholder="Cari judul foto..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-slate-50 dark:bg-slate-800" />
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div v-for="item in filtered" :key="item.id"
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden group hover:border-primary/30 hover:shadow-lg transition-all">
                <!-- Thumbnail -->
                <div class="relative h-44 bg-slate-100 overflow-hidden">
                    <img :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-end p-3 gap-2">
                        <button class="p-2 bg-white/90 text-slate-700 rounded-xl hover:bg-white transition-colors"><Pencil class="w-4 h-4" /></button>
                        <button @click="deleteTarget = item" class="p-2 bg-white/90 text-red-500 rounded-xl hover:bg-white transition-colors"><Trash2 class="w-4 h-4" /></button>
                    </div>
                    <span class="absolute top-3 left-3 px-2.5 py-1 bg-primary text-white text-[10px] font-black uppercase rounded-lg">{{ item.category }}</span>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-slate-800 dark:text-white text-sm leading-snug mb-2">{{ item.title }}</h3>
                    <div class="flex items-center justify-between text-[10px] text-slate-400">
                        <span class="flex items-center gap-1"><Calendar class="w-3 h-3" />{{ item.date }}</span>
                        <span>{{ item.photographer }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1 mt-3">
                        <span v-for="tag in item.tags" :key="tag" class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-lg">{{ tag }}</span>
                    </div>
                </div>
            </div>

            <!-- Empty -->
            <div v-if="filtered.length === 0" class="sm:col-span-2 lg:col-span-3 py-20 text-center bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                <ImageIcon class="w-12 h-12 text-slate-200 mx-auto mb-3" />
                <p class="text-slate-400 font-bold">Tidak ada foto ditemukan.</p>
            </div>
        </div>

        <!-- Add Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tambah Foto Kegiatan</h2>
                    <button @click="showModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Upload area -->
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-8 text-center hover:border-primary/50 transition-colors cursor-pointer">
                        <ImageIcon class="w-10 h-10 text-slate-300 mx-auto mb-3" />
                        <p class="text-sm font-bold text-slate-500">Klik atau seret foto ke sini</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG — maks. 5MB</p>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Judul Foto</label>
                        <input type="text" placeholder="Deskripsi kegiatan..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Kategori</label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                                <option v-for="c in categories.slice(1)" :key="c">{{ c }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Tanggal</label>
                            <input type="month" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Deskripsi</label>
                        <textarea rows="3" placeholder="Ceritakan kegiatan ini..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Tags (pisahkan dengan koma)</label>
                        <input type="text" placeholder="Server, Infrastruktur, Maintenance" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                    </div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="showModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan Foto</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Foto?</h3>
                <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteTarget.title }}</span>" akan dihapus permanen.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
