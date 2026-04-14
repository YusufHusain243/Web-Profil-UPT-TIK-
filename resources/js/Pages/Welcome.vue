<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import axios from 'axios';
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import HeroCarousel from '@/Components/UPA/HeroCarousel.vue';
import AboutSection from '@/Components/UPA/AboutSection.vue';
import ProjectCard from '@/Components/UPA/ProjectCard.vue';
import ProjectModal from '@/Components/UPA/ProjectModal.vue';
import FaqAccordion from '@/Components/UPA/FaqAccordion.vue';
import StatCard from '@/Components/UPA/StatCard.vue';
import ServiceCard from '@/Components/UPA/ServiceCard.vue';
import StatusBadge from '@/Components/UPA/StatusBadge.vue';
import { Search, Send, Ticket, ChevronRight, ArrowLeft, CheckCircle2 } from 'lucide-vue-next';

defineProps({
    canRegister: Boolean,
});

const projects = [
    {
        title: "SIUBER (SIA)",
        category: "Akademik",
        description: "Sistem Informasi Akademik terintegrasi untuk mahasiswa, dosen, dan staf administrasi (KRS, KHS, Pembayaran). SIUBER menangani siklus hidup akademik lengkap, mulai dari pendaftaran mahasiswa baru (SIREMA), pengarsipan data, pengisian KRS, hingga pemantauan kelulusan dan ijazah digital.",
        url: "https://sia.upr.ac.id",
        imageId: "1498243639311-f3b5541cb427",
        keywords: "academic, graduation, study"
    },
    {
        title: "SIREMA",
        category: "Akademik",
        description: "Sistem Registrasi Mahasiswa Baru (MABA) Universitas Palangka Raya. SIREMA adalah pintu gerbang awal bagi calon mahasiswa, mengelola validasi dokumen, verifikasi biodata, hingga penetapan NIM secara otomatis.",
        url: "https://sirema.upr.ac.id",
        imageId: "1486312338219-ce68d2c6f44d",
        keywords: "registration, laptop, office"
    },
    {
        title: "E-Learning",
        category: "Akademik",
        description: "Platform pembelajaran daring (LMS) berbasis Moodle untuk mendukung perkuliauh daring dan daring. Memfasilitasi distribusi materi, kuis online, kelas virtual, dan forum diskusi civitas akademika.",
        url: "https://e-learning.upr.ac.id",
        imageId: "1524995997946-a1c2e315a42f",
        keywords: "online-learning, education, library"
    },
    {
        title: "E-Sign",
        category: "Institusi",
        description: "Layanan Tanda Tangan Elektronik (TTE) resmi yang terintegrasi dengan BSRE (Balai Sertifikasi Elektronik). Menjamin keaslian dan legalitas dokumen digital di lingkungan Universitas Palangka Raya.",
        url: "https://e-sign.upr.ac.id",
        imageId: "1563986768609-322da13575f3",
        keywords: "security, digital-signature, verify"
    },
    {
        title: "Wisuda",
        category: "Akademik",
        description: "Sistem pendaftaran wisuda dan penulisan ijazah digital Universitas Palangka Raya. Mengelola validasi predikat kelulusan, pendaftaran seremoni, hingga sinkronisasi data ke pangkalan data PT.",
        url: "https://wisuda.upr.ac.id",
        imageId: "1523240795612-9a054b0db644",
        keywords: "graduation, success, celebration"
    },
    {
        title: "Tagihan",
        category: "Keuangan",
        description: "Sistem informasi pengelolaan tagihan dan biaya pendidikan mahasiswa (UKT, SPI, dll). Terintegrasi secara real-time dengan bank mitra untuk verifikasi pembayaran yang instan.",
        url: "https://tagihan.upr.ac.id",
        imageId: "1554224155-6726b3ff858f",
        keywords: "finance, payment, banking"
    },
    {
        title: "DITRACE",
        category: "Akademik",
        description: "Sistem informasi Tracer Study untuk melacak karir dan umpan balik alumni UPR. Penting untuk akreditasi kampus dan peningkatan kualitas kurikulum berdasarkan serapan dunia kerja.",
        url: "https://ditrace.upr.ac.id",
        imageId: "1460925895917-afdab827c52f",
        keywords: "career, analytics, growth"
    },
    {
        title: "SINTAM",
        category: "Akademik",
        description: "Sistem Informasi Tugas Akhir Mahasiswa untuk manajemen bimbingan skripsi dan tesis. Memantau progres penelitian, jadwal sidang, hingga revisi akhir secara digital.",
        url: "https://sintam.upr.ac.id",
        imageId: "1456513080510-7bf3a84b82f8",
        keywords: "research, book, library"
    },
    {
        title: "E-NUM",
        category: "Institusi",
        description: "Aplikasi penomoran surat kedinasan elektronik yang terstruktur dan terpusat. Mengurangi duplikasi nomor surat dan memudahkan pelacakan arsip korespondensi universitas.",
        url: "https://e-num.upr.ac.id",
        imageId: "1586769852044-692d6e3703f0",
        keywords: "document, administration, folder"
    },
    {
        title: "Kerjasama",
        category: "Institusi",
        description: "Sistem Informasi Kerjasama (Sikerma) Universitas Palangka Raya. Mencatat MoU, MoA, dan IA dengan mitra nasional maupun internasional untuk pemantauan implementasi kerja sama.",
        url: "https://kerjasama.upr.ac.id",
        imageId: "1521737604893-d14cc237f11d",
        keywords: "partnership, handshake, global"
    },
    {
        title: "Portal Ortu",
        category: "Akademik",
        description: "Portal informasi akademik yang dikhususkan bagi orang tua atau wali mahasiswa untuk memantau nilai (KHS), kehadiran, dan status pembayaran pendidikan anak secara real-time.",
        url: "https://si-ortu.upr.ac.id",
        imageId: "1491438590914-bc09fcaaf77a",
        keywords: "family, secure, monitoring"
    },
    {
        title: "Logbook",
        category: "Akademik",
        description: "Pencatatan kegiatan harian bagi mahasiswa yang mengikuti program maupun magang. Mendukung sinkronisasi data untuk program MBKM (Merdeka Belajar Kampus Merdeka).",
        url: "https://logbook.upr.ac.id",
        imageId: "1517842645767-c639042777db",
        keywords: "activity, journal, notebook"
    },
    {
        title: "Panduan",
        category: "Institusi",
        description: "Knowledge Base dan pusat panduan penggunaan aplikasi-aplikasi di lingkungan UPR. Berisi video tutorial dan dokumentasi PDF untuk memudahkan user mengadaptasi sistem.",
        url: "https://panduan.upr.ac.id",
        imageId: "1521791136064-7986c2923216",
        keywords: "help, guide, support"
    },
    {
        title: "ShortURL",
        category: "Institusi",
        description: "Layanan pemendek tautan (URL Shortener) resmi Universitas Palangka Raya dengan domain upr.ac.id, memudahkan berbagi tautan panjang secara kredibel.",
        url: "https://shorturl.upr.ac.id",
        imageId: "1558486012-817176f84c6d",
        keywords: "link, network, global"
    },
    {
        title: "SSO",
        category: "Institusi",
        description: "Single Sign On (SSO) untuk akses terpadu. Cukup satu akun (@upr.ac.id) untuk mengakses seluruh ekosistem aplikasi di lingkungan Universitas Palangka Raya.",
        url: "#",
        imageId: "1555066931-4365d14bab8c",
        keywords: "security, authentication, lock"
    },
    {
        title: "SIRIP",
        category: "Institusi",
        description: "Sistem Informasi Riwayat Pangkat dan Jabatan staf Universitas Palangka Raya. Mengelola database kepegawaian, kenaikan jabatan, dan riwayat pelatihan staf.",
        url: "https://sirip.upr.ac.id",
        imageId: "1450101499163-c8848c66ca85",
        keywords: "work, analytics, data"
    }
];

const categories = ["Semua", "Akademik", "Keuangan", "Institusi"];
const activeCategory = ref("Semua");
const isModalOpen = ref(false);
const selectedProject = ref(null);
const displayLimit = ref(8);
const isExpanded = ref(false);

// Image Fallback Engine
const getProjectImage = (project) => {
    // If a manual override image exists, use it
    if (project.image && project.image.startsWith('http')) return project.image;
    
    // If a fixed Unsplash ID exists, use it (Most reliable & high quality)
    if (project.imageId) {
        return `https://images.unsplash.com/photo-${project.imageId}?auto=format&fit=crop&q=80&w=800`;
    }
    
    // Otherwise, generate a dynamic URL based on keywords with Lorem Flickr (Reliable fallback)
    const projectKeywords = project.keywords || "university";
    return `https://loremflickr.com/800/600/technology,${projectKeywords}/all`;
};

const displayedProjects = computed(() => {
    const list = isExpanded.value ? filteredProjects.value.slice(0, displayLimit.value) : [];
    return list.map(p => ({
        ...p,
        image: getProjectImage(p)
    }));
});

const row1Projects = computed(() => {
    return projects.slice(0, Math.ceil(projects.length / 2)).map(p => ({
        ...p,
        image: getProjectImage(p)
    }));
});

const row2Projects = computed(() => {
    return projects.slice(Math.ceil(projects.length / 2)).map(p => ({
        ...p,
        image: getProjectImage(p)
    }));
});

const expandShowcase = () => {
    isExpanded.value = true;
};

// Reset limit when category changes
watch(activeCategory, () => {
    displayLimit.value = 8;
});

const openProjectModal = (project) => {
    selectedProject.value = project;
    isModalOpen.value = true;
};

const faqCategories = [
    { id: "email", label: "Email Institusi" },
    { id: "internet", label: "Internet & WiFi" },
    { id: "siakad", label: "SIAKAD" },
    { id: "lab", label: "Laboratorium" },
    { id: "bantuan", label: "Bantuan & Admin" }
];
const activeFaqCategory = ref("email");

const faqs = [
    // Kategori 1: Email
    { 
        category: "email",
        question: "Bagaimana cara mendapatkan akun email institusi (@upr.ac.id)?", 
        answer: "Bagi mahasiswa baru, akun dibuat secara kolektif. Untuk dosen/staf yang belum memiliki akun, silakan ajukan permohonan melalui admin TIK fakultas atau datang langsung ke Gedung UPA TIK dengan membawa SK/Kartu Identitas." 
    },
    { 
        category: "email",
        question: "Saya lupa kata sandi email, apa yang harus saya lakukan?", 
        answer: "Anda dapat melakukan reset secara mandiri melalui form reset password resmi universitas. Silakan akses tautan tersebut untuk memulihkan akses akun Anda." 
    },
    { 
        category: "email",
        question: "Mengapa saya tidak bisa mengirim/menerima email?", 
        answer: "Periksa sisa kuota penyimpanan email Anda. Jika penuh, hapus file atau email yang tidak diperlukan di Google Drive/Gmail karena kuota bersifat terintegrasi." 
    },
    // Kategori 2: Internet
    { 
        category: "internet",
        question: "Bagaimana cara terhubung ke WiFi Eduroam?", 
        answer: "Gunakan identitas email institusi (@upr.ac.id) sebagai username dan kata sandi email Anda sebagai password untuk login ke jaringan Eduroam." 
    },
    { 
        category: "internet",
        question: "Mengapa perangkat saya gagal terhubung ke Eduroam?", 
        answer: "Lakukan 'Forget Network' pada pengaturan WiFi perangkat Anda, kemudian coba login kembali menggunakan format email lengkap. Pastikan akun email Anda dalam status aktif." 
    },
    { 
        category: "internet",
        question: "Di mana saja lokasi hotspot WiFi kampus?", 
        answer: "Jaringan Eduroam tersedia di seluruh area gedung fakultas, rektorat, dan berbagai area publik di lingkungan Universitas Palangka Raya." 
    },
    // Kategori 3: SIAKAD
    { 
        category: "siakad",
        question: "Muncul notifikasi 'User Terkunci' saat login SIAKAD, bagaimana solusinya?", 
        answer: "Hal ini biasanya terjadi karena salah memasukkan password berulang kali. Silakan hubungi admin TIK di unit atau fakultas Anda untuk pembukaan blokir akses." 
    },
    { 
        category: "siakad",
        question: "Saya tidak bisa mengisi KRS di SIAKAD, apa masalahnya?", 
        answer: "Pastikan Anda sudah menyelesaikan administrasi keuangan dan masa pengisian KRS belum berakhir sesuai dengan kalender akademik yang berlaku." 
    },
    // Kategori 4: Lab
    { 
        category: "lab",
        question: "Bagaimana prosedur meminjam Laboratorium Komputer untuk kegiatan?", 
        answer: "Mengajukan surat permohonan resmi kepada Kepala UPA TIK minimal 3 hari sebelum kegiatan. Pastikan jadwal tersedia melalui staf administrasi kami." 
    },
    { 
        category: "lab",
        question: "Apakah Laboratorium Komputer buka di luar jam kuliah?", 
        answer: "Laboratorium beroperasi sesuai jadwal praktikum yang telah ditetapkan. Penggunaan mandiri oleh mahasiswa harus dengan izin resmi dari staf laboratorium." 
    },
    // Kategori 5: Bantuan
    { 
        category: "bantuan",
        question: "Di mana lokasi kantor UPA TIK UPR?", 
        answer: "Gedung UPA TIK terletak di komplek area kampus Universitas Palangka Raya (Kampus Tanjung Nyaho)." 
    },
    { 
        category: "bantuan",
        question: "Kapan saya bisa berkonsultasi langsung dengan staf teknis?", 
        answer: "Layanan bantuan manual tersedia pada hari kerja (Senin-Jumat) selama jam operasional resmi kantor. Chatbot dan portal bantuan tetap melayani informasi mandiri 24/7." 
    }
];

const filteredFaqs = computed(() => {
    return faqs.filter(f => f.category === activeFaqCategory.value);
});

// Helpdesk & Status Logic
const helpCategories = ["Email Institusi", "Wi-Fi & Jaringan", "SIAKAD/Sistem Akademik", "Sistem Institusi", "Lainnya"];
const helpForm = ref({
    name: "",
    identity: "",
    unit: "",
    category: "Email Institusi",
    description: "",
    email: "",
    phone: ""
});
const isSubmitting = ref(false);
const formSubmitted = ref(false);

const systemStatusMap = ref({});

const checkSystems = async () => {
    // Collect all URLs to check from projects
    const urlsToCheck = projects.map(p => p.url).filter(url => url && url !== '#');
    
    try {
        // Send batch request to our backend monitoring engine
        const response = await axios.get('/api/status-check', {
            params: { urls: urlsToCheck }
        });
        
        const results = response.data;
        
        // Map backend results back to project titles
        projects.forEach(p => {
            if (!p.url || p.url === '#') {
                systemStatusMap.value[p.title] = "maintenance";
            } else {
                systemStatusMap.value[p.title] = results[p.url] || "issue";
            }
        });
    } catch (e) {
        console.error("Status monitoring failed:", e);
        // Fallback to error state for all URLs if API fails
        projects.forEach(p => {
            if (!p.url || p.url === '#') {
                systemStatusMap.value[p.title] = "maintenance";
            } else {
                systemStatusMap.value[p.title] = "issue";
            }
        });
    }
};

const submitHelpForm = () => {
    isSubmitting.value = true;
    // Simulate API call
    setTimeout(() => {
        isSubmitting.value = false;
        formSubmitted.value = true;
    }, 1500);
};

onMounted(() => {
    // Initialize all to checking state
    projects.forEach(p => systemStatusMap.value[p.title] = "checking");
    
    // Perform initial check
    checkSystems();
    
    // Poll every 15 minutes for accurate backend-driven status
    setInterval(checkSystems, 15 * 60 * 1000);
});
</script>

<template>
    <UPAGuestLayout>
        <!-- Hero Carousel Section -->
        <div id="home">
            <HeroCarousel />
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
        <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Berita & Inovasi</h2>
                    <p class="text-slate-500 mt-2">Dapatkan info terbaru seputar teknologi di kampus.</p>
                </div>
                <button
                    class="px-6 py-2 border border-slate-200 dark:border-slate-800 rounded-xl font-bold text-primary hover:bg-slate-50 transition-colors">Lihat Semua Berita</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Featured News 1 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-3xl mb-6">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop"
                            class="w-full h-[300px] object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-amber-500 text-white text-[10px] font-bold uppercase rounded-lg">Unggulan</span>
                        </div>
                    </div>
                    <h3
                        class="text-2xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                        Cybersecurity Alert: Phishing Campaign Targeting University Accounts</h3>
                    <p class="mt-3 text-slate-500 text-sm line-clamp-2">Tim keamanan siber UPA TIK mendeteksi adanya
                        upaya phishing massal yang menargetkan email civitas akademika...</p>
                    <div
                        class="mt-4 flex items-center text-slate-400 text-xs font-medium uppercase tracking-widest leading-none">
                        <span>5 menit yang lalu</span>
                        <span class="mx-2 inline-block w-1 h-1 bg-slate-400 rounded-full"></span>
                        <span>Update Keamanan</span>
                    </div>
                </div>

                <!-- Featured News 2 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-3xl mb-6">
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop"
                            class="w-full h-[300px] object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div class="absolute top-4 left-4">
                            <span
                                class="px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-lg">Innovation</span>
                        </div>
                    </div>
                    <h3
                        class="text-2xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                        New High-Performance Computing System Launched</h3>
                    <p class="mt-3 text-slate-500 text-sm line-clamp-2">UPA TIK meluncurkan kluster HPC baru untuk
                        mendukung akselerasi penelitian berbasis data besar dan AI bagi dosen...</p>
                    <div
                        class="mt-4 flex items-center text-slate-400 text-xs font-medium uppercase tracking-widest leading-none">
                        <span>2 jam yang lalu</span>
                        <span class="mx-2 inline-block w-1 h-1 bg-slate-400 rounded-full"></span>
                        <span>Infrastruktur</span>
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
