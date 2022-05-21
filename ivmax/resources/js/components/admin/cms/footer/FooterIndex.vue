<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mr-2 mb-2 mb-sm-0">Footer info</h3>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="card-body">
                        <div v-if="loading" class="loading-indicator">
                            <div class="spinner"></div>
                        </div>
                        <div class="form-group">
                            <text-field
                                v-model="form.company_name"
                                :form="form"
                                label="Company name *"
                                name="company_name"
                                placeholder="Enter text..." type="text"
                            />
                            <text-field
                                v-model="form.address"
                                :form="form"
                                label="Address *"
                                name="address"
                                placeholder="Enter text..." type="text"
                            />
                            <text-field
                                v-model="form.phone_number"
                                :form="form"
                                label="Phone number *"
                                name="phone_number"
                                placeholder="Enter text..." type="text"
                            />
                            <text-field
                                v-model="form.email"
                                :form="form"
                                label="Email *"
                                name="email"
                                placeholder="Enter text..." type="text"
                            />
                            <file-field
                                name="terms_and_conditions"
                                label="Terms and conditions *"
                                v-model="form.terms_and_conditions"
                                :form="form"
                                :placeholder="termsPlaceholder"
                            />
                            <file-field
                                name="privacy_policy"
                                label="Privacy policy *"
                                v-model="form.privacy_policy"
                                :form="form"
                                :placeholder="policyPlaceholder"
                            />
                        </div>
                    </div>
                    <div class="card-footer">
                        <a :href="form.terms_and_conditions" target="_blank" type="button" class="btn btn-success">
                            <i class="fas fa-eye mr-2"></i> Terms & Conditions
                        </a>
                        <a :href="form.privacy_policy" target="_blank" type="button" class="btn btn-warning ml-2">
                            <i class="fas fa-eye mr-2"></i> Privacy Policy
                        </a>
                        <submit-button :disabled="form.busy" :loading="form.busy" class="float-right ml-2" text="Save"></submit-button>
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
import TextAreaField from "@admin/forms/TextareaField";
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";
import FileField from "../../forms/FileField";
import ShowVideo from "../../forms/ShowVideo";
import ImageField from "../../forms/ImageField";
import ShowImage from "../../forms/ShowImage";

export default {
    name: "FooterInfo",
    components: {
        SubmitButton,
        TextField,
        FileField,
    },
    data() {
        return {
            info: null,
            termsPlaceholder: 'Choose file',
            policyPlaceholder: 'Choose file',
            form: new Form({
                company_name: '',
                address: '',
                phone_number: '',
                email: '',
                terms_and_conditions: '',
                privacy_policy: '',
            }),
            loading: true,
        }
    },
    methods: {
        loadFooterInfo() {
            this.loading = true;
            axios
                .get(route("footer.index"))
                .then((response) => {
                    this.info = response.data;
                    this.termsPlaceholder = this.info.terms_file_name;
                    this.policyPlaceholder = this.info.policy_file_name;
                    this.form.fill(this.info);
                    this.loading = false;
                });
        },
        submitForm() {
            let method, path, message;
            method = "post"; //put
            path = route("footer.update", 1);
            message = "Footer edited successfully.";
            this.form._method = 'put';

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.loadFooterInfo();
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
        showCoverPhoto(photo){
            Bus.$emit('show-photo-modal', photo);
        }
    },
    mounted() {
        this.loadFooterInfo();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Footer",
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
