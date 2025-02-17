<template>
    <Head title="User Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                User Management
            </h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 border-b border-gray-200" v-if="pendingUsers.length > 0 || verifiedUsers.length > 0">
                            <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                                <template v-if="pendingUsers.length > 0">
                                    <button @click="activeTab = 'Pending'"
                                            :class="[ 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm',
                                                      activeTab === 'Pending' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                                      'text-red-500'
                                                    ]">
                                        <i class="material-icons align-middle mr-2 shake-horizontal">notifications</i>
                                        Pending ({{ pendingUsers.length }})
                                    </button>
                                </template>
                                <template v-if="verifiedUsers.length > 0">
                                    <button @click="activeTab = 'Verified'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'Verified', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'Verified' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Verified ({{ verifiedUsers.length }})
                                    </button>
                                </template>
                            </nav>
                        </div>
                        <div v-else class="text-center text-gray-500">
                            No users pending or verified.
                        </div>
                        <div v-if="activeTab === 'Verified' && verifiedUsers.length > 0">
                            <UserTable :users="verifiedUsers" @toggle-role="toggleRole" @confirm-delete-user="confirmDeleteUser" />
                        </div>
                        <div v-if="activeTab === 'Pending' && pendingUsers.length > 0">
                            <UserTable :users="pendingUsers" @toggle-role="toggleRole" @confirm-delete-user="confirmDeleteUser" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ConfirmDeleteModal
            v-if="showConfirmDeleteModal"
            :show="showConfirmDeleteModal"
            @close="showConfirmDeleteModal = false"
            @confirm="deleteUser"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, defineProps, onMounted, computed } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';
import UserTable from './UserTable.vue';
import ConfirmDeleteModal from './ConfirmDeleteModal.vue';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

const props = defineProps({
    users: Array,
    flash: Object,
});

const users = ref(props.users);
const form = useForm({});
const showConfirmDeleteModal = ref(false);
const userToDelete = ref(null);
const activeTab = ref('');

const verifiedUsers = computed(() => users.value.filter(user => user.role === 'Verified'));
const pendingUsers = computed(() => users.value.filter(user => user.role === 'Pending'));

onMounted(() => {
    const pageProps = usePage().props.value;
    if (pageProps && pageProps.flash) {
        const flash = pageProps.flash;
        if (flash.success) {
            toastr.success(flash.success);
        }
        if (flash.error) {
            toastr.error(flash.error);
        }
    }

    // Mở tab nếu chỉ có một tab hiển thị
    if (pendingUsers.value.length > 0 && verifiedUsers.value.length === 0) {
        activeTab.value = 'Pending';
    } else if (verifiedUsers.value.length > 0 && pendingUsers.value.length === 0) {
        activeTab.value = 'Verified';
    } else if (verifiedUsers.value.length > 0 && pendingUsers.value.length > 0) {
        activeTab.value = 'Pending'; // Hoặc bất kỳ tab mặc định nào bạn muốn mở trước
    }
});

function toggleRole(user, newRole) {
    router.patch(route('users.update', user.id), {
        role: newRole ? 'Verified' : 'Pending',
    }, {
        onSuccess: () => {
            const index = users.value.findIndex(u => u.id === user.id);
            if (index !== -1) {
                users.value[index].role = newRole ? 'Verified' : 'Pending';
            }
            toastr.success('User role updated successfully.');
            // Kiểm tra lại các tab sau khi thay đổi trạng thái
            if (pendingUsers.value.length > 0 && verifiedUsers.value.length === 0) {
                activeTab.value = 'Pending';
            } else if (verifiedUsers.value.length > 0 && pendingUsers.value.length === 0) {
                activeTab.value = 'Verified';
            } else if (verifiedUsers.value.length > 0 && pendingUsers.value.length > 0) {
                activeTab.value = 'Pending';
            } else {
                activeTab.value = ''; // Nếu không có người dùng nào, tab sẽ không được hiển thị
            }
        },
        onError: () => {
            toastr.error('Failed to update user role.');
        },
    });
}

function confirmDeleteUser(user) {
    userToDelete.value = user;
    showConfirmDeleteModal.value = true;
}

function deleteUser() {
    if (userToDelete.value) {
        router.delete(route('users.destroy', userToDelete.value.id), {
            onSuccess: () => {
                const index = users.value.findIndex(u => u.id === userToDelete.value.id);
                if (index !== -1) {
                    users.value.splice(index, 1);
                }
                toastr.success('User deleted successfully.');
                showConfirmDeleteModal.value = false;
                // Kiểm tra lại các tab sau khi xóa người dùng
                if (pendingUsers.value.length > 0 && verifiedUsers.value.length === 0) {
                    activeTab.value = 'Pending';
                } else if (verifiedUsers.value.length > 0 && pendingUsers.value.length === 0) {
                    activeTab.value = 'Verified';
                } else if (verifiedUsers.value.length > 0 && pendingUsers.value.length > 0) {
                    activeTab.value = 'Pending';
                } else {
                    activeTab.value = ''; // Nếu không có người dùng nào, tab sẽ không được hiển thị
                }
            },
            onError: () => {
                toastr.error('Failed to delete user.');
            },
        });
    }
}
</script>

<style scoped>
.text-red-500 {
    color: #ef4444; /* Màu đỏ */
}

.shake-horizontal {
    animation: shake-horizontal 0.5s infinite; /* Tốc độ nhanh hơn */
}

@keyframes shake-horizontal {
    0%, 100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-2px); /* Giao động nhỏ hơn */
    }
    75% {
        transform: translateX(2px); /* Giao động nhỏ hơn */
    }
}
</style>
