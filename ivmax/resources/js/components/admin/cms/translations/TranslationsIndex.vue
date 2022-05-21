<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form @submit.prevent="submitForm">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 d-flex justify-content-center divider">
                                <h5 class="heading d-flex justify-content-center">Homepage</h5>
                            </div>
                            <div class="col-3 d-flex justify-content-center divider">
                                <h5 class="heading d-flex justify-content-center">Products</h5>
                            </div>
                            <div class="col-3 d-flex justify-content-center">
                                <h5 class="heading d-flex justify-content-center" style="width: 250px;">About & Help & Blog</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div v-if="loading" class="loading-indicator">
                            <div class="spinner"></div>
                        </div>
                        <div class="form-group">
                            <div class="row mb-1">
                                <div class="col-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.order_yours"
                                                :form="form"
                                                label="Order yours *"
                                                name="order_yours"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.toothbrush_toothpaste"
                                                :form="form"
                                                label="Toothbrush. Toothpaste. *"
                                                name="toothbrush_toothpaste"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.view_all_products"
                                                :form="form"
                                                label="View all products *"
                                                name="view_all_products"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_1"
                                                :form="form"
                                                label="Text 1 *"
                                                name="text_1"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_1_description"
                                                :form="form"
                                                label="Text 1 - description *"
                                                name="text_1_description"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_2"
                                                :form="form"
                                                label="Text 2 *"
                                                name="text_2"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_2_description"
                                                :form="form"
                                                label="Text 2 - description *"
                                                name="text_2_description"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_3"
                                                :form="form"
                                                label="Text 3 *"
                                                name="text_3"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_3_description"
                                                :form="form"
                                                label="Text 3 - description *"
                                                name="text_3_description"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_4"
                                                :form="form"
                                                label="Text 4 *"
                                                name="text_4"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.text_4_description"
                                                :form="form"
                                                label="Text 4 - description *"
                                                name="text_4_description"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.our_exclusive_features"
                                                :form="form"
                                                label="Our exclusive features *"
                                                name="our_exclusive_features"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.always_at_hand"
                                                :form="form"
                                                label="Always at hand *"
                                                name="always_at_hand"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                        <div class="col-12">
                                            <text-field
                                                v-model="form.perfect_for_outdoors"
                                                :form="form"
                                                label="Perfect for outdoors *"
                                                name="perfect_for_outdoors"
                                                placeholder="Enter text..." type="text"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 divider">
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.expert_construction"
                                            :form="form"
                                            label="Expert construction *"
                                            name="expert_construction"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.airplane_friendly"
                                            :form="form"
                                            label="Airplane friendly *"
                                            name="airplane_friendly"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <!---->
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.brush_your_teeth_anytime"
                                            :form="form"
                                            label="Brush your teeth anytime *"
                                            name="brush_your_teeth_anytime"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.ivmax"
                                            :form="form"
                                            label="Ivmax *"
                                            name="ivmax"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.anatomy"
                                            :form="form"
                                            label="Anatomy *"
                                            name="anatomy"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>

                                    <!---->
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.subscribe_annual"
                                            :form="form"
                                            label="Subscribe *"
                                            name="subscribe_annual"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.and_save"
                                            :form="form"
                                            label="and Save *"
                                            name="and_save"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <!---->
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.learn_more"
                                            :form="form"
                                            label="Learn more *"
                                            name="learn_more"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.what_our_clients_say"
                                            :form="form"
                                            label="What our clients say *"
                                            name="what_our_clients_say"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.testimonials"
                                            :form="form"
                                            label="Testimonials *"
                                            name="testimonials"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>


                                    <div class="col-12">
                                        <text-field
                                            v-model="form.find_your"
                                            :form="form"
                                            label="Find Your *"
                                            name="find_your"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.style"
                                            :form="form"
                                            label="Style *"
                                            name="style"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.five_unique_colors"
                                            :form="form"
                                            label="Description 1 *"
                                            name="five_unique_colors"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.which_one_goes_with_your_character"
                                            :form="form"
                                            label="Description 2 *"
                                            name="which_one_goes_with_your_character"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                </div>
                                <div class="col-3 divider p-0">
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.products_title"
                                            :form="form"
                                            label="Title *"
                                            name="products_title"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.pack_include"
                                            :form="form"
                                            label="Pack include *"
                                            name="pack_include"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.ivmax_toothbrush"
                                            :form="form"
                                            label="Ivmax Toothbrush *"
                                            name="ivmax_toothbrush"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.brush_head"
                                            :form="form"
                                            label="Brush Head *"
                                            name="brush_head"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.toothpaste_cartridges"
                                            :form="form"
                                            label="Toothpaste Cartridges *"
                                            name="toothpaste_cartridges"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.available_brush_heads"
                                            :form="form"
                                            label="Available Brush Heads *"
                                            name="available_brush_heads"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.buy"
                                            :form="form"
                                            label="Buy *"
                                            name="buy"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.create_your_pack"
                                            :form="form"
                                            label="Create your pack *"
                                            name="create_your_pack"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.every_3_months_or_yearly"
                                            :form="form"
                                            label="Annual plan - description *"
                                            name="every_3_months_or_yearly"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                </div>
                                <div class="col-3 p-0">
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.all_in_one_toothbrush_solution"
                                            :form="form"
                                            label="All-in-one toothbrush solution *"
                                            name="all_in_one_toothbrush_solution"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.who_we_are"
                                            :form="form"
                                            label="Who we are? *"
                                            name="who_we_are"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.our_team"
                                            :form="form"
                                            label="Our team *"
                                            name="our_team"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <text-field
                                            v-model="form.similar_blogs"
                                            :form="form"
                                            label="Similar blogs *"
                                            name="similar_blogs"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.share"
                                            :form="form"
                                            label="Share *"
                                            name="share"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12 ">
                                        <text-field
                                            v-model="form.general_info"
                                            :form="form"
                                            label="General information *"
                                            name="general_info"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.faq"
                                            :form="form"
                                            label="FAQ *"
                                            name="faq"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.contact_support"
                                            :form="form"
                                            label="Contact Support *"
                                            name="contact_support"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12 d-flex justify-content-center navbar-heading" style="width: 100%">
                                        <h5 class="heading d-flex justify-content-center">Footer</h5>
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.subscribe_newsletter"
                                            :form="form"
                                            label="Subscribe to our newsletter *"
                                            name="subscribe_newsletter"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.footer_successful_submit"
                                            :form="form"
                                            label="Subscribed successfully *"
                                            name="footer_successful_submit"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.terms_and_conditions"
                                            :form="form"
                                            label="Terms and conditions *"
                                            name="terms_and_conditions"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <text-field
                                            v-model="form.privacy_policy"
                                            :form="form"
                                            label="Privacy policy *"
                                            name="privacy_policy"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center navbar-heading" style="width: 100%">
                                    <h5 class="heading d-flex justify-content-center my-2">Navbar</h5>
                                </div>
                                <div class="col-3">
                                    <text-field
                                        v-model="form.products"
                                        :form="form"
                                        label="Products *"
                                        name="products"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-3">
                                    <text-field
                                        v-model="form.about"
                                        :form="form"
                                        label="About *"
                                        name="about"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-2">
                                    <text-field
                                        v-model="form.blog"
                                        :form="form"
                                        label="Blog *"
                                        name="blog"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-2">
                                    <text-field
                                        v-model="form.help"
                                        :form="form"
                                        label="Help *"
                                        name="help"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-2 divider">
                                    <text-field
                                        v-model="form.shop"
                                        :form="form"
                                        label="Shop *"
                                        name="shop"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center navbar-heading my-3" style="width: 100%">
                                    <div class="col-8 d-flex justify-content-center">
                                        <h5 class="heading d-flex justify-content-center my-2">Contact form</h5>
                                    </div>
                                    <div class="col-4 d-flex justify-content-center my-2">
                                        <h5 class="heading d-flex justify-content-center">Errors</h5>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <text-field
                                        v-model="form.full_name"
                                        :form="form"
                                        label="First and last name *"
                                        name="full_name"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-2">
                                    <text-field
                                        v-model="form.message"
                                        :form="form"
                                        label="Message *"
                                        name="message"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-2">
                                    <text-field
                                        v-model="form.send"
                                        :form="form"
                                        label="Send *"
                                        name="send"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-2 divider">
                                        <text-field
                                            v-model="form.form_successful_submit"
                                            :form="form"
                                            label="Form submitted message *"
                                            name="form_successful_submit"
                                            placeholder="Enter text..." type="text"
                                        />
                                    </div>
                                <div class="col-1">
                                    <text-field
                                        v-model="form.error_404"
                                        :form="form"
                                        label="Error 404 *"
                                        name="error_404"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-1">
                                    <text-field
                                        v-model="form.not_found"
                                        :form="form"
                                        label="Not Found *"
                                        name="not_found"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-1">
                                    <text-field
                                        v-model="form.error_500"
                                        :form="form"
                                        label="Error 500 *"
                                        name="error_500"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                                <div class="col-1">
                                    <text-field
                                        v-model="form.internal_server_error"
                                        :form="form"
                                        label="Server error *"
                                        name="internal_server_error"
                                        placeholder="Enter text..." type="text"
                                    />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-center py-3">
                        <submit-button :disabled="form.busy" :loading="form.busy" class="float-right ml-2"
                                       text="Save" :width="'300px'"></submit-button>
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

export default {
    name: "Translations",
    components: {
        SubmitButton,
        TextField,
    },
    data() {

        return {
            form: new Form({

                order_yours: '',
                toothbrush_toothpaste: '',
                view_all_products: '',
                text_1: '',
                text_1_description: '',
                text_2: '',
                text_2_description: '',
                text_3: '',
                text_3_description: '',
                text_4: '',
                text_4_description: '',
                our_exclusive_features: '',
                always_at_hand: '',
                perfect_for_outdoors: '',
                expert_construction: '',
                airplane_friendly: '',
                brush_your_teeth_anytime: '',
                ivmax: '',
                anatomy: '',
                subscribe_annual: '',
                and_save: '',
                learn_more: '',
                what_our_clients_say: '',
                testimonials: '',
                find_your: '',
                style: '',
                five_unique_colors: '',
                which_one_goes_with_your_character: '',

                products_title: '',
                pack_include: '',
                ivmax_toothbrush: '',
                brush_head: '',
                toothpaste_cartridges: '',
                available_brush_heads: '',
                buy: '',
                create_your_pack: '',
                every_3_months_or_yearly: '',
                all_in_one_toothbrush_solution: '',
                who_we_are: '',
                our_team: '',
                blog: '',
                similar_blogs: '',
                share: '',
                general_info: '',
                faq: '',
                contact_support: '',
                full_name: '',
                message: '',
                send: '',
                form_successful_submit: '',
                products: '',
                about: '',
                help: '',
                shop: '',
                error_404: '',
                error_500: '',
                internal_server_error: '',
                not_found: '',
                subscribe_newsletter: '',
                footer_successful_submit: '',
                terms_and_conditions: '',
                privacy_policy: '',
            }),
            loading: true,
        }
    },
    methods: {
        loadStaticFields() {
            this.loading = true;
            axios
                .get(route("static-fields"))
                .then((response) => {
                    this.form.fill(response.data);
                    this.loading = false;
                });
        },
        submitForm() {
            let method, path, message;
            method = "post"; //put
            path = route("update-static-fields");
            message = "Fields edited successfully.";
            this.form._method = 'put';

            this.form.submit(method, (path), {
                transformRequest: [function (data, headers) {
                    return objectToFormData(data)
                }]
            })
                .then((response) => {
                    this.loadStaticFields();
                    swalNotification("success", message);
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response.status !== 422) {
                        swalNotification("error", "There was a problem.");
                    }
                });
        },
    },
    mounted() {
        this.loadStaticFields();
        this.$emit("loadBreadcrumbLink", {
            pageName: "Translations",
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

.heading {
    width: 200px;
    color: white;
    background-color: #1a4246;
    padding: 10px;
    border-radius: 3%;
}

.divider {
    border-right: 1px #ced4da solid;
    padding-left: 15px;
}

h5 {
    margin: 0;
}

.navbar-heading {
    background-color: #f7f7f7;
    padding-top: 15px;
    padding-bottom: 15px;
    margin-bottom: 10px;
    border-top: 1px rgba(180, 180, 180, 0.5) solid;
    border-bottom: 1px rgba(180, 180, 180, 0.5) solid;
}

</style>
