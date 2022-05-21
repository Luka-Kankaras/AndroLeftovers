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
                            <div class="col-3">
                                <text-field
                                    v-model="form.first_name"
                                    :form="form"
                                    label="First name *"
                                    name="first_name"
                                    placeholder="Enter first name..." type="text"
                                />
                            </div>
                            <div class="col-3">
                                <text-field
                                    v-model="form.last_name"
                                    :form="form"
                                    label="Last name *"
                                    name="last_name"
                                    placeholder="Enter last name..." type="text"
                                />
                            </div>
                            <div class="col-3">
                                <text-field
                                    v-model="form.city"
                                    :form="form"
                                    label="City *"
                                    name="city"
                                    placeholder="Enter city..." type="text"
                                />
                            </div>
                            <div class="col-3">
                                <text-field
                                    v-model="form.country"
                                    :form="form"
                                    label="Country *"
                                    name=country
                                    placeholder="Enter country..." type="text"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <image-field
                                    :key="componentKey"
                                    ref="imageUpload"
                                    v-model="form.photo"
                                    :form="form"
                                    :oldImage="oldImage"
                                    label="Photo *"
                                    name="photo"
                                    placeholder="Attach image"
                                />
                            </div>
                            <div class="col-6">
                                <tiny-mce-field
                                    v-model="form.text"
                                    :form="form"
                                    label="Text *"
                                    name="text"
                                    placeholder="Enter text..."
                                    height="500"
                                    :toolbar="'bold italic'"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary float-right" data-dismiss="modal" type="button">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <submit-button :disabled="form.busy" :loading="form.busy" class="float-right ml-2"
                                       text="Save"></submit-button>
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
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";
import TextareaField from "../../forms/TextareaField";
import ImageField from "../../forms/ImageField";
import TinyMceField from "../../forms/TinyMceField";
import SelectField from "../../forms/SelectField";
import NumberField from "../../forms/NumberField";

export default {
    components: {
        ImageField,
        TextareaField,
        SubmitButton,
        TextField,
        TinyMceField,
    },
    data() {
        return {
            testimonial: null,
            oldImage: null,
            componentKey: 0,
            form: new Form({
                first_name: "",
                last_name: "",
                city: "",
                country: "",
                text: "",
                photo: null,
            }),
        };
    },
    computed: {
        title() {
            return this.testimonial ? "Edit testimonial" : "Add testimonial";
        },
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            this.resetForm();
            $(this.$refs.modal).modal("hide");
        },
        submitForm() {
            let method, path, message;
            if (this.testimonial) {
                method = "post"; //put
                path = route("testimonials.update", this.testimonial.id);
                message = "Testimonial has been edited.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("testimonials.store");
                message = "Testimonial has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    if (data.photo === null)
                        data.photo = '';
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-testimonials");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
        resetForm() {
            this.testimonial = null;
            this.form.reset();
            this.form.errors.clear();
            this.oldImage = '';
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", () => {
            this.resetForm();
            this.componentKey += 1;
            this.$refs.imageUpload.imagePreviewUrl = '';
        });

        Bus.$on('removedImage', (img) => {
           this.form.removed_images.push(img);
        });

        Bus.$on("open-testimonials-modal", (testimonial) => {
            if (testimonial) {
                this.testimonial = testimonial;
                this.oldImage = testimonial.photo;
                this.form.fill(this.testimonial);
            }
            this.showModal();
        });
        Bus.$on("tinymce-input", (e) => {
            this.form.text = e;
        });
    },
};

</script>

<style scoped>

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

.img-wrap {
    height: 350px;
    overflow: hidden;
}

.img-wrap img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center;
}

</style>
