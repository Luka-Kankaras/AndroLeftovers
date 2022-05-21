<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of toothbrush types</h3>
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
                        @click.prevent="addToothBrushType"
                    >
                        Add Toothbrush Type
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
                            <template v-if="toothBrushTypes">
                                <tr v-for="toothBrushType in toothBrushTypes.data" :key="toothBrushType.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ toothBrushType.name }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editToothBrushType(toothBrushType)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteToothBrushType(toothBrushType)"
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
                        :data="toothBrushTypes"
                        :limit="1"
                        @pagination-change-page="loadToothBrushTypes"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <toothbrush-modal/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import ToothbrushModal from "./ToothbrushModal";

export default {
    components: {
        Pagination,
        ToothbrushModal,
    },
    data() {
        return {
            loading: false,
            toothBrushTypes: null,
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.toothBrushTypes?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadToothBrushTypes();
            }, 250),
        },
    },
    methods: {
        loadToothBrushTypes(page = 1) {
            this.loading = true;
            axios
                .get(route("toothbrush-types.index", { page, ...this.filters }))
                .then((response) => {
                    this.toothBrushTypes = response.data;
                    this.loading = false;
                });
        },
        addToothBrushType() {
            Bus.$emit("open-toothbrush-type-modal", null);
        },
        editToothBrushType(toothBrushType) {
            Bus.$emit("open-toothbrush-type-modal", toothBrushType);
        },
        deleteToothBrushType(id) {
            Swal.fire({
                icon: "warning",
                title: "Deleting!",
                text: "Are you sure you want to proceed?",
                showCancelButton: true,
                cancelButtonToothBrushType: "#3085d6",
                confirmButtonToothBrushType: "#c82333",
                cancelButtonText: "Cancel",
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.value) {
                    axios
                        .delete(route("toothbrush-types.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Toothbrush Type has been deleted successfully.");
                            this.loadToothBrushTypes();
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
        this.loadToothBrushTypes();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Toothbrush Types",
        });

        Bus.$on("load-toothBrushTypes", this.loadToothBrushTypes);
    },
};
</script>
