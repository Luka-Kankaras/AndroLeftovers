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
                            <div class="col-lg-6">
                                <text-field
                                    v-model="form.title"
                                    :form="form"
                                    label="Title *"
                                    name="title"
                                    placeholder="Enter title..." type="text"
                                />
                                <image-field
                                    :key="componentKey"
                                    ref="imageUpload"
                                    v-model="form.thumbnail"
                                    :form="form"
                                    :oldImage="oldImage"
                                    label="Thumbnail *"
                                    name="thumbnail"
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
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <select-field
                                    label="Tags"
                                    type="text"
                                    name="tags[]"
                                    placeholder="Choose tags"
                                    :options="tags"
                                    v-model="form.tags"
                                    :form="form"
                                    option-value="id"
                                    option-label="name"
                                    :multiple="true"
                                    :searchable="true"
                                />
                            </div>
                            <div class="col-3">
                                <number-field
                                    label="Time to read (minutes) *"
                                    name="time_to_read"
                                    placeholder="Enter time..."
                                    v-model="form.time_to_read" :form="form"
                                />
                            </div>
                            <div class="col-3">
                                <select-field
                                    label="Author *"
                                    type="text"
                                    name="team_id"
                                    placeholder="Choose author"
                                    :options="team"
                                    v-model="form.team_id"
                                    :form="form"
                                    option-value="id"
                                    option-label="name"
                                    :multiple="false"
                                    :searchable="true"
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
        SelectField,
        NumberField,
    },
    props: ['tags', 'team'],
    data() {
        return {
            post: null,
            oldImage: null,
            componentKey: 0,
            form: new Form({
                removed_images: [],
                title: "",
                text: "",
                thumbnail: null,
                time_to_read: 0,
                tags: [],
                team_id: '',
            }),
        };
    },
    computed: {
        title() {
            return this.post ? "Edit post" : "Add post";
        },
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            this.resetForm();
            // this.$refs.imageUpload.imagePreviewUrl = '';
            $(this.$refs.modal).modal("hide");
        },
        submitForm() {
            let method, path, message;
            if (this.post) {
                method = "post"; //put
                path = route("posts.update", this.post.id);
                message = "Post has been edited.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("posts.store");
                message = "Post has been added.";
            }

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    if (data.thumbnail === null)
                        data.thumbnail = '';
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-posts");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
        resetForm() {
            this.post = null;
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

        Bus.$on("open-posts-modal", (post) => {
            if (post) {
                this.post = post;
                this.oldImage = post.thumbnail;
                this.form.fill(this.post);
                this.form.removed_images = [];
                this.form.tags = [...post.tags.flatMap(item => (item.id))];
            }
            this.showModal();
        });
        Bus.$on("tinymce-input", (e) => {
            this.form.text = e;
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
