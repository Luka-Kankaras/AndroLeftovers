<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of admins</h3>
                    <div class="float-sm-right">
                        <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Search"
                            aria-label="Search"
                            v-model="filters.term"
                        />
                    </div>
                </div>
                <div class="card-body">
                    <button
                        class="btn btn-sm btn-primary mb-3 float-right"
                        style="width: 120px"
                        @click.prevent="addUser"
                    >
                        Add admin
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">First name</th>
                                <th class="text-center align-middle no-wrap">Last name</th>
                                <th class="text-center align-middle no-wrap">Email</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Edit</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="7">
                                    <h4 class="text-center my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="users">
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ user.first_name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ user.last_name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ user.email }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editUser(user)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            v-if="user.id !== currentUser.id"
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteUser(user.id)"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>

                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer" v-if="resultsCount">
                    <pagination
                        class="my-1"
                        align="right"
                        :data="users"
                        :limit="1"
                        @pagination-change-page="loadUsers"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <user-modal/>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import UserModal from "@admin/users/UserModal";
import {swalNotification} from "@/utilities";

export default {
    components: {
        UserModal,
        Pagination,
    },
    data() {
        return {
            loading: false,
            users: null,
            currentUser: null,
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.users?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadUsers();
            }, 250),
        },
    },
    methods: {
        loadUsers(page = 1) {
            this.loading = true;
            axios
                .get(route("users.index", {page, ...this.filters}))
                .then((response) => {
                    this.users = response.data.users;
                    this.currentUser = response.data.current_user;

                    for (let i = 0; i < this.users.data.length; i++){
                        if(this.users.data[i].id === this.currentUser.id){
                            let temp = this.users.data[0];
                            this.users.data[0] = this.users.data[i];
                            this.users.data[i] = temp;
                        }
                    }

                    this.loading = false;
                });
        },
        addUser() {
            Bus.$emit("open-user-modal", null);
        },
        editUser(user) {
            Bus.$emit("open-user-modal", user);
        },
        deleteUser(id) {
            Swal.fire({
                icon: "warning",
                title: "Deleting!",
                text: "Are you sure you want to proceed?",
                showCancelButton: true,
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#c82333",
                cancelButtonText: "Cancel",
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.value) {
                    axios
                        .delete(route("users.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Admin has been deleted successfully.");
                            this.loadUsers();
                        })
                        .catch((error) => {
                            if(error.response.status === 405)
                                Swal.fire("Error!", error.response.data, "error");
                            else
                                Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadUsers();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Admins",
        });

        Bus.$on("load-users", this.loadUsers);
    },
};
</script>
