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
                                    label="Name *"
                                    type="text"
                                    name="name"
                                    placeholder="Enter tag name..."
                                    v-model="form.name" :form="form"
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
    components: {
        TextField,
        SubmitButton,
    },
    data() {
        return {
            tag: null,
            form: new Form({
                name: '',
            }),
        };
    },
    props: ['languages'],
    computed: {
        title() {
            return this.tag ? "Edit tag" : "Add tag";
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
            if (this.tag) {
                method = "post"; //put
                path = route("tags.update", this.tag);
                message = "Tag has been updated.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("tags.store");
                message = "Tag has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-tags");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "An error has occurred.");
                    }
                });
        },
        resetForm() {
            this.tag = null;
            this.form.reset();
            this.form.errors.clear();
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);
        Bus.$on("open-tag-modal", (tag) => {
            if (tag) {
                this.tag = tag
                this.form.fill(tag);
            }
            this.showModal();
        });
    },
};

</script>
