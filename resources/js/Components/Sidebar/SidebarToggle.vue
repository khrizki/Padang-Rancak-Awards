<script setup>
import { useSidebar } from '@/Composables/useSidebar';

const { isMobileOpen, toggleMobile } = useSidebar();
</script>

<template>
    <button
        @click="toggleMobile"
        class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500"
        aria-label="Toggle menu"
    >
        <!-- Hamburger Icon (closed) -->
        <svg
            v-if="!isMobileOpen"
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
            />
        </svg>

        <!-- Close Icon (open) -->
        <svg
            v-else
            class="h-6 w-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
    </button>
</template>
