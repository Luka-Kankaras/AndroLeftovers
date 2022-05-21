<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of Info Categories</h3>
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
                        @click.prevent="addInfoCategory"
                    >
                        Add info category
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">ID</th>
                                <th class="text-center align-middle no-wrap">Name</th>
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
                            <template v-if="infoCategories">
                                <tr v-for="category in infoCategories.data" :key="category.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ category.id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ category.name }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editInfoCategory(category)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteInfoCategory(category)"
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
                        :data="infoCategories"
                        :limit="1"
                        @pagination-change-page="loadInfoCategories"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <info-categories-modal :languages="languages"/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import InfoCategoriesModal from "./InfoCategoriesModal";

export default {
    components: {
        Pagination,
        InfoCategoriesModal,
    },
    data() {
        return {
            loading: false,
            infoCategories: null,
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.infoCategories?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadInfoCategories();
            }, 250),
        },
    },
    methods: {
        loadInfoCategories(page = 1) {
            this.loading = true;
            axios
                .get(route("info-category.index", { page, ...this.filters }))
                .then((response) => {
                    this.infoCategories = response.data;
                    this.loading = false;
                });
        },
        addInfoCategory() {
            Bus.$emit("open-infoCategory-modal", null);
        },
        editInfoCategory(infoCategory) {
            Bus.$emit("open-infoCategory-modal", infoCategory);
        },
        deleteInfoCategory(id) {
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
                        .delete(route("info-category.destroy", id))
                        .then((response) => {
                            console.log(response.status);
                            swalNotification("success", "Info category has been deleted successfully.");
                            this.loadInfoCategories();
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
        this.loadInfoCategories();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Info categories",
        });

        Bus.$on("load-infoCategories", this.loadInfoCategories);
    },
};
</script>
