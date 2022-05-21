<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Tabela examples</h3>
                    <div class="float-sm-right">
                        <input
                                class="form-control form-control-sm"
                                type="text"
                                placeholder="Pretraga"
                                aria-label="Search"
                                v-model="filters.term"
                        />
                    </div>
                </div>
                <div class="card-body">
                    <button
                            class="btn btn-primary mb-2 float-right"
                            @click.prevent="addExample"
                    >
                        Dodaj example
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Naziv</th>
                                <th class="text-center align-middle no-wrap">Kategorija</th>
                                <th class="text-center align-middle no-wrap">Datum objave</th>
                                <th class="text-center align-middle no-wrap">Vrijeme objave</th>
                                <th class="text-center align-middle no-wrap">Izmijeni</th>
                                <th class="text-center align-middle no-wrap">Izbriši</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="7">
                                    <h4 class="text-center mb-0">Nema rezultata</h4>
                                </td>
                            </tr>
                            <template v-if="examples">
                                <tr v-for="example in examples.data" :key="example.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ example.title }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ example.category_id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ example.publication_date }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ example.publication_time }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                                class="btn btn-sm btn-info"
                                                @click="editExample(example)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                                class="btn btn-sm btn-danger"
                                                @click="deleteExample(example.id)"
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
                            :data="examples"
                            :limit="1"
                            @pagination-change-page="loadExamples"
                            show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <example-modal />
        </div>
    </div>
</template>

<script>
    import Swal from "sweetalert2";
    import debounce from "lodash/debounce";
    import Pagination from "laravel-vue-pagination";
    import ExampleModal from "@admin/examples/ExampleModal";
    import { swalNotification } from "@/utilities";

    export default {
        components: {
            ExampleModal,
            Pagination,
        },
        data() {
            return {
                loading: false,
                examples: null,
                filters: {
                    term: "",
                },
            };
        },
        computed: {
            resultsCount() {
                return this.examples?.data?.length;
            },
        },
        watch: {
            filters: {
                deep: true,
                immediate: false,
                handler: debounce(function (value) {
                    this.loadExamples();
                }, 250),
            },
        },
        methods: {
            loadExamples(page = 1) {
                this.loading = true;
                axios
                    .get(route("examples.index", { page, ...this.filters }))
                    .then((response) => {
                        this.examples = response.data;
                        this.loading = false;
                    });
            },
            addExample() {
                Bus.$emit("open-example-modal", null);
            },
            editExample(example) {
                Bus.$emit("open-example-modal", example);
            },
            deleteExample(id) {
                Swal.fire({
                    icon: "warning",
                    title: "Brisanje!",
                    text: "Da li ste sigurni da želite da nastavite?",
                    showCancelButton: true,
                    cancelButtonColor: "#3085d6",
                    confirmButtonColor: "#c82333",
                    cancelButtonText: "Otkaži",
                    confirmButtonText: "Izbriši",
                }).then((result) => {
                    if (result.value) {
                        axios
                            .delete(route("examples.destroy", id))
                            .then((response) => {
                                swalNotification("success", "Example je uspješno izbrisan.");
                                this.loadExamples();
                            })
                            .catch(() => {
                                Swal.fire("Neuspješno!", "Došlo je do greške", "warning");
                            });
                    }
                });
            },
        },
        mounted() {
            this.loadExamples();

            this.$emit("loadBreadcrumbLink", {
                pageName: "Examples",
            });

            Bus.$on("load-examples", this.loadExamples);
        },
    };
</script>
