<template>
  <transition :name="transitionName" mode="out-in" appear>
    <validation-observer
      v-if="!form.submitted"
      ref="form"
      v-slot="{ handleSubmit, failed }"
    >
      <form
        novalidate
        @submit.prevent="handleSubmit(submitForm)"
        class="newsletters-form mx-auto text-left"
      >
        <validation-provider
          class="input-wrap"
          name="email"
          v-slot="{ errors }"
        >
          <fieldset
            class="d-flex flex-column"
            :class="{ 'is-invalid': errors.length }"
          >
            <input
              type="email"
              name="email"
              id="email_newsletter"
              class="input__email"
              required
              minlength="3"
              maxlength="100"
              placeholder="E-mail"
              v-model.lazy="form.email"
            />
          </fieldset>
          <span class="invalid-feedback d-block">
            {{ errors[0] }}
          </span>
        </validation-provider>
        <button
          type="submit"
          class="submit__email"
          aria-label="Subscribe to our Newsletter"
          :disabled="failed"
        >
          <img src="assets/images/send.png" alt="Send" />
        </button>
      </form>
    </validation-observer>
    <div v-else>
      <h3 class="white">{{ form_successful_submit }}</h3>
      <div class="submit-wrap justify-content-center">
        <button
          type="button"
          class="btn btn-primary btn__white d-block mx-auto mt-3"
          @click="resetForm"
        >
          <span>OK!</span>
        </button>
      </div>
    </div>
  </transition>
</template>

<script>
import validationMixin from "../../validationMixin";

export default {
  props: ["form_successful_submit"],
  mixins: [validationMixin],

  data() {
    return {
      form: {
        email: "",
        submitted: false,
        errors: [],
      },
      transitionName: "",
    };
  },
  methods: {
    submitForm() {
      let formData = new FormData();

      formData.append("email", this.form.email);

      axios
        .post("/newsletter/store", formData)
        .then((response) => {
          this.form.submitted = true;

          this.transitionName = "slide-right";
        })
        .catch((errors) => {
          if (errors.message == "Request failed with status code 422") {
            this.$refs.form.errors.email.push("The email has already been taken.");
          }
        });
    },
    resetForm() {
      this.form.email = "";

      this.form.submitted = false;
      this.transitionName = "slide-left";
    },
  },
};
</script>
