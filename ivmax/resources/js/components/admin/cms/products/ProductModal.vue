<template>
    <div id="example-modal" ref="modal" aria-hidden="true" aria-labelledby="Example modal" class="modal fade"
         role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div :class="product && product.id !== 2 ? 'col-6' : 'col-12'">
                                        <text-field
                                            label="Name *"
                                            type="text"
                                            name="name"
                                            placeholder="Enter product name..."
                                            v-model="form.name" :form="form"
                                        />
                                    </div>
                                    <div class="col-6" v-if="product &&  product.id !== 2">
                                        <image-field
                                            v-model="form.image"
                                            :form="form"
                                            label="Image *"
                                            name="image"
                                            placeholder="Attach image"
                                            :preview="false"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea-field
                                            label="Description *"
                                            type="text"
                                            name="description"
                                            placeholder="Enter product description..."
                                            v-model="form.description" :form="form"
                                        />
                                    </div>
                                </div>
                                <div class="row" v-if="product &&  product.id !== 2">
                                    <div class="col-12">
                                        <number-field
                                            label="Discount"
                                            name="discount"
                                            placeholder="Enter product discount..."
                                            v-model="form.discount" :form="form"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <text-field
                                            label="Buy url *"
                                            type="text"
                                            name="buy_url"
                                            placeholder="Enter product buy url..."
                                            v-model="form.buy_url" :form="form"
                                        />
                                    </div>
                                </div>
                                <div class="row" v-if="product &&  product.id === 1">
                                    <div class="col-4">
                                        <number-field
                                            label="Ivmax toothbrush"
                                            name="ivmax_toothbrush_count"
                                            placeholder="Enter amount..."
                                            v-model="form.ivmax_toothbrush_count" :form="form"
                                        />
                                    </div>
                                    <div class="col-4">
                                        <number-field
                                            label="Brush head"
                                            name="brush_head_count"
                                            placeholder="Enter amount..."
                                            v-model="form.brush_head_count" :form="form"
                                        />
                                    </div>
                                    <div class="col-4">
                                        <number-field
                                            label="Toothpaste cartridges"
                                            name="toothpaste_cartridges_count"
                                            placeholder="Enter amount..."
                                            v-model="form.toothpaste_cartridges_count" :form="form"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <select-field
                                            v-if="product &&  product.id === 1"
                                            label="Toothbrush types"
                                            type="text"
                                            name="toothbrush_types[]"
                                            placeholder="Choose toothbrush types"
                                            :options="toothbrush_types"
                                            v-model="form.toothbrushTypes"
                                            :form="form"
                                            option-value="id"
                                            option-label="name"
                                            :multiple="true"
                                            :searchable="true"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <select-field
                                            v-if="product &&  product.id === 4"
                                            label="Toothpaste types"
                                            type="text"
                                            name="toothpaste_types[]"
                                            placeholder="Choose toothpaste types"
                                            :options="toothpaste_types"
                                            v-model="form.toothpasteTypes"
                                            :form="form"
                                            option-value="id"
                                            option-label="name"
                                            :multiple="true"
                                            :searchable="true"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <select-field
                                            v-if="product &&  product.id === 1"
                                            label="Toothbrush colors"
                                            type="text"
                                            name="toothbrush_colors[]"
                                            placeholder="Choose toothbrush colors"
                                            :options="colors"
                                            v-model="form.toothbrushColors"
                                            :form="form"
                                            option-value="id"
                                            option-label="name"
                                            :multiple="true"
                                            :searchable="true"
                                        />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <select-field
                                            v-if="product &&  product.id === 3"
                                            label="Toothbrush head colors"
                                            type="text"
                                            name="toothbrush_head_colors[]"
                                            placeholder="Choose toothbrush head colors"
                                            :options="colors"
                                            v-model="form.toothbrushHeadColors"
                                            :form="form"
                                            option-value="id"
                                            option-label="name"
                                            :multiple="true"
                                            :searchable="true"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <submit-button class="float-right ml-2" text="Save" :disabled="form.busy"
                                       :loading="form.busy"></submit-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {Form} from "vform";
import objectToFormData from '@admin/objectToForm';

import TextField from "@admin/forms/TextField";
import TextareaField from "@admin/forms/TextareaField";
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";
import NumberField from "../../forms/NumberField";
import SelectField from "../../forms/SelectField";
import axios from "axios";
import ImageField from "../../forms/ImageField";

export default {
    components: {
        NumberField,
        TextField,
        TextareaField,
        SelectField,
        SubmitButton,
        ImageField,
    },
    props: ['toothbrush_types', 'toothpaste_types', 'colors', 'languages'],
    data() {
        return {
            product: null,
            componentKey: 0,
            form: new Form({
                id: '',
                name: '',
                description: '',
                price: '',
                discount: '',
                image: '',
                buy_url: '',
                color_id: '',
                ivmax_toothbrush_count: '',
                brush_head_count: '',
                toothpaste_cartridges_count: '',
                toothbrushTypes: '',
                toothpasteTypes: '',
                toothbrushColors: '',
                toothbrushHeadColors: '',
            }),
        };
    },
    computed: {
        title() {
            return this.product ? `Edit product - ${this.product.name}` : "Add product";
        },
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            $(this.$refs.modal).modal("hide");
        },
        setActiveLanguage(lang){
            this.activeLanguage = lang;
        },
        getProduct(product){
            axios.get(route('products.show', product.id)).then((response) => {
                this.product = response.data[0];
            });
        },
        submitForm() {
            let method, path, message;
            if (this.product) {
                method = "post"; //put
                path = route("products.update", this.product);
                message = "Product has been updated.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("products.store");
                message = "Product has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-products");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "An error has occurred.");
                    }
                });
        },
        fillForm(product){
            this.form.fill(product);
            this.form.toothbrushTypes = [...product.toothbrush_types.flatMap(item => (item.id))];
            this.form.toothpasteTypes = [...product.toothpaste_types.flatMap(item => (item.id))];
            this.form.toothbrushColors = [...product.toothbrush_colors.flatMap(item => (item.id))];
            this.form.toothbrushHeadColors = [...product.toothbrush_head_colors.flatMap(item => (item.id))];
        },
        resetForm() {
            this.product = null;
            this.form.reset();
            this.form.errors.clear();
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);
        Bus.$on("open-product-modal", (product) => {
            if (product) {
                this.product = product;
                this.fillForm(product);
                if (!this.form.discount)
                    this.form.discount = 0;
            }
            this.showModal();
        });
    },
};

</script>

<style>

.multiselect__tag {
    color: white;
    background-color: #17a2b8;
    font-size: 80%;
}

.multiselect__tag-icon {
    line-height: 1.45rem;
}

.btn:focus {
    background-color: #17a2b8;
    box-shadow: none;
    border-color: #17a2b8;
}

</style>
