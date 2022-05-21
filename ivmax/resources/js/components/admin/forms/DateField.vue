<template>
  <div class="form-group">
    <label :for="name">{{ label }}</label>
    <flat-pickr
      :id="name"
      :name="name"
      :config="config"
      class="form-control"
      :placeholder="placeholder"
      :class="{ 'is-invalid': form.errors.has(name) }"
      :value="value"
      @input="$emit('input', $event)"
      @on-open="onPickerOpen"
      @on-close="onPickerClose"
    ></flat-pickr>
    <has-error :form="form" :field="name"></has-error>
  </div>
</template>

<script>
import { HasError } from "vform";
import flatPickr from "vue-flatpickr-component";
import { Serbian } from "flatpickr/dist/l10n/sr";

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
    format: {
      type: String,
    },
    timepicker: {
      type: Boolean,
      default: false,
    },
    noCalendar: {
        type: Boolean,
        default: false,
    },
    minDate: {
      type: String | Date | null,
      default: null,
    },
    maxDate: {
      type: String | Date | null,
      default: null,
    },
    placeholder: String,
    label: String,
    value: String | null,
  },
  components: {
    HasError,
    flatPickr,
  },
  computed: {
    config() {
      return {
        // altFormat: "d.m.Y.",
        // altInput: true,
        dateFormat: this.dateFormat,
        disableMobile: true,
        enableTime: this.timepicker,
        time_24hr: true,
        minDate: this.minDate,
        maxDate: this.maxDate,
        locale: Serbian,
        noCalendar: this.noCalendar,
      };
    },
    dateFormat() {
      if (this.format) {
        return this.format;
      }
      return this.timepicker ? "d.m.Y. H:i" : "d.m.Y.";
    },
  },
  methods: {
    onPickerOpen() {
      if (this.$parent.$refs.modal) {
        this.$parent.$refs.modal.removeAttribute("tabindex");
      }
    },
    onPickerClose() {
      if (this.$parent.$refs.modal) {
        this.$parent.$refs.modal.setAttribute("tabindex", -1);
      }
    },
  },
};
</script>
