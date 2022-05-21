<template>
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="Product images modal"
        aria-hidden="true"
        ref="modal"
    >
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4">
                        <div
                            class="col mb-4"
                            v-for="(image, index) in productImages"
                            :key="image.id"
                        >
                            <div class="image-wrapper-gallery">
                                <img
                                    :src="image.file_path"
                                    alt="Product image"
                                />
                                <div class="order-btns">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-info"
                                        :disabled="image.order_number === 1"
                                        @click.prevent="updateOrder(image, 'moveOrderUp')"
                                    >
                                        <i class="fas fa-arrow-left"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-info ml-1"
                                        :disabled="image.order_number === max_order"
                                        @click.prevent="updateOrder(image, 'moveOrderDown')"
                                    >
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                                <button
                                    class="btn btn-sm btn-danger delete-btn"
                                    @click="deleteCompanyImage(image)"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="submitForm" ref="myForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <multiple-image-field
                                    label="Add photo(s)"
                                    name="image"
                                    v-model="form.image"
                                    :form="form"
                                    :isMultiple="true"
                                ></multiple-image-field>

                            </div>
                            <div class="col-12">
                                <submit-button
                                    text="Save"
                                    :disabled="form.busy"
                                    :loading="form.busy"
                                ></submit-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { swalNotification } from "@/utilities";
import { Form } from "vform";
import CoolLightBox from "vue-cool-lightbox";
import ImageField from "@admin/forms/ImageField";
import SubmitButton from "@admin/forms/SubmitButton";
import objectToFormData from '@admin/objectToForm';
import {confirmAction} from "@/utilities";
import MultipleImageField from "@admin/forms/MultipleImageField";


export default {
    components: {
        ImageField,
        SubmitButton,
        CoolLightBox,
        MultipleImageField,
    },
    data() {
        return {
            slide: null,
            product: null,
            order_numbers: null,
            max_order: null,
            productImages: [],
            form: new Form({
                image: [],
                model: "",
                currObjID: null
            }),
        };
    },
    computed: {
        title() {
            return this.productImages?.length
                ? "Edit product gallery"
                : "Add image to product gallery";
        },
        imageLinks() {
            return this.productImages.map((image) => image.file_path);
        },
    },
    watch: {
        slide() {
            if (this.slide) {
                $(this.$refs.modal).data("bs.modal")._config.keyboard = false;
                $(this.$refs.modal).data("bs.modal")._config.backdrop = "static";
            } else {
                $(this.$refs.modal).data("bs.modal")._config.keyboard = true;
                $(this.$refs.modal).data("bs.modal")._config.backdrop = true;
            }
        },
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            $(this.$refs.modal).modal("hide");
        },
        getCompanyImages() {
            axios
                .get(route("models.images.index", this.product), { params: { model_name:  'Company' } })
                .then((response) => {
                    this.max_order = response.data.max_order;
                    this.productImages = response.data.images;
                    this.form.model = 'Company';
                    this.form.currObjID = this.product;
                });
        },
        submitForm() {
            let method, path, message;
            method = "post";
            path = route("models.images.store", this.product);
            message = "Company gallery has been updated.";

            this.form.submit(method,(path),{
                transformRequest: [function(data, headers){
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    swalNotification("success", message);
                    this.getCompanyImages(this.product);
                    Bus.$emit('images-added');
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "An error has occurred.");
                    }
                });

        },
        updateOrder(image, method) {
            axios
                .post(route("images.update-order", image), {method})
                .then((respnse) => {
                    this.getCompanyImages();
                });
        },
        deleteCompanyImage(image) {
            confirmAction().then(() => {
                axios
                    .delete(route("models.images.destroy", [this.product, image, 'Company']))
                    .then((response) => {
                        swalNotification("success", "Photo has been deleted successfully!");
                        this.getCompanyImages();
                    });
            });
        },
        resetForm() {
            this.product = null;
            this.productImages = [];
            this.form.reset();
            this.form.errors.clear();
            this.slide = null;
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", () => {
            this.resetForm;
            // location.reload();
        });

        Bus.$on("open-company-images-modal", (product) => {
            this.form.model = "Company";
            this.form.currObjID = product;
            this.product = product;
            if (this.product) {
                this.getCompanyImages();
            }
            this.showModal();
        });
    },
};
</script>
