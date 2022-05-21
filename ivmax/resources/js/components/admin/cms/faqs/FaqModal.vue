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
                                <textarea-field
                                    name="question"
                                    placeholder="Enter question..."
                                    label="Question *"
                                    v-model="form.question" :form="form"
                                    rows="2"
                                />
                                <textarea-field
                                    label="Answer *"
                                    name="answer"
                                    placeholder="Enter answer..."
                                    rows="4"
                                    v-model="form.answer" :form="form"
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
import TextareaField from "../../forms/TextareaField";

export default {
    components: {
        TextareaField,
        TextField,
        SubmitButton,
    },
    data() {
        return {
            faq: null,
            form: new Form({
                question: '',
                answer: '',
            }),
        };
    },
    computed: {
        title() {
            return this.faq ? "Edit FAQ" : "Add FAQ";
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
            if (this.faq) {
                method = "post"; //put
                path = route("faqs.update", this.faq);
                message = "FAQ has been updated.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("faqs.store");
                message = "FAQ has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-faqs");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "An error has occurred.");
                    }
                });
        },
        resetForm() {
            this.faq = null;
            this.form.reset();
            this.form.errors.clear();
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);
        Bus.$on("open-faq-modal", (faq) => {

            if (faq) {
                this.faq = faq;
                this.form.fill(faq);
            }

            this.showModal();
        });
    },
};

</script>
