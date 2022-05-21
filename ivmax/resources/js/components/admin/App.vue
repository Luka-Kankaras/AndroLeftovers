<template>
    <div class="wrapper">
        <nav
            class="main-header navbar navbar-expand navbar-white navbar-light"
            style="z-index: 2"
        >
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link btn" @click.prevent="logout">
                        <i class="fas fa-power-off mr-2"></i> Log out
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="/" target="_blank" class="brand-link py-3" style="width: 100%;">
                <div class="image d-flex justify-content-center">
                    <img src="/ivmax.png" alt="" style="width: 50%; min-width: 40px" />
                </div>
            </a>

            <div class="sidebar">
                <nav class="mt-2 pb-2">
                    <ul
                        class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false"
                    >
                        <li class="nav-item pb-2 my-1" style="border-bottom: 1px #4b545c solid; color: white">
                            <a class="nav-link current-user" style="background-color: #096677; color: white">
                                <i class="fas fa-user nav-icon"></i>
                                <p>{{ currUser.full_name }}</p>
                            </a>
                        </li>

                        <li class="nav-header pt-3">PRODUCTS</li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'products' }">
                                <i class="fas fa-store nav-icon"></i>
                                <p>Products</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'colors' }">
                                <i class="fad fa-palette nav-icon"></i>
                                <p>Colors</p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'types' }">
                                <i class="fad fa-toothbrush nav-icon"></i>
                                <p>Types</p>
                            </router-link>
                        </li>


                        <li class="nav-header pt-3">BLOG</li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'posts' }">
                                <i class="fad fa-newspaper nav-icon"></i>
                                <p>Posts</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'tags' }">
                                <i class="fal fa-hashtag nav-icon"></i>
                                <p>Tags</p>
                            </router-link>
                        </li>

                        <li class="nav-header pt-3">ABOUT</li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'company' }">
                                <i class="fad fa-info-square nav-icon"></i>
                                <p>About us</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'team' }">
                                <i class="fad fa-users nav-icon"></i>
                                <p>Team</p>
                            </router-link>
                        </li>

                        <li class="nav-header pt-3">HELP</li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'general-info' }">
                                <i class="fad fa-info-circle nav-icon"></i>
                                <p>General info</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'info-category' }">
                                <i class="fad fa-box nav-icon"></i>
                                <p>Info categories</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'faqs' }">
                                <i class="fad fa-comments nav-icon"></i>
                                <p>FAQ</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'contact' }">
                                <i class="fad fa-mailbox nav-icon"></i>
                                <p>Recieved messages</p>
                            </router-link>
                        </li>

                        <li class="nav-header pt-3 mb-1">HOME</li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'homepage' }">
                                <i class="fad fa-home nav-icon"></i>
                                <p>Home page</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'testimonial' }">
                                <i class="fad fa-comment-lines nav-icon"></i>
                                <p>Testimonials</p>
                            </router-link>
                        </li>



                        <li class="nav-header pt-3 mb-1">OTHER</li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'translations' }">
                                <i class="fad fa-books nav-icon"></i>
                                <p>Translations</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'footer' }">
                                <i class="fad fa-puzzle-piece nav-icon"></i>
                                <p>Footer</p>
                            </router-link>
                        </li>

                        <li class="nav-item mb-1">
                            <router-link class="nav-link" :to="{ name: 'newsletter' }">
                                <i class="fad fa-newspaper nav-icon"></i>
                                <p>Newsletter</p>
                            </router-link>
                        </li>


                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users' }">
                                <i class="fad fa-users nav-icon"></i>
                                <p>Admins</p>
                            </router-link>
                        </li>


<!--                        <li class="nav-item mb-1">-->
<!--                            <router-link class="nav-link" :to="{ name: 'languages' }">-->
<!--                                <i class="fad fa-globe-americas nav-icon"></i>-->
<!--                                <p>Languages</p>-->
<!--                            </router-link>-->
<!--                        </li>-->

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">
                                {{ pageName }}
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <router-link :to="{ name: 'admin' }">Admin</router-link>
                                </li>
                                <li
                                    class="breadcrumb-item"
                                    v-for="(url, index) in breadcrumbUrls"
                                    :key="index"
                                >
                                    <router-link :to="{ name: url.name }">
                                        {{ url.text }}
                                    </router-link>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ pageName }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section id="content" class="content">
                <div class="container-fluid">
                    <router-view @loadBreadcrumbLink="showBreadcrumbLink"></router-view>
                </div>
            </section>
        </div>

        <footer class="main-footer" style="padding-left: 50px">
            Copyright &copy; {{ year }}.
            <strong
            >Powered by
                <a href="https://amplitudo.me" target="_blank">Amplitudo</a>.
            </strong>
        </footer>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";

export default {
    data() {
        return {
            breadcrumbUrls: [],
            pageName: "",
            currUser: '',
        };
    },
    computed: {
        year() {
            return new Date().getFullYear();
        },
    },
    methods: {
        logout() {
            Swal.fire({
                icon: "question",
                title: "Log out!",
                text: "Are you sure?",
                showCancelButton: true,
                cancelButtonColor: "#0069d9",
                confirmButtonColor: "#c82333",
                cancelButtonText: "Cancel",
                confirmButtonText: "Log out",
            }).then((result) => {
                if (result.value) {
                    axios.post(`/logout`).then((response) => (location.href = "/"));
                }
            });
        },
        showBreadcrumbLink(data) {
            if (data.url) {
                this.breadcrumbUrls.push(data.url);
            } else {
                this.breadcrumbUrls = [];
            }
            this.pageName = data.pageName;
        },
    },
    mounted() {
        axios.get('/cms/user/me').then((response) => {
            this.currUser = response.data;
        })
    }
};
</script>

<style>

    /* width */
    ::-webkit-scrollbar {
        width: 4px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 30px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 30px;
    }

    .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active, .sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
        background-color: #001e31;
        border: 1px rgba(255, 255, 255, 0.3) solid;
        border-radius: 10px;
    }

    [class*=sidebar-dark-] {
        background-color: #002d31;
    }

    .btn:focus {
        box-shadow: none;
        border-color: #17a2b8;
    }

    .swal2-styled:focus {
        box-shadow: none;
    }


</style>
