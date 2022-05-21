<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <editor
            :id="name"
            :name="name"
            class="form-control tinymce"
            :placeholder="placeholder"
            :class="{ 'is-invalid': form.errors.has(name) }"
            :value="value"
            model-events="change keydown blur focus paste"
            @input="change"
            apiKey="6ck7igjskkovc9v6n51ftgihmfjefwmjr5iza5fmegrepgwl"
            :init="{
                branding: false,
                height: height,
                mode: 'none',
                menubar: false,
                image_dimensions: false,
                image_title: false,
                image_description: false,
                /* enable automatic uploads of images represented by blob or data URIs*/
               plugins: [
                 'lists link image paste help wordcount'
                ],
                automatic_uploads: true,
                file_picker_types: 'image',
                images_upload_handler: uploadImage,
                // file_picker_callback: tinyPicker,
                 init_instance_callback: tiny,
                toolbar: toolbar,

            }"
        >
        </editor>
        <has-error :form="form" :field="name"></has-error>
    </div>
</template>

<script>
import {HasError} from "vform";
import Editor from '@tinymce/tinymce-vue'


export default {
    props: {
        height: {
            type: String,
            default: "400",
        },
        name: {
            type: String,
            required: true,
        },
        model: {
            type: String,
            required: false,
            default: "Post"
        },
        form: {
            type: Object,
            required: true,
        },
        placeholder: String,
        label: String,
        value: String,
        toolbar: {
            type: String,
            default: 'formatselect bold italic image alignleft aligncenter alignright alignjustify bullist numlist help',
        },
        event: {
            type: String,
            default: 'tinymce-input',
        }
    },
    components: {
        HasError,
        Editor,
    },
    data() {
        return {
        };
    },
    methods: {
        tinyPicker(cb, value, meta) {

            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {

                let file = this.files[0];

                let reader = new FileReader();
                reader.onload = function() {

                    let id = "blobid" + (new Date()).getTime();
                    let blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    let base64 = reader.result.split(',')[1];

                    let blobinfo = blobCache.create(id, file, base64);
                    blobCache.add(blobinfo);

                    cb(blobinfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click()
        },
        tiny(editor){
            editor.on('BeforeAddUndo', function(e) {
                return false;
            });
            editor.on('KeyDown', function (e) {

                if ((e.keyCode === 8 || e.keyCode === 46) && editor.selection) { // delete & backspace keys

                    let selectedNode = editor.selection.getNode(); // get the selected node (element) in the editor

                    if (selectedNode && selectedNode.nodeName === 'IMG') {
                        let src = selectedNode.src.split('/'),
                            img = '/'+src[3]+'/'+src[4]+'/'+src[5];

                        Bus.$emit('removedImage', img)
                    }
                }
            });
        },
        uploadImage(blobInfo, success, failure) {
            let data = new FormData();
            let method, path, message;
            method = "post";
            path = route("post.image");
            message = "Post gallery has been updated.";
            data.append('image', blobInfo.blob(), blobInfo.filename());
            // data.append('model', this.model);
            // data.append('currObjID', this.currId);
            axios.post(path, data)
                .then(function (res) {
                    success(res.data.location);
                })
                .catch(function (err) {
                    failure('Error: ' + err.response.data.errors['image'][0]);
                    // failure('HTTP Error: ' + err.message);
                });
        },
        change(e) {
            Bus.$emit(this.event, e)
        }
    }
};
</script>
