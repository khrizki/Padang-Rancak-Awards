<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useSidebar } from '@/Composables/useSidebar';

const page = usePage();
const { isCollapsed, closeMobile } = useSidebar();

const user = computed(() => page.props.auth?.user);
const userRole = computed(() => user.value?.roles?.[0]?.name || 'Warga');
const userName = computed(() => user.value?.name || 'User');
const userInitial = computed(() => userName.value.charAt(0).toUpperCase());
</script>

<template>
    <div class="border-t border-gray-200 bg-gray-50 p-4">
        <!-- User Info -->
        <div class="flex items-center gap-3">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-sm font-semibold text-white">
                    {{ userInitial }}
                </div>
            </div>

            <!-- User Details -->
            <transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-show="!isCollapsed" class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-gray-900">
                        {{ userName }}
                    </p>
                    <p class="truncate text-xs text-gray-500">
                        {{ userRole }}
                    </p>
                </div>
            </transition>

            <!-- Logout Button (when collapsed) -->
            <Link
                v-if="isCollapsed"
                :href="route('logout')"
                method="post"
                as="button"
                class="flex-shrink-0 rounded-lg p-2 text-gray-400 transition hover:bg-red-50 hover:text-red-600"
                title="Logout"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </Link>
        </div>

        <!-- Action Buttons (when expanded) -->
        <transition
            enter-active-class="transition-opacity duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-show="!isCollapsed" class="mt-3 flex gap-2">
                <Link
                    :href="route('profile.edit')"
                    class="flex-1 rounded-lg px-3 py-2 text-center text-xs font-medium text-gray-600 transition hover:bg-gray-200 hover:text-gray-900"
                    @click="closeMobile"
                >
                    Profile
                </Link>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="flex-1 rounded-lg px-3 py-2 text-center text-xs font-medium text-red-600 transition hover:bg-red-50 hover:text-red-700"
                >
                    Logout
                </Link>
            </div>
        </transition>
    </div>
</template>
