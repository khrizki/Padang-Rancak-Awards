<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import RoleSelector from '@/Components/Users/RoleSelector.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    availableRoles: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone: '',
    address: '',
    roles: [],
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Tambah User" />

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
                <h2 class="text-xl font-semibold text-gray-800">Tambah User Baru</h2>
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
                        <h3 class="mb-4 text-lg font-semibold text-gray-800">Password</h3>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Password -->
                            <div>
                                <InputLabel for="password" value="Password" />
                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    class="mt-2 block w-full"
                                    required
                                    placeholder="Minimal 8 karakter"
                                />
                                <InputError :message="form.errors.password" class="mt-2" />
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <InputLabel for="password_confirmation" value="Konfirmasi Password" />
                                <TextInput
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    type="password"
                                    class="mt-2 block w-full"
                                    required
                                    placeholder="Ulangi password"
                                />
                                <InputError :message="form.errors.password_confirmation" class="mt-2" />
                            </div>
                        </div>
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
                    <div class="flex items-center justify-end gap-4">
                        <Link :href="route('users.index')">
                            <SecondaryButton>Batal</SecondaryButton>
                        </Link>
                        <PrimaryButton
                            :class="{ 'opacity-50': form.processing }"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Memproses...</span>
                            <span v-else>Simpan User</span>
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
