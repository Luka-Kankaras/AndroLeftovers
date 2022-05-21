<template>
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="Product images modal"
        aria-hidden="true"
        ref="modal"
    >
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body d-flex justify-content-center px-5" v-if="video"
                     style="background-color: #002d31">
                    <iframe class="my-4" width="800" height="400" :src="video.photo_or_video ? video.photo_or_video : video.video" style="width: 100%"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            video: null,
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
            let iframe = document.querySelector('iframe');
            let video = document.querySelector('video');
            if ( iframe ) {
                let iframeSrc = iframe.src;
                iframe.src = iframeSrc;
            }
            if ( video ) {
                video.pause();
            }
        });

        Bus.$on("show-video-modal", (video) => {
            this.video = video;
            if (video.video_ext === 'mp4')
                this.showModal();
        });
    },
};
</script>

<style>

.modal-body, .modal-content {
    border-radius: 1%;
}

</style>
