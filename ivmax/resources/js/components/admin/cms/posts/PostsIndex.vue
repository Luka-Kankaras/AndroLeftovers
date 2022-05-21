<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table posts</h3>
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

                        <select @change="filterStatus" v-model="status" class="custom-select custom-select-sm mr-3 mb-3" style="width: 15%">
                            <option
                            v-for="o in statusOptions"
                            :key="o.id"
                            :value="o.val"
                            :selected="o.val !== '1' && o.val !== '0'"
                            >{{o.title}}</option>
                        </select>
                        <button
                            class="btn btn-sm btn-primary mb-3"
                            @click.prevent="addPost"
                        >
                            Add post
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
                                <th class="text-center align-middle no-wrap">ID</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Thumbnail</th>
                                <th class="text-center align-middle no-wrap">Title</th>
                                <th class="text-center align-middle no-wrap">Text</th>
                                <th class="text-center align-middle no-wrap">Author</th>
                                <th class="text-center align-middle no-wrap" style="width: 70px;">Status</th>
<!--                                <th class="text-center align-middle no-wrap" style="width: 70px;">Tags</th>-->
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
                            <template v-if="posts">
                                <tr v-for="post in posts.data" :key="post.id">
                                    <td class="text-center align-middle no-wrap">
                                        {{ post.id }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        <img :src="post.thumbnail" alt="" class="thumbnail">
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ post.title }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ post.text | stripHTML | short }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ post.team.full_name }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            :class="post.active ? 'btn-success' : 'btn-secondary'"
                                            class="btn btn-sm btn-block "
                                            @click="toggleStatus(post)"
                                        >
                                            <i :class="post.active ? 'fa-check-circle' : 'fa-times-circle'"
                                               class="fas"></i>
                                        </button>
                                    </td>

                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editPost(post)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deletePost(post)"
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
                        :data="posts"
                        :limit="1"
                        align="right"
                        class="my-1"
                        show-disabled
                        @pagination-change-page="loadPosts"
                    >
                    </pagination>
                </div>
            </div>

            <posts-modal :tags="tags" :team="team"/>

        </div>
    </div>
</template>


<script>

import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import PostsModal from "./PostsModal";
import {swalNotification} from "@/utilities";
import axios from "axios";

export default {
    name: "PostsIndex",
    components: {
        PostsModal,
        Pagination,
    },
    data() {
        return {
            loading: false,
            posts: null,
            status: '',
            statusOptions: [{id: 0, title: "All posts", val: ''}, {id: 1, title: "Active", val: '1'}, {id: 2, title: "Inactive", val: '0'}],
            filters: {
                term: "",
            },
            tags: [],
            team: [],
        };
    },
    computed: {
        resultsCount() {
            return this.posts?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadPosts();
            }, 250),
        },
    },
    methods: {
        filterStatus(e){
          this.filters.status = e.target.value
            this.loadPosts();
        },
        loadPosts(page = 1) {
            this.loading = true;
            axios
                .get(route("posts.index", {page, ...this.filters}))
                .then((response) => {
                    this.posts = response.data;
                    this.loading = false;
                });
        },
        postGallery(post) {
            Bus.$emit("open-post-images-modal", post);
        },
        addPost() {
            Bus.$emit("open-posts-modal", null);
        },
        editPost(post) {
            Bus.$emit("open-posts-modal", post);
        },
        deletePost(id) {
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
                        .delete(route("posts.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Post has been deleted successfully.");
                            this.loadPosts();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
        getTags(){
            axios.get(route('tags.select-tags')).then((response) => {
                this.tags = response.data;
            });
        },
        getMembers(){
            axios.get(route('tags.select-members')).then((response) => {
                this.team = response.data;
            });
        },
        toggleStatus(post) {
            Swal.fire({
                icon: "warning",
                title: post.active ? "Deactivating!" : "Activating!",
                text: `Are you sure you want to the ${post.active ? "deactivate" : "activate"} the post?`,
                showCancelButton: true,
                cancelButtonColor: "#3085d6",
                confirmButtonColor: post.active ? "#6c757d" : "#03972FFF",
                cancelButtonText: "Cancel",
                confirmButtonText: post.active ? "Deactivate" : "Activate",
            }).then((result) => {
                if (result.value) {
                    axios
                        .put(route("posts.toggle-status", post.id))
                        .then((response) => {
                            swalNotification("success", `Post has been successfully ${post.active ? "deactivated" : "activated"}.`);
                            this.loadPosts();
                        })
                        .catch(() => {
                            Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadPosts();
        this.getTags();
        this.getMembers();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Posts",
        });

        Bus.$on("load-posts", this.loadPosts);
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
