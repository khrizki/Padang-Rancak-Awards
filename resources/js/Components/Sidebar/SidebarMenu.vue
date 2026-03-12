<script setup>
import SidebarMenuItem from './SidebarMenuItem.vue';

defineProps({
    menuItems: {
        type: Array,
        required: true,
    },
    isCollapsed: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <nav class="space-y-6 px-3">
        <div v-for="(section, index) in menuItems" :key="index" class="space-y-1">
            <!-- Section Title -->
            <transition
                enter-active-class="transition-opacity duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-opacity duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <h3
                    v-show="!isCollapsed"
                    class="mb-2 px-2 text-xs font-semibold uppercase tracking-wider text-gray-400"
                >
                    {{ section.section }}
                </h3>
            </transition>

            <!-- Menu Items -->
            <div class="space-y-1">
                <SidebarMenuItem
                    v-for="(item, itemIndex) in section.items"
                    :key="itemIndex"
                    :name="item.name"
                    :href="item.href"
                    :icon="item.icon"
                    :is-collapsed="isCollapsed"
                />
            </div>
        </div>
    </nav>
</template>
