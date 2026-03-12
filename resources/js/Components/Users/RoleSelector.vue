<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    availableRoles: {
        type: Array,
        required: true,
    },
    error: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const selectedRoles = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

const toggleRole = (role) => {
    const index = selectedRoles.value.indexOf(role);
    if (index === -1) {
        selectedRoles.value.push(role);
    } else {
        selectedRoles.value.splice(index, 1);
    }
};

const isSelected = (role) => {
    return selectedRoles.value.includes(role);
};
</script>

<template>
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">
            Roles
        </label>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
            <label
                v-for="role in availableRoles"
                :key="role"
                class="relative flex cursor-pointer items-center rounded-lg border-2 p-4 transition hover:bg-gray-50"
                :class="isSelected(role)
                    ? 'border-green-500 bg-green-50'
                    : 'border-gray-200 bg-white'"
            >
                <input
                    type="checkbox"
                    :value="role"
                    v-model="selectedRoles"
                    class="sr-only"
                />

                <!-- Custom Checkbox -->
                <div class="flex h-5 w-5 items-center justify-center rounded border-2 transition"
                     :class="isSelected(role)
                         ? 'border-green-500 bg-green-500'
                         : 'border-gray-300'">
                    <svg
                        v-if="isSelected(role)"
                        class="h-3 w-3 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>

                <span class="ml-3 text-sm font-medium"
                      :class="isSelected(role) ? 'text-green-700' : 'text-gray-700'">
                    {{ role }}
                </span>
            </label>
        </div>

        <!-- Error Message -->
        <p v-if="error" class="mt-2 text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>
