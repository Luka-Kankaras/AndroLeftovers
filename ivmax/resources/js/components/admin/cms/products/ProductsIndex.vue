<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table of Products</h3>
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
<!--                    <button-->
<!--                        class="btn btn-primary mb-2 float-right"-->
<!--                        @click.prevent="addProduct"-->
<!--                    >-->
<!--                        Add Product-->
<!--                        <i class="fas fa-plus-circle ml-1"></i>-->
<!--                    </button>-->
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Name</th>
                                <th class="text-center align-middle no-wrap">Description</th>
                                <th class="text-center align-middle no-wrap">Discount</th>
                                <th class="text-center align-middle no-wrap">Buy url</th>
                                <th class="text-center align-middle no-wrap" style="width: 110px;">Image</th>
                                <th class="text-center align-middle no-wrap" style="width: 110px;">Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="8">
                                    <h4 class="text-center my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="products">
                                <tr v-for="product in products.data" :key="product.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ product.name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ product.description | short }}
                                    </td>
                                    <td class="text-center align-middle no-wrap" v-if="product.discount">
                                        {{ product.discount }}%
                                    </td>
                                    <td class="text-center align-middle no-wrap" v-else>
                                        <i class="fal fa-times-circle text-danger"></i>
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ product.buy_url }}
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-success"
                                            @click="showImage(product.image)"
                                            v-if="product.id !== 2"
                                        >
                                            <i class="fas fa-images"></i>
                                        </button>
                                        <i class="far fa-times-circle text-danger" v-else></i>
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editProduct(product)"
                                        >
                                            <i class="fas fa-edit"></i>
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
                        :data="products"
                        :limit="1"
                        @pagination-change-page="loadProducts"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>

            <product-modal :toothbrush_types="toothbrush_types"
                           :toothpaste_types="toothpaste_types"
                           :colors="colors"
                           :languages="languages"
            />

            <product-gallery/>
            <show-image/>

        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import { swalNotification } from "@/utilities";
import ProductModal from "./ProductModal";
import ProductGallery from "./ProductGallery";
import ShowImage from "../../forms/ShowImage";

export default {
    components: {
        Pagination,
        ProductModal,
        ProductGallery,
        ShowImage,
    },
    data() {
        return {
            loading: false,
            products: null,
            toothbrush_types: [],
            toothpaste_types: [],
            colors: [],
            languages: [],
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.products?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadProducts();
            }, 250),
        },
    },
    methods: {
        loadProducts(page = 1) {
            this.loading = true;
            axios
                .get(route("products.index", { page, ...this.filters }))
                .then((response) => {
                    this.products = response.data;
                    this.loading = false;
                });
        },
        addProduct() {
            Bus.$emit("open-product-modal", null);
        },
        editProduct(product) {
            Bus.$emit("open-product-modal", product, this.toothbrush_types, this.toothpaste_types);
        },
        showImage(image){
            Bus.$emit("show-photo-modal", image);
        },
        getToothbrushTypes(){
            axios.get(route("toothbrush-types.get-all")).then(response => {
                this.toothbrush_types = response.data.data;
            })
        },
        getToothpasteTypes(){
            axios.get(route("toothpaste-types.get-all")).then(response => {
                this.toothpaste_types = response.data.data;
            })
        },
        getColors(){
            axios.get(route("colors.get-all")).then(response => {
                this.colors = response.data.data;
            })
        },
        deleteProduct(id) {
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
                        .delete(route("products.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Product has been deleted successfully.");
                            this.loadProducts();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadProducts();
        this.getToothbrushTypes();
        this.getToothpasteTypes();
        this.getColors();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Products",
        });

        Bus.$on("load-products", this.loadProducts);
    },
};
</script>
