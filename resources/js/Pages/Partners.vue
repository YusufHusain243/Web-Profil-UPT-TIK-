<script setup>
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { 
    Users, 
    Handshake, 
    Globe, 
    Cpu, 
    ShieldCheck, 
    Layers,
    ExternalLink,
    Building2,
    GraduationCap
} from 'lucide-vue-next';

defineProps({
});

const partners = [
    {
        category: 'Institutional Partners',
        items: [
            { name: 'KEMENDIKBUDRISTEK', description: 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi', color: 'bg-blue-500', icon: Building2 },
            { name: 'Universitas Palangka Raya', description: 'Induk Institusi Pendidikan Tinggi Terbesar di Kalteng', color: 'bg-primary', icon: GraduationCap },
            { name: 'PEMPROV KALTENG', description: 'Pemerintah Provinsi Kalimantan Tengah', color: 'bg-red-500', icon: Building2 },
        ]
    },
    {
        category: 'Technology Partners',
        items: [
            { name: 'Cisco Networking', description: 'Partner Infrastruktur Jaringan & Keamanan Data', color: 'bg-blue-600', icon: Cpu },
            { name: 'Google for Education', description: 'Kolaborasi Layanan Cloud & Produktivitas Akademik', color: 'bg-green-500', icon: Globe },
            { name: 'MikroTik Academy', description: 'Pusat Pelatihan & Sertifikasi Jaringan Lokal', color: 'bg-slate-700', icon: ShieldCheck },
            { name: 'Microsoft Azure', description: 'Layanan Cloud Computing & AI Terintegrasi', color: 'bg-sky-500', icon: Layers },
        ]
    }
];

const bentoItems = [
    { 
        title: 'Strategic Alliances', 
        desc: 'Membangun ekosistem digital bersama institusi global.', 
        icon: Handshake, 
        class: 'md:col-span-2 md:row-span-1 bg-primary text-white' 
    },
    { 
        title: 'Regional Impact', 
        desc: 'Mendukung digitalisasi pemerintahan daerah di Kalimantan Tengah.', 
        icon: Globe, 
        class: 'bg-secondary text-primary' 
    },
    { 
        title: 'Global Standards', 
        desc: 'Sertifikasi internasional untuk mahasiswa.', 
        icon: ShieldCheck, 
        class: 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white' 
    }
];

</script>

<template>
    <Head title="Partners" />

    <UPAGuestLayout title="Partners">
        <div class="relative pt-20 pb-20 overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-16 space-y-4">
                    <div class="inline-flex items-center space-x-2 px-4 py-2 bg-primary/10 rounded-full border border-primary/20">
                        <Handshake class="w-4 h-4 text-primary" />
                        <span class="text-xs font-bold text-primary uppercase tracking-widest">Our Ecosystem</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight">
                        Our Trusted <span class="text-primary tracking-tighter italic">Partners</span>
                    </h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                        Kolaborasi strategis dengan berbagai institusi dan pemimpin teknologi industri untuk menghadirkan inovasi digital terbaik di lingkungan kampus.
                    </p>
                </div>

                <!-- Bento Intro Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
                    <div v-for="(item, idx) in bentoItems" :key="idx" 
                        :class="['p-8 rounded-3xl flex flex-col justify-between group hover:rotate-1 transition-all duration-300', item.class]">
                        <div class="flex justify-between items-start">
                            <component :is="item.icon" class="w-12 h-12" />
                            <ExternalLink class="w-5 h-5 opacity-0 group-hover:opacity-50 transition-opacity" />
                        </div>
                        <div class="mt-12">
                            <h3 class="text-2xl font-bold mb-2">{{ item.title }}</h3>
                            <p class="text-sm opacity-80">{{ item.desc }}</p>
                        </div>
                    </div>
                </div>

                <!-- Partners Grid -->
                <div class="space-y-20">
                    <section v-for="(group, gIdx) in partners" :key="gIdx" class="space-y-10">
                        <div class="flex items-center space-x-4">
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ group.category }}</h2>
                            <div class="h-[2px] bg-slate-200 dark:bg-slate-800 flex-grow"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div v-for="(partner, pIdx) in group.items" :key="pIdx"
                                class="p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl hover:shadow-2xl hover:shadow-primary/10 hover:-translate-y-2 transition-all duration-500 cursor-pointer group">
                                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 text-white transition-transform group-hover:scale-110" :class="partner.color">
                                    <component :is="partner.icon" class="w-8 h-8" />
                                </div>
                                <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ partner.name }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                                    {{ partner.description }}
                                </p>
                                <div class="flex items-center text-xs font-bold text-primary uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all">
                                    <span>Learn More</span>
                                    <ExternalLink class="w-3 h-3 ml-2" />
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- CTA Section -->
                <div class="mt-32 p-12 bg-slate-900 dark:bg-primary rounded-[40px] text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-secondary/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                    <h2 class="text-3xl font-bold mb-6">Tertarik berkolaborasi dengan UPA TIK?</h2>
                    <p class="text-slate-400 dark:text-blue-100 mb-10 max-w-xl mx-auto">Kami terbuka untuk peluang kerja sama baru dalam pengembangan ekosistem digital dan inovasi teknologi.</p>
                    <button class="px-8 py-4 bg-secondary text-primary text-lg font-black rounded-2xl hover:scale-105 transition-transform">
                        CONTACT OUR PARTNERSHIP TEAM
                    </button>
                </div>
            </div>
        </div>
    </UPAGuestLayout>
</template>

<style scoped>
/* Gradient Text and custom effects */
.text-primary {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>
