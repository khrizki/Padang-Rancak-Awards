<script setup>
import Sidebar from '@/Components/Sidebar/Sidebar.vue';
import SidebarToggle from '@/Components/Sidebar/SidebarToggle.vue';
import { useSidebar } from '@/Composables/useSidebar';

const { contentMargin } = useSidebar();
</script>

<template>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Main Content Area -->
        <div class="flex flex-1 flex-col transition-all duration-300" :class="contentMargin">
            <!-- Top Navigation -->
            <nav class="border-b border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <!-- Left: Toggle & Title -->
                        <div class="flex items-center gap-4">
                            <SidebarToggle />
                            <h1 class="text-lg font-semibold text-gray-800 hidden sm:block">
                                {{ $page.props.auth?.user?.roles?.[0]?.name || 'Dashboard' }} Panel
                            </h1>
                        </div>

                        <!-- Right: User Info (for desktop) -->
                        <div class="hidden sm:flex sm:items-center sm:gap-4">
                            <span class="text-sm text-gray-600">
                                {{ $page.props.auth?.user?.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                v-if="$slots.header"
                class="bg-white shadow-sm"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                <slot />
            </main>
        </div>
    </div>
</template>
