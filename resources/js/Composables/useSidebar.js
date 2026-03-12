import { ref, computed, onMounted, provide, inject } from 'vue';

const SIDEBAR_STATE_KEY = 'sidebarState';

export function useSidebar() {
    // Try to get existing state from parent (inject)
    const existingState = inject(SIDEBAR_STATE_KEY, null);

    if (existingState) {
        return existingState;
    }

    // Load collapsed state from localStorage
    const savedCollapsed = localStorage.getItem('sidebarCollapsed');
    const isCollapsed = ref(savedCollapsed === 'true');

    // Mobile menu state (not persisted)
    const isMobileOpen = ref(false);

    // Computed width based on collapsed state
    const width = computed(() => {
        return isCollapsed.value ? 'w-20' : 'w-64';
    });

    // Computed for content margin
    const contentMargin = computed(() => {
        return isCollapsed.value ? 'lg:ml-20' : 'lg:ml-64';
    });

    // Toggle collapsed state
    const toggle = () => {
        isCollapsed.value = !isCollapsed.value;
        localStorage.setItem('sidebarCollapsed', isCollapsed.value.toString());
    };

    // Open mobile menu
    const openMobile = () => {
        isMobileOpen.value = true;
    };

    // Close mobile menu
    const closeMobile = () => {
        isMobileOpen.value = false;
    };

    // Toggle mobile menu
    const toggleMobile = () => {
        isMobileOpen.value = !isMobileOpen.value;
    };

    // Initialize from localStorage on mount
    onMounted(() => {
        const saved = localStorage.getItem('sidebarCollapsed');
        if (saved !== null) {
            isCollapsed.value = saved === 'true';
        }
    });

    const state = {
        isCollapsed,
        isMobileOpen,
        width,
        contentMargin,
        toggle,
        openMobile,
        closeMobile,
        toggleMobile,
    };

    // Provide state for child components
    provide(SIDEBAR_STATE_KEY, state);

    return state;
}
