<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of Info</h3>
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
                        @click.prevent="addInfo"
                    >
                        Add info
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Category</th>
                                <th class="text-center align-middle no-wrap">Name</th>
                                <th class="text-center align-middle no-wrap">Description</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Video</th>
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
                            <template v-if="info">
                                <tr v-for="i in info.data" :key="i.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ i.info_category.name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ i.name | short }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ i.description | stripHTML | short }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-success"
                                            @click="showVideo(i)"
                                            v-if="i.video"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <i class="far fa-times-circle text-danger" v-else></i>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editInfo(i)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteInfo(i.id)"
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
                        :data="info"
                        :limit="1"
                        @pagination-change-page="loadInfo"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <general-info-modal :info-categories="infoCategories"/>
            <show-video/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import GeneralInfoModal from "./GeneralInfoModal";
import ShowVideo from "../../forms/ShowVideo";

export default {
    name: 'GeneralInfoIndex',
    components: {
        Pagination,
        GeneralInfoModal,
        ShowVideo,
    },
    data() {
        return {
            loading: false,
            info: null,
            infoCategories: [],
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.info?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadInfo();
            }, 250),
        },
    },
    methods: {
        loadInfo(page = 1) {
            this.loading = true;
            axios
                .get(route("general-info.index", { page, ...this.filters }))
                .then((response) => {
                    this.info = response.data;
                    this.loading = false;
                });
        },
        getInfoCategories(){
            axios.get(route("info-categories")).then(response => {
                this.infoCategories = response.data.data;
            })
        },
        addInfo() {
            Bus.$emit("open-info-modal", null);
        },
        editInfo(info) {
            Bus.$emit("open-info-modal", info);
        },
        deleteInfo(id) {
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
                        .delete(route("general-info.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Info has been deleted successfully.");
                            this.loadInfo();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
        showVideo(info){
            Bus.$emit('show-video-modal', info);
        }
    },
    mounted() {
        this.loadInfo();
        this.getInfoCategories();
        this.$emit("loadBreadcrumbLink", {
            pageName: "General info",
        });

        Bus.$on("load-info", this.loadInfo);
    },
};
</script>
