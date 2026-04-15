<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import UPAGuestLayout from '@/Layouts/UPAGuestLayout.vue';
import { ArrowLeft, Calendar, Tag, Clock, Share2, Twitter, Facebook, Linkedin, ChevronRight, BookOpen, TrendingUp, Shield, Cpu, Wifi } from 'lucide-vue-next';
import { allNews } from '@/data/news.js';

const props = defineProps({
    slug: String,
});

const categoryIcon = {
    Security: Shield,
    Innovation: TrendingUp,
    Event: BookOpen,
    Infrastructure: Cpu,
};

const categoryColor = {
    Security: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    Innovation: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
    Event: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
    Infrastructure: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
};

const article = computed(() => allNews.find(n => n.slug === props.slug) ?? allNews[0]);

const relatedArticles = computed(() =>
    allNews.filter(n => n.slug !== article.value.slug && n.category === article.value.category).slice(0, 3),
);

const moreArticles = computed(() => {
    if (relatedArticles.value.length >= 3) return [];
    const existing = new Set([article.value.slug, ...relatedArticles.value.map(r => r.slug)]);
    return allNews.filter(n => !existing.has(n.slug)).slice(0, 3 - relatedArticles.value.length);
});

const combinedRelated = computed(() => [...relatedArticles.value, ...moreArticles.value]);

const getImage = (imageId) => `https://images.unsplash.com/photo-${imageId}?auto=format&fit=crop&q=80&w=1200`;
const getImageSm = (imageId) => `https://images.unsplash.com/photo-${imageId}?auto=format&fit=crop&q=80&w=600`;
</script>
<template>
    <UPAGuestLayout :title="article.title">
        <!-- Hero Section -->
        <div class="relative pt-28 pb-0 overflow-hidden">
            <!-- Background Blobs -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px]"></div>
                <div class="absolute -bottom-20 -left-40 w-[500px] h-[500px] bg-secondary/5 rounded-full blur-[100px]"></div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-xs font-bold uppercase tracking-widest text-slate-400 mb-10">
                    <Link :href="route('home')" class="hover:text-primary transition-colors">Beranda</Link>
                    <ChevronRight class="w-3 h-3" />
                    <Link :href="route('home') + '#news'" class="hover:text-primary transition-colors">Berita</Link>
                    <ChevronRight class="w-3 h-3" />
                    <span class="text-slate-600 dark:text-slate-300 truncate max-w-[200px]">{{ article.category }}</span>
                </nav>

                <!-- Category Badge -->
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm"
                        :class="categoryColor[article.category] ?? 'bg-slate-100 text-slate-600'"
                    >
                        <component :is="categoryIcon[article.category] ?? Tag" class="w-3 h-3" />
                        {{ article.category }}
                    </span>
                    <span v-if="article.featured" class="px-4 py-1.5 bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 rounded-full text-xs font-black uppercase tracking-widest">
                        ⭐ Unggulan
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6 tracking-tight">
                    {{ article.title }}
                </h1>

                <!-- Lead -->
                <p class="text-lg text-slate-500 dark:text-slate-400 leading-relaxed mb-10 max-w-3xl">
                    {{ article.description }}
                </p>

                <!-- Meta Row -->
                <div class="flex flex-wrap items-center gap-6 pb-10 border-b border-slate-100 dark:border-slate-800">
                    <!-- Author -->
                    <div class="flex items-center gap-3">
                        <img :src="article.authorAvatar" class="w-10 h-10 rounded-full object-cover ring-2 ring-primary/20" :alt="article.author" />
                        <div>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ article.author }}</p>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Penulis</p>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-slate-200 dark:bg-slate-700"></div>
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <Calendar class="w-4 h-4 text-primary" />
                        <span class="font-semibold">{{ article.date }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-sm text-slate-500">
                        <Clock class="w-4 h-4 text-primary" />
                        <span class="font-semibold">{{ article.readTime }}</span>
                    </div>
                    <!-- Share -->
                    <div class="ml-auto flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-widest mr-1 hidden sm:block">Bagikan</span>
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-primary hover:text-white text-slate-500 flex items-center justify-center transition-all duration-200">
                            <Twitter class="w-4 h-4" />
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-blue-600 hover:text-white text-slate-500 flex items-center justify-center transition-all duration-200">
                            <Facebook class="w-4 h-4" />
                        </a>
                        <a href="#" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-sky-700 hover:text-white text-slate-500 flex items-center justify-center transition-all duration-200">
                            <Linkedin class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
            <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl aspect-video">
                <img
                    :src="getImage(article.imageId)"
                    :alt="article.title"
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 to-transparent"></div>
            </div>
        </div>

        <!-- Article Body + Sidebar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-16">
                <!-- Body -->
                <div class="article-body" v-html="article.content"></div>

                <!-- Sidebar -->
                <aside class="space-y-8 lg:sticky lg:top-28 self-start">
                    <!-- Tags -->
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[1.5rem] p-6 border border-slate-100 dark:border-slate-700/50">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Topik Terkait</h3>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="tag in article.tags"
                                :key="tag"
                                class="px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 rounded-lg text-xs font-bold hover:border-primary hover:text-primary transition-colors cursor-default"
                            >
                                #{{ tag }}
                            </span>
                        </div>
                    </div>

                    <!-- Back to News -->
                    <div class="bg-gradient-to-br from-primary/10 to-secondary/10 rounded-[1.5rem] p-6 border border-primary/10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-primary mb-3">Navigasi</h3>
                        <Link
                            :href="route('home') + '#news'"
                            class="inline-flex items-center gap-2 font-bold text-slate-700 dark:text-slate-200 hover:text-primary transition-colors"
                        >
                            <ArrowLeft class="w-4 h-4" />
                            Kembali ke Daftar Berita
                        </Link>
                    </div>

                    <!-- Share Card -->
                    <div class="bg-white dark:bg-slate-800/50 rounded-[1.5rem] p-6 border border-slate-100 dark:border-slate-700/50">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4 flex items-center gap-2">
                            <Share2 class="w-3.5 h-3.5" />
                            Bagikan Artikel
                        </h3>
                        <div class="grid grid-cols-3 gap-2">
                            <a href="#" class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-sky-50 dark:hover:bg-sky-900/20 hover:text-sky-500 text-slate-400 transition-all group">
                                <Twitter class="w-5 h-5 group-hover:scale-110 transition-transform" />
                                <span class="text-[9px] font-black uppercase tracking-widest">Twitter</span>
                            </a>
                            <a href="#" class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 text-slate-400 transition-all group">
                                <Facebook class="w-5 h-5 group-hover:scale-110 transition-transform" />
                                <span class="text-[9px] font-black uppercase tracking-widest">Facebook</span>
                            </a>
                            <a href="#" class="flex flex-col items-center gap-1.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-sky-700 text-slate-400 transition-all group">
                                <Linkedin class="w-5 h-5 group-hover:scale-110 transition-transform" />
                                <span class="text-[9px] font-black uppercase tracking-widest">LinkedIn</span>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Related Articles -->
        <section v-if="combinedRelated.length" class="py-20 bg-slate-50 dark:bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-12">
                    <div>
                        <span class="text-primary font-bold text-xs uppercase tracking-widest block mb-2">Lanjut Membaca</span>
                        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Artikel Terkait</h2>
                    </div>
                    <Link
                        :href="route('home') + '#news'"
                        class="group hidden md:flex items-center gap-2 text-sm font-bold text-primary hover:gap-3 transition-all"
                    >
                        Semua Berita
                        <ChevronRight class="w-4 h-4" />
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Link
                        v-for="news in combinedRelated"
                        :key="news.slug"
                        :href="route('news.show', { slug: news.slug })"
                        class="group bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden border border-slate-100 dark:border-slate-700/50 hover:shadow-2xl hover:border-primary/20 hover:-translate-y-1 transition-all duration-500 block"
                        prefetch
                    >
                        <div class="relative overflow-hidden aspect-video">
                            <img :src="getImageSm(news.imageId)" :alt="news.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide shadow-sm"
                                    :class="categoryColor[news.category] ?? 'bg-white text-slate-600'"
                                >{{ news.category }}</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2 leading-snug mb-3 text-base">
                                {{ news.title }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed mb-5">
                                {{ news.description }}
                            </p>
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest pt-4 border-t border-slate-50 dark:border-slate-700/50">
                                <span class="flex items-center gap-1.5">
                                    <Calendar class="w-3 h-3" />
                                    {{ news.date }}
                                </span>
                                <span class="text-primary flex items-center gap-0.5 group-hover:gap-1.5 transition-all">
                                    Baca
                                    <ChevronRight class="w-3 h-3" />
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </UPAGuestLayout>
</template>

<style scoped>
/* ── Article Body (sans @tailwindcss/typography) ── */
:deep(.article-body) {
    color: #334155; /* slate-700 */
    font-size: 1.1rem;
    line-height: 1.85;
    max-width: none;
}

:deep(.article-body p) {
    margin-bottom: 1.4rem;
}

:deep(.article-body h2) {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a; /* slate-900 */
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    letter-spacing: -0.025em;
    line-height: 1.3;
}

:deep(.article-body h3) {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
}

:deep(.article-body ul),
:deep(.article-body ol) {
    margin-left: 1.5rem;
    margin-bottom: 1.5rem;
}

:deep(.article-body ul) {
    list-style-type: disc;
}

:deep(.article-body ol) {
    list-style-type: decimal;
}

:deep(.article-body li) {
    margin-bottom: 0.5rem;
    padding-left: 0.25rem;
}

:deep(.article-body li strong) {
    color: #003366;
}

:deep(.article-body blockquote) {
    border-left: 4px solid #003366;
    background: rgba(0, 51, 102, 0.05);
    border-radius: 0 1rem 1rem 0;
    padding: 1.25rem 1.5rem;
    margin: 2rem 0;
    color: #475569; /* slate-600 */
    font-style: italic;
    font-size: 1.05rem;
    line-height: 1.7;
}

:deep(.article-body strong) {
    font-weight: 700;
    color: #1e293b;
}

:deep(.article-body em) {
    font-style: italic;
    color: #475569;
}

:deep(.article-body code) {
    background: #f1f5f9;
    color: #003366;
    border-radius: 0.3rem;
    padding: 0.15rem 0.45rem;
    font-family: 'Courier New', monospace;
    font-size: 0.9em;
}

:deep(.article-body a) {
    color: #003366;
    text-decoration: underline;
    text-underline-offset: 3px;
}

:deep(.article-body a:hover) {
    color: #004080;
}

/* Dark mode overrides */
.dark :deep(.article-body) {
    color: #cbd5e1; /* slate-300 */
}
.dark :deep(.article-body h2),
.dark :deep(.article-body h3) {
    color: #f1f5f9;
}
.dark :deep(.article-body strong) {
    color: #e2e8f0;
}
.dark :deep(.article-body blockquote) {
    background: rgba(0, 51, 102, 0.15);
    color: #94a3b8;
}
.dark :deep(.article-body code) {
    background: #1e293b;
    color: #FFCC00;
}
.dark :deep(.article-body li strong) {
    color: #93c5fd;
}
</style>

