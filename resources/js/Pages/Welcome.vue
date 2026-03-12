<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const year = new Date().getFullYear()

</script>

<template>
    <Head title="Padang Rancak Award"/>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-2 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Padang Rancak Award</span>
                    </div>

                    <div v-if="canLogin" class="flex items-center gap-4">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="px-4 py-2 text-sm font-medium text-green-700 hover:text-green-800 transition"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-green-700 transition"
                            >
                                Masuk
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transition shadow-md hover:shadow-lg"
                            >
                                Daftar
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Kompetisi Lingkungan Tingkat Kota
                        </div>

                        <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Wujudkan Kota Padang
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">
                                Hijau & Bersih
                            </span>
                        </h1>

                        <p class="text-lg text-gray-600 leading-relaxed max-w-xl">
                            Kompetisi tahunan untuk RT terbaik dalam pengelolaan lingkungan. Mari bersama-sama ciptakan lingkungan yang asri, bersih, dan sehat untuk masa depan Kota Padang.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <Link
                                v-if="!$page.props.auth.user"
                                :href="route('register')"
                                class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                            >
                                Daftarkan RT Anda
                            </Link>
                            <a
                                href="#tentang"
                                class="px-8 py-4 bg-white text-gray-800 font-semibold rounded-xl border-2 border-gray-200 hover:border-green-500 transition shadow-md hover:shadow-lg"
                            >
                                Pelajari Lebih Lanjut
                            </a>
                        </div>

                        <div class="flex items-center gap-8 pt-4">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">100+</div>
                                <div class="text-sm text-gray-600">RT Peserta</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">11</div>
                                <div class="text-sm text-gray-600">Kecamatan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">5</div>
                                <div class="text-sm text-gray-600">Tahun Penyelenggaraan</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-500 rounded-3xl transform rotate-3 opacity-20"></div>
                        <div class="relative bg-white rounded-3xl shadow-2xl p-8 border border-green-100">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl">
                                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Kebersihan</h3>
                                    <p class="text-sm text-gray-600">Penilaian kebersihan lingkungan</p>
                                </div>

                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-2xl">
                                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Pendidikan</h3>
                                    <p class="text-sm text-gray-600">Sosialisasi & edukasi warga</p>
                                </div>

                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-2xl">
                                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Inovasi</h3>
                                    <p class="text-sm text-gray-600">Kreativitas pengelolaan</p>
                                </div>

                                <div class="bg-gradient-to-br from-orange-50 to-yellow-50 p-6 rounded-2xl">
                                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Partisipasi</h3>
                                    <p class="text-sm text-gray-600">Keterlibatan masyarakat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tentang Section -->
        <section id="tentang" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Tentang Kompetisi
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Padang Rancak Award adalah kompetisi tahunan yang digelar oleh Pemerintah Kota Padang untuk mendorong RT berpartisipasi dalam pengelolaan lingkungan.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100">
                        <div class="w-16 h-16 bg-green-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Transparan</h3>
                        <p class="text-gray-600">Penilaian dilakukan secara transparan oleh juri yang kompeten dan independen.</p>
                    </div>

                    <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-100">
                        <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Objektif</h3>
                        <p class="text-gray-600">Kriteria penilaian yang jelas dan terukur untuk semua peserta.</p>
                    </div>

                    <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-100">
                        <div class="w-16 h-16 bg-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Berprestasi</h3>
                        <p class="text-gray-600">Penghargaan dan insentif untuk RT dengan penilaian terbaik.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center gap-3 mb-4 md:mb-0">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <span class="font-semibold">Padang Rancak Award</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        &copy; {{ year }} Pemerintah Kota Padang — Dinas Komunikasi dan Informatika Kota Padang. All Rights Reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
