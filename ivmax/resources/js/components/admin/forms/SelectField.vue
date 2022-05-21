<template>
    <div class="form-group">
        <label :for="name">{{ label }}</label>

        <select
            v-if="simple"
            :id="name"
            :class="{ 'is-invalid': !simple && form && form.errors.has(name) }"
            :disabled="disabled"
            :name="name"
            :value="value"
            class="custom-select"
            @input="$emit('input', $event.target.value)"
        >
            <option disabled selected value>{{ placeholder }}</option>
            <option
                v-for="option in options"
                :key="option[optionValue]"
                :value="translatable ? option[optionValue][languageKey] : option[optionValue]"
            >
                {{ translatable ? option[optionValue][languageKey] : option[optionValue] | short }}
            </option>
        </select>

        <multiselect
            v-else
            :id="name"
            :class="{ 'is-invalid': !simple && form && form.errors.has(name) }"
            :custom-label="!translatable ? (opt) => options.find((x) => x[optionValue] == opt)[optionLabel] : (opt) => options.find((x) => x[optionValue] == opt)[optionLabel][languageKey]"
            :disabled="disabled"
            :multiple="multiple"
            :name="name"
            :options="options.map((option) => option[optionValue])"
            :placeholder="placeholder"
            :searchable="searchable"
            :showLabels="false"
            :value="value"
            @input="$emit('input', $event)"
        >
            <template slot="noOptions">No results</template>
            <template slot="noResult">No results</template>
        </multiselect>

        <has-error v-if="!simple" :field="name" :form="form"></has-error>
    </div>
</template>

<script>
import {HasError} from "vform";

export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        form: {
            type: Object,
            required: false,
            default: null
        },
        options: {
            type: Array | null,
            required: true,
        },
        searchable: {
            type: Boolean,
            default: false,
        },
        optionValue: {
            type: String,
            default: "id",
        },
        optionLabel: {
            type: String,
            required: true,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        simple: {
            type: Boolean,
            default: false,
        },
        multiple: {
            type: Boolean,
            default: false,
        },
        translatable: {
            type: Boolean,
            default: false,
        },
        languageKey: {
            type: String,
            default: "en",
        },
        placeholder: String,
        label: String,
        value: String | Number | Array,
    },
    components: {
        HasError,
        Multiselect: () =>
            import(/* webpackChunkName: "vue-multiselect" */ "vue-multiselect"),
    },
};
</script>
