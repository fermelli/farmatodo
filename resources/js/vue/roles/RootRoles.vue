<script>
import roleService from './../../services/role-service';
import PaginationButtons from '../components/PaginationButtons.vue';
import { uuid } from './../../utils';

export default {
    name: 'RootRoles',
    components: {
        PaginationButtons,
    },
    data() {
        return {
            loading: false,
            size: parseInt(localStorage.getItem('size')) || 10,
            roles: null,
            userRolePagination: null,
            notifications: [],
        };
    },
    created() {
        this.getRolesAndUserRole();
    },
    methods: {
        async getRolesAndUserRole() {
            this.loading = true;
            try {
                const response = await roleService.getRolesAndUserRole(
                    this.size
                );
                const [responseRoles, responseUserRole] = response;
                this.roles = responseRoles.data;
                this.userRolePagination = responseUserRole.data;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        async getUserRole(page) {
            try {
                if (this.userRolePagination.current_page != page) {
                    this.loading = true;
                }
                const promiseUserRole = await roleService.getUserRole(
                    page,
                    this.size
                );
                this.userRolePagination = promiseUserRole.data;
            } catch (error) {
                console.error(error);
            } finally {
                this.loading = false;
            }
        },
        checkedRole(roles, roleName) {
            return roles.findIndex((role) => role.name == roleName) != -1;
        },
        async updateRole(event, userId, role) {
            try {
                if (role.name != 'Guest') {
                    let response;
                    if (event.target.checked) {
                        response = await roleService.postRole(userId, role.id);
                    } else {
                        response = await roleService.deleteRole(
                            userId,
                            role.id
                        );
                    }
                    this.createNotification({
                        id: uuid(),
                        type: response.statusText,
                        title: response.data.message,
                        message: `Usuario: ${response.data.user.name}`,
                    });
                }
            } catch (error) {
                console.error(error);
            } finally {
                let currentPage = this.userRolePagination
                    ? this.userRolePagination.current_page
                    : 1;
                this.getUserRole(currentPage);
            }
        },
        changeSizePagination(size) {
            this.size = size;
            localStorage.setItem('size', String(this.size));
            this.getUserRole(1);
        },
        createNotification(data) {
            this.notifications.push(data);
            let interval = setInterval(() => {
                this.closeNotification(data.id);
                clearInterval(interval);
            }, 5000);
        },
        closeNotification(id) {
            let index = this.notifications.findIndex(
                (notification) => notification.id == id
            );
            this.notifications.splice(index, 1);
        },
    },
};
</script>

<template>
    <div class="pt-4">
        <div v-if="loading" class="p-28">
            <div class="spinner"></div>
        </div>
        <div v-else>
            <table class="table mx-auto">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">Nombre</th>
                        <th rowspan="2">Email</th>
                        <th :colspan="roles?.length">Roles</th>
                    </tr>
                    <tr>
                        <th v-for="role in roles" :key="role.id">
                            {{ role.name }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(user, index) in userRolePagination?.data"
                        :key="user.id"
                    >
                        <th>{{ userRolePagination.from + index }}</th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td
                            v-for="role in roles"
                            :key="role.id"
                            class="text-center"
                        >
                            <input
                                class="
                                    disabled:text-slate-200
                                    disabled:cursor-not-allowed
                                "
                                type="checkbox"
                                :disabled="role.name == 'Guest'"
                                :checked="checkedRole(user.roles, role.name)"
                                @change="updateRole($event, user.id, role)"
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
            <PaginationButtons
                :pagination="{
                    current_page: userRolePagination?.current_page,
                    last_page: userRolePagination?.last_page,
                }"
                :page-size="size"
                @get-data="getUserRole"
                @change-size-pagination="changeSizePagination"
            />
        </div>
    </div>
    <div
        class="
            absolute
            top-32
            right-0
            bg-transparent
            overflow-y-auto overflow-x-hidden
        "
    >
        <TransitionGroup name="list">
            <div
                v-for="(notification, index) in notifications"
                :key="index"
                class="m-4 p-4 bg-white shadow w-[280px]"
            >
                <div class="flex justify-between pb-2">
                    <h5
                        class="font-bold"
                        :class="{
                            'text-blue-700': notification.type == 'OK',
                            'text-green-700': notification.type == 'Created',
                        }"
                    >
                        {{ notification.title }}
                    </h5>
                    <button
                        :class="{
                            'text-blue-700': notification.type == 'OK',
                            'text-green-700': notification.type == 'Created',
                        }"
                        @click="closeNotification(notification.id)"
                    >
                        &times;
                    </button>
                </div>
                <div class="text-sm">
                    {{ notification.message }}
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease-in-out;
}
.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>