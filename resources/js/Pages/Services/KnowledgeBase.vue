<script setup>
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { BookOpen, Search, ChevronRight, Clock, Tag, User, Wifi, Mail, Monitor, Shield, Network, HelpCircle, Star, Eye, ArrowLeft } from 'lucide-vue-next';
import { ref, computed } from 'vue';

const searchQuery = ref('');
const activeCategory = ref('semua');
const selectedArticle = ref(null);

const categories = [
    { id: 'semua', label: 'Semua Panduan', icon: BookOpen },
    { id: 'email', label: 'Email Institusi', icon: Mail },
    { id: 'wifi', label: 'Wi-Fi & Jaringan', icon: Wifi },
    { id: 'siakad', label: 'SIAKAD & Akademik', icon: Monitor },
    { id: 'keamanan', label: 'Keamanan Digital', icon: Shield },
    { id: 'infrastruktur', label: 'Infrastruktur', icon: Network },
];

const articles = [
    {
        id: 1,
        category: 'email',
        title: 'Cara Setting Email Institusi di Microsoft Outlook',
        description: 'Panduan lengkap mengonfigurasi akun email @upr.ac.id di Microsoft Outlook untuk Windows dan Mac.',
        author: 'Tim TIK UPR',
        readTime: '5 menit',
        views: 1420,
        rating: 4.8,
        featured: true,
        steps: [
            {
                title: 'Buka Microsoft Outlook',
                content: 'Pastikan Anda telah menginstal Microsoft Outlook. Buka aplikasi dan klik "Tambah Akun" jika ini adalah pertama kali, atau buka menu File > Tambah Akun jika sudah ada akun sebelumnya.',
            },
            {
                title: 'Masukkan Alamat Email Institusi',
                content: 'Ketikkan alamat email lengkap Anda dalam format nama@upr.ac.id, kemudian klik "Sambungkan". Outlook akan secara otomatis mencoba mendeteksi pengaturan server.',
            },
            {
                title: 'Pilih Jenis Akun (IMAP)',
                content: 'Pilih opsi "IMAP" sebagai jenis akun. Masukkan password email institusi Anda yang sama dengan password Google Workspace UPR.',
            },
            {
                title: 'Konfigurasi Server Manual (Jika Diperlukan)',
                content: 'Server Masuk (IMAP): imap.gmail.com, Port: 993, SSL. Server Keluar (SMTP): smtp.gmail.com, Port: 587, TLS/STARTTLS.',
            },
            {
                title: 'Verifikasi & Selesai',
                content: 'Klik "Selesai" setelah konfigurasi berhasil. Outlook akan mulai mengunduh email Anda. Proses ini mungkin membutuhkan beberapa menit tergantung jumlah email.',
            },
        ],
        tips: [
            'Pastikan "Akses Aplikasi Kurang Aman" TIDAK diaktifkan — gunakan OAuth2 (login via Google).',
            'Untuk sinkronisasi Google Kalender dan Kontak, install add-in "Google Workspace Sync for Microsoft Outlook" (GWSMO).',
            'Jika gagal, pastikan akun email Anda dalam status aktif di admin panel TIK.',
        ],
    },
    {
        id: 2,
        category: 'wifi',
        title: 'Cara Konfigurasi Eduroam di Android & iOS',
        description: 'Langkah-langkah terhubung ke jaringan Wi-Fi Eduroam menggunakan perangkat smartphone Android dan iPhone.',
        author: 'Tim Infrastruktur',
        readTime: '4 menit',
        views: 2318,
        rating: 4.9,
        featured: true,
        steps: [
            {
                title: 'Buka Pengaturan Wi-Fi',
                content: 'Di Android: Buka Pengaturan > Wi-Fi. Di iOS: Buka Pengaturan > Wi-Fi. Pastikan Wi-Fi sudah aktif.',
            },
            {
                title: 'Pilih Jaringan "eduroam"',
                content: 'Dari daftar jaringan yang tersedia, tap "eduroam". Jaringan ini tersedia di seluruh area kampus UPR.',
            },
            {
                title: 'Isi Kredensial Login',
                content: 'Metode EAP: PEAP. Identitas/Username: masukkan email institusi lengkap Anda (nama@upr.ac.id). Password: masukkan password email institusi. Sertifikat CA: Pilih "Jangan Validasi" atau "Gunakan sertifikat sistem".',
            },
            {
                title: 'Terhubung',
                content: 'Tap "Sambungkan" atau "Join". Perangkat Anda akan terautentikasi dan terhubung dalam beberapa detik. Ikon Wi-Fi akan muncul di status bar.',
            },
        ],
        tips: [
            'Jika gagal konek, lakukan "Lupakan Jaringan" (Forget Network) dan ulangi dari awal.',
            'Untuk iOS versi terbaru, mungkin perlu menerima sertifikat - tap "Percaya" ketika diminta.',
            'Eduroam berlaku di seluruh universitas yang tergabung dalam jaringan Eduroam Indonesia.',
        ],
    },
    {
        id: 3,
        category: 'email',
        title: 'Reset Password Email Institusi Secara Mandiri',
        description: 'Cara memulihkan akses akun email @upr.ac.id tanpa perlu menghubungi admin.',
        author: 'Tim TIK UPR',
        readTime: '3 menit',
        views: 3104,
        rating: 4.7,
        featured: false,
        steps: [
            {
                title: 'Akses Portal Reset Password',
                content: 'Buka browser dan kunjungi portal layanan mandiri UPR di accounts.google.com/signin/recovery atau gunakan nomor HP recovery yang telah terdaftar.',
            },
            {
                title: 'Masukkan Email Institusi',
                content: 'Ketikkan alamat email @upr.ac.id Anda. Jika akun terverifikasi, Google akan menampilkan opsi pemulihan.',
            },
            {
                title: 'Pilih Metode Verifikasi',
                content: 'Pilih metode verifikasi yang tersedia: kode ke nomor HP, email pemulihan (jika sudah diset), atau verifikasi pertanyaan keamanan.',
            },
            {
                title: 'Buat Password Baru',
                content: 'Setelah verifikasi berhasil, buat password baru yang kuat (minimal 8 karakter, kombinasi huruf besar, kecil, angka, dan simbol).',
            },
        ],
        tips: [
            'Jika tidak ada metode pemulihan yang tersedia, datang langsung ke Gedung UPA TIK dengan membawa KTM/KTP.',
            'Segera atur nomor HP pemulihan setelah berhasil login untuk memudahkan reset di masa mendatang.',
        ],
    },
    {
        id: 4,
        category: 'siakad',
        title: 'Panduan Pengisian KRS di SIUBER/SIAKAD',
        description: 'Panduan lengkap cara mengisi Kartu Rencana Studi (KRS) semester melalui sistem SIUBER UPR.',
        author: 'Tim Sistem Informasi',
        readTime: '6 menit',
        views: 5821,
        rating: 4.6,
        featured: true,
        steps: [
            {
                title: 'Pastikan Syarat Terpenuhi',
                content: 'Sebelum mengisi KRS, pastikan: (1) Pembayaran UKT sudah lunas dan terverifikasi, (2) Tidak ada blokir akademik/keuangan, (3) Masa pengisian KRS sedang aktif sesuai kalender akademik.',
            },
            {
                title: 'Login ke Portal SIUBER',
                content: 'Buka sia.upr.ac.id dan login menggunakan NIM sebagai username dan password yang telah diberikan. Hubungi admin fakultas jika belum memiliki akun.',
            },
            {
                title: 'Buka Menu KRS',
                content: 'Setelah login, pilih menu "Akademik" > "Kartu Rencana Studi". Pastikan semester aktif sudah sesuai dengan periode yang Anda rencanakan.',
            },
            {
                title: 'Pilih Mata Kuliah',
                content: 'Pilih mata kuliah sesuai kurikulum dan ketentuan dari dosen PA (Pembimbing Akademik). Perhatikan batas SKS maksimal per semester.',
            },
            {
                title: 'Konsultasi dengan Dosen PA',
                content: 'Sebelum finalisasi, konsultasikan pilihan mata kuliah dengan Dosen Pembimbing Akademik. Dosen PA harus menyetujui (approve) KRS Anda.',
            },
            {
                title: 'Finalisasi & Cetak KRS',
                content: 'Setelah disetujui PA, klik "Finalisasi KRS". Download dan cetak KRS untuk keperluan administrasi. KRS yang telah difinalisasi tidak bisa diubah tanpa izin khusus.',
            },
        ],
        tips: [
            'Isi KRS jauh sebelum batas waktu untuk menghindari sistem yang lambat saat peak.',
            'Screenshot atau download bukti persetujuan PA sebagai backup.',
            'Jika ada mata kuliah yang tidak muncul, hubungi admin akademik fakultas.',
        ],
    },
    {
        id: 5,
        category: 'keamanan',
        title: 'Panduan Aktivasi Two-Factor Authentication (2FA)',
        description: 'Cara mengamankan akun institusi dengan autentikasi dua faktor menggunakan Google Authenticator.',
        author: 'Tim Keamanan Siber',
        readTime: '5 menit',
        views: 987,
        rating: 4.9,
        featured: false,
        steps: [
            {
                title: 'Install Aplikasi Authenticator',
                content: 'Unduh dan install Google Authenticator atau Microsoft Authenticator di smartphone Anda dari Play Store (Android) atau App Store (iOS).',
            },
            {
                title: 'Buka Pengaturan Akun Google',
                content: 'Login ke email institusi Anda, buka myaccount.google.com > Keamanan > Cara login ke Google.',
            },
            {
                title: 'Aktifkan Verifikasi 2 Langkah',
                content: 'Pilih "Verifikasi 2 Langkah" dan klik "Mulai". Ikuti wizard yang muncul. Pilih "Aplikasi Authenticator" sebagai metode kedua.',
            },
            {
                title: 'Scan QR Code',
                content: 'Buka aplikasi Authenticator di HP Anda, tap "+" atau "Tambah Akun", pilih "Scan QR code", kemudian scan QR yang ditampilkan di layar komputer.',
            },
            {
                title: 'Verifikasi & Simpan Kode Cadangan',
                content: 'Masukkan 6-digit kode dari aplikasi untuk verifikasi. Simpan kode cadangan (backup codes) di tempat yang aman — gunakan jika HP Anda hilang.',
            },
        ],
        tips: [
            'JANGAN bagikan kode 2FA kepada siapa pun, termasuk yang mengaku sebagai staf TIK.',
            'Simpan kode cadangan di tempat aman seperti password manager atau cetak dan simpan di dompet.',
            'Sync waktu HP Anda agar kode 2FA selalu akurat.',
        ],
    },
    {
        id: 6,
        category: 'infrastruktur',
        title: 'Cara Mengajukan Permohonan Subdomain UPR',
        description: 'Prosedur resmi pengajuan subdomain .upr.ac.id untuk unit, lab, atau acara resmi universitas.',
        author: 'Tim Infrastruktur',
        readTime: '4 menit',
        views: 643,
        rating: 4.5,
        featured: false,
        steps: [
            {
                title: 'Unduh & Isi Formulir Permohonan',
                content: 'Download formulir permohonan subdomain dari halaman Pusat Unduhan UPA TIK. Isi dengan lengkap: nama subdomain yang diinginkan, tujuan penggunaan, dan informasi penanggung jawab.',
            },
            {
                title: 'Dapatkan Tanda Tangan Pimpinan Unit',
                content: 'Formulir harus ditandatangani dan distempel oleh Kepala Unit/Dekan/Direktur sebagai bukti permohonan resmi.',
            },
            {
                title: 'Ajukan ke UPA TIK',
                content: 'Serahkan formulir secara langsung ke Gedung UPA TIK atau kirim via email ke upt.tik@upr.ac.id dengan subject "Permohonan Subdomain - [Nama Unit]".',
            },
            {
                title: 'Proses Verifikasi (3-5 Hari Kerja)',
                content: 'Tim UPA TIK akan memverifikasi ketersediaan subdomain dan kelayakan permohonan. Anda akan dihubungi melalui email.',
            },
            {
                title: 'Konfigurasi DNS & Hosting',
                content: 'Setelah disetujui, tim teknis akan mengonfigurasi DNS dan memberikan informasi akses server kepada penanggung jawab teknis yang ditunjuk.',
            },
        ],
        tips: [
            'Pilih nama subdomain yang singkat, relevan, dan mudah diingat (contoh: lab-fisika.upr.ac.id).',
            'Subdomain yang tidak aktif selama 6 bulan berturut-turut dapat dicabut tanpa pemberitahuan.',
            'Untuk acara/event, lampirkan surat undangan atau SK penyelenggaraan.',
        ],
    },
    {
        id: 7,
        category: 'wifi',
        title: 'Troubleshooting Masalah Koneksi Wi-Fi Kampus',
        description: 'Solusi mandiri untuk berbagai masalah koneksi Wi-Fi yang sering dijumpai di lingkungan kampus.',
        author: 'Tim Infrastruktur',
        readTime: '5 menit',
        views: 1876,
        rating: 4.6,
        featured: false,
        steps: [
            {
                title: 'Cek Status Jaringan via Portal Status',
                content: 'Kunjungi halaman Status Sistem UPA TIK (upa-tik.upr.ac.id/status) untuk memastikan tidak ada gangguan jaringan terjadwal atau insiden di area Anda.',
            },
            {
                title: 'Restart Perangkat & Lupakan Jaringan',
                content: 'Restart smartphone/laptop Anda. Kemudian lakukan "Forget Network" / "Lupakan Jaringan" untuk koneksi Eduroam yang bermasalah, dan hubungkan ulang.',
            },
            {
                title: 'Periksa Validitas Akun',
                content: 'Coba login ke email institusi Anda di browser. Jika tidak bisa login, kemungkinan akun Anda tidak aktif — hubungi UPA TIK.',
            },
            {
                title: 'Ubah DNS Perangkat',
                content: 'Coba ubah DNS ke 8.8.8.8 (Google) atau 1.1.1.1 (Cloudflare) melalui Pengaturan Wi-Fi > Lanjutan > DNS.',
            },
            {
                title: 'Hubungi Helpdesk Jika Masih Bermasalah',
                content: 'Jika semua langkah di atas sudah dilakukan namun masalah berlanjut, laporkan ke Portal Helpdesk UPA TIK dengan menyertakan: lokasi Anda, perangkat yang digunakan, dan screenshot error.',
            },
        ],
        tips: [
            'Catat MAC Address perangkat Anda — ini mungkin diperlukan saat melapor.',
            'Kualitas sinyal bergantung pada lokasi — coba pindah lebih dekat ke titik akses Wi-Fi.',
            'Gunakan aplikasi "WiFi Analyzer" untuk mendeteksi titik akses terdekat.',
        ],
    },
    {
        id: 8,
        category: 'siakad',
        title: 'Panduan Login & Navigasi Portal Dosen UPR',
        description: 'Panduan untuk dosen dalam menggunakan Portal Dosen untuk manajemen kelas, nilai, dan jadwal.',
        author: 'Tim Sistem Informasi',
        readTime: '7 menit',
        views: 1234,
        rating: 4.7,
        featured: false,
        steps: [
            {
                title: 'Akses Portal Dosen',
                content: 'Buka browser dan kunjungi portal-dosen.upr.ac.id. Pastikan browser updated (Chrome/Firefox versi terbaru).',
            },
            {
                title: 'Login dengan NIP dan Password',
                content: 'Masukkan NIP Anda sebagai username. Password default adalah tanggal lahir format DDMMYYYY. Segera ganti password setelah login pertama.',
            },
            {
                title: 'Kelola Kelas & Materi',
                content: 'Di menu "Perkuliahan", pilih mata kuliah yang diajar. Upload materi perkuliahan, absensi, dan informasi jadwal dari sini.',
            },
            {
                title: 'Input Nilai Mahasiswa',
                content: 'Akses menu "Penilaian" untuk input nilai UTS, UAS, tugas, dan kehadiran. Nilai harus diinput sebelum batas waktu yang ditetapkan akademik.',
            },
        ],
        tips: [
            'Jika lupa password, hubungi admin akademik fakultas untuk reset.',
            'Update profil dan nomor HP untuk memudahkan pemulihan akun.',
        ],
    },
];

const filteredArticles = computed(() => {
    let result = articles;
    if (activeCategory.value !== 'semua') {
        result = result.filter(a => a.category === activeCategory.value);
    }
    if (searchQuery.value) {
        const q = searchQuery.value.toLowerCase();
        result = result.filter(a =>
            a.title.toLowerCase().includes(q) ||
            a.description.toLowerCase().includes(q)
        );
    }
    return result;
});

const featuredArticles = computed(() => articles.filter(a => a.featured).slice(0, 3));

const openArticle = (article) => {
    selectedArticle.value = article;
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

const closeArticle = () => {
    selectedArticle.value = null;
};

const categoryLabel = (catId) => {
    return categories.find(c => c.id === catId)?.label ?? catId;
};
</script>

<template>
    <UPAGuestLayout title="Knowledge Base">
        <!-- Article Detail View -->
        <div v-if="selectedArticle">
            <section class="pt-32 pb-20 bg-white dark:bg-slate-900 min-h-screen">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Back Button -->
                    <button
                        @click="closeArticle"
                        class="flex items-center space-x-2 text-sm font-bold text-slate-500 hover:text-primary transition-colors mb-10 group"
                    >
                        <ArrowLeft class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
                        <span>Kembali ke Knowledge Base</span>
                    </button>

                    <!-- Article Header -->
                    <div class="mb-12">
                        <span class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold uppercase rounded-lg tracking-wider mb-4 inline-block">
                            {{ categoryLabel(selectedArticle.category) }}
                        </span>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-6 leading-tight">
                            {{ selectedArticle.title }}
                        </h1>
                        <p class="text-lg text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">
                            {{ selectedArticle.description }}
                        </p>
                        <div class="flex flex-wrap items-center gap-6 text-sm text-slate-400 pb-8 border-b border-slate-100 dark:border-slate-800">
                            <span class="flex items-center gap-2"><User class="w-4 h-4" /> {{ selectedArticle.author }}</span>
                            <span class="flex items-center gap-2"><Clock class="w-4 h-4" /> {{ selectedArticle.readTime }} baca</span>
                            <span class="flex items-center gap-2"><Eye class="w-4 h-4" /> {{ selectedArticle.views.toLocaleString('id') }} dilihat</span>
                            <span class="flex items-center gap-2 text-amber-500">
                                <Star class="w-4 h-4 fill-current" />
                                {{ selectedArticle.rating }}
                            </span>
                        </div>
                    </div>

                    <!-- Steps -->
                    <div class="space-y-6 mb-12">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Langkah-Langkah</h2>
                        <div
                            v-for="(step, index) in selectedArticle.steps"
                            :key="index"
                            class="flex gap-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6"
                        >
                            <div class="shrink-0 w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-black text-lg">
                                {{ index + 1 }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ step.title }}</h3>
                                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">{{ step.content }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div v-if="selectedArticle.tips && selectedArticle.tips.length" class="bg-secondary/10 border border-secondary/30 rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                            <HelpCircle class="w-5 h-5 text-secondary" />
                            Tips & Catatan Penting
                        </h3>
                        <ul class="space-y-3">
                            <li
                                v-for="(tip, i) in selectedArticle.tips"
                                :key="i"
                                class="flex items-start gap-3 text-slate-700 dark:text-slate-300 text-sm leading-relaxed"
                            >
                                <div class="w-2 h-2 bg-secondary rounded-full shrink-0 mt-1.5"></div>
                                {{ tip }}
                            </li>
                        </ul>
                    </div>

                    <!-- Still need help? -->
                    <div class="mt-12 bg-primary rounded-2xl p-8 text-white text-center">
                        <h3 class="text-xl font-bold mb-2">Masih Membutuhkan Bantuan?</h3>
                        <p class="text-slate-300 mb-6 text-sm">Jika panduan ini belum menyelesaikan masalah Anda, tim helpdesk kami siap membantu.</p>
                        <a href="/#helpdesk" class="inline-block px-8 py-3 bg-secondary text-primary font-bold rounded-xl hover:bg-secondary-light transition-colors">
                            Hubungi Helpdesk
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Main Knowledge Base Listing -->
        <div v-else>
            <!-- Header -->
            <section class="pt-40 pb-20 bg-primary text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-secondary rounded-full translate-x-1/2 -translate-y-1/2 blur-[100px]"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 translate-y-1/2 blur-[100px]"></div>
                </div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center mb-12">
                        <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 text-secondary font-bold text-xs uppercase tracking-widest rounded-full mb-6 inline-block">Dokumentasi Teknis</span>
                        <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Knowledge Base</h1>
                        <p class="text-slate-300 max-w-2xl mx-auto text-lg leading-relaxed">
                            Panduan teknis dan tutorial langkah-demi-langkah untuk membantu civitas akademika menggunakan layanan digital UPR secara mandiri.
                        </p>
                    </div>

                    <!-- Search -->
                    <div class="max-w-2xl mx-auto">
                        <div class="relative">
                            <Search class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Cari panduan, tutorial, atau solusi..."
                                class="w-full pl-14 pr-6 py-5 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-secondary text-base"
                            />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Articles -->
            <section class="py-16 bg-slate-50 dark:bg-slate-900/50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">Panduan Populer</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div
                            v-for="article in featuredArticles"
                            :key="article.id"
                            @click="openArticle(article)"
                            class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 hover:border-primary/30 hover:shadow-xl cursor-pointer transition-all group"
                        >
                            <span class="text-[10px] font-black uppercase tracking-widest text-primary dark:text-secondary">{{ categoryLabel(article.category) }}</span>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-2 mb-3 group-hover:text-primary transition-colors leading-snug">{{ article.title }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-6">{{ article.description }}</p>
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase">
                                <span class="flex items-center gap-1"><Clock class="w-3 h-3" /> {{ article.readTime }}</span>
                                <span class="flex items-center gap-1 text-amber-500"><Star class="w-3 h-3 fill-current" /> {{ article.rating }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- All Articles with Category Filter -->
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
                                <component :is="cat.icon" class="w-4 h-4 shrink-0" />
                                {{ cat.label }}
                            </button>
                        </div>

                        <!-- Article List -->
                        <div class="lg:col-span-3">
                            <div v-if="filteredArticles.length" class="space-y-4">
                                <div
                                    v-for="article in filteredArticles"
                                    :key="article.id"
                                    @click="openArticle(article)"
                                    class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 hover:border-primary/30 hover:shadow-xl cursor-pointer transition-all group flex items-start gap-6"
                                >
                                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                                        <BookOpen class="w-6 h-6 text-primary" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-primary dark:text-secondary">{{ categoryLabel(article.category) }}</span>
                                            <span v-if="article.featured" class="text-[10px] bg-amber-100 text-amber-600 font-bold px-2 py-0.5 rounded">Populer</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors mb-2">{{ article.title }}</h3>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">{{ article.description }}</p>
                                        <div class="flex items-center gap-6 mt-4 text-[10px] font-bold text-slate-400 uppercase">
                                            <span class="flex items-center gap-1"><Clock class="w-3 h-3" /> {{ article.readTime }}</span>
                                            <span class="flex items-center gap-1"><Eye class="w-3 h-3" /> {{ article.views.toLocaleString('id') }}</span>
                                            <span class="flex items-center gap-1 text-amber-500"><Star class="w-3 h-3 fill-current" /> {{ article.rating }}</span>
                                        </div>
                                    </div>
                                    <ChevronRight class="w-5 h-5 text-slate-300 group-hover:text-primary group-hover:translate-x-1 transition-all shrink-0 mt-1" />
                                </div>
                            </div>

                            <div v-else class="py-20 text-center bg-white dark:bg-slate-800 rounded-3xl">
                                <BookOpen class="w-16 h-16 text-slate-200 dark:text-slate-700 mx-auto mb-4" />
                                <p class="text-slate-500 font-bold text-lg">Panduan tidak ditemukan</p>
                                <p class="text-slate-400 text-sm mt-2">Coba kata kunci lain atau pilih kategori berbeda.</p>
                                <button @click="searchQuery = ''; activeCategory = 'semua'" class="mt-6 text-primary font-bold hover:underline">Reset Pencarian</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </UPAGuestLayout>
</template>
