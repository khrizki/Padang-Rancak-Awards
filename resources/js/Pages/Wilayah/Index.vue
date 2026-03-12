<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SidebarMenuItem from '@/Components/Sidebar/SidebarMenuItem.vue';

const page = usePage();
const props = defineProps({
    rts: Object,
    filters: Object,
    filterOptions: Object,
});

// Filter state
const statusFilter = ref(props.filters.status || '');
const kecamatanFilter = ref(props.filters.kecamatan || '');
const kelurahanFilter = ref(props.filters.kelurahan || '');
const rwFilter = ref(props.filters.rw || '');

// Dependent dropdown options
const kelurahans = ref([]);
const rws = ref([]);
const loadingKelurahans = ref(false);
const loadingRWs = ref(false);

// Flash messages
const flash = computed(() => page.props.flash);

// Status update form
const statusForm = useForm({
    status_terdaftar: false,
});

// Load kelurahans when kecamatan changes
watch(kecamatanFilter, async (newVal) => {
    kelurahanFilter.value = '';
    rwFilter.value = '';
    kelurahans.value = [];
    rws.value = [];

    if (newVal) {
        loadingKelurahans.value = true;
        try {
            const response = await fetch(`/wilayah/kelurahans?kecamatan_id=${newVal}`);
            kelurahans.value = await response.json();
        } catch (error) {
            console.error('Failed to load kelurahans:', error);
        } finally {
            loadingKelurahans.value = false;
        }
    }
});

// Load RWs when kelurahan changes
watch(kelurahanFilter, async (newVal) => {
    rwFilter.value = '';
    rws.value = [];

    if (newVal) {
        loadingRWs.value = true;
        try {
            const response = await fetch(`/wilayah/rws?kelurahan_id=${newVal}`);
            rws.value = await response.json();
        } catch (error) {
            console.error('Failed to load RWs:', error);
        } finally {
            loadingRWs.value = false;
        }
    }
});

// Build filter URL
const filterUrl = computed(() => {
    const params = new URLSearchParams();
    if (statusFilter.value) params.append('status', statusFilter.value);
    if (kecamatanFilter.value) params.append('kecamatan', kecamatanFilter.value);
    if (kelurahanFilter.value) params.append('kelurahan', kelurahanFilter.value);
    if (rwFilter.value) params.append('rw', rwFilter.value);

    const queryString = params.toString();
    return queryString ? `/wilayah?${queryString}` : '/wilayah';
});

// Toggle RT status
const toggleStatus = (rt) => {
    const newStatus = rt.status_terdaftar === 'sudah' ? 'belum' : 'sudah';
    statusForm.status_terdaftar = newStatus === 'sudah';

    statusForm.put(`/wilayah/${rt.id}/status`, {
        preserveScroll: true,
        onSuccess: () => {
            rt.status_terdaftar = newStatus;
        },
    });
};

// Get status badge classes
const getStatusBadgeClasses = (status) => {
    return status === 'sudah'
        ? 'bg-green-100 text-green-800 border-green-200'
        : 'bg-yellow-100 text-yellow-800 border-yellow-200';
};

// Get status text
const getStatusText = (status) => {
    return status === 'sudah' ? 'Sudah Terdaftar' : 'Belum Terdaftar';
};

// Load initial dependent data
onMounted(async () => {
    if (props.filters.kelurahan) {
        try {
            const response = await fetch(`/wilayah/kelurahans?kecamatan_id=${props.filters.kecamatan}`);
            kelurahans.value = await response.json();
        } catch (error) {
            console.error('Failed to load kelurahans:', error);
        }
    }

    if (props.filters.rw) {
        try {
            const response = await fetch(`/wilayah/rws?kelurahan_id=${props.filters.kelurahan}`);
            rws.value = await response.json();
        } catch (error) {
            console.error('Failed to load RWs:', error);
        }
    }
});
</script>

<template>
    <AuthenticatedLayout title="Manajemen Wilayah">
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Wilayah</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Flash Messages -->
<div v-if="flash?.success" class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
    {{ flash.success }}
</div>

<div v-if="flash?.error" class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
    {{ flash.error }}
</div>

                <!-- Filters Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-800">Filter Wilayah</h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status Pendaftaran
                                </label>
                                <select
                                    v-model="statusFilter"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="sudah">Sudah Terdaftar</option>
                                    <option value="belum">Belum Terdaftar</option>
                                </select>
                            </div>

                            <!-- Kecamatan Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Kecamatan
                                </label>
                                <select
                                    v-model="kecamatanFilter"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                >
                                    <option value="">Semua Kecamatan</option>
                                    <option
                                        v-for="kecamatan in filterOptions.kecamatans"
                                        :key="kecamatan.id"
                                        :value="kecamatan.id"
                                    >
                                        {{ kecamatan.nama }}
                                    </option>
                                </select>
                            </div>

                            <!-- Kelurahan Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Kelurahan
                                </label>
                                <select
                                    v-model="kelurahanFilter"
                                    :disabled="!kecamatanFilter || loadingKelurahans"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                >
                                    <option value="">Semua Kelurahan</option>
                                    <option
                                        v-for="kelurahan in kelurahans"
                                        :key="kelurahan.id"
                                        :value="kelurahan.id"
                                    >
                                        {{ kelurahan.nama }}
                                    </option>
                                </select>
                            </div>

                            <!-- RW Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    RW
                                </label>
                                <select
                                    v-model="rwFilter"
                                    :disabled="!kelurahanFilter || loadingRWs"
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                >
                                    <option value="">Semua RW</option>
                                    <option
                                        v-for="rw in rws"
                                        :key="rw.id"
                                        :value="rw.id"
                                    >
                                        RW {{ rw.nomor_rw }} - {{ rw.nama }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="mt-4 flex justify-end">
                            <Link
                                :href="filterUrl"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Terapkan Filter
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- RT Table Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800">Daftar RT</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Menampilkan {{ rts.from }} - {{ rts.to }} dari {{ rts.total }} RT
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama RT
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Alamat
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Warga
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. HP Ketua RT
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr
                                    v-for="rt in rts.data"
                                    :key="rt.id"
                                    class="hover:bg-gray-50"
                                >
                                    <!-- Location Hierarchy -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">RT {{ rt.nomor_rt }}</div>
                                            <div class="text-gray-600">RW {{ rt.rw.nomor_rw }}</div>
                                            <div class="text-gray-500 text-xs">{{ rt.rw.kelurahan.nama }}</div>
                                            <div class="text-gray-400 text-xs">Kec. {{ rt.rw.kelurahan.kecamatan.nama }}</div>
                                        </div>
                                    </td>

                                    <!-- RT Name -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ rt.nama }}
                                        </div>
                                    </td>

                                    <!-- Address -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">
                                            {{ rt.alamat || '-' }}
                                        </div>
                                    </td>

                                    <!-- Population -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ rt.jumlah_warga || 0 }} jiwa
                                        </div>
                                    </td>

                                    <!-- Phone -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-600">
                                            {{ rt.no_hp_ketua_rt || '-' }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border"
                                            :class="getStatusBadgeClasses(rt.status_terdaftar)"
                                        >
                                            {{ getStatusText(rt.status_terdaftar) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-4 py-4">
                                        <button
                                            @click="toggleStatus(rt)"
                                            :disabled="statusForm.processing"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors duration-200"
                                            :class="rt.status_terdaftar === 'sudah'
                                                ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200'
                                                : 'bg-green-100 text-green-800 hover:bg-green-200'"
                                        >
                                            <svg
                                                class="w-4 h-4 mr-1"
                                                :class="{'rotate-180': rt.status_terdaftar === 'sudah'}"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            {{ rt.status_terdaftar === 'sudah' ? 'Belum' : 'Sudah' }}
                                        </button>
                                    </td>
                                </tr>

                                <!-- Empty State -->
                                <tr v-if="rts.data.length === 0">
                                    <td colspan="7" class="px-4 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data RT</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Coba ubah filter atau tambahkan data RT baru.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="rts.data.length > 0" class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ rts.from }} - {{ rts.to }} dari {{ rts.total }} RT
                        </div>

                        <div class="flex items-center space-x-2">
                            <Link
                                v-if="rts.prev_page_url"
                                :href="rts.prev_page_url"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Sebelumnya
                            </Link>

                            <span v-else class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Sebelumnya
                            </span>

                            <Link
                                v-if="rts.next_page_url"
                                :href="rts.next_page_url"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                            >
                                Selanjutnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </Link>

                            <span v-else class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 cursor-not-allowed">
                                Selanjutnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
