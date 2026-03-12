<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import RoleSelector from '@/Components/Users/RoleSelector.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    availableRoles: Array,
    userRoles: Array,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    phone: props.user.phone || '',
    address: props.user.address || '',
    roles: props.userRoles,
});

const submit = () => {
    form.put(route('users.update', props.user.id));
};

const deleteUser = () => {
    if (confirm(`Apakah Anda yakin ingin menghapus user "${props.user.name}"? Tindakan ini tidak dapat dibatalkan.`)) {
        useForm().delete(route('users.destroy', props.user.id));
    }
};
</script>

<template>
    <Head title="Edit User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link
                    :href="route('users.index')"
                    class="text-gray-600 transition hover:text-gray-900"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold text-gray-800">Edit User</h2>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Personal Information -->
                    <div class="rounded-xl bg-white p-6 shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Informasi Pribadi</h3>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Name -->
                            <div>
                                <InputLabel for="name" value="Nama Lengkap" />
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-2 block w-full"
                                    required
                                    autofocus
                                    placeholder="Masukkan nama lengkap"
                                />
                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-2 block w-full"
                                    required
                                    placeholder="nama@email.com"
                                />
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <InputLabel for="phone" value="Nomor Telepon" />
                                <TextInput
                                    id="phone"
                                    v-model="form.phone"
                                    type="text"
                                    class="mt-2 block w-full"
                                    placeholder="08xxxxxxxxxx"
                                />
                                <InputError :message="form.errors.phone" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div>
                                <InputLabel for="address" value="Alamat" />
                                <textarea
                                    id="address"
                                    v-model="form.address"
                                    rows="3"
                                    class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                    placeholder="Masukkan alamat lengkap"
                                ></textarea>
                                <InputError :message="form.errors.address" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="rounded-xl bg-white p-6 shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Ganti Password (Opsional)</h3>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Password -->
                            <div>
                                <InputLabel for="password" value="Password Baru" />
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-2 block w-full"
                                    placeholder="Kosongkan jika tidak ingin mengubah"
                                />
                                <InputError :message="form.errors.password" class="mt-2" />
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <InputLabel for="password_confirmation" value="Konfirmasi Password Baru" />
                                <TextInput
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="mt-2 block w-full"
                                    placeholder="Ulangi password baru"
                                />
                                <InputError :message="form.errors.password_confirmation" class="mt-2" />
                            </div>
                        </div>

                        <p class="mt-2 text-sm text-gray-500">
                            Biarkan password kosong jika tidak ingin mengubah password user ini.
                        </p>
                    </div>

                    <!-- Roles -->
                    <div class="rounded-xl bg-white p-6 shadow-sm">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Role & Permissions</h3>

                        <RoleSelector
                            v-model="form.roles"
                            :available-roles="availableRoles"
                            :error="form.errors.roles"
                        />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between rounded-xl bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <Link :href="route('users.index')">
                                <SecondaryButton>Batal</SecondaryButton>
                            </Link>
                            <DangerButton
                                type="button"
                                @click="deleteUser"
                                :disabled="user.id === $page.props.auth.user.id"
                                :class="{ 'opacity-50 cursor-not-allowed': user.id === $page.props.auth.user.id }"
                            >
                                Hapus User
                            </DangerButton>
                        </div>
                        <PrimaryButton
                            :class="{ 'opacity-50': form.processing }"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Memproses...</span>
                            <span v-else>Update User</span>
                        </PrimaryButton>
                    </div>

                    <!-- Warning for self deletion -->
                    <div v-if="user.id === $page.props.auth.user.id" class="rounded-xl bg-yellow-50 p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Anda tidak dapat menghapus akun Anda sendiri.
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
