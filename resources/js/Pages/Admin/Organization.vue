<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Plus, Pencil, Trash2, Users, User, Award, Phone, Mail, MapPin } from 'lucide-vue-next';

const activeTab = ref('leadership');

const tabs = [
    { id: 'leadership', label: 'Pimpinan', icon: Award },
    { id: 'team',       label: 'Tim & Staf',  icon: Users },
    { id: 'vision',     label: 'Visi & Misi', icon: null },
];

const leadership = [
    { id: 1, name: 'Dr. Ir. Bambang Wahyudi, M.T.', position: 'Kepala UPA TIK', nip: '197805102003121003', phone: '(0536) 3226068', email: 'kepala.tik@upr.ac.id', bg: 'from-primary to-blue-800' },
    { id: 2, name: 'Ir. Siti Rahmawati, M.Kom.',    position: 'Sekretaris UPA TIK', nip: '198203152006042001', phone: '(0536) 3226069', email: 'sekretaris.tik@upr.ac.id', bg: 'from-emerald-600 to-teal-700' },
];

const teams = [
    { id: 1, name: 'Ahmad Fauzi, S.Kom.',      division: 'Divisi Infrastruktur',     role: 'Koordinator Infrastruktur Jaringan',    phone: '0812-3456-7890' },
    { id: 2, name: 'Dewi Kusuma, M.T.',         division: 'Divisi Sistem Informasi',  role: 'Koordinator Pengembangan Sistem',       phone: '0813-5678-9012' },
    { id: 3, name: 'Rizky Pratama, S.T.',       division: 'Divisi Infrastruktur',     role: 'Administrator Jaringan',               phone: '0814-7890-1234' },
    { id: 4, name: 'Maya Anggraini, S.Kom.',    division: 'Divisi Sistem Informasi',  role: 'Developer Aplikasi Web',               phone: '0815-9012-3456' },
    { id: 5, name: 'Hendro Santoso, A.Md.',     division: 'Divisi Helpdesk',          role: 'Koordinator Layanan Pengguna',          phone: '0816-1234-5678' },
    { id: 6, name: 'Fitri Handayani, S.E.',     division: 'Divisi Administrasi',      role: 'Staf Administrasi & Keuangan',         phone: '0817-3456-7890' },
];

const editLeaderModal = ref(null);
const editMemberModal = ref(null);
const addMemberModal = ref(false);
const deleteTarget = ref(null);
</script>

<template>
    <Head title="Organisasi" />
    <AdminLayout title="Organisasi">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-black text-slate-900 dark:text-white">Seksi Organisasi</h1>
                <p class="text-slate-500 text-sm mt-0.5">Kelola profil pimpinan, tim, serta visi misi UPA TIK</p>
            </div>
        </div>

        <!-- Tab nav -->
        <div class="flex gap-1 bg-slate-100 dark:bg-slate-800 rounded-2xl p-1 mb-6 w-fit">
            <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all"
                :class="activeTab === tab.id ? 'bg-white dark:bg-slate-900 text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700'">
                {{ tab.label }}
            </button>
        </div>

        <!-- ─── LEADERSHIP TAB ─── -->
        <div v-if="activeTab === 'leadership'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div v-for="leader in leadership" :key="leader.id"
                class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden hover:shadow-lg transition-all">
                <div :class="`bg-gradient-to-r ${leader.bg} p-6`">
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <User class="w-10 h-10 text-white" />
                    </div>
                    <div class="text-center text-white">
                        <p class="font-black text-base leading-snug">{{ leader.name }}</p>
                        <p class="text-white/70 text-xs font-bold mt-1">{{ leader.position }}</p>
                    </div>
                </div>
                <div class="p-5 space-y-2.5">
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <Award class="w-4 h-4 text-slate-400 shrink-0" />
                        <span class="font-mono text-xs">{{ leader.nip }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <Phone class="w-4 h-4 text-slate-400 shrink-0" />
                        <span>{{ leader.phone }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <Mail class="w-4 h-4 text-slate-400 shrink-0" />
                        <span>{{ leader.email }}</span>
                    </div>
                </div>
                <div class="flex gap-2 px-5 pb-5">
                    <button @click="editLeaderModal = leader" class="flex-1 py-2 text-xs font-bold text-primary border border-primary/30 rounded-xl hover:bg-primary/5 transition-colors flex items-center justify-center gap-1.5"><Pencil class="w-3.5 h-3.5" /> Edit Profil</button>
                </div>
            </div>
        </div>

        <!-- ─── TEAM TAB ─── -->
        <div v-if="activeTab === 'team'">
            <div class="flex justify-end mb-4">
                <button @click="addMemberModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition-colors">
                    <Plus class="w-4 h-4" /> Tambah Anggota
                </button>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-100 dark:border-slate-700">
                        <tr>
                            <th class="text-left px-6 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama & Jabatan</th>
                            <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hidden md:table-cell">Divisi</th>
                            <th class="text-left px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 hidden lg:table-cell">Telepon</th>
                            <th class="px-4 py-3.5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        <tr v-for="member in teams" :key="member.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                                        <User class="w-4 h-4 text-primary" />
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-white text-sm">{{ member.name }}</p>
                                        <p class="text-slate-400 text-xs">{{ member.role }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 hidden md:table-cell">
                                <span class="text-xs font-bold px-2.5 py-1 bg-primary/10 text-primary rounded-xl">{{ member.division }}</span>
                            </td>
                            <td class="px-4 py-4 text-sm text-slate-500 hidden lg:table-cell">{{ member.phone }}</td>
                            <td class="px-4 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button @click="editMemberModal = member" class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                                    <button @click="deleteTarget = member" class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"><Trash2 class="w-4 h-4" /></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ─── VISION TAB ─── -->
        <div v-if="activeTab === 'vision'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Visi -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-black text-slate-800 dark:text-white">Visi</h3>
                    <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                </div>
                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                    Menjadi pusat pelayanan teknologi informasi dan komunikasi yang profesional, inovatif, dan terpercaya dalam mendukung tridharma perguruan tinggi Universitas Palangka Raya menuju World Class University.
                </p>
            </div>
            <!-- Misi -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-black text-slate-800 dark:text-white">Misi</h3>
                    <button class="p-1.5 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><Pencil class="w-4 h-4" /></button>
                </div>
                <ul class="space-y-2.5">
                    <li v-for="(item, i) in ['Menyediakan infrastruktur TIK yang handal','Mengembangkan sistem informasi terintegrasi','Memberikan layanan helpdesk berkualitas','Meningkatkan kompetensi SDM di bidang TIK','Mendorong transformasi digital kampus']" :key="i" class="flex items-start gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                        <span class="w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center text-[10px] font-black shrink-0 mt-0.5">{{ i+1 }}</span>
                        {{ item }}
                    </li>
                </ul>
            </div>
            <!-- Sejarah -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-black text-slate-800 dark:text-white">Sejarah & Timeline</h3>
                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-primary border border-primary/30 rounded-xl hover:bg-primary/5 transition-colors"><Plus class="w-3 h-3" /> Tambah Milestone</button>
                </div>
                <div class="relative">
                    <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-slate-100 dark:bg-slate-700 ml-3"></div>
                    <div v-for="(event, i) in [
                        { year: '2005', title: 'Pendirian Pusat Komputer', desc: 'Dibentuknya unit pengelola teknologi informasi pertama di lingkungan Universitas Palangka Raya.' },
                        { year: '2011', title: 'Transformasi menjadi PUSTIPANDA', desc: 'Perluasan fungsi dan layanan, mencakup pengembangan sistem informasi akademik.' },
                        { year: '2016', title: 'Rebrand menjadi UPA TIK', desc: 'Perubahan nomenklatur berdasarkan SK Rektor No.024/UN24/KP/2016.' },
                        { year: '2023', title: 'Implementasi Cloud Infrastructure', desc: 'Migrasi infrastruktur ke hybrid cloud untuk mendukung layanan yang lebih scalable.' },
                    ]" :key="i" class="relative flex gap-5 pb-6">
                        <div class="w-6 h-6 bg-primary rounded-full border-2 border-white dark:border-slate-900 shadow-sm shrink-0 z-10 mt-0.5"></div>
                        <div class="flex-1 bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-black text-primary text-sm">{{ event.year }}</span>
                                <div class="flex gap-1">
                                    <button class="p-1 text-slate-400 hover:text-amber-500 rounded transition-colors"><Pencil class="w-3.5 h-3.5" /></button>
                                    <button class="p-1 text-slate-400 hover:text-red-500 rounded transition-colors"><Trash2 class="w-3.5 h-3.5" /></button>
                                </div>
                            </div>
                            <p class="font-bold text-slate-800 dark:text-white text-sm mb-1">{{ event.title }}</p>
                            <p class="text-slate-500 text-xs leading-relaxed">{{ event.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Leader Modal -->
        <div v-if="editLeaderModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Edit Profil Pimpinan</h2>
                    <button @click="editLeaderModal = null" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Nama Lengkap</label><input type="text" :value="editLeaderModal.name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Jabatan</label><input type="text" :value="editLeaderModal.position" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">NIP</label><input type="text" :value="editLeaderModal.nip" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Email</label><input type="email" :value="editLeaderModal.email" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Telepon</label><input type="text" :value="editLeaderModal.phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="editLeaderModal = null" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="editLeaderModal = null" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Add/Edit member modal -->
        <div v-if="addMemberModal || editMemberModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-md">
                <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">{{ editMemberModal ? 'Edit Anggota' : 'Tambah Anggota' }}</h2>
                    <button @click="addMemberModal = false; editMemberModal = null" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-colors">✕</button>
                </div>
                <div class="p-6 space-y-4">
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Nama</label><input type="text" :value="editMemberModal?.name" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Jabatan</label><input type="text" :value="editMemberModal?.role" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Divisi</label>
                        <select class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20">
                            <option v-for="d in ['Divisi Infrastruktur','Divisi Sistem Informasi','Divisi Helpdesk','Divisi Administrasi']" :key="d" :selected="editMemberModal?.division === d">{{ d }}</option>
                        </select>
                    </div>
                    <div><label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1.5">Telepon</label><input type="text" :value="editMemberModal?.phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-primary/20" /></div>
                </div>
                <div class="flex gap-3 p-6 border-t border-slate-100 dark:border-slate-800 justify-end">
                    <button @click="addMemberModal = false; editMemberModal = null" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="addMemberModal = false; editMemberModal = null" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-xl hover:bg-primary/90 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Delete confirm -->
        <div v-if="deleteTarget" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4"><Trash2 class="w-6 h-6 text-red-500" /></div>
                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-2">Hapus Anggota?</h3>
                <p class="text-slate-500 text-sm mb-6">"<span class="font-bold text-slate-700">{{ deleteTarget.name }}</span>" akan dihapus.</p>
                <div class="flex gap-3">
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">Batal</button>
                    <button @click="deleteTarget = null" class="flex-1 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-colors">Hapus</button>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
