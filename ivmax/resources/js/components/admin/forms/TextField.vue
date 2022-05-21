<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <input
            :id="name"
            :name="name"
            :type="type"
            :maxlength="maxlength"
            class="form-control"
            :placeholder="placeholder"
            :class="{ 'is-invalid': form.errors.has(name) }"
            :value="value"
            @input="$emit('input', $event.target.value)"
        />
        <has-error :form="form" :field="name"></has-error>
    </div>
</template>

<script>
import {HasError} from "vform";

export default {
    props: {
        type: {
            type: String,
            default: "text",
        },
        name: {
            type: String,
            required: true,
        },
        form: {
            type: Object,
            required: true,
        },
        maxlength: {
            required: false,
            type: Number
        },
        placeholder: String,
        label: String,
        value: String,
    },
    components: {
        HasError,
    },
};
</script>
