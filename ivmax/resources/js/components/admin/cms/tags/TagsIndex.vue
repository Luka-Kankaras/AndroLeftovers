<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of Tags</h3>
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
                        @click.prevent="addTag"
                    >
                        Add tag
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
                            <template v-if="tags">
                                <tr v-for="tag in tags.data" :key="tag.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ tag.id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ tag.name }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editTag(tag)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteTag(tag)"
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
                        :data="tags"
                        :limit="1"
                        @pagination-change-page="loadTags"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <tags-modal :languages="languages"/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import TagsModal from "./TagsModal";

export default {
    components: {
        Pagination,
        TagsModal,
    },
    data() {
        return {
            loading: false,
            tags: null,
            cities: [],
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.tags?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadTags();
            }, 250),
        },
    },
    methods: {
        loadTags(page = 1) {
            this.loading = true;
            axios
                .get(route("tags.index", { page, ...this.filters }))
                .then((response) => {
                    this.tags = response.data;
                    this.loading = false;
                });
        },
        addTag() {
            Bus.$emit("open-tag-modal", null);
        },
        editTag(tag) {
            Bus.$emit("open-tag-modal", tag);
        },
        deleteTag(id) {
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
                        .delete(route("tags.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Tag has been deleted successfully.");
                            this.loadTags();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadTags();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Tags",
        });

        Bus.$on("load-tags", this.loadTags);
    },
};
</script>
