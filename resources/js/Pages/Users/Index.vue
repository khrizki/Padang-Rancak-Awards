<script setup>
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SearchInput from '@/Components/Table/SearchInput.vue';
import Pagination from '@/Components/Table/Pagination.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    users: Object,
    filters: Object,
    availableRoles: Object,
});

const search = ref(props.filters.search || '');
const roleFilter = ref(props.filters.role || '');
const perPage = ref(props.filters.per_page || 10);

const perPageOptions = [10, 25, 50, 100];

// Watch for changes and update URL
watch([search, roleFilter, perPage], ([newSearch, newRole, newPerPage]) => {
    router.get(route('users.index'), {
        search: newSearch,
        role: newRole,
        per_page: newPerPage,
    }, {
        preserveState: true,
        replace: true,
    });
}, { debounce: 300 });

const deleteUser = (user) => {
    if (confirm(`Apakah Anda yakin ingin menghapus user "${user.name}"?`)) {
        router.delete(route('users.destroy', user.id));
    }
};

const getUserInitial = (name) => {
    return name.charAt(0).toUpperCase();
};

const getUserPrimaryRole = (user) => {
    return user.roles?.[0]?.name || 'No Role';
};
</script>

<template>
    <Head title="Manajemen User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Manajemen User</h2>
                <Link
                    :href="route('users.create')"
                    class="rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-md transition hover:from-green-600 hover:to-emerald-700"
                >
                    Tambah User
                </Link>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filters Card -->
                <div class="mb-6 rounded-xl bg-white p-6 shadow-sm">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <SearchInput
                                v-model="search"
                                placeholder="Cari berdasarkan nama, email, atau telepon..."
                            />
                        </div>

                        <!-- Role Filter -->
                        <div>
                            <select
                                v-model="roleFilter"
                                class="block w-full rounded-lg border-gray-300 bg-white py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-green-500 focus:ring-green-500"
                            >
                                <option value="">Semua Roles</option>
                                <option v-for="role in availableRoles" :key="role" :value="role">
                                    {{ role }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Per Page Selector -->
                    <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">Tampilkan:</span>
                            <select
                                v-model="perPage"
                                class="rounded-lg border-gray-300 text-sm focus:border-green-500 focus:ring-green-500"
                            >
                                <option v-for="option in perPageOptions" :key="option" :value="option">
                                    {{ option }}
                                </option>
                            </select>
                            <span class="text-sm text-gray-600">per halaman</span>
                        </div>

                        <div class="text-sm text-gray-600">
                            Total {{ users.total }} user
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Role
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Kontak
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-if="users.data.length === 0">
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                        </svg>
                                        <p class="mt-2 text-sm text-gray-600">Tidak ada user ditemukan</p>
                                    </td>
                                </tr>
                                <tr v-for="user in users.data" :key="user.id" class="transition hover:bg-gray-50">
                                    <!-- User Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-sm font-semibold text-white">
                                                {{ getUserInitial(user.name) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ user.name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ user.email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Role -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                            {{ getUserPrimaryRole(user) }}
                                        </span>
                                    </td>

                                    <!-- Contact -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ user.phone || '-' }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link
                                            :href="route('users.edit', user.id)"
                                            class="mr-3 text-green-600 transition hover:text-green-900"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteUser(user)"
                                            class="text-red-600 transition hover:text-red-900"
                                        >
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    <Pagination
                        :links="users.links"
                        :from="users.from"
                        :to="users.to"
                        :total="users.total"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
