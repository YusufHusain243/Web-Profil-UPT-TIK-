export const faqCategories = [
    { id: 'email', label: 'Email Institusi' },
    { id: 'internet', label: 'Internet & WiFi' },
    { id: 'siakad', label: 'SIAKAD' },
    { id: 'lab', label: 'Laboratorium' },
    { id: 'bantuan', label: 'Bantuan & Admin' },
];

export const faqs = [
    {
        category: 'email',
        question: 'Bagaimana cara mendapatkan akun email institusi (@upr.ac.id)?',
        answer: 'Bagi mahasiswa baru, akun dibuat secara kolektif. Untuk dosen/staf yang belum memiliki akun, silakan ajukan permohonan melalui admin TIK fakultas atau datang langsung ke Gedung UPA TIK dengan membawa SK/Kartu Identitas.',
    },
    {
        category: 'email',
        question: 'Saya lupa kata sandi email, apa yang harus saya lakukan?',
        answer: 'Anda dapat melakukan reset secara mandiri melalui form reset password resmi universitas. Silakan akses tautan tersebut untuk memulihkan akses akun Anda.',
    },
    {
        category: 'email',
        question: 'Mengapa saya tidak bisa mengirim/menerima email?',
        answer: 'Periksa sisa kuota penyimpanan email Anda. Jika penuh, hapus file atau email yang tidak diperlukan di Google Drive/Gmail karena kuota bersifat terintegrasi.',
    },
    {
        category: 'internet',
        question: 'Bagaimana cara terhubung ke WiFi Eduroam?',
        answer: 'Gunakan identitas email institusi (@upr.ac.id) sebagai username dan kata sandi email Anda sebagai password untuk login ke jaringan Eduroam.',
    },
    {
        category: 'internet',
        question: 'Mengapa perangkat saya gagal terhubung ke Eduroam?',
        answer: "Lakukan 'Forget Network' pada pengaturan WiFi perangkat Anda, kemudian coba login kembali menggunakan format email lengkap. Pastikan akun email Anda dalam status aktif.",
    },
    {
        category: 'internet',
        question: 'Di mana saja lokasi hotspot WiFi kampus?',
        answer: 'Jaringan Eduroam tersedia di seluruh area gedung fakultas, rektorat, dan berbagai area publik di lingkungan Universitas Palangka Raya.',
    },
    {
        category: 'siakad',
        question: "Muncul notifikasi 'User Terkunci' saat login SIAKAD, bagaimana solusinya?",
        answer: 'Hal ini biasanya terjadi karena salah memasukkan password berulang kali. Silakan hubungi admin TIK di unit atau fakultas Anda untuk pembukaan blokir akses.',
    },
    {
        category: 'siakad',
        question: 'Saya tidak bisa mengisi KRS di SIAKAD, apa masalahnya?',
        answer: 'Pastikan Anda sudah menyelesaikan administrasi keuangan dan masa pengisian KRS belum berakhir sesuai dengan kalender akademik yang berlaku.',
    },
    {
        category: 'lab',
        question: 'Bagaimana prosedur meminjam Laboratorium Komputer untuk kegiatan?',
        answer: 'Mengajukan surat permohonan resmi kepada Kepala UPA TIK minimal 3 hari sebelum kegiatan. Pastikan jadwal tersedia melalui staf administrasi kami.',
    },
    {
        category: 'lab',
        question: 'Apakah Laboratorium Komputer buka di luar jam kuliah?',
        answer: 'Laboratorium beroperasi sesuai jadwal praktikum yang telah ditetapkan. Penggunaan mandiri oleh mahasiswa harus dengan izin resmi dari staf laboratorium.',
    },
    {
        category: 'bantuan',
        question: 'Di mana lokasi kantor UPA TIK UPR?',
        answer: 'Gedung UPA TIK terletak di komplek area kampus Universitas Palangka Raya (Kampus Tanjung Nyaho).',
    },
    {
        category: 'bantuan',
        question: 'Kapan saya bisa berkonsultasi langsung dengan staf teknis?',
        answer: 'Layanan bantuan manual tersedia pada hari kerja (Senin-Jumat) selama jam operasional resmi kantor. Chatbot dan portal bantuan tetap melayani informasi mandiri 24/7.',
    },
];

export const helpCategories = [
    'Email Institusi',
    'Wi-Fi & Jaringan',
    'SIAKAD/Sistem Akademik',
    'Sistem Institusi',
    'Lainnya',
];
