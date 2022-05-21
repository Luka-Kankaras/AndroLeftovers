<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of colors</h3>
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
                        @click.prevent="addColor"
                    >
                        Add Color
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Color</th>
                                <th class="text-center align-middle no-wrap">Name</th>
                                <th class="text-center align-middle no-wrap">Hex</th>
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
                            <template v-if="colors">
                                <tr v-for="color in colors.data" :key="color.id">
                                    <td class="text-center align-middle no-wrap" :style="{backgroundColor: color.hex, width: '100px'}">
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ color.name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ color.hex }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editColor(color)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteColor(color)"
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
                        :data="colors"
                        :limit="1"
                        @pagination-change-page="loadColors"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <color-modal/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import ColorModal from "./ColorModal";

export default {
    components: {
        Pagination,
        ColorModal,
    },
    data() {
        return {
            loading: false,
            colors: null,
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.colors?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadColors();
            }, 250),
        },
    },
    methods: {
        loadColors(page = 1) {
            this.loading = true;
            axios
                .get(route("colors.index", { page, ...this.filters }))
                .then((response) => {
                    this.colors = response.data;
                    this.loading = false;
                });
        },
        addColor() {
            Bus.$emit("open-color-modal", null);
        },
        editColor(color) {
            Bus.$emit("open-color-modal", color);
        },
        deleteColor(id) {
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
                        .delete(route("colors.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Color has been deleted successfully.");
                            this.loadColors();
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
        this.loadColors();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Colors",
        });

        Bus.$on("load-colors", this.loadColors);
    },
};
</script>
