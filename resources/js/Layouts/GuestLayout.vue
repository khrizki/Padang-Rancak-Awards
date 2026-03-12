<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <Link href="/" class="flex items-center gap-3">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-2 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-800">Padang Rancak Award</span>
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="flex min-h-[calc(100vh-4rem)] flex-col items-center justify-center px-4 sm:px-6">
            <div class="w-full max-w-md">
                <div class="relative">
                    <!-- Decorative background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-500 rounded-3xl transform rotate-2 opacity-10"></div>

                    <!-- Card -->
                    <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-green-100 p-8">
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
