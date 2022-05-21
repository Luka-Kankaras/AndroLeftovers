<template>
  <div class="form-group">
    <div class="custom-control custom-checkbox">
      <input
        type="checkbox"
        class="custom-control-input"
        :class="{ 'is-invalid': form.errors.has(name) }"
        :name="name"
        :id="inputId"
        :checked="value"
        @input="$emit('input', $event.target.checked)"
      />
      <label class="custom-control-label font-weight-normal" :for="inputId">
        {{ label }}
      </label>
      <has-error :form="form" :field="name"></has-error>
    </div>
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
    label: {
      type: String,
      required: true,
    },
    form: {
      type: Object,
      required: true,
    },
    value: {
      type: Boolean,
      default: false,
    },
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
};
</script>
