<script setup>
import { Link } from '@inertiajs/vue3';
import { useSidebar } from '@/Composables/useSidebar';

const { isCollapsed, toggle, closeMobile } = useSidebar();
</script>

<template>
    <div class="flex h-16 items-center justify-between border-b border-gray-200 bg-white px-4">
        <!-- Logo -->
        <Link
            :href="route('dashboard')"
            class="flex items-center gap-3 overflow-hidden"
            @click="closeMobile"
        >
            <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-emerald-600 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <span
                    v-show="!isCollapsed"
                    class="whitespace-nowrap text-lg font-bold text-gray-800"
                >
                    Padang Rancak
                </span>
            </transition>
        </Link>

        <!-- Toggle Button -->
        <button
            @click="toggle"
            class="hidden lg:flex flex-shrink-0 items-center justify-center rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500"
            :class="{ 'lg:rotate-180': isCollapsed }"
            aria-label="Toggle sidebar"
        >
            <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>
    </div>
</template>
