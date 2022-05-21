<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mr-2 mb-2 mb-sm-0">Homepage info</h3>
                </div>
                <div class="card-body">
                    <div v-if="loading" class="loading-indicator">
                        <div class="spinner"></div>
                    </div>
                    <form @submit.prevent="submitForm">
                        <div class="form-group">
                            <div class="row mb-1">
                                <div class="col-6">
                                    <text-field
                                        v-model="form.title"
                                        :form="form"
                                        label="Title *"
                                        name="title"
                                        placeholder="Enter title..." type="text"
                                    />
                                </div>
                                <div class="col-6">
                                    <text-field
                                        v-model="form.subtitle"
                                        :form="form"
                                        label="Subtitle *"
                                        name="subtitle"
                                        placeholder="Enter title..." type="text"
                                    />
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-3">
                                    <image-field
                                        ref="imageUpload"
                                        v-model="form.thumbnail_big"
                                        :form="form"
                                        :preview="false"
                                        label="Cover photo (big screen) *"
                                        name="thumbnail_big"
                                        placeholder="Attach image"
                                    />
                                </div>
                                <div class="col-3">
                                    <image-field
                                        ref="imageUpload"
                                        v-model="form.thumbnail_small"
                                        :form="form"
                                        :preview="false"
                                        label="Cover photo (small screen) *"
                                        name="thumbnail_small"
                                        placeholder="Attach image"
                                    />
                                </div>
                                <div class="col-6">
                                    <file-field
                                        name="video"
                                        label="Photo or Video *"
                                        v-model="form.photo_or_video"
                                        v-if="info"
                                        :form="form"
                                        :placeholder="info.video_name"
                                    />
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-6">
                                    <text-area-field
                                        v-model="form.text_1"
                                        :form="form"
                                        label="Text 1 *"
                                        name="text"
                                        placeholder="Enter text..."
                                        rows="3"
                                    />
                                </div>
                                <div class="col-6">
                                    <text-area-field
                                        v-model="form.text_2"
                                        :form="form"
                                        label="Text 2 (bold) *"
                                        name="text"
                                        placeholder="Enter text..."
                                        rows="3"
                                    />
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-12">
                                    <text-area-field
                                        v-model="form.ivmax_anatomy"
                                        :form="form"
                                        label="Ivmax anatomy *"
                                        name="ivmax_anatomy"
                                        placeholder="Enter text..."
                                        rows="3"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <text-area-field
                                        v-model="form.feature_1"
                                        :form="form"
                                        label="Feature 1 *"
                                        name="feature_1"
                                        placeholder="Enter text..."
                                        rows="6"
                                    />
                                </div>
                                <div class="col-3">
                                    <text-area-field
                                        v-model="form.feature_2"
                                        :form="form"
                                        label="Feature 2 *"
                                        name="feature_2"
                                        placeholder="Enter text..."
                                        rows="6"
                                    />
                                </div>
                                <div class="col-3">
                                    <text-area-field
                                        v-model="form.feature_3"
                                        :form="form"
                                        label="Feature 3 *"
                                        name="feature_3"
                                        placeholder="Enter text..."
                                        rows="6"
                                    />
                                </div>
                                <div class="col-3">
                                    <text-area-field
                                        v-model="form.feature_4"
                                        :form="form"
                                        label="Feature 4 *"
                                        name="feature_4"
                                        placeholder="Enter text..."
                                        rows="6"
                                    />
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-6">
                                    <text-area-field
                                        v-model="form.annual_text_1"
                                        :form="form"
                                        label="Annual text 1 *"
                                        name="annual_text_1"
                                        placeholder="Enter text..."
                                        rows="3"
                                    />
                                </div>
                                <div class="col-6">
                                    <text-area-field
                                        v-model="form.annual_text_2"
                                        :form="form"
                                        label="Annual text 2 *"
                                        name="annual_text_2"
                                        placeholder="Enter text..."
                                        rows="3"
                                    />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-warning" @click="showPhoto(info.photo_or_video)" v-if="info ? isAnnualPhoto(info) : ''">
                            <i class="fas fa-eye mr-2"></i> Show photo (Annual plan)
                        </button>
                        <button type="button" class="btn btn-success" @click="showVideo(info)" v-else>
                            <i class="fas fa-eye mr-2"></i> Show video (Annual plan)
                        </button>
                        <button type="button" class="btn btn-warning ml-2" @click="showPhoto(info.thumbnail_big)">
                            <i class="fas fa-eye mr-2"></i> Show photo (big screen)
                        </button>
                        <button type="button" class="btn btn-warning ml-2" @click="showPhoto(info.thumbnail_small)">
                            <i class="fas fa-eye mr-2"></i> Show photo (small screen)
                        </button>
                        <submit-button :disabled="form.busy" :loading="form.busy" class="float-right ml-2"
                                       text="Save"></submit-button>
                    </form>
                </div>
            </div>
        </div>

        <show-image/>
        <show-video/>

    </div>


</template>


<script>

import {Form} from "vform";
import objectToFormData from '@admin/objectToForm';
import TextField from "@admin/forms/TextField";
import TextAreaField from "@admin/forms/TextareaField";
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";
import FileField from "../../forms/FileField";
import ShowVideo from "../../forms/ShowVideo";
import ImageField from "../../forms/ImageField";
import ShowImage from "../../forms/ShowImage";

export default {
    name: "HomepageInfo",
    components: {
        SubmitButton,
        TextField,
        TextAreaField,
        FileField,
        ShowVideo,
        ImageField,
        ShowImage,
    },
    data() {
        return {
            info: null,
            form: new Form({
                title: '',
                subtitle: '',
                text_1: '',
                text_2: '',
                ivmax_anatomy: '',
                feature_1: '',
                feature_2: '',
                feature_3: '',
                feature_4: '',
                annual_text_1: '',
                annual_text_2: '',
                photo_or_video: '',
                video_name: '',
                video_ext: '',
                thumbnail: null,
            }),
            loading: true,
        }
    },
    methods: {
        loadHomepageInfo() {
            this.loading = true;
            axios
                .get(route("homepage.index"))
                .then((response) => {
                    this.info = response.data;
                    this.form.fill(this.info);
                    this.loading = false;
                });
        },
        submitForm() {
            let method, path, message;
            method = "post"; //put
            path = route("homepage.update", 1);
            message = "Homepage edited successfully.";
            this.form._method = 'put';

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.loadHomepageInfo();
                    swalNotification("success", message);
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
        showVideo(info){
            Bus.$emit('show-video-modal', info);
        },
        showPhoto(photo){
            Bus.$emit('show-photo-modal', photo);
        },
        isAnnualPhoto(info){
            console.log(info);
            return info.video_ext === 'jpg' || info.video_ext === 'jpeg' || info.video_ext === 'png';
        }
    },
    mounted() {
        this.loadHomepageInfo();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Homepage info",
        });
    },

}

</script>
<style scoped>
.btn:focus {
    background-color: #17a2b8;
    box-shadow: none;
    border-color: #17a2b8;
}
</style>
