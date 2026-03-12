<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import SidebarHeader from './SidebarHeader.vue';
import SidebarMenu from './SidebarMenu.vue';
import SidebarFooter from './SidebarFooter.vue';
import { useSidebar } from '@/Composables/useSidebar';
import { getMenuByRole } from '@/Config/sidebarConfig';

const page = usePage();
const { isCollapsed, isMobileOpen, closeMobile } = useSidebar();

// Get user's role
const userRole = computed(() => {
    return page.props.auth?.user?.roles?.[0]?.name || 'Warga';
});

// Get menu based on role
const menuItems = computed(() => {
    return getMenuByRole(userRole.value);
});
</script>

<template>
    <!-- Mobile Overlay -->
    <div
        v-if="isMobileOpen"
        class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
        @click="closeMobile"
    ></div>

    <!-- Sidebar Container -->
    <aside
        class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-gray-200 shadow-sm transition-all duration-300 ease-in-out lg:translate-x-0"
        :class="[
            isCollapsed ? 'w-20' : 'w-64',
            isMobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]"
    >
        <!-- Header -->
        <SidebarHeader />

        <!-- Menu -->
        <div class="flex-1 overflow-y-auto py-4">
            <SidebarMenu :menu-items="menuItems" :is-collapsed="isCollapsed" />
        </div>

        <!-- Footer -->
        <SidebarFooter />
    </aside>
</template>
