<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { Pencil, Plus, Trash2, Star, ChevronDown, ChevronUp, Image, ToggleLeft, ToggleRight, GripVertical, Eye, AlertCircle, CheckCircle } from 'lucide-vue-next';

const props = defineProps({
    slides: { type: Array, default: () => [] },
});

const activeTab = ref('carousel');

const tabs = [
    { id: 'carousel',     label: '🎠 Carousel' },
    { id: 'stats',        label: '📊 Statistik' },
    { id: 'services',     label: '⚙️ Layanan' },
    { id: 'projects',     label: '🚀 Proyek' },
    { id: 'testimonials', label: '💬 Testimoni' },
    { id: 'faq',          label: '❓ FAQ' },
];

// ═══ CAROUSEL ═══
const showSlideModal = ref(false);
const editingSlide = ref(null);   // null = add mode, object = edit mode
const deleteSlideTarget = ref(null);
const previewSlide = ref(null);
const imagePreview = ref(null);

const emptyForm = () => ({
    order: props.slides.length + 1,
    badge: '',
    heading: '',
    description: '',
    cta1_text: '',
    cta2_text: '',
    image: null,
    image_url: '',
    is_active: true,
});

const form = useForm(emptyForm());

const openAdd = () => {
    editingSlide.value = null;
    imagePreview.value = null;
    form.reset();
    Object.assign(form, emptyForm());
    showSlideModal.value = true;
};

const openEdit = (slide) => {
    editingSlide.value = slide;
    imagePreview.value = resolvedImage(slide);
    form.clearErrors();
    form.order       = slide.order;
    form.badge       = slide.badge ?? '';
    form.heading     = slide.heading;
    form.description = slide.description ?? '';
    form.cta1_text   = slide.cta1_text ?? '';
    form.cta2_text   = slide.cta2_text ?? '';
    form.image       = null;
    form.image_url   = '';
    form.is_active   = slide.is_active;
    showSlideModal.value = true;
};

const closeModal = () => {
    showSlideModal.value = false;
    editingSlide.value = null;
    imagePreview.value = null;
    form.clearErrors();
};

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (!file) { return; }
    form.image = file;
    form.image_url = '';
    imagePreview.value = URL.createObjectURL(file);
};

const onImageUrlBlur = (e) => {
    if (e.target.value) {
        form.image = null;
        imagePreview.value = e.target.value;
    }
};

const submitSlide = () => {
    if (editingSlide.value) {
        form.post(route('carousel.update', editingSlide.value.id), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: closeModal,
        });
    } else {
        form.post(route('carousel.store'), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: closeModal,
        });
    }
};

const toggleActive = (slide) => {
    router.patch(route('carousel.toggle', slide.id), {}, { preserveScroll: true });
};

const confirmDelete = () => {
    router.delete(route('carousel.destroy', deleteSlideTarget.value.id), {
        preserveScroll: true,
        onSuccess: () => { deleteSlideTarget.value = null; },
    });
};

const resolvedImage = (slide) => {
    if (!slide.image_path) { return null; }
    if (slide.image_path.startsWith('http')) { return slide.image_path; }
    return `/storage/${slide.image_path}`;
};

// Stats
const stats = ref([
    { id: 1, value: '5,000+', label: 'Pengguna Aktif' },
    { id: 2, value: '99.9%',  label: 'Uptime Jaringan' },
    { id: 3, value: '24/7',   label: 'Dukungan Teknis' },
    { id: 4, value: '50+',    label: 'Layanan Digital' },
]);

// Services
const services = ref([
    { id: 1, icon: '🌐', title: 'Infrastruktur Jaringan', desc: 'Jaringan fiber optik berkecepatan tinggi dan Wi-Fi (Eduroam) di seluruh area kampus.' },
    { id: 2, icon: '💻', title: 'Pengembangan Sistem',    desc: 'Membangun dan memelihara sistem informasi akademik, keuangan, dan administrasi kampus.' },
    { id: 3, icon: '🏢', title: 'Data Center',            desc: 'Pengelolaan pusat data kampus dengan standar keamanan dan keandalan tinggi.' },
    { id: 4, icon: '📞', title: 'Helpdesk & Dukungan',   desc: 'Layanan dukungan teknis cepat dan responsif untuk seluruh civitas akademika.' },
    { id: 5, icon: '🔒', title: 'Keamanan Siber',         desc: 'Perlindungan aset digital kampus dari ancaman siber dengan sistem keamanan berlapis.' },
    { id: 6, icon: '☁️', title: 'Cloud Services',          desc: 'Akses layanan cloud Microsoft 365 dan Google Workspace untuk produktivitas kampus.' },
]);

// Projects
const projects = ref([
    { id: 1, name: 'SIUBER Cloud Migration',     status: 'Selesai',     year: 2023, desc: 'Migrasi sistem informasi akademik ke cloud hybrid.' },
    { id: 2, name: 'Smart Campus IoT',            status: 'Berjalan',    year: 2024, desc: 'Implementasi sensor IoT di seluruh gedung kampus.' },
    { id: 3, name: 'Fiber Optic Expansion',       status: 'Selesai',     year: 2022, desc: 'Perluasan jaringan fiber optik ke 15 gedung baru.' },
    { id: 4, name: 'Cybersecurity Framework',     status: 'Berjalan',    year: 2024, desc: 'Implementasi kerangka keamanan siber komprehensif.' },
]);

// Testimonials
const testimonials = ref([
    { id: 1, name: 'Dr. Susanti, M.Pd.',    role: 'Dosen FKIP',       stars: 5, text: 'Layanan IT kampus sangat responsif dan membantu.' },
    { id: 2, name: 'Budi Santoso',           role: 'Mahasiswa Teknik', stars: 5, text: 'Eduroam sangat membantu proses belajar saya.' },
    { id: 3, name: 'Hj. Rahmawati, S.E.',   role: 'Staf BAK',         stars: 4, text: 'Sistem administrasi kini jauh lebih mudah digunakan.' },
]);

// FAQ
const faqs = ref([
    { id: 1, q: 'Bagaimana cara mendapatkan akun email institusi?', a: 'Akun email institusi diberikan secara otomatis saat mahasiswa/dosen aktif terdaftar. Hubungi helpdesk jika belum menerima informasi akun.', open: false },
    { id: 2, q: 'Apakah ada dukungan teknis 24 jam?',               a: 'Tim helpdesk kami beroperasi 8AM–5PM pada hari kerja. Untuk keadaan darurat, gunakan grup WhatsApp darurat TIK.', open: false },
]);

const deleteSvcTarget = ref(null);
const deleteTestimonialTarget = ref(null);
const deleteFaqTarget = ref(null);
const addServiceModal = ref(false);
const addTestimonialModal = ref(false);
const addFaqModal = ref(false);

const toggleFaq = (faq) => { faq.open = !faq.open; };
</script>

<template>
    <Head title="Kelola Homepage" />
    <AdminLayout title="Kelola Homepage">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-xl font-black text-slate-900 dark:text-white">Kelola Homepage</h1>
            <p class="text-slate-500 text-sm mt-0.5">Edit konten seluruh bagian pada halaman beranda website</p>
        </div>

        <!-- Tabs -->
        <div class="flex gap-1 overflow-x-auto bg-slate-100 dark:bg-slate-800 rounded-2xl p-1 mb-6">
            <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
                class="px-4 py-2.5 rounded-xl text-sm font-bold whitespace-nowrap transition-all"
                :class="activeTab === tab.id ? 'bg-white dark:bg-slate-900 text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700'">
                {{ tab.label }}
            </button>
        </div>

        <!-- ═══ CAROUSEL ═══ -->
        <div v-if="activeTab === 'carousel'">
            <div class="flex items-center justify-between mb-4">
                <p class="text-slate-500 text-sm">{{ props.slides.filter(s => s.is_active).length }} slide aktif dari {{ props.slides.length }} total</p>
                <button @click="openAdd" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                    <Plus class="w-4 h-4" /> Tambah Slide
                </button>
            </div>

            <div class="space-y-4">
                <div v-for="slide in props.slides.slice().sort((a,b) => a.order - b.order)" :key="slide.id"
                    class="bg-white dark:bg-slate-900 rounded-2xl border overflow-hidden transition-all"
                    :class="slide.is_active ? 'border-slate-100 dark:border-slate-800' : 'border-dashed border-slate-300 dark:border-slate-700 opacity-60'">
                    <div class="flex items-stretch">
                        <!-- Thumbnail -->
                        <div class="w-48 shrink-0 relative overflow-hidden hidden sm:block bg-slate-800">
                            <img v-if="resolvedImage(slide)" :src="resolvedImage(slide)" class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full flex items-center justify-center"><Image class="w-8 h-8 text-slate-600" /></div>
                            <div v-if="slide.badge" class="absolute bottom-0 left-0 right-0 bg-primary/70 px-3 py-1.5">
                                <span class="text-[9px] font-black text-white uppercase tracking-widest">{{ slide.badge }}</span>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1 p-5">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex items-center gap-2">
                                    <GripVertical class="w-4 h-4 text-slate-300 cursor-grab" />
                                    <span class="text-[10px] font-black text-slate-400 uppercase">Slide #{{ slide.order }}</span>
                                    <span v-if="!slide.is_active" class="text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-400 rounded">Nonaktif</span>
                                </div>
                                <div class="flex gap-1 shrink-0">
                                    <button @click="previewSlide = slide" class="p-1.5 text-slate-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Preview"><Eye class="w-4 h-4" /></button>
                                    <button @click="toggleActive(slide)" class="p-1.5 rounded-lg transition-colors" :class="slide.is_active ? 'text-emerald-500 hover:bg-emerald-50' : 'text-slate-400 hover:bg-slate-100'" :title="slide.is_active ? 'Nonaktifkan' : 'Aktifkan'">
                                        <ToggleRight v-if="slide.is_active" class="w-4 h-4" />
                                        <ToggleLeft v-else class="w-4 h-4" />
                                    </button>
                                    <button @click="openEdit(slide)" class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                                    <button @click="deleteSlideTarget = slide" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                                </div>
                            </div>
                            <h3 class="font-black text-slate-800 dark:text-white text-base mb-1 leading-snug">{{ slide.heading }}</h3>
                            <p class="text-slate-500 text-xs leading-relaxed mb-3 line-clamp-2">{{ slide.description }}</p>
                            <div class="flex gap-2">
                                <span v-if="slide.cta1_text" class="text-[10px] font-bold px-2.5 py-1 bg-primary text-white rounded-lg">{{ slide.cta1_text }}</span>
                                <span v-if="slide.cta2_text" class="text-[10px] font-bold px-2.5 py-1 border border-slate-200 text-slate-600 rounded-lg">{{ slide.cta2_text }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="props.slides.length === 0" class="py-20 text-center bg-white dark:bg-slate-900 rounded-2xl border border-dashed border-slate-200">
                    <Image class="w-12 h-12 text-slate-200 mx-auto mb-3" />
                    <p class="text-slate-400 font-bold text-sm">Belum ada slide carousel.</p>
                    <button @click="openAdd" class="mt-3 text-primary text-sm font-bold hover:underline">+ Tambah slide pertama</button>
                </div>
            </div>

            <!-- Slide Add/Edit Modal -->
            <div v-if="showSlideModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                    <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800 sticky top-0 bg-white dark:bg-slate-900 z-10">
                        <h2 class="text-lg font-black text-slate-900 dark:text-white">{{ editingSlide ? 'Edit Slide' : 'Tambah Slide Baru' }}</h2>
                        <button @click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                    </div>
                    <form @submit.prevent="submitSlide" enctype="multipart/form-data">
                    <div class="p-6 space-y-5">
                        <!-- Image -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Foto Background</label>
                            <!-- Preview -->
                            <div v-if="imagePreview" class="mb-3 rounded-xl overflow-hidden h-36 bg-slate-800 relative">
                                <img :src="imagePreview" class="w-full h-full object-cover opacity-80" />
                                <button type="button" @click="imagePreview = null; form.image = null; form.image_url = ''" class="absolute top-2 right-2 p-1 bg-black/50 text-white rounded-lg text-xs">✕ Hapus</button>
                            </div>
                            <label class="block border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-5 text-center hover:border-primary/50 transition-colors cursor-pointer group">
                                <Image class="w-7 h-7 text-slate-300 group-hover:text-primary/50 mx-auto mb-1.5 transition-colors" />
                                <p class="text-sm font-bold text-slate-500">Klik untuk upload foto</p>
                                <p class="text-xs text-slate-400 mt-0.5">PNG, JPG, WEBP — maks. 5MB, rasio 16:9</p>
                                <input type="file" accept="image/*" class="sr-only" @change="onFileChange" />
                            </label>
                            <p v-if="form.errors.image" class="text-red-500 text-xs mt-1 flex items-center gap-1"><AlertCircle class="w-3 h-3" />{{ form.errors.image }}</p>
                            <div class="mt-3">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Atau URL gambar eksternal</label>
                                <input type="url" v-model="form.image_url" placeholder="https://..." @blur="onImageUrlBlur" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                                <p v-if="form.errors.image_url" class="text-red-500 text-xs mt-1 flex items-center gap-1"><AlertCircle class="w-3 h-3" />{{ form.errors.image_url }}</p>
                            </div>
                        </div>
                        <!-- Badge + Order -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Badge / Label</label>
                                <input type="text" v-model="form.badge" placeholder="contoh: PRODUKTIVITAS" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" />
                                <p v-if="form.errors.badge" class="text-red-500 text-xs mt-1">{{ form.errors.badge }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Urutan Slide</label>
                                <input type="number" v-model="form.order" min="1" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                                <p v-if="form.errors.order" class="text-red-500 text-xs mt-1">{{ form.errors.order }}</p>
                            </div>
                        </div>
                        <!-- Heading -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Judul <span class="text-red-400">*</span></label>
                            <input type="text" v-model="form.heading" placeholder="Judul besar yang tampil di slider" class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm" :class="form.errors.heading ? 'border-red-400 bg-red-50' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800'" />
                            <p v-if="form.errors.heading" class="text-red-500 text-xs mt-1 flex items-center gap-1"><AlertCircle class="w-3 h-3" />{{ form.errors.heading }}</p>
                        </div>
                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Deskripsi</label>
                            <textarea rows="3" v-model="form.description" placeholder="Teks penjelasan singkat di bawah judul..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                        </div>
                        <!-- CTA -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Teks Tombol Utama</label>
                                <input type="text" v-model="form.cta1_text" placeholder="Cek Lisensi" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Teks Tombol Kedua</label>
                                <input type="text" v-model="form.cta2_text" placeholder="Informasi Lebih Lanjut" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" />
                            </div>
                        </div>
                        <!-- Active -->
                        <label class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl cursor-pointer">
                            <input type="checkbox" v-model="form.is_active" class="w-4 h-4 rounded text-primary border-slate-300" />
                            <div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Aktifkan slide ini</p>
                                <p class="text-xs text-slate-400">Slide nonaktif tidak akan tampil di website</p>
                            </div>
                        </label>
                    </div>
                    <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end sticky bottom-0 bg-white dark:bg-slate-900">
                        <button type="button" @click="closeModal" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors disabled:opacity-60 flex items-center gap-2">
                            <span v-if="form.processing" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            {{ editingSlide ? 'Simpan Perubahan' : 'Tambah Slide' }}
                        </button>
                    </div>
                    </form>
                </div>
            </div>

            <!-- Preview Modal -->
            <div v-if="previewSlide" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" @click.self="previewSlide = null">
                <div class="relative w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl">
                    <button @click="previewSlide = null" class="absolute top-4 right-4 z-10 p-2 bg-black/50 text-white rounded-xl hover:bg-black/70 transition-colors">✕</button>
                    <div class="relative h-80 sm:h-[420px] bg-slate-900">
                        <img v-if="resolvedImage(previewSlide)" :src="resolvedImage(previewSlide)" class="w-full h-full object-cover opacity-60" />
                        <div class="absolute inset-0 flex flex-col justify-center px-10">
                            <span v-if="previewSlide.badge" class="inline-block text-xs font-black uppercase tracking-widest bg-secondary text-primary px-3 py-1 rounded mb-4 w-fit">{{ previewSlide.badge }}</span>
                            <h2 class="text-white font-black text-3xl sm:text-4xl leading-snug mb-3">{{ previewSlide.heading }}</h2>
                            <p class="text-white/80 text-sm max-w-lg mb-6">{{ previewSlide.description }}</p>
                            <div class="flex gap-3">
                                <span v-if="previewSlide.cta1_text" class="px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl">{{ previewSlide.cta1_text }}</span>
                                <span v-if="previewSlide.cta2_text" class="px-5 py-2.5 border border-white/40 text-white text-sm font-bold rounded-xl">{{ previewSlide.cta2_text }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800 px-6 py-3 flex items-center justify-between">
                        <span class="text-white/60 text-xs font-bold uppercase tracking-widest">Preview Slide #{{ previewSlide.order }}</span>
                        <span class="text-xs font-bold px-2.5 py-1 rounded" :class="previewSlide.is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-600 text-slate-400'">{{ previewSlide.is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </div>
                </div>
            </div>

            <!-- Delete confirm -->
            <div v-if="deleteSlideTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                    <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Slide?</h3>
                    <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteSlideTarget.heading }}</span>" akan dihapus permanen.</p>
                    <div class="flex gap-3">
                        <button @click="deleteSlideTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                        <button @click="confirmDelete" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ STATS ═══ -->
        <div v-if="activeTab === 'stats'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div v-for="stat in stats" :key="stat.id" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black uppercase tracking-widest text-slate-400">Statistik</span>
                    <button class="p-1 text-slate-400 hover:text-amber-500"><Pencil class="w-3.5 h-3.5" /></button>
                </div>
                <input type="text" :value="stat.value" class="w-full text-3xl font-black text-primary bg-transparent border-b border-slate-200 focus:outline-none focus:border-primary mb-2 pb-1" />
                <input type="text" :value="stat.label" class="w-full text-sm text-slate-500 bg-transparent border-b border-slate-200 focus:outline-none focus:border-primary pb-1" />
            </div>
        </div>

        <!-- ═══ SERVICES ═══ -->
        <div v-if="activeTab === 'services'">
            <div class="flex justify-end mb-4">
                <button @click="addServiceModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors"><Plus class="w-4 h-4" /> Tambah Layanan</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="svc in services" :key="svc.id" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-5">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-3xl">{{ svc.icon }}</span>
                        <div class="flex gap-1">
                            <button class="p-1.5 text-slate-400 hover:text-amber-500 rounded-lg transition-colors"><Pencil class="w-3.5 h-3.5" /></button>
                            <button @click="deleteSvcTarget = svc" class="p-1.5 text-slate-400 hover:text-red-500 rounded-lg transition-colors"><Trash2 class="w-3.5 h-3.5" /></button>
                        </div>
                    </div>
                    <p class="font-black text-slate-800 dark:text-white text-sm mb-1.5">{{ svc.title }}</p>
                    <p class="text-slate-500 text-xs leading-relaxed">{{ svc.desc }}</p>
                </div>
            </div>
        </div>

        <!-- ═══ PROJECTS ═══ -->
        <div v-if="activeTab === 'projects'">
            <div class="flex justify-end mb-4">
                <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors"><Plus class="w-4 h-4" /> Tambah Proyek</button>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                        <tr>
                            <th class="text-left px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Proyek</th>
                            <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hidden md:table-cell">Tahun</th>
                            <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                            <th class="px-4 py-3.5 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        <tr v-for="proj in projects" :key="proj.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 dark:text-white text-sm">{{ proj.name }}</p>
                                <p class="text-slate-400 text-xs mt-0.5">{{ proj.desc }}</p>
                            </td>
                            <td class="px-4 py-4 text-slate-500 text-sm hidden md:table-cell">{{ proj.year }}</td>
                            <td class="px-4 py-4">
                                <span class="text-xs font-bold px-2.5 py-1 rounded-xl"
                                    :class="proj.status === 'Selesai' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600'">
                                    {{ proj.status }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                                    <button class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ═══ TESTIMONIALS ═══ -->
        <div v-if="activeTab === 'testimonials'">
            <div class="flex justify-end mb-4">
                <button @click="addTestimonialModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors"><Plus class="w-4 h-4" /> Tambah Testimoni</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div v-for="t in testimonials" :key="t.id" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex gap-0.5">
                            <Star v-for="i in 5" :key="i" class="w-3.5 h-3.5" :class="i <= t.stars ? 'text-amber-400 fill-current' : 'text-slate-200'" />
                        </div>
                        <div class="flex gap-1">
                            <button class="p-1 text-slate-400 hover:text-amber-500"><Pencil class="w-3.5 h-3.5" /></button>
                            <button @click="deleteTestimonialTarget = t" class="p-1 text-slate-400 hover:text-red-500"><Trash2 class="w-3.5 h-3.5" /></button>
                        </div>
                    </div>
                    <p class="text-slate-600 dark:text-slate-300 text-sm italic leading-relaxed mb-4">"{{ t.text }}"</p>
                    <div>
                        <p class="font-black text-slate-800 dark:text-white text-sm">{{ t.name }}</p>
                        <p class="text-slate-400 text-xs">{{ t.role }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ═══ FAQ ═══ -->
        <div v-if="activeTab === 'faq'">
            <div class="flex justify-end mb-4">
                <button @click="addFaqModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors"><Plus class="w-4 h-4" /> Tambah FAQ</button>
            </div>
            <div class="space-y-3">
                <div v-for="faq in faqs" :key="faq.id" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden">
                    <div class="flex items-center gap-3 p-5 cursor-pointer" @click="toggleFaq(faq)">
                        <div class="flex-1">
                            <p class="font-bold text-slate-800 dark:text-white text-sm">{{ faq.q }}</p>
                        </div>
                        <div class="flex gap-1 shrink-0">
                            <button class="p-1.5 text-slate-400 hover:text-amber-500 rounded-lg transition-colors" @click.stop><Pencil class="w-3.5 h-3.5" /></button>
                            <button @click.stop="deleteFaqTarget = faq" class="p-1.5 text-slate-400 hover:text-red-500 rounded-lg transition-colors"><Trash2 class="w-3.5 h-3.5" /></button>
                            <button class="p-1.5 text-slate-400 rounded-lg">
                                <ChevronDown v-if="!faq.open" class="w-4 h-4" />
                                <ChevronUp v-else class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                    <div v-if="faq.open" class="px-5 pb-5">
                        <p class="text-slate-500 text-sm leading-relaxed border-t border-slate-100 dark:border-slate-700 pt-4">{{ faq.a }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Service Modal -->
        <div v-if="addServiceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tambah Layanan</h2>
                    <button @click="addServiceModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Ikon (Emoji)</label><input type="text" placeholder="🌐" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Nama Layanan</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Deskripsi</label><textarea rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea></div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 justify-end">
                    <button @click="addServiceModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="addServiceModal = false" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Add Testimonial Modal -->
        <div v-if="addTestimonialModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tambah Testimoni</h2>
                    <button @click="addTestimonialModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Nama</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Peran / Jabatan</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Bintang (1-5)</label><input type="number" min="1" max="5" value="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Testimoni</label><textarea rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea></div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 justify-end">
                    <button @click="addTestimonialModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="addTestimonialModal = false" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Add FAQ Modal -->
        <div v-if="addFaqModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Tambah FAQ</h2>
                    <button @click="addFaqModal = false" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Pertanyaan</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Jawaban</label><textarea rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 resize-none"></textarea></div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 justify-end">
                    <button @click="addFaqModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="addFaqModal = false" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Generic Delete confirm -->
        <div v-if="deleteSvcTarget || deleteTestimonialTarget || deleteFaqTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Item?</h3>
                <p class="text-slate-500 text-sm mb-6">Item ini akan dihapus secara permanen.</p>
                <div class="flex gap-3">
                    <button @click="deleteSvcTarget = null; deleteTestimonialTarget = null; deleteFaqTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteSvcTarget = null; deleteTestimonialTarget = null; deleteFaqTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
