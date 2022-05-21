<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>
        <textarea
            :id="name"
            :name="name"
            :rows="rows"
            class="form-control"
            :placeholder="placeholder"
            :class="{ 'is-invalid': form.errors.has(name) }"
            :value="value"
            @input="$emit('input', $event.target.value)"
        ></textarea>
        <has-error :form="form" :field="name"></has-error>
    </div>
</template>

<script>
import {HasError} from "vform";

export default {
    props: {
        rows: {
            type: String,
            default: "4",
        },
        name: {
            type: String,
            required: true,
        },
        form: {
            type: Object,
            required: true,
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
