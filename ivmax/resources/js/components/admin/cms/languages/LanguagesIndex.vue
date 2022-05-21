<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of Languages</h3>
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
                        @click.prevent="addLanguage"
                        :disabled="languages.data.length > 1"
                    >
                        Add Language
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
                                <th class="text-center align-middle no-wrap">Country code</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="8">
                                    <h4 class="text-center my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="languages">
                                <tr v-for="language in languages.data" :key="language.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ language.id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ language.name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ language.country_code }}
                                    </td>

<!--                                    <td class="text-center align-middle">-->
<!--                                        <button-->
<!--                                            class="btn btn-sm btn-block btn-outline-info"-->
<!--                                            v-if="language.id !== 1"-->
<!--                                            @click="editLanguage(language)"-->
<!--                                        >-->
<!--                                            <i class="fas fa-edit"></i>-->
<!--                                        </button>-->
<!--                                    </td>-->

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            v-if="language.id !== 1"
                                            @click="deleteLanguage(language)"
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
                        :data="languages"
                        :limit="1"
                        @pagination-change-page="loadLanguages"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <language-modal :languages="allLanguages"/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import LanguageModal from "./LanguageModal";
import axios from "axios";

export default {
    components: {
        Pagination,
        LanguageModal,
    },
    data() {
        return {
            loading: false,
            languages: null,
            allLanguages: null,
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.languages?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadLanguages();
            }, 250),
        },
    },
    methods: {
        loadLanguages(page = 1) {
            this.loading = true;
            axios
                .get(route("languages.get-active", { page, ...this.filters }))
                .then((response) => {
                    this.languages = response;
                    this.loading = false;
                });
        },
        getAllLanguages(){
            axios.get(route('languages.index')).then((response) => {
                this.allLanguages = response.data;
            });
        },
        addLanguage() {
            Bus.$emit("open-language-modal", null);
        },
        // editLanguage(language) {
        //     Bus.$emit("open-language-modal", language, this.toothbrush_types, this.toothpaste_types);
        // },
        deleteLanguage(id) {
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
                        .delete(route("languages.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Language has been removed successfully.");
                            this.loadLanguages();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadLanguages();
        this.getAllLanguages();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Languages",
        });

        Bus.$on("load-languages", this.loadLanguages);
    },
};
</script>
