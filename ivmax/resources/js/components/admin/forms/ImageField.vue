<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <div class="custom-file">
            <input
                type="file"
                class="custom-file-input"
                accept="image/*"
                :class="{ 'is-invalid': form.errors.has(name) }"
                :name="name"
                :id="inputId"
                ref="image-input"
                @change="imageSelected($event)"
            />
            <label
                class="custom-file-label"
                :for="inputId"
                ref="image-label"
                data-browse="Choose"
            >
                {{ placeholder }}
            </label>
            <has-error :form="form" :field="name"></has-error>
        </div>
        <div class="img-wrap mt-2" v-if="preview">
            <img
                class="preview-image"
                :class="{ logo: name == 'logo', favicon: name == 'favicon' }"
                :src="imagePreviewUrl"
                alt="Preview"
                style="width: 100%"
                v-if="imagePreviewUrl"
            />
        </div>
    </div>
</template>

<script>
import { HasError } from "vform";
import bsCustomFileInput from "bs-custom-file-input";

export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        form: {
            type: Object,
            required: true,
        },
        placeholder: {
            type: String,
            default: "Odaberite sliku",
        },
        preview: {
            type: Boolean,
            default: true,
        },
        oldImage: String,
        value: null,
    },
    data() {
        return {
            imagePreviewUrl: null,
        };
    },
    components: {
        HasError,
    },
    computed: {
        inputId() {
            let randomNumber = Math.floor(Math.random() * 1000);
            return `${this.name}-${randomNumber}`;
        },
    },
    watch: {
        form: {
            deep: true,
            handler(newValue, oldValue) {
                if (newValue[this.name] != oldValue[this.name]) {
                    this.resetInput();
                }
            },
        },
        value() {
            if (this.value == "") {
                this.resetInput();
            }
        },
        oldImage(newValue) {
            console.log(this.oldImage);
            if (this.oldImage) {
                this.imagePreviewUrl = this.oldImage;
            } else {
                this.imagePreviewUrl = "";
            }
        },
    },
    methods: {
        isFileImage(file) {
            return file && file["type"].split("/")[0] === "image";
        },
        resetInput() {
            this.$refs["image-input"].value = "";
            this.$refs["image-label"].innerText = this.placeholder;
            if (this.preview) {
                this.imagePreviewUrl = null;
            }
        },
        imageSelected(event) {
            let image = event.target.files[0];
            if (!this.isFileImage(image)) {
                this.resetInput();
                return;
            }
            this.$emit("input", image);
            bsCustomFileInput.init(this.$refs["image-input"].$el);
            if (this.preview) {
                this.imagePreviewUrl = URL.createObjectURL(image);
            }
        },
    },
    mounted() {
        bsCustomFileInput.init(this.$refs["image-input"].$el);
        Bus.$on("clear-image-field", () => {
            this.imagePreviewUrl = null;
        })
        Bus.$on("clear-image-input", this.resetInput);
    }
};
</script>

<style>

.preview-image {
    object-fit: contain;
}

</style>
