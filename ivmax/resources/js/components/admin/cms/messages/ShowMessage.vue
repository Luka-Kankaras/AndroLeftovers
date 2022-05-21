<template>
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="Product images modal"
        aria-hidden="true"
        ref="modal"
    >
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
<!--                style="background-color: #002d31"-->
                <div class="modal-body d-flex justify-content-center" v-if="message" style="background-color: #002d31; color: white">
                    <p>{{ message }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            message: null,
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

        Bus.$on("open-message-modal", (message) => {
            this.message = message;
            this.showModal();
        });
    },
};
</script>
