<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <div class="d-inline-block" v-if="oldFile">
            <span> - </span>
            <a :href="oldFile" target="_blank">{{ oldFileName }}</a>
        </div>
        <div class="custom-file">
            <input
                type="file"
                class="custom-file-input"
                :class="{ 'is-invalid': form.errors.has(name) }"
                :name="name"
                :id="inputId"
                ref="file-input"
                :accept="accept"
                @change="fileSelected($event)"
            />
            <label
                class="custom-file-label"
                :for="inputId"
                ref="file-label"
                data-browse="Choose"
            >
                {{ placeholder }}
            </label>
            <has-error :form="form" :field="name"></has-error>
        </div>
    </div>
</template>

<script>
import {HasError} from "vform";
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
        accept: {
            type: String,
            required: false,
            default: '*'
        },
        oldFile: String,
        value: null,
    },
    components: {
        HasError,
    },
    computed: {
        inputId() {
            let randomNumber = Math.floor(Math.random() * 1000);
            return `${this.name}-${randomNumber}`;
        },
        oldFileName() {
            if (this.oldFile) {
                let elements = this.oldFile.split("/");
                return elements[elements.length - 1];
            }
        },
    },
    watch: {
        form: {
            deep: true,
            handler(newValue) {
                if (this.form[this.name] == "") {
                    this.$refs["file-input"].value = "";
                    this.$refs["file-label"].innerText = this.placeholder;
                }
            },
        },
    },
    methods: {
        fileSelected(event) {
            this.$emit("input", event.target.files[0]);
            bsCustomFileInput.init(this.$refs["file-input"].$el);
        },
    },
    mounted() {
        bsCustomFileInput.init(this.$refs["file-input"].$el);
    },
};
</script>

<style>

.custom-file-label {

    color: #6c757d;

}

</style>
