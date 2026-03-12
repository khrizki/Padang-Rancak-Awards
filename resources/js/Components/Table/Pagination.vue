<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
    from: {
        type: Number,
        required: true,
    },
    to: {
        type: Number,
        required: true,
    },
    total: {
        type: Number,
        required: true,
    },
});

const goToPage = (url) => {
    if (url) {
        router.get(url, {}, { preserveState: true });
    }
};
</script>

<template>
    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row sm:gap-0">
        <!-- Info -->
        <div class="text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ from }}</span>
            to
            <span class="font-medium">{{ to }}</span>
            of
            <span class="font-medium">{{ total }}</span>
            results
        </div>

        <!-- Pagination -->
        <nav class="flex items-center gap-2">
            <!-- Previous Button -->
            <button
                v-if="links[0]?.url"
                @click="goToPage(links[0].url)"
                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Page Numbers -->
            <template v-for="(link, index) in links.slice(1, -1)" :key="index">
                <button
                    v-if="link.url"
                    @click="goToPage(link.url)"
                    class="rounded-lg border px-3 py-2 text-sm font-medium transition"
                    :class="link.active
                        ? 'border-green-500 bg-green-50 text-green-700'
                        : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'"
                    v-html="link.label"
                />
                <span
                    v-else
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500"
                    v-html="link.label"
                />
            </template>

            <!-- Next Button -->
            <button
                v-if="links[links.length - 1]?.url"
                @click="goToPage(links[links.length - 1].url)"
                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </nav>
    </div>
</template>
