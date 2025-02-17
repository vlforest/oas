<template>
    <div>
        <Head title="Pending Verification" />
        <div class="min-h-screen flex items-center justify-center">
            <div class="p-8 rounded-lg shadow-lg bg-white" style="width: 600px; height: 350px;">
                <h1 class="text-2xl font-bold mb-4">Your Account is Pending Verification</h1>
                <div class="mt-4">
                    <p class="text-gray-700 mb-4">Tài khoản bạn phải được xác thực bởi quản trị viên, nếu không bạn sẽ không thể sử dụng ứng dụng.</p>
                    <p class="text-gray-700 mb-4">您的帐户必须由管理员验证，否则您将无法使用该应用程序。</p>
                    <p class="text-gray-700 mb-4">Your account must be verified by an administrator, otherwise, you will not be able to use the application.</p>
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <DangerButton @click="logout" class="inline-flex items-center">
                        <span class="material-icons mr-2">logout</span> Log Out
                    </DangerButton>
                    <SecondaryButton @click="refreshPage" class="inline-flex items-center">
                        <span class="material-icons mr-2">refresh</span> Refresh
                    </SecondaryButton>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Head } from '@inertiajs/inertia-vue3';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue'; // Import SecondaryButton
import { Inertia } from '@inertiajs/inertia';

export default {
    name: 'PendingVerification',
    components: {
        Head,
        DangerButton,
        SecondaryButton // Register SecondaryButton
    },
    methods: {
        logout() {
            Inertia.post(route('logout'));
        },
        refreshPage() {
            location.reload();
        }
    }
};
</script>
<style>
.cursor-pointer {
    cursor: pointer; /* Con trỏ chuột dạng pointer khi hover */
}
</style>
