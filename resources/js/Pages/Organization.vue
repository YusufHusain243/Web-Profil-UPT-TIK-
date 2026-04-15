<script setup>
import { Head } from '@inertiajs/vue3';
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { Mail, Linkedin, Twitter, Target, Eye, History, CheckCircle2 } from 'lucide-vue-next';

const visiMisi = {
    visi: 'Menjadi pusat teknologi informasi dan komunikasi yang handal, inovatif, dan berdaya saing global dalam mendukung Universitas Palangka Raya sebagai kampus berstandar internasional.',
    misi: [
        'Menyediakan infrastruktur teknologi informasi yang andal, aman, dan berkualitas tinggi bagi seluruh civitas akademika UPR.',
        'Mengembangkan dan mengelola sistem informasi terintegrasi yang mendukung proses akademik, administrasi, dan tata kelola universitas.',
        'Meningkatkan literasi digital melalui pelatihan, pendampingan, dan penyediaan sumber daya teknologi bagi seluruh sivitas akademika.',
        'Membangun kemitraan strategis dengan lembaga pemerintah, industri teknologi, dan institusi pendidikan dalam pengembangan ekosistem digital kampus.',
        'Menerapkan tata kelola TIK yang transparan, akuntabel, dan berorientasi pada kepuasan pengguna layanan.',
    ],
    sejarah: [
        {
            year: '2003',
            title: 'Pembentukan Unit Komputer UPR',
            description: 'Lahirnya cikal bakal UPA TIK sebagai unit pengelola sarana komputer dan jaringan kampus pertama kali di Universitas Palangka Raya.',
        },
        {
            year: '2008',
            title: 'Ekspansi Jaringan & Email Institusi',
            description: 'Pembangunan backbone jaringan fiber optik kampus dan launching email institusi @upr.ac.id bagi seluruh dosen dan staf.',
        },
        {
            year: '2013',
            title: 'Transformasi menjadi UPA TIK',
            description: 'Berdasarkan SK Rektor, unit resmi bertransformasi menjadi Unit Pelaksana Teknis Teknologi Informasi dan Komunikasi (UPA TIK) dengan cakupan tugas yang lebih luas.',
        },
        {
            year: '2017',
            title: 'Launching SIUBER (SIAKAD Terintegrasi)',
            description: 'Peluncuran Sistem Informasi Akademik Unggul dan Berkarakter (SIUBER) yang mengintegrasikan seluruh proses akademik dari pendaftaran mahasiswa baru hingga wisuda.',
        },
        {
            year: '2021',
            title: 'Era Cloud & Digitalisasi Penuh',
            description: 'Migrasi besar-besaran ke infrastruktur cloud, adopsi Microsoft 365 untuk seluruh civitas akademika, dan pengembangan 30+ sistem informasi baru dalam satu periode.',
        },
        {
            year: '2024',
            title: 'UPR Smart Campus Initiative',
            description: 'Peluncuran inisiatif kampus cerdas dengan implementasi IoT untuk monitoring infrastruktur, dashboard analitik universitas, dan aplikasi mobile UPR terintegrasi.',
        },
    ],
};

defineProps({
});

const organization = {
    head: {
        name: "Dr. Ir. Yosef Barita Sarman, S.T., M.T.",
        role: "Kepala UPA TIK",
        image: "https://i.pravatar.cc/300?img=12",
        bio: "Bertanggung jawab atas seluruh arah strategis dan tata kelola teknologi informasi di lingkungan Universitas Palangka Raya."
    },
    secretary: {
        name: "Dewi Sartika, S.Kom., M.T.",
        role: "Sekretaris",
        image: "https://i.pravatar.cc/300?img=5",
        bio: "Mengelola administrasi dan koordinasi internal divisi teknis UPA TIK."
    },
    teams: [
        {
            name: "Dharmawan Putra, M.Cs.",
            role: "Koordinator Tim Infrastruktur",
            image: "https://i.pravatar.cc/300?img=11"
        },
        {
            name: "Siti Aminah, S.T.",
            role: "Koordinator Sistem Informasi",
            image: "https://i.pravatar.cc/300?img=26"
        },
        {
            name: "Budi Santoso, S.Kom.",
            role: "Kepala Keamanan Jaringan",
            image: "https://i.pravatar.cc/300?img=68"
        },
        {
            name: "Anita Wijaya, M.IT.",
            role: "Koordinator Layanan Data",
            image: "https://i.pravatar.cc/300?img=44"
        }
    ]
};
</script>

<template>
    <UPAGuestLayout title="Struktur Organisasi">
        <!-- Header -->
        <section class="relative pt-40 pb-20 bg-primary overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2 blur-[100px]"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary rounded-full translate-x-1/2 translate-y-1/2 blur-[100px]"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-secondary font-bold text-xs uppercase tracking-widest rounded-full mb-6 inline-block">Mengenal Kami</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Struktur Organisasi</h1>
                <p class="max-w-2xl mx-auto text-slate-300 text-lg leading-relaxed">
                    Sinergi tim profesional yang berdedikasi untuk mewujudkan ekosistem digital terbaik di Universitas Palangka Raya.
                </p>
            </div>
        </section>

        <!-- Org Chart -->
        <section class="py-24 bg-white dark:bg-slate-900 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Head of Unit -->
                <div class="flex justify-center mb-24 animate-fade-in-up">
                    <div class="max-w-md w-full text-center">
                        <div class="relative inline-block mb-8">
                            <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl group-hover:bg-primary/40 transition-all duration-500"></div>
                            <img :src="organization.head.image" class="relative w-48 h-48 rounded-full border-4 border-white dark:border-slate-800 shadow-2xl object-cover" alt="Kepala Unit" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ organization.head.name }}</h2>
                        <span class="px-4 py-1 bg-primary text-white text-xs font-bold uppercase tracking-widest rounded-full mb-6 inline-block">{{ organization.head.role }}</span>
                        <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">{{ organization.head.bio }}</p>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><Mail class="w-5 h-5" /></a>
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><Linkedin class="w-5 h-5" /></a>
                        </div>
                    </div>
                </div>

                <!-- Connectors (Visual Only) -->
                <div class="hidden lg:flex justify-center -mt-16 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="w-0.5 h-16 bg-gradient-to-b from-primary to-transparent opacity-20"></div>
                </div>

                <!-- Secretary -->
                <div class="flex justify-center mb-24 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="max-w-md w-full text-center">
                        <div class="relative inline-block mb-8">
                            <img :src="organization.secretary.image" class="relative w-40 h-40 rounded-full border-4 border-white dark:border-slate-800 shadow-xl object-cover" alt="Sekretaris" />
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ organization.secretary.name }}</h2>
                        <span class="px-4 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold uppercase tracking-widest rounded-full mb-4 inline-block">{{ organization.secretary.role }}</span>
                        <div class="flex justify-center space-x-4">
                            <a href="#" class="text-slate-400 hover:text-primary transition-colors"><Mail class="w-5 h-5" /></a>
                        </div>
                    </div>
                </div>

                <!-- Tech Teams Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mt-20 animate-fade-in-up" style="animation-delay: 0.5s;">
                    <div v-for="member in organization.teams" :key="member.name" class="text-center group">
                        <div class="mb-6 relative inline-block">
                            <img :src="member.image" class="w-24 h-24 rounded-2xl border-2 border-slate-100 dark:border-slate-700 shadow-lg object-cover group-hover:scale-105 transition-transform" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 group-hover:text-primary transition-colors">{{ member.name }}</h3>
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-bold">{{ member.role }}</p>
                    </div>
                </div>

            </div>
        </section>

        <!-- Visi, Misi & Sejarah Section -->
        <section class="py-24 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Visi -->
                <div class="text-center mb-20">
                    <span class="px-4 py-1.5 bg-primary/10 text-primary font-bold text-xs uppercase tracking-widest rounded-full mb-6 inline-block">Arah & Tujuan</span>
                    <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-16">Visi, Misi & Sejarah</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
                        <!-- Visi Card -->
                        <div class="bg-primary text-white rounded-3xl p-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full translate-x-1/3 -translate-y-1/3 blur-2xl"></div>
                            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                                <Eye class="w-6 h-6 text-secondary" />
                            </div>
                            <h3 class="text-2xl font-extrabold mb-4">Visi</h3>
                            <p class="text-slate-200 leading-relaxed text-lg font-medium italic">"{{ visiMisi.visi }}"</p>
                        </div>

                        <!-- Misi Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-slate-100 dark:border-slate-700 shadow-sm">
                            <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                                <Target class="w-6 h-6 text-primary" />
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-6">Misi</h3>
                            <ul class="space-y-4">
                                <li
                                    v-for="(item, i) in visiMisi.misi"
                                    :key="i"
                                    class="flex items-start gap-3"
                                >
                                    <CheckCircle2 class="w-5 h-5 text-primary shrink-0 mt-0.5" />
                                    <span class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">{{ item }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sejarah / Timeline -->
                <div>
                    <div class="text-center mb-12">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <History class="w-6 h-6 text-primary" />
                        </div>
                        <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">Perjalanan UPA TIK</h3>
                        <p class="text-slate-500 mt-3 max-w-xl mx-auto">Dari unit komputer sederhana hingga menjadi pusat digitalisasi universitas.</p>
                    </div>

                    <div class="relative">
                        <!-- Vertical Line -->
                        <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary via-primary/30 to-transparent hidden md:block"></div>

                        <div class="space-y-8">
                            <div
                                v-for="(event, index) in visiMisi.sejarah"
                                :key="event.year"
                                class="relative flex flex-col md:flex-row gap-4 md:gap-0 items-start"
                                :class="index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'"
                            >
                                <!-- Content -->
                                <div class="md:w-[calc(50%-2rem)] bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:border-primary/20 transition-all"
                                    :class="index % 2 === 0 ? 'md:mr-8' : 'md:ml-8'">
                                    <div class="text-3xl font-black text-primary/20 dark:text-primary/30 mb-2">{{ event.year }}</div>
                                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ event.title }}</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ event.description }}</p>
                                </div>

                                <!-- Year Badge (center) -->
                                <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 top-6 w-16 h-16 bg-primary text-white rounded-full items-center justify-center font-black text-sm shadow-lg shadow-primary/30 z-10">
                                    {{ event.year }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-white dark:bg-slate-900">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Bergabung Bersama Kami?</h2>
                <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                    Kami selalu mencari talenta muda berbakat di bidang IT untuk bergabung dalam program magang atau riset kolaboratif.
                </p>
                <button class="px-8 py-4 bg-primary text-white font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-105 transition-all">Hubungi Kami</button>
            </div>
        </section>
    </UPAGuestLayout>
</template>
