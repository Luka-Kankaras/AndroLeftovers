<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mt-1 mb-2 mb-sm-0">Table teams</h3>
                    <div class="float-sm-right">
                        <input
                            class="form-control form-control-sm"
                            type="text"
                            placeholder="Search"
                            aria-label="Search"
                            v-model="filters.term"
                        />
                    </div>
                </div>
                <div class="card-body">
                    <button
                        class="btn btn-sm btn-primary mb-3 float-right"
                        @click.prevent="addTeam"
                    >
                        Add team member
                        <i class="fas fa-plus-circle ml-1"></i>
                    </button>
                    <div class="loading-indicator" v-if="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="table-responsive table-sm">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center align-middle no-wrap">Photo</th>
                                <th class="text-center align-middle no-wrap">First name</th>
                                <th class="text-center align-middle no-wrap">Last name</th>
                                <th class="text-center align-middle no-wrap">Position</th>
<!--                                <th class="text-center align-middle no-wrap" style="width: 100px;">Gallery</th>-->
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Edit</th>
                                <th class="text-center align-middle no-wrap" style="width: 100px;">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="resultsCount === 0">
                                <td colspan="7">
                                    <h4 class="text-center my-3">No result</h4>
                                </td>
                            </tr>
                            <template v-if="team">
                                <tr v-for="t in team.data" :key="t.id">
                                    <td class="text-center align-middle no-wrap">
                                        <img :src="t.image" alt="" class="thumbnail">
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ t.first_name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ t.last_name }}
                                    </td>
                                    <td class="text-center align-middle no-wrap">
                                        {{ t.position }}
                                    </td>
<!--                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-success"
                                            @click="teamGallery(t)"
                                        >
                                            <i class="fas fa-images"></i>
                                        </button>
                                    </td>-->
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-info"
                                            @click="editTeam(t)"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button
                                            class="btn btn-sm btn-block btn-outline-danger"
                                            @click="deleteTeam(t.id)"
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
                <div class="card-footer" v-if="resultsCount">
                    <pagination
                        class="my-1"
                        align="right"
                        :data="team"
                        :limit="1"
                        @pagination-change-page="loadTeam"
                        show-disabled
                    >
                    </pagination>
                </div>
            </div>
            <team-modal/>
            <team-gallery />
        </div>
    </div>
</template>


<script>
import Swal from "sweetalert2";
import debounce from "lodash/debounce";
import Pagination from "laravel-vue-pagination";
import TeamModal from "./TeamModal";
import { swalNotification } from "@/utilities";
import TeamGallery from "./TeamGallery";

export default {
    components: {
        TeamGallery,
        TeamModal,
        Pagination,
    },
    data() {
        return {
            loading: false,
            team: null,
            filters: {
                term: "",
            },
        };
    },
    computed: {
        resultsCount() {
            return this.team?.data?.length;
        },
    },
    watch: {
        filters: {
            deep: true,
            immediate: false,
            handler: debounce(function (value) {
                this.loadTeam();
            }, 250),
        },
    },
    methods: {
        loadTeam(page = 1) {
            this.loading = true;
            axios
                .get(route("team.index", { page, ...this.filters }))
                .then((response) => {
                    this.team = response.data;
                    this.loading = false;
                });
        },
        teamGallery(team){
            Bus.$emit("open-team-images-modal", team);
        },
        addTeam() {
            Bus.$emit("open-team-modal", null);
        },
        editTeam(team) {
            Bus.$emit("open-team-modal", team);
        },
        deleteTeam(id) {
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
                        .delete(route("team.destroy", id))
                        .then((response) => {
                            swalNotification("success", "Team member has been deleted successfully.");
                            this.loadTeam();
                        })
                        .catch((error) => {
                            if(error.response.status === 405)
                                Swal.fire("Error!", error.response.data, "error");
                            else
                                Swal.fire("Error!", "Something went wrong!", "warning");
                        });
                }
            });
        },
    },
    mounted() {
        this.loadTeam();

        this.$emit("loadBreadcrumbLink", {
            pageName: "Team",
        });

        Bus.$on("load-team", this.loadTeam);

    },
};
</script>
<style>

.profile-image{
    width: 2rem;
    height: 2rem;
    -o-object-fit: cover;
    object-fit: cover;
}

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
