<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of subscribers</h3>
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
                        class="btn btn-sm btn-success mb-3 float-right"
                        style="width: 120px"
                        @click="exportSubscribers()"
                    >
                        Export
                        <i class="fas fa-file-export ml-2"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">ID</th>
                                <th class="text-center align-middle no-wrap">Email</th>
                                <th class="text-center align-middle no-wrap">Subscribed since</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="4">
                                    <h4 class="text-center mb-0 my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="subscribers">
                                <tr v-for="color in subscribers.data" :key="color.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ color.id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ color.email }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ color.subscribed_since }}
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
                        :data="subscribers"
                        :limit="1"
                        @pagination-change-page="loadSubscribers"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";

export default {
    components: {
        Pagination,
    },
    data() {
        return {
            loading: false,
            subscribers: null,
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.subscribers?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadSubscribers();
            }, 250),
        },
    },
    methods: {
        loadSubscribers(page = 1) {
            this.loading = true;
            axios
                .get(route("newsletter.index", { page, ...this.filters }))
                .then((response) => {
                    this.subscribers = response.data;
                    this.loading = false;
                });
        },
        exportSubscribers(){
            this.loading = true;
            axios
                .get(route("newsletter.export"))
                .then((response) => {
                    let link = document.createElement('a');
                    link.href = response.data;
                    link.target = '_blank'
                    link.download = "subscribers.xlsx";
                    link.click();
                    this.loading = false;
                });
        }
    },
    mounted() {
        this.loadSubscribers();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Subscribers",
        });

        Bus.$on("load-subscribers", this.loadSubscribers);
    },
};
</script>
