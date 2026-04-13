<script setup>
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import HeroCarousel from '@/Components/UPA/HeroCarousel.vue';
import AboutSection from '@/Components/UPA/AboutSection.vue';
import ProjectCard from '@/Components/UPA/ProjectCard.vue';
import FaqAccordion from '@/Components/UPA/FaqAccordion.vue';
import StatCard from '@/Components/UPA/StatCard.vue';
import ServiceCard from '@/Components/UPA/ServiceCard.vue';
import StatusBadge from '@/Components/UPA/StatusBadge.vue';
import { Search, Send, Ticket, ChevronRight } from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const projects = [
    { title: "SIAKAD Terintegrasi", category: "Academic System", image: "https://images.unsplash.com/photo-1454165833767-027ff33027ef?q=80&w=2070&auto=format&fit=crop", status: "Active" },
    { title: "Sister UPR", category: "Personnel System", image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop", status: "Active" },
    { title: "Moodle Learning Management", category: "E-Learning", image: "https://images.unsplash.com/photo-1501504905252-473c47e087f8?q=80&w=2070&auto=format&fit=crop", status: "Active" },
    { title: "UPR Institutional Repository", category: "Digital Library", image: "https://images.unsplash.com/photo-1497633762265-9d179a990aa6?q=80&w=2070&auto=format&fit=crop", status: "Active" },
];

const faqs = [
    { question: "Bagaimana cara mendapatkan akses Wi-Fi kampus?", answer: "Seluruh civitas akademika dapat mengakses Wi-Fi kampus menggunakan akun SSO (Single Sign-On) yang sama dengan email @upr.ac.id. Pastikan Anda berada di area coverage hotspot UPR." },
    { question: "Lupa password email civitas (@upr.ac.id)?", answer: "Anda dapat melakukan reset mandiri melalui portal pemulihan kata sandi atau mengunjungi loket layanan UPA TIK di Gedung TIK Kampus Tanjung Nyaho dengan membawa kartu identitas." },
    { question: "Bagaimana mengajukan hosting untuk website prodi/unit?", answer: "Silakan ajukan surat permohonan resmi dari unit terkait yang ditujukan ke Kepala UPA TIK. Setelah disetujui, tim teknis akan memberikan akses panel hosting dalam 1x24 jam." },
    { question: "Jam operasional Helpdesk TIK?", answer: "Layanan tatap muka kami tersedia setiap hari kerja (Senin - Jumat) mulai pukul 08:30 WIB hingga 15:30 WIB. Layanan tiket online tersedia 24/7." }
];
</script>

<template>
    <UPAGuestLayout :canLogin="canLogin">
        <!-- Hero Carousel Section -->
        <div id="home">
            <HeroCarousel />
        </div>

        <!-- Impact Stats -->
        <section class="max-w-5xl mx-auto px-4 -mt-10 relative z-20 animate-fade-in-up">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center lg:text-left">
                <StatCard label="Active Users" value="15k+" icon="users" />
                <StatCard label="Systems Managed" value="100+" icon="systems" />
                <StatCard label="Network Uptime" value="99.9%" icon="uptime" />
            </div>
        </section>

        <!-- About Section -->
        <div id="about" class="animate-fade-in-up" style="animation-delay: 0.2s;">
            <AboutSection />
        </div>

        <!-- Digital Services Ecosystem -->
        <section id="services" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">Digital Services Ecosystem</h2>
                <div class="w-24 h-1.5 bg-primary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <ServiceCard 
                    title="Academic Systems"
                    description="Platform e-learning, manajemen data akademik (SIAKAD), dan perpustakaan digital terintegrasi."
                    icon="academic"
                />
                <ServiceCard 
                    title="Network Infrastructure"
                    description="Jaringan kampus berkecepatan tinggi, Wi-Fi luas, dan sistem keamanan siber tingkat lanjut."
                    icon="network"
                />
                <ServiceCard 
                    title="Cloud Solutions"
                    description="Penyimpanan cloud, hosting aplikasi kampus, dan komputasi berkinerja tinggi untuk penelitian."
                    icon="cloud"
                />
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="py-24 bg-slate-50 dark:bg-slate-900/50 animate-fade-in-up" style="animation-delay: 0.4s;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-16">
                    <div>
                        <span class="text-primary dark:text-secondary font-bold text-sm uppercase tracking-widest mb-4 block">Portfolio</span>
                        <h2 class="text-4xl font-bold text-slate-900 dark:text-white">Our Digital Projects</h2>
                    </div>
                    <button class="px-6 py-2 border border-primary text-primary dark:text-secondary rounded-xl font-bold hover:bg-primary hover:text-white transition-all">View All Systems</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <ProjectCard v-for="project in projects" :key="project.title" :title="project.title" :category="project.category" :image="project.image" :status="project.status" />
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="faq" class="py-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="text-center mb-16">
                <span class="text-primary dark:text-secondary font-bold text-sm uppercase tracking-widest mb-4 block">Bantuan Cepat</span>
                <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-6">Frequently Asked Questions</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">Punya pertanyaan seputar layanan TIK Universitas Palangka Raya? Temukan jawaban untuk pertanyaan umum di bawah ini.</p>
            </div>

            <div class="space-y-4">
                <FaqAccordion v-for="faq in faqs" :key="faq.question" :question="faq.question" :answer="faq.answer" />
            </div>
        </section>

        <!-- Support Portal Section (Bento Inspired) -->

        <!-- Support Portal Section (Bento Inspired) -->
        <section class="py-20 bg-slate-900 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/20 blur-[120px] rounded-full translate-x-1/2"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-4xl font-bold mb-6">UPA TIK Support Portal</h2>
                        <p class="text-slate-400 mb-8 text-lg">Butuh bantuan teknis? Temukan solusi di basis pengetahuan kami atau ajukan tiket bantuan langsung ke tim kami.</p>
                        
                        <div class="relative mb-10">
                            <input type="text" placeholder="Search knowledge base for solutions..." class="w-full h-16 bg-slate-800 border-none rounded-2xl pl-14 pr-6 text-white focus:ring-2 focus:ring-primary transition-all shadow-xl" />
                            <Search class="absolute left-6 top-5 text-slate-500 w-6 h-6" />
                        </div>

                        <Link href="/" class="flex items-center space-x-3 group mb-8">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <img src="https://upload.wikimedia.org/wikipedia/id/8/83/Logo_Universitas_Palangka_Raya.png" alt="UPR Logo" class="w-7 h-7" />
                            </div>
                            <span class="font-bold text-lg">UPA TIK Support</span>
                        </Link>

                        <div class="grid grid-cols-2 gap-4">
                            <button class="p-6 bg-primary rounded-2xl flex flex-col items-center hover:scale-105 transition-transform">
                                <Send class="w-8 h-8 mb-3" />
                                <span class="font-bold">Submit Ticket</span>
                            </button>
                            <button class="p-6 bg-slate-800 rounded-2xl flex flex-col items-center hover:scale-105 transition-transform">
                                <Ticket class="w-8 h-8 mb-3" />
                                <span class="font-bold">Check Status</span>
                            </button>
                        </div>
                    </div>

                    <!-- System Status Grid -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold">Real-time System Status</h3>
                            <a href="#" class="text-primary text-sm font-bold flex items-center hover:underline">
                                View Full Status <ChevronRight class="w-4 h-4 ml-1" />
                            </a>
                        </div>
                        <StatusBadge label="Campus Wi-Fi" status="operational" />
                        <StatusBadge label="Academic Email (Outlook)" status="operational" />
                        <StatusBadge label="Learning Management (Moodle)" status="operational" />
                        <StatusBadge label="Student Portal" status="maintenance" />
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white">News & Innovation</h2>
                    <p class="text-slate-500 mt-2">Dapatkan info terbaru seputar teknologi di kampus.</p>
                </div>
                <button class="px-6 py-2 border border-slate-200 dark:border-slate-800 rounded-xl font-bold text-primary hover:bg-slate-50 transition-colors">See All News</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Featured News 1 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-3xl mb-6">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop" class="w-full h-[300px] object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-amber-500 text-white text-[10px] font-bold uppercase rounded-lg">Featured</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">Cybersecurity Alert: Phishing Campaign Targeting University Accounts</h3>
                    <p class="mt-3 text-slate-500 text-sm line-clamp-2">Tim keamanan siber UPA TIK mendeteksi adanya upaya phishing massal yang menargetkan email civitas akademika...</p>
                    <div class="mt-4 flex items-center text-slate-400 text-xs font-medium uppercase tracking-widest leading-none">
                        <span>5 minutes ago</span>
                        <span class="mx-2 inline-block w-1 h-1 bg-slate-400 rounded-full"></span>
                        <span>Security Update</span>
                    </div>
                </div>

                <!-- Featured News 2 -->
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-3xl mb-6">
                        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop" class="w-full h-[300px] object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-primary text-white text-[10px] font-bold uppercase rounded-lg">Innovation</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">New High-Performance Computing System Launched</h3>
                    <p class="mt-3 text-slate-500 text-sm line-clamp-2">UPA TIK meluncurkan kluster HPC baru untuk mendukung akselerasi penelitian berbasis data besar dan AI bagi dosen...</p>
                    <div class="mt-4 flex items-center text-slate-400 text-xs font-medium uppercase tracking-widest leading-none">
                        <span>2 hours ago</span>
                        <span class="mx-2 inline-block w-1 h-1 bg-slate-400 rounded-full"></span>
                        <span>Infrastructure</span>
                    </div>
                </div>
            </div>
        </section>
    </UPAGuestLayout>
</template>

<style scoped>
.italic {
    /* Custom font styling if needed */
}
</style>
