<script setup>
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { Download, Search, FileText, File, FileSpreadsheet, Presentation, ChevronRight, Calendar, ArrowDown } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const searchQuery = ref('');
const activeCategory = ref('semua');

const categories = [
    { id: 'semua', label: 'Semua Dokumen' },
    { id: 'sop', label: 'SOP' },
    { id: 'formulir', label: 'Formulir' },
    { id: 'panduan', label: 'Panduan' },
    { id: 'kebijakan', label: 'Kebijakan' },
    { id: 'laporan', label: 'Laporan' },
];

const fileTypeConfig = {
    pdf:  { icon: FileText,        badge: 'bg-red-50 text-red-600 border border-red-100',                    iconBg: 'bg-red-50',      iconColor: 'text-red-500' },
    docx: { icon: File,            badge: 'bg-blue-50 text-blue-600 border border-blue-100',                 iconBg: 'bg-blue-50',     iconColor: 'text-blue-500' },
    xlsx: { icon: FileSpreadsheet, badge: 'bg-emerald-50 text-emerald-600 border border-emerald-100',        iconBg: 'bg-emerald-50',  iconColor: 'text-emerald-500' },
    pptx: { icon: Presentation,   badge: 'bg-orange-50 text-orange-600 border border-orange-100',           iconBg: 'bg-orange-50',   iconColor: 'text-orange-500' },
};

const files = [
    { id: 1,  category: 'sop',      title: 'SOP Helpdesk & Layanan Teknis',           description: 'Prosedur standar operasional untuk layanan helpdesk dan dukungan teknis UPA TIK.',                        type: 'pdf',  size: '1.2 MB', date: '2024-03-10', downloads: 384,  featured: true  },
    { id: 2,  category: 'sop',      title: 'SOP Pengelolaan Infrastruktur Jaringan',  description: 'Prosedur pengelolaan dan pemeliharaan infrastruktur jaringan kampus UPR.',                                 type: 'pdf',  size: '2.5 MB', date: '2024-01-20', downloads: 215,  featured: false },
    { id: 3,  category: 'formulir', title: 'Formulir Permohonan Akun Sistem',         description: 'Formulir resmi untuk permohonan akun baru SIAKAD, email institusi, dan sistem lainnya.',                  type: 'docx', size: '145 KB', date: '2024-02-15', downloads: 928,  featured: true  },
    { id: 4,  category: 'formulir', title: 'Formulir Serah Terima Perangkat IT',      description: 'Formulir dokumentasi serah terima perangkat keras dan lunak milik universitas.',                            type: 'docx', size: '98 KB',  date: '2024-01-05', downloads: 301,  featured: false },
    { id: 5,  category: 'panduan',  title: 'Panduan Penggunaan E-Learning UPR',       description: 'Panduan lengkap untuk dosen dan mahasiswa dalam menggunakan platform LMS e-learning.',                     type: 'pdf',  size: '3.8 MB', date: '2024-03-22', downloads: 1542, featured: true  },
    { id: 6,  category: 'panduan',  title: 'Panduan Koneksi Wi-Fi Kampus',            description: 'Cara menghubungkan perangkat ke jaringan Wi-Fi kampus UPR untuk semua platform.',                          type: 'pdf',  size: '1.1 MB', date: '2024-02-28', downloads: 2103, featured: true  },
    { id: 7,  category: 'panduan',  title: 'Panduan Setting Email Institusi',         description: 'Instruksi konfigurasi email @upr.ac.id di berbagai aplikasi email client populer.',                        type: 'pdf',  size: '870 KB', date: '2024-01-18', downloads: 1890, featured: false },
    { id: 8,  category: 'kebijakan',title: 'Kebijakan Keamanan Informasi UPR',       description: 'Dokumen kebijakan resmi pengamanan data dan informasi di lingkungan universitas.',                          type: 'pdf',  size: '560 KB', date: '2023-12-01', downloads: 410,  featured: false },
    { id: 9,  category: 'kebijakan',title: 'Kebijakan Penggunaan Aset TIK',          description: 'Aturan dan tata kelola penggunaan perangkat dan layanan teknologi milik UPR.',                              type: 'pdf',  size: '430 KB', date: '2023-11-15', downloads: 295,  featured: false },
    { id: 10, category: 'laporan',  title: 'Laporan Kinerja UPA TIK 2023',           description: 'Rekapitulasi kegiatan, statistik layanan, dan capaian UPA TIK selama tahun 2023.',                         type: 'pdf',  size: '5.2 MB', date: '2024-01-31', downloads: 178,  featured: false },
    { id: 11, category: 'laporan',  title: 'Data Statistik Penggunaan Jaringan 2023',description: 'Laporan trafik, uptime, dan statistik penggunaan infrastruktur jaringan kampus.',                           type: 'xlsx', size: '1.8 MB', date: '2024-02-05', downloads: 142,  featured: false },
    { id: 12, category: 'panduan',  title: 'Presentasi Orientasi Layanan TIK',       description: 'Slide presentasi pengenalan layanan UPA TIK untuk mahasiswa baru.',                                         type: 'pptx', size: '6.4 MB', date: '2024-02-20', downloads: 672,  featured: false },
];

const featuredFiles = computed(() => files.filter(f => f.featured));

const filteredFiles = computed(() => {
    return files.filter(f => {
        const matchCat = activeCategory.value === 'semua' || f.category === activeCategory.value;
        const q = searchQuery.value.toLowerCase();
        const matchSearch = !q || f.title.toLowerCase().includes(q) || f.description.toLowerCase().includes(q);
        return matchCat && matchSearch;
    });
});

const totalDownloads = computed(() => files.reduce((s, f) => s + f.downloads, 0));

const formatDate = (str) =>
    new Date(str).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

const categoryLabel = (id) => categories.find(c => c.id === id)?.label ?? id;
</script>

<template>
    <UPAGuestLayout title="Pusat Unduhan">

        <!-- Hero / Header -->
        <section class="pt-40 pb-20 bg-primary text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-96 h-96 bg-secondary rounded-full translate-x-1/2 -translate-y-1/2 blur-[100px]"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 translate-y-1/2 blur-[100px]"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-12">
                    <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-secondary font-bold text-xs uppercase tracking-widest rounded-full mb-6 inline-block">Dokumen Resmi</span>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Pusat Unduhan</h1>
                    <p class="text-slate-300 max-w-2xl mx-auto text-lg leading-relaxed">
                        SOP, formulir, panduan, dan dokumen resmi UPA TIK tersedia untuk diunduh oleh seluruh civitas akademika secara gratis.
                    </p>
                </div>

                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-10 mb-12">
                    <div class="text-center">
                        <div class="text-3xl font-black text-secondary">{{ files.length }}</div>
                        <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Dokumen</div>
                    </div>
                    <div class="w-px bg-white/10 hidden sm:block"></div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-secondary">{{ categories.length - 1 }}</div>
                        <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Kategori</div>
                    </div>
                    <div class="w-px bg-white/10 hidden sm:block"></div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-secondary">{{ totalDownloads.toLocaleString('id-ID') }}+</div>
                        <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Total Unduhan</div>
                    </div>
                </div>

                <!-- Search -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative">
                        <Search class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari dokumen, SOP, formulir..."
                            class="w-full pl-14 pr-6 py-5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-secondary text-base"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured / Populer -->
        <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">Dokumen Populer</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div
                        v-for="file in featuredFiles"
                        :key="file.id"
                        class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/30 hover:shadow-xl transition-all group flex flex-col"
                    >
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" :class="fileTypeConfig[file.type].iconBg">
                                <component :is="fileTypeConfig[file.type].icon" class="w-5 h-5" :class="fileTypeConfig[file.type].iconColor" />
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-lg" :class="fileTypeConfig[file.type].badge">
                                {{ file.type }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-primary transition-colors flex-1">{{ file.title }}</h3>
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-slate-50 dark:border-slate-700">
                            <span class="text-[10px] font-bold text-slate-400 flex items-center gap-1">
                                <ArrowDown class="w-3 h-3" />{{ file.downloads.toLocaleString('id-ID') }}
                            </span>
                            <a href="#" download class="flex items-center gap-1 text-[10px] font-black text-primary uppercase tracking-widest hover:underline">
                                <Download class="w-3 h-3" /> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- All Files with Sidebar Filter -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

                    <!-- Sidebar -->
                    <div class="space-y-2">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Kategori</h3>
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            @click="activeCategory = cat.id"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-left"
                            :class="activeCategory === cat.id
                                ? 'bg-primary text-white shadow-lg shadow-primary/20'
                                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                        >
                            {{ cat.label }}
                        </button>
                    </div>

                    <!-- File List -->
                    <div class="lg:col-span-3">
                        <div v-if="filteredFiles.length" class="space-y-4">
                            <div
                                v-for="file in filteredFiles"
                                :key="file.id"
                                class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 hover:border-primary/30 hover:shadow-xl transition-all group flex items-start gap-5"
                            >
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" :class="fileTypeConfig[file.type].iconBg">
                                    <component :is="fileTypeConfig[file.type].icon" class="w-6 h-6" :class="fileTypeConfig[file.type].iconColor" />
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-primary dark:text-secondary">{{ categoryLabel(file.category) }}</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-lg" :class="fileTypeConfig[file.type].badge">{{ file.type.toUpperCase() }}</span>
                                        <span v-if="file.featured" class="text-[10px] bg-amber-100 text-amber-600 font-bold px-2 py-0.5 rounded">Populer</span>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors mb-1 leading-snug">{{ file.title }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">{{ file.description }}</p>
                                    <div class="flex flex-wrap items-center gap-5 mt-3 text-[10px] font-bold text-slate-400 uppercase">
                                        <span class="flex items-center gap-1"><Calendar class="w-3 h-3" />{{ formatDate(file.date) }}</span>
                                        <span class="flex items-center gap-1"><ArrowDown class="w-3 h-3" />{{ file.downloads.toLocaleString('id-ID') }} unduhan</span>
                                        <span>{{ file.size }}</span>
                                    </div>
                                </div>

                                <a
                                    href="#"
                                    download
                                    class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 transition-colors shrink-0 self-center"
                                >
                                    <Download class="w-3.5 h-3.5" />
                                    Unduh
                                </a>
                            </div>
                        </div>

                        <div v-else class="py-20 text-center bg-white dark:bg-slate-800 rounded-3xl">
                            <Search class="w-16 h-16 text-slate-200 dark:text-slate-700 mx-auto mb-4" />
                            <p class="text-slate-500 font-bold text-lg">Dokumen tidak ditemukan</p>
                            <p class="text-slate-400 text-sm mt-2">Coba kata kunci lain atau pilih kategori berbeda.</p>
                            <button @click="searchQuery = ''; activeCategory = 'semua'" class="mt-6 text-primary font-bold hover:underline">
                                Reset Pencarian
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-primary rounded-2xl p-10 text-white text-center">
                    <h3 class="text-2xl font-extrabold mb-3">Tidak menemukan dokumen yang dibutuhkan?</h3>
                    <p class="text-slate-300 mb-8 text-sm max-w-lg mx-auto">Hubungi tim UPA TIK dan kami akan membantu menyediakan atau membuat dokumen yang Anda perlukan.</p>
                    <a href="/#helpdesk" class="inline-flex items-center gap-2 px-8 py-3 bg-secondary text-primary font-bold rounded-xl hover:bg-secondary-light transition-colors">
                        Ajukan Permintaan Dokumen
                    </a>
                </div>
            </div>
        </section>

    </UPAGuestLayout>
</template>
