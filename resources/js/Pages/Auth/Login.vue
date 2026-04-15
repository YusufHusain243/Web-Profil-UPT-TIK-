<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, Eye, EyeOff, LogIn, ShieldCheck } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin Login — UPA TIK" />

    <div class="min-h-screen bg-primary flex">

        <!-- Left Panel — Branding -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-14 relative overflow-hidden">
            <!-- Blobs -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-secondary rounded-full translate-x-1/2 -translate-y-1/2 blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-white rounded-full -translate-x-1/2 translate-y-1/2 blur-[120px]"></div>
            </div>

            <!-- Top: Logo -->
            <div class="relative flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center ring-1 ring-white/20">
                    <img src="/images/logo-upr.png" alt="UPR" class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-white font-extrabold text-xl leading-none">UPA TIK</div>
                    <div class="text-secondary text-[10px] font-bold uppercase tracking-widest">Universitas Palangka Raya</div>
                </div>
            </div>

            <!-- Center: Text -->
            <div class="relative space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-full border border-white/20">
                    <ShieldCheck class="w-4 h-4 text-secondary" />
                    <span class="text-xs font-bold text-secondary uppercase tracking-widest">Panel Admin</span>
                </div>
                <h1 class="text-5xl font-black text-white leading-tight">
                    Sistem<br />Manajemen<br /><span class="text-secondary">Konten</span>
                </h1>
                <p class="text-slate-300 text-base leading-relaxed max-w-sm">
                    Akses khusus tim internal UPA TIK untuk mengelola konten website, data layanan, dan informasi publik universitas.
                </p>
            </div>

            <!-- Bottom: Info -->
            <div class="relative flex items-center gap-3 text-slate-400 text-xs">
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                Sistem aktif — hanya untuk personel berwenang
            </div>
        </div>

        <!-- Right Panel — Form -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white dark:bg-slate-900">
            <div class="w-full max-w-md">

                <!-- Mobile logo -->
                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center">
                        <img src="/images/logo-upr.png" alt="UPR" class="w-7 h-7" />
                    </div>
                    <div>
                        <div class="text-primary font-extrabold leading-none">UPA TIK</div>
                        <div class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Admin Panel</div>
                    </div>
                </div>

                <!-- Heading -->
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-2">Masuk ke CMS</h2>
                    <p class="text-slate-500 text-sm">Gunakan akun yang telah diberikan oleh administrator sistem.</p>
                </div>

                <!-- Status message -->
                <div v-if="status" class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm font-medium">
                    <ShieldCheck class="w-4 h-4 shrink-0" />
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-5">

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Alamat Email</label>
                        <div class="relative">
                            <Mail class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                autocomplete="username"
                                autofocus
                                required
                                placeholder="admin@upr.ac.id"
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 dark:bg-slate-800 border rounded-2xl text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                :class="form.errors.email ? 'border-red-300 bg-red-50' : 'border-slate-200 dark:border-slate-700'"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 text-xs text-red-500 font-medium">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Password</label>
                        <div class="relative">
                            <Lock class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                required
                                placeholder="••••••••••"
                                class="w-full pl-12 pr-12 py-4 bg-slate-50 dark:bg-slate-800 border rounded-2xl text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                :class="form.errors.password ? 'border-red-300 bg-red-50' : 'border-slate-200 dark:border-slate-700'"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-primary transition-colors"
                            >
                                <Eye v-if="!showPassword" class="w-4 h-4" />
                                <EyeOff v-else class="w-4 h-4" />
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-xs text-red-500 font-medium">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input
                                type="checkbox"
                                v-model="form.remember"
                                class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30 cursor-pointer"
                            />
                            <span class="text-sm text-slate-600 dark:text-slate-400 font-medium">Ingat saya</span>
                        </label>
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm font-semibold text-primary hover:underline"
                        >
                            Lupa password?
                        </Link>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full flex items-center justify-center gap-3 py-4 bg-primary text-white font-bold rounded-2xl hover:bg-primary/90 focus:outline-none focus:ring-4 focus:ring-primary/20 transition-all disabled:opacity-60 disabled:cursor-not-allowed mt-2"
                    >
                        <span v-if="form.processing" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        <LogIn v-else class="w-5 h-5" />
                        {{ form.processing ? 'Memuat...' : 'Masuk ke Panel Admin' }}
                    </button>

                </form>

                <p class="mt-10 text-center text-xs text-slate-400">
                    Halaman ini bersifat internal. Akses tidak sah dilarang keras.
                </p>
            </div>
        </div>
    </div>
</template>
