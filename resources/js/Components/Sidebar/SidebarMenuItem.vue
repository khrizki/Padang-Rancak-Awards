<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useSidebar } from '@/Composables/useSidebar';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
    isCollapsed: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const { closeMobile } = useSidebar();

// Check if href is an external link (starts with #, http, etc.)
const isExternalLink = computed(() => {
    return props.href.startsWith('#') ||
           props.href.startsWith('http://') ||
           props.href.startsWith('https://');
});

// Get the actual href (either route or external link)
const linkHref = computed(() => {
    if (isExternalLink.value) {
        return props.href;
    }
    return route(props.href);
});

// Check if this is the active route
const isActive = computed(() => {
    if (isExternalLink.value) {
        return false;
    }
    return page.props.ziggy?.url === `/${props.href}` ||
           page.url.startsWith(`/${props.href}`) ||
           route().current(props.href);
});
</script>

<template>
    <Link
        :href="linkHref"
        class="group relative flex items-center gap-3 rounded-r-full border-l-4 px-4 py-3 transition-all duration-200 hover:bg-gray-50"
        :class="[
            isActive
                ? 'border-green-500 bg-green-50 text-green-700'
                : 'border-transparent text-gray-600 hover:border-gray-300',
            isCollapsed ? 'justify-center px-2' : 'px-4'
        ]"
        @click="closeMobile"
    >
        <!-- Icon -->
        <div
            class="flex-shrink-0"
            :class="[
                isActive
                    ? 'text-green-600'
                    : 'text-gray-400 group-hover:text-gray-600'
            ]"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon"/>
            </svg>
        </div>

        <!-- Label -->
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
                class="whitespace-nowrap text-sm font-medium"
            >
                {{ name }}
            </span>
        </transition>

        <!-- Tooltip (when collapsed) -->
        <div
            v-if="isCollapsed"
            class="absolute left-full ml-2 hidden rounded-lg bg-gray-900 px-3 py-2 text-sm text-white whitespace-nowrap opacity-0 transition-opacity group-hover:opacity-100 lg:block group-hover:block"
        >
            {{ name }}
            <div class="absolute left-0 top-1/2 -translate-x-1 -translate-y-1/2 border-8 border-transparent border-r-gray-900"></div>
        </div>
    </Link>
</template>
