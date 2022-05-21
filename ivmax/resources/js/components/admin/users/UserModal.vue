<template>
    <div
        class="modal fade"
        id="user-modal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="User modal"
        aria-hidden="true"
        ref="modal"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="modal-body">
                        <text-field
                            label="First name *"
                            type="text"
                            name="first_name"
                            placeholder="Enter first name"
                            v-model="form.first_name"
                            :form="form"
                        ></text-field>
                        <text-field
                            label="Last name *"
                            type="text"
                            name="last_name"
                            placeholder="Enter last name"
                            v-model="form.last_name"
                            :form="form"
                        ></text-field>
                        <text-field
                            label="Email *"
                            type="email"
                            name="email"
                            placeholder="Enter email"
                            v-model="form.email"
                            :form="form"
                        ></text-field>
                        <text-field
                            :label="'Password ' + (user ? '' : '*')"
                            type="password"
                            name="password"
                            placeholder="Enter password"
                            v-model="form.password"
                            :form="form"
                        ></text-field>
                        <text-field
                            :label="'Password confirmation ' + (user ? '' : '*')"
                            type="password"
                            name="password_confirmation"
                            placeholder="Re-enter your password"
                            v-model="form.password_confirmation"
                            :form="form"
                        ></text-field>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary float-right"
                            data-dismiss="modal"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <submit-button
                            class="float-right ml-2"
                            text="Save"
                            :disabled="form.busy"
                            :loading="form.busy"
                        ></submit-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {Form} from "vform";
import TextField from "@admin/forms/TextField";
import DateField from "@admin/forms/DateField";
import SubmitButton from "@admin/forms/SubmitButton";
import {swalNotification} from "@/utilities";

export default {
    components: {
        TextField,
        DateField,
        SubmitButton,
    },
    data() {
        return {
            user: null,
            form: new Form({
                first_name: "",
                last_name: "",
                email: "",
                phone_number: "",
                date_of_birth: "",
                password: "",
                password_confirmation: "",
            }),
        };
    },
    computed: {
        title() {
            return this.user ? "Edit admin" : "Add admin";
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
            if (this.user) {
                method = "put";
                path = route("users.update", this.user);
                message = "Admin has been edited.";
            } else {
                method = "post";
                path = route("users.store");
                message = "Admin has been added.";
            }

            this.form[method](path)
                .then((response) => {
                    this.hideModal();
                    Bus.$emit("load-users");
                    swalNotification("success", message);
                })
                .catch((error) => {
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
        resetForm() {
            this.user = null;
            this.form.reset();
            this.form.errors.clear();
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);

        Bus.$on("open-user-modal", (user) => {
            if (user) {
                this.user = user;
                this.form.fill(user);
            }
            this.showModal();
        });
    },
};
</script>

