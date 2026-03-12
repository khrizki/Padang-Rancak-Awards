<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Daftar" />

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Daftar Akun Warga</h2>
            <p class="text-sm text-gray-600">Bergabunglah dalam mewujudkan Padang yang hijau</p>
        </div>

        <form @submit.prevent="submit">
            <!-- Name Field -->
            <div class="mb-5">
                <InputLabel for="name" value="Nama Lengkap" class="text-gray-700 font-medium" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email Field -->
            <div class="mb-5">
                <InputLabel for="email" value="Email" class="text-gray-700 font-medium" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="nama@email.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div class="mb-5">
                <InputLabel for="password" value="Password" class="text-gray-700 font-medium" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Password Confirmation Field -->
            <div class="mb-6">
                <InputLabel
                    for="password_confirmation"
                    value="Konfirmasi Password"
                    class="text-gray-700 font-medium"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-2 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <!-- Submit Button -->
            <PrimaryButton
                class="w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
            >
                <span v-if="form.processing">Memproses...</span>
                <span v-else>Daftar Sekarang</span>
            </PrimaryButton>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <Link
                        :href="route('login')"
                        class="font-semibold text-green-600 hover:text-green-700 transition"
                    >
                        Masuk
                    </Link>
                </p>
            </div>
        </form>

        <!-- Role Badge -->
        <div class="mt-6 p-4 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">Akun Warga</p>
                    <p class="text-xs text-gray-600">Anda akan terdaftar sebagai warga untuk dapat mengikuti kompetisi</p>
                </div>
            </div>
        </div>

        <!-- Eco Footer -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                </svg>
                <span>Bersama wujudkan Padang yang hijau dan bersih</span>
            </div>
        </div>
    </GuestLayout>
</template>
