<template>
    <div class="modal fade" id="announcement-modal" tabindex="-1" role="dialog" aria-labelledby="Restaurant modal"
         aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title mr-3">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <text-field
                                    type="text"
                                    name="name"
                                    placeholder="Enter category name..."
                                    v-model="form.name"
                                    :form="form"
                                    label="Name *"
                                />
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
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";

export default {
    props: ['languages'],
    components: {
        TextField,
        SubmitButton,
    },
    data() {
        return {
            infoCategory: null,
            form: new Form({
                name: '',
            }),
        };
    },
    computed: {
        title() {
            return this.infoCategory ? "Edit info category" : "Add info category";
        },
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            $(this.$refs.modal).modal("hide");
        },
        submitForm() {
            let method, path, message;
            if (this.infoCategory) {
                method = "post"; //put
                path = route("info-category.update", this.infoCategory);
                message = "Info category has been updated.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("info-category.store");
                message = "Info category has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-infoCategories");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "An error has occurred.");
                    }
                });
        },
        resetForm() {
            this.infoCategory = null;
            this.form.reset();
            this.form.errors.clear();
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);
        Bus.$on("open-infoCategory-modal", (infoCategory) => {
            if (infoCategory) {
                this.infoCategory = infoCategory;
                this.form.fill(infoCategory);
            }
            this.showModal();
        });
    },
};

</script>
