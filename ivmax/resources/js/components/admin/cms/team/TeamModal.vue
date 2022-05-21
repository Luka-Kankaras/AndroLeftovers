<template>
    <div class="modal fade" id="example-modal" tabindex="-1" role="dialog" aria-labelledby="Example modal"
         aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">{{  title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <text-field
                                        label="First name *"
                                        type="text"
                                        name="first_name"
                                        placeholder="Enter first name..."
                                        v-model="form.first_name" :form="form"
                                />
                                <text-field
                                    label="Last name *"
                                    type="text"
                                    name="last_name"
                                    placeholder="Enter last name..."
                                    v-model="form.last_name" :form="form"
                                />
                                <text-field
                                    label="Position *"
                                    type="text"
                                    name="position"
                                    placeholder="Enter position"
                                    v-model="form.position" :form="form"
                                />
                                <image-field
                                    :key="componentKey"
                                    v-model="form.image"
                                    :form="form"
                                    :oldImage="oldImage"
                                    label="Photo *"
                                    name="image"
                                    placeholder="Attach image"
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
import { swalNotification } from "@/utilities";
import ImageField from "../../forms/ImageField";


export default {
    components: {
        SubmitButton,
        TextField,
        ImageField,
    },
    data() {
        return {
            componentKey: 0,
            teamMember: null,
            oldImage: null,
            form: new Form({
                first_name: "",
                last_name: "",
                position: "",
                image: null,
            }),
        };
    },
    computed: {
        title() {
            return this.teamMember ? "Edit team member" : "Add team member";
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
            if (this.teamMember) {
                method = "post"; //put
                path = route("team.update", this.teamMember.id);
                message = "Team member has been edited.";
                this.form._method = 'put';
            } else {
                method = "post";
                path = route("team.store");
                message = "Team member has been added.";
            }

            this.form.submit(method,(path),{
                    transformRequest: [function(data, headers){
                        return objectToFormData(data)
                    }]
                })
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-team");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
        resetForm() {
            this.teamMember = null;
            this.form.reset();
            this.form.errors.clear();
            this.oldImage = '';
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", () => {
            this.componentKey += 1;
            this.resetForm();
        });

        Bus.$on("open-team-modal", (teamMember) => {
            if (teamMember) {
                this.teamMember = teamMember;
                this.form.fill(teamMember);
                this.oldImage = teamMember.image;
            }
            this.showModal();
        });
    },
};

</script>
