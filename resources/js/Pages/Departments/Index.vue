<template>
    <Head title="Departments" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departments</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <DepartmentTable 
                            :departments="departments" 
                            :loading="loading"
                            :openCreateModal="openCreateModal"
                            :editDepartment="editDepartment"
                            :confirmDeleteDepartment="confirmDeleteDepartment"
                            :users="users"
                        />
                    </div>
                </div>
            </div>
        </div>
        
        <CreateDepartmentModal 
            :showCreateModal="showCreateModal"
            :createForm="createForm"
            :closeCreateModal="closeCreateModal"
            :submitCreate="submitCreate"
            :users="availableUsers" 
        />

        <EditDepartmentModal 
            :showEditModal="showEditModal"
            :form="form"
            :closeEditModal="closeEditModal"
            :submitEdit="submitEdit"
            :users="users"
            :availableUsers="availableUsers"
        />

        <ConfirmDeleteModal 
            :showConfirmModal="showConfirmModal"
            :closeConfirmModal="closeConfirmModal"
            :deleteDepartment="deleteDepartment"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DepartmentTable from './DepartmentTable.vue';
import CreateDepartmentModal from './CreateDepartmentModal.vue';
import EditDepartmentModal from './EditDepartmentModal.vue';
import ConfirmDeleteModal from './ConfirmDeleteModal.vue';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import { Head } from '@inertiajs/vue3';

const page = usePage();
let departments = ref([]);
let users = ref([]);
let availableUsers = ref([]);
const loading = ref(true);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showConfirmModal = ref(false);
const selectedDepartment = ref(null);

const createForm = useForm({
    name: '',
    description: '',
    members: [],
    main_responsible: null
});

const form = useForm({
    name: '',
    description: '',
    members: [],
    main_responsible: null
});

onMounted(() => {
    loadData();

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
});

async function loadData() {
    try {
        // Chuyển đổi members từ chuỗi JSON thành mảng
        departments.value = page.props.departments.map(department => {
            department.members = JSON.parse(department.members || '[]');
            return department;
        });

        // Lấy danh sách người dùng thuộc các phòng ban
        const usersInDepartments = departments.value.reduce((acc, department) => {
            return acc.concat(department.members);
        }, []);

        // Lọc danh sách người dùng chưa thuộc phòng ban nào
        availableUsers.value = page.props.users.filter(user => !usersInDepartments.includes(user.id));

        // Gán dữ liệu users
        users.value = [...page.props.users];

        loading.value = false;
    } catch (error) {
        console.error('Failed to load data:', error);
        toastr.error('Failed to load data.');
    }
}

function openCreateModal() {
    createForm.reset();
    showCreateModal.value = true;
}

function closeCreateModal() {
    showCreateModal.value = false;
}

function submitCreate() {
    createForm.transform((data) => ({
        ...data,
        members: JSON.stringify(data.members)
    })).post(route('departments.store'), {
        onSuccess: () => {
            toastr.success('Department created successfully.');
            loadData();
            showCreateModal.value = false;
        },
        onError: (error) => {
            toastr.error('Failed to create department.');
            console.error('Create failed:', error);
        }
    });
}

function editDepartment(department) {
    selectedDepartment.value = department;
    form.name = department.name;
    form.description = department.description;
    form.members = Array.isArray(department.members) ? department.members : (JSON.parse(department.members) || []); // Đảm bảo members là một mảng
    form.main_responsible = department.main_responsible;
    showEditModal.value = true;
}

function submitEdit() {
    form.transform((data) => ({
        ...data,
        members: JSON.stringify(data.members)
    })).put(route('departments.update', selectedDepartment.value.id), {
        onSuccess: () => {
            updateDepartmentInList(selectedDepartment.value.id, form.name, form.description, form.members, form.main_responsible);
            toastr.success('Department updated successfully.');
            loadData();
            showEditModal.value = false;
        },
        onError: (error) => {
            toastr.error('Failed to update department.');
            console.error('Edit failed:', error);
        }
    });
}

function closeEditModal() {
    showEditModal.value = false;
}

function updateDepartmentInList(id, name, description, members, main_responsible) {
    const department = departments.value.find(dep => dep.id === id);
    if (department) {
        department.name = name;
        department.description = description;
        department.members = members;
        department.main_responsible = main_responsible;
    }
}

function confirmDeleteDepartment(department) {
    selectedDepartment.value = department;
    showConfirmModal.value = true;
}

function deleteDepartment() {
    router.delete(route('departments.destroy', { department: selectedDepartment.value.id }), {
        onSuccess: () => {
            departments.value = departments.value.filter(dep => dep.id !== selectedDepartment.value.id);
            toastr.success('Department deleted successfully.');
            loadData();
            showConfirmModal.value = false;
        },
        onError: (error) => {
            toastr.error('Failed to delete department.');
            console.error('Delete failed:', error);
        }
    });
}

function closeConfirmModal() {
    showConfirmModal.value = false;
}
</script>
