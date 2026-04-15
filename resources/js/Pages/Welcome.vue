<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import HeroCarousel from '@/Components/UPA/HeroCarousel.vue';
import AboutSection from '@/Components/UPA/AboutSection.vue';
import ProjectCard from '@/Components/UPA/ProjectCard.vue';
import ProjectModal from '@/Components/UPA/ProjectModal.vue';
import FaqAccordion from '@/Components/UPA/FaqAccordion.vue';
import StatCard from '@/Components/UPA/StatCard.vue';
import ServiceCard from '@/Components/UPA/ServiceCard.vue';
import StatusBadge from '@/Components/UPA/StatusBadge.vue';
import { Search, Send, Ticket, ChevronRight, ArrowLeft, CheckCircle2, ChevronLeft, Calendar, Tag, Star, Quote } from 'lucide-vue-next';
import { projects, projectCategories, getProjectImage } from '@/data/projects.js';
import { allNews, getNewsImage } from '@/data/news.js';
import { faqCategories, faqs, helpCategories } from '@/data/faqs.js';

const testimonials = [
    {
        name: 'Prof. Dr. Ir. Harun Sitepu, M.Sc.',
        role: 'Dekan Fakultas Teknik',
        avatar: 'https://i.pravatar.cc/150?img=33',
        rating: 5,
        text: 'Sejak sistem SIUBER terintegrasi, pengelolaan data akademik di Fakultas Teknik menjadi jauh lebih efisien. Waktu pemrosesan data wisuda yang dulu memakan berhari-hari kini bisa diselesaikan dalam hitungan jam. Luar biasa.',
    },
    {
        name: 'Anisa Kurniawati',
        role: 'Mahasiswi Akuntansi, Angkatan 2022',
        avatar: 'https://i.pravatar.cc/150?img=47',
        rating: 5,
        text: 'Fitur Eduroam sangat membantu. Saya bisa akses jurnal internasional dan mengerjakan tugas dari mana saja di dalam kampus tanpa khawatir kuota habis. Tim TIK juga sangat responsif saat saya ada pertanyaan.',
    },
    {
        name: 'Dr. Rini Setiawati, M.Pd.',
        role: 'Dosen FKIP, Koordinator e-Learning',
        avatar: 'https://i.pravatar.cc/150?img=23',
        rating: 5,
        text: 'Dukungan UPA TIK dalam implementasi platform e-learning sangat profesional. Pelatihan Microsoft 365 yang diberikan benar-benar mengubah cara saya mengajar — lebih interaktif dan terdokumentasi dengan baik.',
    },
    {
        name: 'Andi Saputra',
        role: 'Mahasiswa Ilmu Komputer, Angkatan 2021',
        avatar: 'https://i.pravatar.cc/150?img=60',
        rating: 4,
        text: 'Portal helpdesk sangat memudahkan pelaporan masalah teknis. Tiket saya biasanya ditindaklanjuti dalam 1-2 hari kerja. Semoga ke depannya ada fitur live chat juga untuk masalah yang lebih mendesak.',
    },
    {
        name: 'Ir. Bambang Kristianto, M.T.',
        role: 'Kepala Biro Administrasi Akademik',
        avatar: 'https://i.pravatar.cc/150?img=12',
        rating: 5,
        text: 'Integrasi sistem e-sign dan SIUBER telah memangkas birokrasi administrasi secara signifikan. Dokumen-dokumen penting kini dapat ditandatangani dan diproses secara digital, menghemat waktu dan sumber daya.',
    },
    {
        name: 'Maya Sari Dewi',
        role: 'Staf Administrasi FISIP',
        avatar: 'https://i.pravatar.cc/150?img=37',
        rating: 4,
        text: 'Sistem absensi digital yang dikembangkan UPA TIK sangat membantu monitoring kehadiran mahasiswa. Dashboard rekap kehadiran real-time memudahkan pekerjaan administrasi kami setiap harinya.',
    },
];

const props = defineProps({
    slides: { type: Array, default: () => [] },
});

const activeCategory = ref("Semua");
const isModalOpen = ref(false);
const selectedProject = ref(null);
const displayLimit = ref(8);
const isExpanded = ref(false);

const filteredProjects = computed(() => {
    if (activeCategory.value === 'Semua') return projects;
    return projects.filter(p => p.category === activeCategory.value);
});

const displayedProjects = computed(() => {
    if (!isExpanded.value) return [];
    return filteredProjects.value.slice(0, displayLimit.value).map(p => ({
        ...p,
        image: getProjectImage(p),
    }));
});

const row1Projects = computed(() =>
    projects.slice(0, Math.ceil(projects.length / 2)).map(p => ({ ...p, image: getProjectImage(p) }))
);

const row2Projects = computed(() =>
    projects.slice(Math.ceil(projects.length / 2)).map(p => ({ ...p, image: getProjectImage(p) }))
);

const expandShowcase = () => { isExpanded.value = true; };

watch(activeCategory, () => { displayLimit.value = 8; });

const openProjectModal = (project) => {
    selectedProject.value = project;
    isModalOpen.value = true;
};

// FAQ
const activeFaqCategory = ref('email');
const filteredFaqs = computed(() => faqs.filter(f => f.category === activeFaqCategory.value));

// News
const newsItems = allNews;
const newsSearchQuery = ref('');
const newsCurrentPage = ref(1);
const newsItemsPerPage = 6;
const isNewsExpanded = ref(false);

const filteredNews = computed(() => {
    if (!newsSearchQuery.value) return newsItems;
    const query = newsSearchQuery.value.toLowerCase();
    return newsItems.filter(item =>
        item.title.toLowerCase().includes(query) ||
        item.category.toLowerCase().includes(query) ||
        item.description.toLowerCase().includes(query)
    );
});

const totalNewsPages = computed(() => Math.ceil(filteredNews.value.length / newsItemsPerPage));

const paginatedNews = computed(() => {
    const start = (newsCurrentPage.value - 1) * newsItemsPerPage;
    return filteredNews.value.slice(start, start + newsItemsPerPage);
});

const expandNews = () => {
    isNewsExpanded.value = true;
    setTimeout(() => document.getElementById('news')?.scrollIntoView({ behavior: 'smooth' }), 100);
};

watch(newsSearchQuery, () => { newsCurrentPage.value = 1; });

// Helpdesk
const helpForm = ref({
    name: '',
    identity: '',
    unit: '',
    category: 'Email Institusi',
    description: '',
    email: '',
    phone: '',
});
const isSubmitting = ref(false);
const formSubmitted = ref(false);

const submitHelpForm = () => {
    isSubmitting.value = true;
    setTimeout(() => {
        isSubmitting.value = false;
        formSubmitted.value = true;
    }, 1500);
};

// System Status Monitor
const systemStatusMap = ref({});
let statusInterval = null;

const checkSystems = async () => {
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
};

onMounted(() => {
    projects.forEach(p => { systemStatusMap.value[p.title] = 'checking'; });
    checkSystems();
    statusInterval = setInterval(checkSystems, 15 * 60 * 1000);
});

onUnmounted(() => {
    clearInterval(statusInterval);
});
</script>

<template>
    <UPAGuestLayout>
        <!-- Hero Carousel Section -->
        <div id="home">
            <HeroCarousel :slides="props.slides" />
        </div>

        <!-- Impact Stats -->
        <section class="max-w-5xl mx-auto px-4 -mt-10 relative z-20 animate-fade-in-up">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center lg:text-left">
                <StatCard label="Pengguna Aktif" value="20rb+" icon="users" />
                <StatCard label="Sistem Terkelola" value="50+" icon="systems" />
                <StatCard label="Uptime Jaringan" value="99.9%" icon="uptime" />
            </div>
        </section>

        <!-- About Section -->
        <div id="about" class="animate-fade-in-up" style="animation-delay: 0.2s;">
            <AboutSection />
        </div>

        <!-- Digital Services Ecosystem -->
        <section id="services" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up"
            style="animation-delay: 0.3s;">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">Ekosistem Layanan Digital</h2>
                <div class="w-24 h-1.5 bg-primary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <ServiceCard title="Academic Systems"
                    description="SIUBER (Sistem Informasi Akademik Unggul dan Berkarakter): Layanan terintegrasi dari registrasi Mahasiswa Baru, Pembayaran, hingga Wisuda."
                    icon="academic" />
                <ServiceCard title="Network & Connectivity"
                    description="Jaringan kampus berkecepatan tinggi, akses Wi-Fi luas, serta implementasi sistem keamanan siber."
                    icon="network" />
                <ServiceCard title="Web Hosting & Domain"
                    description="Penyediaan layanan web hosting dan subdomain/domain khusus bagi seluruh unit di Universitas Palangka Raya pada infrastruktur server pusat."
                    icon="server" />
                <ServiceCard title="System Development"
                    description="Rancang bangun sistem informasi kustom, pengembangan aplikasi web/mobile, dan solusi integrasi data terpadu."
                    icon="development" />
                <ServiceCard title="IT Maintenance & Support"
                    description="Pemeliharaan rutin perangkat keras, bantuan teknis (helpdesk), dan troubleshooting sistem secara berkala."
                    icon="maintenance" />
                <ServiceCard title="Digital Workspace"
                    description="Penyediaan lisensi Office 365, email institusi (@upr.ac.id), serta berbagai perangkat lunak berlisensi lainnya."
                    icon="workspace" />
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="py-24 bg-slate-50 dark:bg-slate-900/50 animate-fade-in-up"
            style="animation-delay: 0.4s;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <span
                            class="text-primary dark:text-secondary font-bold text-sm uppercase tracking-widest mb-4 block">Portofolio</span>
                        <h2 class="text-4xl font-bold text-slate-900 dark:text-white">Proyek Digital Kami</h2>
                    </div>
                </div>

                <!-- Portfolio Showcase -->
                <Transition name="fade-scale" mode="out-in">
                    <div v-if="!isExpanded" key="ticker" class="space-y-12">
                        <!-- Ticker Row 1 (Left) -->
                        <div class="relative overflow-hidden py-4">
                            <div class="flex animate-scroll-left hover:[animation-play-state:paused] space-x-8 w-max">
                                <!-- Double loop for seamlessness -->
                                <div v-for="i in 2" :key="i" class="flex space-x-8">
                                    <div v-for="project in row1Projects" :key="project.title" class="w-[320px] shrink-0">
                                        <ProjectCard v-bind="project" @clickCard="openProjectModal(project)" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ticker Row 2 (Right) -->
                        <div class="relative overflow-hidden py-4">
                            <div class="flex animate-scroll-right hover:[animation-play-state:paused] space-x-8 w-max">
                                <div v-for="i in 2" :key="i" class="flex space-x-8">
                                    <div v-for="project in row2Projects" :key="project.title" class="w-[320px] shrink-0">
                                        <ProjectCard v-bind="project" @clickCard="openProjectModal(project)" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expand Button -->
                        <div class="pt-12 text-center">
                            <button 
                                @click="expandShowcase"
                                class="group relative px-12 py-5 bg-primary text-white rounded-[2rem] font-bold text-lg shadow-2xl shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-2 transition-all duration-500 overflow-hidden"
                            >
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                <span class="relative flex items-center space-x-3">
                                    <span>Tampilkan Selengkapnya</span>
                                    <ChevronRight class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-500" />
                                </span>
                            </button>
                        </div>
                    </div>

                    <div v-else key="grid" class="animate-fade-in">
                        <!-- Filter Tabs & Back Button -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-12 border-b border-slate-100 dark:border-slate-700/50 pb-4 gap-4">
                            <div class="flex flex-wrap gap-8">
                                <button v-for="cat in categories" :key="cat" @click="activeCategory = cat"
                                    class="text-base font-bold transition-all outline-none relative group"
                                    :class="activeCategory === cat ? 'text-primary' : 'text-slate-600 dark:text-slate-400 hover:text-primary'">
                                    {{ cat }}
                                    <div class="absolute -bottom-[17px] left-0 h-0.5 bg-primary transition-all duration-300"
                                        :class="activeCategory === cat ? 'w-full' : 'w-0 group-hover:w-1/2'"></div>
                                </button>
                            </div>

                            <button 
                                @click="isExpanded = false"
                                class="flex items-center space-x-2 px-6 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl font-bold transition-all"
                            >
                                <ArrowLeft class="w-4 h-4" />
                                <span>Kembali ke Ringkasan</span>
                            </button>
                        </div>

                        <TransitionGroup 
                            tag="div"
                            name="fade-grid"
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"
                        >
                            <ProjectCard v-for="project in displayedProjects" 
                                :key="project.title" 
                                v-bind="project"
                                @clickCard="openProjectModal(project)" 
                            />
                        </TransitionGroup>

                        <!-- Load More inside Expanded Grid -->
                        <div v-if="filteredProjects.length > displayLimit" class="mt-16 text-center">
                            <button 
                                @click="displayLimit = projects.length"
                                class="group inline-flex items-center space-x-3 px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-slate-700 dark:text-slate-300 hover:border-primary hover:text-primary transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1"
                            >
                                <span>Muat Aplikasi Lainnya</span>
                                <ChevronRight class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up"
            style="animation-delay: 0.5s;">
            <div class="text-center mb-16">
                <span
                    class="text-primary dark:text-secondary font-bold text-sm uppercase tracking-widest mb-4 block">Bantuan
                    Cepat</span>
                <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-6">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">Punya pertanyaan seputar layanan TIK
                    Universitas Palangka Raya? Temukan jawaban untuk pertanyaan umum di bawah ini.</p>
            </div>

            <!-- FAQ Category Tabs -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button 
                    v-for="cat in faqCategories" 
                    :key="cat.id" 
                    @click="activeFaqCategory = cat.id"
                    class="px-6 py-3 rounded-2xl font-bold transition-all duration-300 border shadow-sm"
                    :class="activeFaqCategory === cat.id 
                        ? 'bg-primary text-white border-primary shadow-primary/20 scale-105' 
                        : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-100 dark:border-slate-700 hover:border-primary/50'"
                >
                    {{ cat.label }}
                </button>
            </div>

            <div class="relative min-h-[400px]">
                <TransitionGroup 
                    name="fade-grid"
                    tag="div"
                    class="space-y-4"
                >
                    <FaqAccordion 
                        v-for="faq in filteredFaqs" 
                        :key="faq.question" 
                        :question="faq.question" 
                        :answer="faq.answer" 
                    />
                </TransitionGroup>
            </div>
        </section>

        <!-- Support Portal Section (Helpdesk & Status) -->
        <section id="helpdesk" class="py-24 bg-slate-900 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/10 blur-[120px] rounded-full translate-x-1/2"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    <!-- Left: Helpdesk Form -->
                    <div class="animate-fade-in-up">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 bg-primary/20 rounded-2xl flex items-center justify-center border border-primary/30">
                                <Send class="w-6 h-6 text-primary" />
                            </div>
                            <h2 class="text-3xl font-bold">Portal Bantuan</h2>
                        </div>
                        <p class="text-slate-400 mb-10 text-lg">Laporkan kendala teknis atau pengaduan layanan langsung kepada tim dukungan UPA TIK UPR.</p>

                        <Transition name="fade-scale" mode="out-in">
                            <div v-if="!formSubmitted" key="form" class="bg-slate-800/50 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl">
                                <form @submit.prevent="submitHelpForm" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Nama Lengkap</label>
                                        <input v-model="helpForm.name" required type="text" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all" placeholder="Masukkan nama..." />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">NIM / NIP</label>
                                        <input v-model="helpForm.identity" required type="text" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all" placeholder="123456..." />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Asal Unit / Prodi</label>
                                        <input v-model="helpForm.unit" required type="text" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all" placeholder="Fakultas Teknik..." />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Kategori</label>
                                        <select v-model="helpForm.category" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all appearance-none cursor-pointer">
                                            <option v-for="cat in helpCategories" :key="cat" :value="cat">{{ cat }}</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2 sm:col-span-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Deskripsi Keluhan</label>
                                        <textarea v-model="helpForm.description" required rows="3" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all resize-none" placeholder="Ceritakan kendala Anda secara detail..."></textarea>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Email Utama</label>
                                        <input v-model="helpForm.email" required type="email" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all" placeholder="name@upr.ac.id" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-slate-500">WhatsApp / HP</label>
                                        <input v-model="helpForm.phone" required type="tel" class="w-full bg-slate-900/50 border-white/10 rounded-xl focus:ring-primary focus:border-primary text-sm p-4 transition-all" placeholder="0812..." />
                                    </div>
                                    
                                    <div class="sm:col-span-2 pt-4">
                                        <button 
                                            :disabled="isSubmitting"
                                            class="w-full py-5 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold flex items-center justify-center space-x-3 transition-all transform active:scale-95 disabled:opacity-50"
                                        >
                                            <span v-if="!isSubmitting">Kirim Tiket Bantuan</span>
                                            <span v-else class="flex items-center space-x-2">
                                                <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                                <span>Mengirim Pengaduan...</span>
                                            </span>
                                            <Send class="w-5 h-5" />
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Success State -->
                            <div v-else key="success" class="bg-primary/10 border border-primary/20 backdrop-blur-xl p-12 rounded-[2.5rem] text-center space-y-6">
                                <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <CheckCircle2 class="w-10 h-10 text-primary" />
                                </div>
                                <h3 class="text-2xl font-bold text-white">Keluhan Terkirim!</h3>
                                <p class="text-slate-400">Terima kasih <strong>{{ helpForm.name }}</strong>. Tiket bantuan Anda telah terdaftar dalam sistem kami. Tim teknis akan memverifikasi dalam waktu maksimal 1x24 jam.</p>
                                <button @click="formSubmitted = false" class="text-primary font-bold hover:underline">Kirim keluhan lain</button>
                            </div>
                        </Transition>
                    </div>

                    <!-- Right: System Status Dashboard -->
                    <div class="animate-fade-in-up" style="animation-delay: 0.2s">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-2xl font-bold">Status Sistem Terkini</h3>
                                <p class="text-slate-500 text-sm mt-1">Dicek otomatis setiap 15-30 menit</p>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-1 bg-primary/10 border border-primary/20 rounded-lg">
                                <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                                <span class="text-[10px] font-bold text-primary uppercase">Live</span>
                            </div>
                        </div>

                        <!-- Status List -->
                        <div class="bg-slate-800/30 rounded-[2.5rem] border border-white/5 overflow-hidden">
                            <div class="max-h-[550px] overflow-y-auto p-2 scrollbar-premium">
                                <div class="grid grid-cols-1 gap-3 p-4">
                                    <StatusBadge 
                                        v-for="project in projects" 
                                        :key="project.title" 
                                        :label="project.title" 
                                        :status="systemStatusMap[project.title]" 
                                    />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Legend -->
                        <div class="mt-8 grid grid-cols-3 gap-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-accent rounded-full"></div>
                                <span>Operasional</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                <span>Pemeliharaan</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <span>Ada Kendala</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section id="news" class="py-24 bg-white dark:bg-slate-900 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-8">
                    <div class="animate-fade-in-up">
                        <span class="text-primary font-bold text-sm uppercase tracking-widest mb-4 block">Update Terbaru</span>
                        <h2 class="text-4xl font-bold text-slate-900 dark:text-white">Berita & Inovasi</h2>
                        <p class="text-slate-500 mt-4 text-lg max-w-xl">Dapatkan informasi terkini seputar transformasi digital dan terobosan teknologi di lingkungan UPR.</p>
                    </div>
                    
                    <div v-if="!isNewsExpanded" class="animate-fade-in-up">
                        <button
                            @click="expandNews"
                            class="group px-8 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-primary hover:bg-primary hover:text-white hover:border-primary transition-all duration-300 flex items-center space-x-3 shadow-sm hover:shadow-xl"
                        >
                            <span>Lihat Semua Berita</span>
                            <ChevronRight class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                        </button>
                    </div>

                    <!-- Search Bar in Expanded Mode -->
                    <div v-else class="w-full md:w-96 animate-fade-in">
                        <div class="relative group">
                            <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 group-focus-within:text-primary transition-colors" />
                            <input 
                                v-model="newsSearchQuery"
                                type="text" 
                                placeholder="Cari berita atau inovasi..."
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-primary focus:border-primary transition-all text-sm outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- News Grid -->
                <div class="relative min-h-[500px]">
                    <Transition name="fade-scale" mode="out-in">
                        <!-- Summary View (Initial) -->
                        <div v-if="!isNewsExpanded" key="summary" class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <Link 
                                v-for="(news, index) in newsItems.filter(n => n.featured).slice(0, 2)" 
                                :key="news.slug"
                                :href="route('news.show', { slug: news.slug })"
                                class="group cursor-pointer animate-fade-in-up block"
                                :style="`animation-delay: ${index * 0.1}s`"
                                prefetch
                            >
                                <div class="relative overflow-hidden rounded-[2.5rem] mb-8 shadow-lg group-hover:shadow-2xl transition-all duration-500">
                                    <img :src="getNewsImage(news)" class="w-full h-[350px] object-cover group-hover:scale-110 transition-transform duration-700 font-display" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>
                                    <div class="absolute top-6 left-6 flex space-x-2">
                                        <span class="px-4 py-2 bg-primary/90 backdrop-blur-md text-white text-[10px] font-bold uppercase rounded-xl tracking-wider">{{ news.category }}</span>
                                        <span v-if="news.featured" class="px-4 py-2 bg-amber-500/90 backdrop-blur-md text-white text-[10px] font-bold uppercase rounded-xl tracking-wider">Unggulan</span>
                                    </div>
                                </div>
                                <h3 class="text-3xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors leading-tight mb-4">{{ news.title }}</h3>
                                <p class="text-slate-500 dark:text-slate-400 text-lg line-clamp-2 leading-relaxed">{{ news.description }}</p>
                                <div class="mt-6 flex items-center text-slate-400 text-xs font-bold uppercase tracking-widest bg-slate-50 dark:bg-slate-800 w-max px-4 py-2 rounded-lg">
                                    <Calendar class="w-4 h-4 mr-2" />
                                    <span>{{ news.date }}</span>
                                </div>
                            </Link>
                        </div>

                        <!-- Full List View (Paginated) -->
                        <div v-else key="full" class="space-y-16">
                            <TransitionGroup 
                                name="fade-grid"
                                tag="div"
                                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                            >
                                <Link 
                                    v-for="news in paginatedNews" 
                                    :key="news.slug"
                                    :href="route('news.show', { slug: news.slug })"
                                    class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 p-4 hover:shadow-2xl hover:border-primary/20 transition-all duration-500 group cursor-pointer block"
                                    prefetch
                                >
                                    <div class="relative overflow-hidden rounded-2xl mb-6 aspect-video">
                                        <img :src="getNewsImage(news)" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                        <div class="absolute top-3 left-3">
                                            <span class="px-3 py-1.5 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-primary dark:text-secondary text-[10px] font-black uppercase rounded-lg shadow-sm border border-slate-100 dark:border-slate-800">{{ news.category }}</span>
                                        </div>
                                    </div>
                                    <div class="px-2 pb-2">
                                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors line-clamp-2 leading-snug">{{ news.title }}</h4>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-3 mb-6 leading-relaxed">{{ news.description }}</p>
                                        <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest border-t border-slate-50 dark:border-slate-700/50 pt-4">
                                            <span class="flex items-center"><Calendar class="w-3 h-3 mr-1.5" /> {{ news.date }}</span>
                                            <span class="text-primary flex items-center group-hover:translate-x-1 transition-transform">Baca <ChevronRight class="w-3 h-3 ml-0.5" /></span>
                                        </div>
                                    </div>
                                </Link>
                            </TransitionGroup>

                            <!-- Empty State -->
                            <div v-if="paginatedNews.length === 0" class="py-20 text-center animate-fade-in">
                                <Search class="w-16 h-16 text-slate-200 dark:text-slate-800 mx-auto mb-6" />
                                <h3 class="text-2xl font-bold text-slate-600 dark:text-slate-400">Berita tidak ditemukan</h3>
                                <p class="text-slate-400 mt-2">Coba gunakan kata kunci lainnya.</p>
                                <button @click="newsSearchQuery = ''" class="mt-8 text-primary font-bold hover:underline">Hapus Pencarian</button>
                            </div>

                            <!-- Pagination -->
                            <div v-if="totalNewsPages > 1" class="flex flex-col sm:flex-row items-center justify-between pt-12 border-t border-slate-100 dark:border-slate-700/50 gap-6">
                                <div class="text-sm text-slate-500 font-medium">
                                    Menampilkan <span class="text-slate-900 dark:text-white font-bold">{{ newsCurrentPage }}</span> dari <span class="text-slate-900 dark:text-white font-bold">{{ totalNewsPages }}</span> Halaman
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <button 
                                        @click="newsCurrentPage--"
                                        :disabled="newsCurrentPage === 1"
                                        class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 disabled:opacity-30 disabled:cursor-not-allowed hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                                    >
                                        <ChevronLeft class="w-5 h-5 text-slate-600 dark:text-slate-400" />
                                    </button>

                                    <div class="flex space-x-2">
                                        <button 
                                            v-for="page in totalNewsPages" 
                                            :key="page"
                                            @click="newsCurrentPage = page"
                                            class="w-12 h-12 rounded-xl border font-bold transition-all duration-300"
                                            :class="newsCurrentPage === page 
                                                ? 'bg-primary text-white border-primary shadow-lg shadow-primary/20 scale-110' 
                                                : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:border-primary/50'"
                                        >
                                            {{ page }}
                                        </button>
                                    </div>

                                    <button 
                                        @click="newsCurrentPage++"
                                        :disabled="newsCurrentPage === totalNewsPages"
                                        class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 disabled:opacity-30 disabled:cursor-not-allowed hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors"
                                    >
                                        <ChevronRight class="w-5 h-5 text-slate-600 dark:text-slate-400" />
                                    </button>
                                </div>

                                <button 
                                    @click="isNewsExpanded = false"
                                    class="hidden sm:flex items-center space-x-2 text-sm font-bold text-slate-500 hover:text-primary transition-colors"
                                >
                                    <ArrowLeft class="w-4 h-4" />
                                    <span>Tutup List</span>
                                </button>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="py-24 bg-slate-50 dark:bg-slate-900/50 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-primary dark:text-secondary font-bold text-sm uppercase tracking-widest mb-4 block">Suara Pengguna</span>
                    <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">Testimoni Stakeholder</h2>
                    <p class="text-slate-500 max-w-xl mx-auto leading-relaxed">Apa yang dirasakan civitas akademika UPR tentang layanan digital yang kami kembangkan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="(t, index) in testimonials"
                        :key="index"
                        class="bg-white dark:bg-slate-800 rounded-[2rem] p-8 border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-500 group flex flex-col"
                    >
                        <!-- Quote Icon -->
                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <Quote class="w-5 h-5 text-primary" />
                        </div>

                        <!-- Rating -->
                        <div class="flex gap-1 mb-4">
                            <Star
                                v-for="s in 5"
                                :key="s"
                                class="w-4 h-4"
                                :class="s <= t.rating ? 'text-amber-400 fill-amber-400' : 'text-slate-200 dark:text-slate-700'"
                            />
                        </div>

                        <!-- Text -->
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed flex-1 mb-6 italic">"{{ t.text }}"</p>

                        <!-- Author -->
                        <div class="flex items-center gap-4 pt-6 border-t border-slate-50 dark:border-slate-700/50">
                            <img :src="t.avatar" :alt="t.name" class="w-12 h-12 rounded-full object-cover ring-2 ring-primary/20 group-hover:ring-primary/40 transition-colors" />
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white text-sm">{{ t.name }}</p>
                                <p class="text-[11px] text-slate-400 font-medium">{{ t.role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Detail Modal -->
        <ProjectModal 
            :is-open="isModalOpen" 
            :project="selectedProject" 
            @close="isModalOpen = false" 
        />
    </UPAGuestLayout>
</template>

<style scoped>
.staggered-list-enter-active,
.staggered-list-leave-active,
.fade-grid-enter-active,
.fade-grid-leave-active {
    transition: all 0.4s ease;
}
.staggered-list-enter-from,
.fade-grid-enter-from {
    opacity: 0;
    transform: translateY(20px);
}
.staggered-list-leave-to,
.fade-grid-leave-to {
    opacity: 0;
    transform: translateY(-20px);
}

/* Marquee Animations */
@keyframes scroll-left {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

@keyframes scroll-right {
    0% { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}

.animate-scroll-left {
    animation: scroll-left 40s linear infinite;
}

.animate-scroll-right {
    animation: scroll-right 40s linear infinite;
}

/* General Transitions */
.fade-scale-enter-active, .fade-scale-leave-active {
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.fade-scale-enter-from, .fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.95);
}

.scrollbar-premium::-webkit-scrollbar {
    width: 6px;
}
.scrollbar-premium::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-premium::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
.scrollbar-premium::-webkit-scrollbar-thumb:hover {
    background: var(--primary);
}
</style>
