<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import {
    LayoutDashboard, Newspaper, Image, Download, BookOpen,
    Users, Handshake, Activity, UserCircle, LogOut,
    Home, ChevronDown, ChevronRight, Menu, X, Bell, Search,
    Globe, Settings, Shield,
} from 'lucide-vue-next';

defineProps({ title: String });

const page = usePage();
const user = computed(() => page.props.auth?.user);

const sidebarOpen = ref(true);
const mobileOpen = ref(false);

const openGroups = ref({ konten: true, layanan: false, institusi: false });
const toggleGroup = (g) => { openGroups.value[g] = !openGroups.value[g]; };

const logout = () => router.post(route('logout'));

const navigation = [
    {
        group: null,
        items: [
            { label: 'Dashboard', icon: LayoutDashboard, route: 'dashboard' },
        ],
    },
    {
        group: 'Konten Utama', key: 'konten',
        items: [
            { label: 'Homepage', icon: Home, route: 'admin.homepage' },
            { label: 'Berita & Inovasi', icon: Newspaper, route: 'admin.news' },
            { label: 'Galeri Kegiatan', icon: Image, route: 'admin.gallery' },
        ],
    },
    {
        group: 'Layanan', key: 'layanan',
        items: [
            { label: 'Pusat Unduhan', icon: Download, route: 'admin.downloads' },
            { label: 'Knowledge Base', icon: BookOpen, route: 'admin.knowledge-base' },
        ],
    },
    {
        group: 'Institusi', key: 'institusi',
        items: [
            { label: 'Organisasi', icon: Users, route: 'admin.organization' },
            { label: 'Mitra', icon: Handshake, route: 'admin.partners' },
            { label: 'Status Sistem', icon: Activity, route: 'admin.status' },
        ],
    },
];

const isActive = (routeName) => {
    try { return route().current(routeName); } catch { return false; }
};
</script>

<template>
    <div class="min-h-screen bg-slate-100 dark:bg-slate-950 flex">

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 flex flex-col bg-primary transition-all duration-300"
            :class="[sidebarOpen ? 'w-64' : 'w-16', mobileOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0']"
        >
            <!-- Logo -->
            <div class="flex items-center gap-3 px-4 h-16 border-b border-white/10 shrink-0">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center shrink-0 ring-1 ring-white/20">
                    <img src="/images/logo-upr.png" alt="UPR" class="w-6 h-6" />
                </div>
                <transition name="fade-slide">
                    <div v-if="sidebarOpen" class="overflow-hidden">
                        <div class="text-white font-extrabold text-sm leading-none whitespace-nowrap">UPA TIK</div>
                        <div class="text-secondary text-[9px] font-bold uppercase tracking-widest whitespace-nowrap">CMS Admin Panel</div>
                    </div>
                </transition>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4 space-y-1 px-2">
                <template v-for="section in navigation" :key="section.group ?? 'main'">
                    <!-- Group header -->
                    <div v-if="section.group && sidebarOpen" class="px-3 pt-4 pb-1">
                        <button
                            @click="toggleGroup(section.key)"
                            class="flex items-center justify-between w-full text-[10px] font-black uppercase tracking-[0.15em] text-white/40 hover:text-white/70 transition-colors"
                        >
                            <span>{{ section.group }}</span>
                            <ChevronDown class="w-3 h-3 transition-transform" :class="openGroups[section.key] ? 'rotate-180' : ''" />
                        </button>
                    </div>
                    <div v-else-if="section.group && !sidebarOpen" class="mx-2 my-2 border-t border-white/10"></div>

                    <!-- Items -->
                    <template v-if="!section.group || !section.key || openGroups[section.key] || !sidebarOpen">
                        <Link
                            v-for="item in section.items"
                            :key="item.route"
                            :href="route(item.route)"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group"
                            :class="isActive(item.route)
                                ? 'bg-white/15 text-white'
                                : 'text-white/60 hover:bg-white/10 hover:text-white'"
                        >
                            <component :is="item.icon" class="w-5 h-5 shrink-0" />
                            <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">{{ item.label }}</span>
                            <!-- Active indicator -->
                            <div v-if="isActive(item.route) && sidebarOpen" class="ml-auto w-1.5 h-1.5 bg-secondary rounded-full"></div>
                        </Link>
                    </template>
                </template>
            </nav>

            <!-- Bottom: User + actions -->
            <div class="p-2 border-t border-white/10 space-y-1 shrink-0">
                <Link
                    :href="route('profile.edit')"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/60 hover:bg-white/10 hover:text-white transition-all"
                >
                    <UserCircle class="w-5 h-5 shrink-0" />
                    <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">Profil Saya</span>
                </Link>
                <a
                    :href="route('home')"
                    target="_blank"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/60 hover:bg-white/10 hover:text-white transition-all"
                >
                    <Globe class="w-5 h-5 shrink-0" />
                    <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">Lihat Website</span>
                </a>
                <button
                    @click="logout"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/60 hover:bg-red-500/20 hover:text-red-400 transition-all"
                >
                    <LogOut class="w-5 h-5 shrink-0" />
                    <span v-if="sidebarOpen" class="text-sm font-semibold whitespace-nowrap">Keluar</span>
                </button>
            </div>
        </aside>

        <!-- Mobile overlay -->
        <div
            v-if="mobileOpen"
            @click="mobileOpen = false"
            class="fixed inset-0 z-30 bg-black/50 md:hidden"
        ></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col transition-all duration-300" :class="sidebarOpen ? 'md:ml-64' : 'md:ml-16'">

            <!-- Top bar -->
            <header class="sticky top-0 z-20 h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center gap-4 px-4 sm:px-6 shadow-sm">
                <!-- Sidebar toggle -->
                <button
                    @click="sidebarOpen = !sidebarOpen; mobileOpen = !mobileOpen"
                    class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                >
                    <Menu class="w-5 h-5" />
                </button>

                <!-- Breadcrumb / Title -->
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-slate-400 font-medium hidden sm:block">CMS</span>
                    <span class="text-slate-300 hidden sm:block">/</span>
                    <span class="text-slate-800 dark:text-white font-bold">{{ title ?? 'Dashboard' }}</span>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    <!-- Notification bell -->
                    <button class="relative p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <Bell class="w-5 h-5" />
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-secondary rounded-full"></span>
                    </button>

                    <!-- User avatar -->
                    <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200 dark:border-slate-700">
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-xs font-black">
                            {{ user?.name?.charAt(0) ?? 'A' }}
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-sm font-bold text-slate-800 dark:text-white leading-none">{{ user?.name }}</div>
                            <div class="text-[10px] text-slate-400 font-medium">Administrator</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
.fade-slide-enter-active, .fade-slide-leave-active { transition: opacity 0.15s, transform 0.15s; }
.fade-slide-enter-from, .fade-slide-leave-to { opacity: 0; transform: translateX(-8px); }
</style>
