<template>
    <div class="modal fade" id="example-modal" tabindex="-1" role="dialog" aria-labelledby="Example modal"
         aria-hidden="true" ref="modal">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="submitForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <text-field
                                        label="Naziv *"
                                        type="text"
                                        name="title"
                                        placeholder="Unesite naziv"
                                        v-model="form.title" :form="form"
                                />
                                <select-field
                                        name="category_id"
                                        :form="form"
                                        :options="categories"
                                        :searchable="true"
                                        optionLabel="title"
                                        placeholder="Odaberi kategoriju"
                                        label="Kategorija*"
                                        v-model="form.category_id"
                                />
                                <date-field
                                    name="publication_date"
                                    :form="form"
                                    format="d.m.Y."
                                    placeholder="Odaberi datum"
                                    label="Datum objave"
                                    v-model="form.publication_date"
                                />
                                <date-field
                                    name="publication_time"
                                    :form="form"
                                    format="H:i"
                                    placeholder="Odaberi vrijeme"
                                    label="Vrijeme objave"
                                    v-model="form.publication_time"
                                    :timepicker="true"
                                    :noCalendar="true"
                                />
                                <date-field
                                    name="publication_date_time"
                                    :form="form"
                                    format="d.m.Y. H:i"
                                    placeholder="Odaberi datum i vrijeme objave"
                                    label="Datum i vrijeme objave"
                                    v-model="form.publication_date_time"
                                    :timepicker="true"
                                />
                                <file-field
                                    name="document"
                                    label="Dokument"
                                    :form="form"
                                    v-model="form.document"
                                    placeholder="Prikači dokument"

                                />
                                <image-field
                                    name="image"
                                    label="Fotografija"
                                    :form="form"
                                    v-model="form.image"
                                    :oldImage="oldImage"
                                    placeholder="Prikači sliku"
                                />
                            </div>
                            <div class="col-lg-6">
                                <textarea-field
                                    label="Opis *"
                                    name="description"
                                    placeholder="Unesite opis"
                                    v-model="form.description"
                                    :form="form"
                                    rows="30"
                                />
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">
                            Odustani
                        </button>
                        <submit-button class="float-right ml-2" text="Sačuvaj" :disabled="form.busy"
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

    import CheckboxField from "@admin/forms/CheckboxField";
    import DateField from "@admin/forms/DateField";
    import FileField from "@admin/forms/FileField";
    import ImageField from "@admin/forms/ImageField";
    import NumberField from "@admin/forms/NumberField";
    import SelectField from "@admin/forms/SelectField";
    import TextareaField from "@admin/forms/TextareaField";
    import TextField from "@admin/forms/TextField";
    import SubmitButton from "@admin/forms/SubmitButton";
    import { swalNotification } from "@/utilities";

    export default {
        components: {
            CheckboxField,
            DateField,
            FileField,
            ImageField,
            NumberField,
            SelectField,
            TextareaField,
            TextField,
            SubmitButton,
        },
        data() {
            return {
                example: null,
                oldImage: null,
                form: new Form({
                    title: "",
                    description: "",
                    publication_date: "",
                    publication_time: "",
                    publication_date_time: "",
                    category_id: null,
                    enabled: false,
                    document: null,
                    image: null,
                }),
                categories: [],
            };
        },
        computed: {
            title() {
                return this.example ? "Izmijeni example" : "Dodaj example";
            },
        },
        methods: {
            showModal() {
                $(this.$refs.modal).modal("show");
            },
            hideModal() {
                $(this.$refs.modal).modal("hide");
            },
            getExample(example) {
                axios.get(route("examples.show", example)).then((response) => {
                    this.example = response.data;
                    this.form.fill(this.example);
                    this.oldImage = this.form.image;
                    this.form.image = null;
                });
            },
            getCategories(){
              axios.get(route('example-categories')).then((response) => {
                  this.categories = response.data;
              });
            },
            submitForm() {
                let method, path, message;
                if (this.example) {
                    method = "post"; //put
                    path = route("examples.update", this.example);
                    message = "Example je uspješno izmijenjen.";
                    this.form._method = 'put';
                } else {
                    method = "post";
                    path = route("examples.store");
                    message = "Example je uspješno dodat.";
                }

                this.form.submit(method,(path),{
                        transformRequest: [function(data, headers){
                            return objectToFormData(data)
                        }]
                    })
                    .then((response) => {
                        this.hideModal();
                        Bus.$emit("load-examples");
                        swalNotification("success", message);
                    })
                    .catch((error) => {
                        if (error.response.status !== 422) {
                            swalNotification("error", "Došlo je do greške.");
                        }
                    });
            },
            resetForm() {
                this.example = null;
                this.form.reset();
                this.form.errors.clear();
            },
        },
        mounted() {
            $(this.$refs.modal).on("hidden.bs.modal", this.resetForm);

            Bus.$on("open-example-modal", (example) => {
                if (example) {
                    this.getExample(example);
                }
                this.showModal();
            });
            this.getCategories();
        },
    };

</script>
