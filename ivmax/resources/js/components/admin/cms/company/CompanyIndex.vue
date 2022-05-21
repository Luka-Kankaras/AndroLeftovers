<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mr-2 mb-2 mb-sm-0">About us</h3>
                </div>
                <div class="card-body">
                    <div v-if="loading" class="loading-indicator">
                        <div class="spinner"></div>
                    </div>
                    <form @submit.prevent="submitForm">
                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="form-group">
                                    <tiny-mce-field
                                        v-model="form.section_1"
                                        :form="form"
                                        label="Section 1 *"
                                        name="section_1"
                                        placeholder="Enter text..."
                                        height="200"
                                        :toolbar="'bold italic'"
                                        :event="'event-section-1'"
                                    />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <tiny-mce-field
                                        v-model="form.section_1_bold"
                                        :form="form"
                                        label="Section 1 (bold)"
                                        name="section_1_bold"
                                        placeholder="Enter text..."
                                        height="200"
                                        :toolbar="'bold italic'"
                                        :event="'event-section-1-bold'"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6">
                                <image-field
                                    ref="imageUpload"
                                    v-model="form.photo_1"
                                    :form="form"
                                    :preview="false"
                                    label="Section 1 image *"
                                    name="photo_1"
                                    placeholder="Attach image"
                                />
                            </div>
                            <div class="col-6">
                                <image-field
                                    ref="imageUpload"
                                    v-model="form.photo_2"
                                    :form="form"
                                    :preview="false"
                                    label="Section 2 image *"
                                    name="photo_2"
                                    placeholder="Attach image"
                                />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <tiny-mce-field
                                        v-model="form.section_2"
                                        :form="form"
                                        label="Section 2 *"
                                        name="section_2"
                                        placeholder="Enter text..."
                                        height="200"
                                        :toolbar="'bold italic'"
                                        :event="'event-section-2'"
                                    />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success ml-2" @click="showCoverPhoto(form.photo_1)">
                            <i class="fas fa-eye mr-2"></i> Show photo 1
                        </button>
                        <button type="button" class="btn btn-success ml-2" @click="showCoverPhoto(form.photo_2)">
                            <i class="fas fa-eye mr-2"></i> Show photo 2
                        </button>
                        <submit-button :disabled="form.busy" :loading="form.busy" class="float-right ml-2"
                                       text="Save"></submit-button>
                    </form>
                </div>
            </div>
        </div>

        <show-image/>

    </div>
</template>


<script>
import {Form} from "vform";
import objectToFormData from '@admin/objectToForm';
import TextField from "@admin/forms/TextField";
import TextAreaField from "@admin/forms/TextareaField";
import ImageField from "@admin/forms/ImageField";
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";
import ShowImage from "../../forms/ShowImage";
import TinyMceField from "../../forms/TinyMceField";

export default {
    name: "CompanyInfo",
    components: {
        SubmitButton,
        ImageField,
        TextField,
        TextAreaField,
        ShowImage,
        TinyMceField,
    },
    data() {
        return {
            oldImage: "",
            activeLanguage: 'EN',
            languages: [],
            form: new Form({
                section_1: '',
                section_1_bold: '',
                section_2: '',
                photo_1: null,
                photo_2: null,
            }),
            loading: true,
        }
    },
    methods: {
        loadCompanyInfo() {
            this.loading = true;
            axios
                .get(route("company.index"))
                .then((response) => {
                    this.form.fill(response.data);
                    this.loading = false;
                });
        },
        setActiveLanguage(lang) {
            this.activeLanguage = lang;
        },
        submitForm() {
            let method, path, message;
            method = "post"; //put
            path = route("company.update", 1);
            message = "Information edited successfully.";
            this.form._method = 'put';

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.loadCompanyInfo();
                    swalNotification("success", message);
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
        companyGallery() {
            Bus.$emit("open-company-images-modal", 1);
        },
        showCoverPhoto(photo){
            Bus.$emit('show-photo-modal', photo);
        }
    },
    mounted() {
        this.loadCompanyInfo();
        this.$emit("loadBreadcrumbLink", {
            pageName: "About us",
        });
        Bus.$on("event-section-1", (e) => {
            this.form.section_1 = e;
        });
        Bus.$on("event-section-1-bold", (e) => {
            this.form.section_1_bold = e;
        });
        Bus.$on("event-section-2", (e) => {
            this.form.section_2 = e;
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
