<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <div class="custom-file">
            <input
                type="file"
                class="custom-file-input"
                accept="image/*"
                :class="{ 'is-invalid': form.errors.has(name) || imageError(form.errors, name)}"
                :name="name"
                :id="inputId"
                ref="image-input"
                @change="imageSelected($event)"
                :multiple="isMultiple"
            />
            <div class="invalid-feedback">
                {{ customError }}
            </div>
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
        <div class="mt-2" v-if="preview">
            <img
                class="preview-image"
                :class="{ logo: name == 'logo', favicon: name == 'favicon' }"
                :src="imagePreviewUrl"
                alt="Preview"
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
            default: "Choose file",
        },
        preview: {
            type: Boolean,
            default: true,
        },
        isMultiple: {
            type: Boolean,
            default: false,
        },
        oldImage: String,
        value: null,
    },
    data() {
        return {
            imagePreviewUrl: null,
            customError: null,
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
            this.$emit("input", event.target.files);
            bsCustomFileInput.init(this.$refs["image-input"].$el);
        },
        imageError(errors, name){
            for (const [key, value] of Object.entries(errors.errors))
                if(key.includes('image.')){
                    this.customError = value[0];
                    return true;
                }
            return false;
        }
    },
    mounted() {
        Bus.$on('images-added', () => {
            this.$refs["image-input"].value = "";
            this.$refs["image-label"].innerText = this.placeholder;
        });
        bsCustomFileInput.init(this.$refs["image-input"].$el);
    },
};
</script>
