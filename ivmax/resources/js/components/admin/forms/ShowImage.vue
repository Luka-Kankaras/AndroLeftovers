<template>
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="Product images modal"
        aria-hidden="true"
        ref="modal"
    >
        <div class="modal-dialog modal-dialog-centered modal-xl px-5" role="document">
            <div class="modal-content">

                <div class="modal-body d-flex justify-content-center px-5" v-if="image" style="background-color: #002d31">
                    <img :src="image" alt="" width="1000">
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            image: null,
        };
    },
    methods: {
        showModal() {
            $(this.$refs.modal).modal("show");
        },
        hideModal() {
            $(this.$refs.modal).modal("hide");
        },
    },
    mounted() {
        $(this.$refs.modal).on("hidden.bs.modal", () => {
            this.resetForm;
        });

        Bus.$on("show-photo-modal", (image) => {
            this.image = image;
            this.showModal();
        });
    },
};
</script>

<style>

.modal-body, .modal-content {
    border-radius: 1%;
}

img {
    object-fit: contain;
}

.modal-body {
    max-height: 800px;
}


</style>
