<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of FAQ</h3>
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
                        @click.prevent="addFaq"
                    >
                        Add FAQ
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Question</th>
                                <th class="text-center align-middle no-wrap">Answer</th>
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
                            <template v-if="faqs">
                                <tr v-for="faq in faqs.data" :key="faq.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ faq.question | short }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ faq.answer | short }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editFaq(faq)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteFaq(faq)"
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
                        :data="faqs"
                        :limit="1"
                        @pagination-change-page="loadFaqs"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <faq-modal/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import FaqModal from "./FaqModal";

export default {
    components: {
        FaqModal,
        Pagination,
    },
    data() {
        return {
            loading: false,
            faqs: null,
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.faqs?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadFaqs();
            }, 250),
        },
    },
    methods: {
        loadFaqs(page = 1) {
            this.loading = true;
            axios
                .get(route("faqs.index", { page, ...this.filters }))
                .then((response) => {
                    this.faqs = response.data;
                    this.loading = false;
                });
        },
        addFaq() {
            Bus.$emit("open-faq-modal", null);
        },
        editFaq(faq) {
            Bus.$emit("open-faq-modal", faq);
        },
        deleteFaq(id) {
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
                        .delete(route("faqs.destroy", id))
                        .then((response) => {
                            swalNotification("success", "FAQ has been deleted successfully.");
                            this.loadFaqs();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadFaqs();
        this.$emit("loadBreadcrumbLink", {
            pageName: "FAQ",
        });

        Bus.$on("load-faqs", this.loadFaqs);
    },
};
</script>
