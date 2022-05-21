<template>
  <div class="form-group">
    <label :for="name">{{ label }}</label>
    <input
      :id="name"
      :name="name"
      type="number"
      class="form-control"
      :step="step"
      :placeholder="placeholder"
      :class="{ 'is-invalid': form.errors.has(name) }"
      :value="value"
      @input="$emit('input', $event.target.value)"
    />
    <has-error :form="form" :field="name"></has-error>
  </div>
</template>

<script>
import { HasError } from "vform";

export default {
  props: {
    name: {
      type: String,
      required: true,
    },
    form: {
      type: Object,
      required: true,
    },
    step: {
      type: Number,
      default: 1,
    },
    placeholder: String,
    label: String,
    value: Number | String,
  },
  components: {
    HasError,
  },
};
</script>
