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
                <form @submit.prevent="setActiveLang">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <select-field
                                    label="Tags *"
                                    type="text"
                                    name="language"
                                    placeholder="Chose language"
                                    :options="languages"
                                    v-model="form.language"
                                    :form="form"
                                    option-value="id"
                                    option-label="name"
                                    :multiple="false"
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

import Swal from "sweetalert2";
import { swalNotification } from "@/utilities";
import {Form} from "vform";
import TextField from "@admin/forms/TextField";
import SubmitButton from "@admin/forms/SubmitButton";
import SelectField from "../../forms/SelectField";
import axios from "axios";

export default {
    components: {
        TextField,
        SubmitButton,
        SelectField,
    },
    data() {
        return {
            language: null,
            form: new Form({
                language: null,
            }),
        };
    },
    props: ['languages'],
    computed: {
        title() {
            return this.language ? "Edit language" : "Add language";
        },
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            $(this.$refs.modal).modal("hide");
        },
        // submitForm() {
        //     let method, path, message;
        //     if (this.language) {
        //         method = "post"; //put
        //         path = route("languages.update", this.language);
        //         message = "Language has been updated.";
        //         this.form._method = 'put';
        //     } else {
        //         method = "post";
        //         path = route("languages.store");
        //         message = "Language has been added.";
        //     }
        //
        //     this.form.submit(method, (path), {
        //         transformRequest: [function (data, headers) {
        //             return objectToFormData(data)
        //         }]
        //     })
        //         .then((response) => {
        //             this.hideModal();
        //             Bus.$emit("load-languages");
        //             swalNotification("success", message);
        //         })
        //         .catch((error) => {
        //             if (error.response.status !== 422) {
        //                 swalNotification("error", "An error has occurred.");
        //             }
        //         });
        // },
        setActiveLang(){
            axios.post(route('languages.set-active'), this.form).then((response) => {
                this.hideModal();
                Bus.$emit("load-languages");
                swalNotification("success", message);
            });
        },
        resetForm() {
            this.language = null;
            this.form.reset();
            this.form.errors.clear();
            this.activeLanguage = 'EN';
        },
        // https://flourish.amplitudo.me
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);
        Bus.$on("open-language-modal", (language) => {
            console.log(this.languages);
            if (language) {
                this.language = language;
                this.form.fill(this.language);
            }
            this.showModal();
        });
    },
};

</script>

<style>

.btn:focus {
    background-color: #17a2b8;
    box-shadow: none;
    border-color: #17a2b8;
}

</style>
