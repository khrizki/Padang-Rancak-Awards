<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Search...',
    },
    debounce: {
        type: Number,
        default: 300,
    },
});

const emit = defineEmits(['update:modelValue']);

const localValue = ref(props.modelValue);
let timeout = null;

watch(localValue, (newValue) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        emit('update:modelValue', newValue);
    }, props.debounce);
});

watch(() => props.modelValue, (newValue) => {
    localValue.value = newValue;
});

const clearSearch = () => {
    localValue.value = '';
    emit('update:modelValue', '');
};
</script>

<template>
    <div class="relative">
        <!-- Search Icon -->
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Input -->
        <input
            v-model="localValue"
            type="text"
            class="block w-full rounded-lg border-gray-300 bg-white py-2.5 pl-10 pr-10 text-sm text-gray-900 shadow-sm transition focus:border-green-500 focus:ring-green-500"
            :placeholder="placeholder"
        />

        <!-- Clear Button -->
        <button
            v-if="localValue"
            @click="clearSearch"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 transition hover:text-gray-600"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</template>
