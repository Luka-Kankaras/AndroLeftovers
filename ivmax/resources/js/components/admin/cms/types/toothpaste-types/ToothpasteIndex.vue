<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of toothpaste types</h3>
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
                        @click.prevent="addToothPasteType"
                    >
                        Add Toothpaste Type
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Name</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Edit</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="7">
                                    <h4 class="text-center mb-0 my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="toothPasteTypes">
                                <tr v-for="toothPasteType in toothPasteTypes.data" :key="toothPasteType.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ toothPasteType.name }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editToothPasteType(toothPasteType)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteToothPasteType(toothPasteType)"
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
                        :data="toothPasteTypes"
                        :limit="1"
                        @pagination-change-page="loadToothPasteTypes"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <toothpaste-modal/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import ToothpasteModal from "./ToothpasteModal";

export default {
    components: {
        Pagination,
        ToothpasteModal,
    },
    data() {
        return {
            loading: false,
            toothPasteTypes: null,
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.toothPasteTypes?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadToothPasteTypes();
            }, 250),
        },
    },
    methods: {
        loadToothPasteTypes(page = 1) {
            this.loading = true;
            axios
                .get(route("toothpaste-types.index", { page, ...this.filters }))
                .then((response) => {
                    this.toothPasteTypes = response.data;
                    this.loading = false;
                });
        },
        addToothPasteType() {
            Bus.$emit("open-toothpaste-type-modal", null);
        },
        editToothPasteType(toothPasteType) {
            Bus.$emit("open-toothpaste-type-modal", toothPasteType);
        },
        deleteToothPasteType(id) {
            Swal.fire({
                icon: "warning",
                title: "Deleting!",
                text: "Are you sure you want to proceed?",
                showCancelButton: true,
                cancelButtonToothPasteType: "#3085d6",
                confirmButtonToothPasteType: "#c82333",
                cancelButtonText: "Cancel",
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.value) {
                    axios
                        .delete(route("toothpaste-types.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Toothpaste type has been deleted successfully.");
                            this.loadToothPasteTypes();
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
        this.loadToothPasteTypes();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Toothpaste Types",
        });

        Bus.$on("load-toothPasteTypes", this.loadToothPasteTypes);
    },
};
</script>
