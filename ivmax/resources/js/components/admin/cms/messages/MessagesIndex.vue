<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of received messages</h3>
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
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">ID</th>
                                <th class="text-center align-middle no-wrap">Name</th>
                                <th class="text-center align-middle no-wrap">Email</th>
                                <th class="text-center align-middle no-wrap">Message</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Show</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="7">
                                    <h4 class="text-center my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="contacts">
                                <tr v-for="contact in contacts.data" :key="contact.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ contact.id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ contact.name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ contact.email }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ contact.message | short }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-success"
                                            @click="showMessage(contact.message)"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteContact(contact)"
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
                        :data="contacts"
                        :limit="1"
                        @pagination-change-page="loadContacts"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

        </div>

        <show-message/>

    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import ShowMessage from "./ShowMessage";

export default {
    components: {
        Pagination,
        ShowMessage,
    },
    data() {
        return {
            loading: false,
            contacts: null,
            cities: [],
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.contacts?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadContacts();
            }, 250),
        },
    },
    methods: {
        loadContacts(page = 1) {
            this.loading = true;
            axios
                .get(route("contacts.index", { page, ...this.filters }))
                .then((response) => {
                    this.contacts = response.data;
                    this.loading = false;
                });
        },
        deleteContact(id) {
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
                        .delete(route("contacts.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Message has been deleted successfully.");
                            this.loadContacts();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
        showMessage(message){
            Bus.$emit('open-message-modal', message);
        }
    },
    mounted() {
        this.loadContacts();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Received messages",
        });

        Bus.$on("load-contacts", this.loadContacts);
    },
};
</script>
