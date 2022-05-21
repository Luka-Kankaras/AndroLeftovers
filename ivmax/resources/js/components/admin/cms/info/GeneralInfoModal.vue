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
                                    v-model="form.name"
                                    :form="form"
                                    label="Name *"
                                    name="name"
                                    placeholder="Enter name..." type="text"
                                />
                                <tiny-mce-field
                                    v-model="form.description"
                                    :form="form"
                                    label="Description *"
                                    name="description"
                                    placeholder="Enter description..."
                                    height="200"
                                    :toolbar="'bold italic'"
                                />
                                <select-field
                                    label="Info category *"
                                    name="info_category_id"
                                    placeholder="Choose info category"
                                    :options="infoCategories"
                                    v-model="form.info_category_id"
                                    :form="form"
                                    option-value="id"
                                    option-label="name"
                                    :multiple="false"
                                    :searchable="true"
                                />
                                <file-field
                                    :key="resetField"
                                    name="video"
                                    label="Video"
                                    v-model="form.video"
                                    :form="form"
                                    :placeholder="video_placeholder"
                                />
                                <checkbox-field
                                    v-if="this.info"
                                    name="remove_video"
                                    label="Remove video"
                                    v-model="form.remove_video"
                                    :form="form"
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
import {Form, HasError} from "vform";
import objectToFormData from '@admin/objectToForm';

import TextField from "@admin/forms/TextField";
import SubmitButton from "@admin/forms/SubmitButton";
import TextAreaField from "@admin/forms/TextareaField";
import SelectField from "@admin/forms/SelectField";
import {swalNotification} from "@/utilities";
import FileField from "../../forms/FileField";
import TinyMceField from "../../forms/TinyMceField";
import CheckboxField from "../../forms/CheckboxField";


export default {
    components: {
        TextField,
        SubmitButton,
        TextAreaField,
        SelectField,
        HasError,
        FileField,
        TinyMceField,
        CheckboxField,
    },
    props: ['infoCategories'],
    data() {
        return {
            info: null,
            video: null,
            resetField: null,
            video_placeholder: 'Choose file',
            form: new Form({
                name: '',
                description: '',
                video_path: '',
                video_name: '',
                video_ext: '',
                info_category_id: '',
            }),
        };
    },
    computed: {
        title() {
            return this.tag ? "Edit info" : "Add info";
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
            if (this.info) {
                method = "post"; //put
                path = route("general-info.update", this.info);
                message = "Info has been updated.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("general-info.store");
                message = "Info has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-info");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "An error has occurred.");
                    }
                });
        },
        resetForm() {
            this.resetField += 1;
            this.info = null;
            this.form.reset();
            this.form.errors.clear();
            this.form.video_name = "Choose file";
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);
        Bus.$on("open-info-modal", (info) => {
            if (info) {
                this.info = info;
                this.form.fill(info);
                this.form.video_name ? this.video_placeholder = this.form.video_name : this.video_placeholder = 'Choose file';
                this.video = this.form.video;
            }
            this.showModal();
        });
        Bus.$on("tinymce-input", (e) => {
            this.form.description = e;
        });
    },
};

</script>
