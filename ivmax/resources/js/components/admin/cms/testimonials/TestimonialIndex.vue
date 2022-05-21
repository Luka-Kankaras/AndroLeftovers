<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table testimonials</h3>
                    <div class="float-sm-right">
                        <input
                            v-model="filters.term"
                            aria-label="Search"
                            class="form-control form-control-sm"
                            placeholder="Search"
                            type="text"
                        />
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-end mb-2">
                        <button
                            class="btn btn-sm btn-primary mb-3"
                            @click.prevent="addTestimonial"
                        >
                            Add testimonial
                            <i class="fas fa-plus-circle ml-1"></i>
                        </button>
                    </div>
                    <div v-if="loading" class="loading-indicator">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive table-sm">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Photo</th>
                                <th class="text-center align-middle no-wrap">Author</th>
                                <th class="text-center align-middle no-wrap">Text</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Edit</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="8">
                                    <h4 class="text-center my-3">No results</h4>
                                </td>
                            </tr>
                            <template v-if="testimonials">
                                <tr v-for="testimonial in testimonials.data" :key="testimonial.id">
                                    <td class="text-center align-middle no-wrap">
                                        <img :src="testimonial.photo" alt="" class="thumbnail">
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ testimonial.full_name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ testimonial.text | stripHTML | short }}
                                    </td>


                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editTestimonial(testimonial)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteTestimonial(testimonial)"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="resultsCount" class="card-footer">
                    <pagination
                        :data="testimonials"
                        :limit="1"
                        align="right"
                        class="my-1"
                        show-disabled
                        @pagination-change-page="loadTestimonials"
                    >
                    </pagination>
                </div>
            </div>

            <testimonial-modal/>

        </div>
    </div>
</template>


<script>

import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import TestimonialModal from "./TestimonialModal";
import {swalNotification} from "@/utilities";
import axios from "axios";

export default {
    name: "TestimonialsIndex",
    components: {
        TestimonialModal,
        Pagination,
    },
    data() {
        return {
            loading: false,
            testimonials: null,
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.testimonials?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadTestimonials();
            }, 250),
        },
    },
    methods: {
        filterStatus(e){
          this.filters.status = e.target.value
            this.loadTestimonials();
        },
        loadTestimonials(page = 1) {
            this.loading = true;
            axios
                .get(route("testimonials.index", {page, ...this.filters}))
                .then((response) => {
                    this.testimonials = response.data;
                    this.loading = false;
                });
        },
        testimonialGallery(testimonial) {
            Bus.$emit("open-testimonial-images-modal", testimonial);
        },
        addTestimonial() {
            Bus.$emit("open-testimonials-modal", null);
        },
        editTestimonial(testimonial) {
            Bus.$emit("open-testimonials-modal", testimonial);
        },
        deleteTestimonial(id) {
            Swal.fire({
                icon: "warning",
                title: "Deleting!",
                text: "Are you sure you want to proceed?",
                showCancelButton: true,
                cancelButtonColor: "#3085d6",
                confirmButtonColor: "#c82333",
                cancelButtonText: "Cancel",
                confirmButtonText: "Delete",
            }).then((result) => {
                if (result.value) {
                    axios
                        .delete(route("testimonials.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Testimonial has been deleted successfully.");
                            this.loadTestimonials();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadTestimonials();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Testimonials",
        });

        Bus.$on("load-testimonials", this.loadTestimonials);
    },
};
</script>

<style>

.thumbnail {
    width: 2rem;
    height: 2rem;
    -o-object-fit: cover;
    object-fit: cover;
}

.btn:focus {
    box-shadow: none;
    border-color: #17a2b8;
}

.swal2-styled:focus {
    box-shadow: none;
}

</style>
