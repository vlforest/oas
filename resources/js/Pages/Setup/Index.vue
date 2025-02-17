<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    admin_email: '',
    admin_password: '',
    admin_password_confirmation: '',
});

const submit = () => {
    form.post(route('setup.store'), {
        onFinish: () => form.reset('admin_password', 'admin_password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Admin Setup" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="admin_email" value="Email Admin" />

                <TextInput
                    id="admin_email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.admin_email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.admin_email" />
            </div>

            <div class="mt-4">
                <InputLabel for="admin_password" value="Mật khẩu Admin" />

                <TextInput
                    id="admin_password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.admin_password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.admin_password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="admin_password_confirmation"
                    value="Xác nhận Mật khẩu"
                />

                <TextInput
                    id="admin_password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.admin_password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.admin_password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Khởi tạo
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
