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
        class="contact__form d-flex flex-column"
      >
        <div class="input-group my-2 my-lg-3">
          <validation-provider
            class="input-wrap"
            name="full_name"
            v-slot="{ errors }"
          >
            <fieldset
              class="d-flex flex-column"
              :class="{ 'is-invalid': errors.length }"
            >
              <label for="full_name"> {{ full_name_label }}* </label>
              <input
                type="text"
                id="full_name"
                name="full_name"
                required
                minlength="3"
                maxlength="30"
                :placeholder="full_name_label"
                v-model.lazy="form.full_name"
              />
            </fieldset>
            <span class="invalid-feedback d-block">
              {{ errors[0] }}
            </span>
          </validation-provider>
        </div>
        <div class="input-group my-2 my-lg-3">
          <validation-provider
            class="input-wrap"
            name="email"
            v-slot="{ errors }"
          >
            <fieldset
              class="d-flex flex-column"
              :class="{ 'is-invalid': errors.length }"
            >
              <label for="email"> Email* </label>
              <input
                type="email"
                name="email"
                id="email"
                required
                minlength="3"
                maxlength="100"
                placeholder="Email"
                v-model.lazy="form.email"
              />
            </fieldset>
            <span class="invalid-feedback d-block">
              {{ errors[0] }}
            </span>
          </validation-provider>
        </div>
        <div class="input-group my-2 my-lg-3">
          <validation-provider
            class="input-wrap"
            name="message"
            v-slot="{ errors }"
          >
            <fieldset
              class="d-flex flex-column"
              :class="{ 'is-invalid': errors.length }"
            >
              <label for="message"> {{ message_label }}* </label>
              <textarea
                name="message"
                id="message"
                required
                cols="30"
                rows="3"
                minlength="3"
                maxlength="5000"
                :placeholder="message_label"
                v-model.lazy="form.message"
              ></textarea>
            </fieldset>
            <span class="invalid-feedback d-block">
              {{ errors[0] }}
            </span>
          </validation-provider>
        </div>
        <div class="input-group my-2 my-lg-3">
          <vue-recaptcha
            sitekey="6LdbIA0dAAAAABgIKIM3Rs5uHk71HfGpc2OSmo7K"
            ref="recaptcha"
            @verify="verifyRecaptcha"
          ></vue-recaptcha>
          <div class="help-block invalid-feedback d-block">
            {{ form.recaptchaMessage }}
          </div>
        </div>
        <button
          type="submit"
          class="btn btn-primary btn__white d-block mx-auto mx-lg-0 mt-3"
          :disabled="form.submit_button.disabled || failed"
        >
          <span>{{ send_label }}</span>
          <div v-if="form.submit_button.loading" class="spinner-border"></div>
        </button>
      </form>
    </validation-observer>
    <div v-else>
      <h3 class="white">{{ form_successful_submit }}</h3>
      <div class="submit-wrap justify-content-center mt-5">
        <button
          type="button"
          class="btn btn-primary btn__white d-block mx-auto mx-lg-0 mt-3"
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
import VueRecaptcha from "vue-recaptcha";

export default {
  props: [
    "full_name_label",
    "message_label",
    "send_label",
    "form_successful_submit",
  ],
  mixins: [validationMixin],
  components: { VueRecaptcha },

  data() {
    return {
      form: {
        full_name: "",
        email: "",
        message: "",
        recaptchaResponse: "",
        recaptchaVerified: false,
        recaptchaMessage: "",
        submit_button: {
          disabled: false,
          loading: false,
        },
        submitted: false,
      },
      transitionName: "",
    };
  },

  methods: {
    verifyRecaptcha(response) {
      this.form.recaptchaResponse = response;
      this.form.recaptchaMessage = "";
      this.form.recaptchaVerified = true;

      this.form.submit_button.disabled = false;
    },
    submitForm() {
      let formData = new FormData();

      formData.append("name", this.form.full_name);
      formData.append("email", this.form.email);
      formData.append("message", this.form.message);

      this.form.submit_button.loading = true;
      this.form.submit_button.disabled = true;

      if (!this.form.recaptchaVerified) {
        this.form.recaptchaMessage = "Please confirm that you are not a robot.";

        this.disableSubmitButton();
      } else {
        axios
          .post("/submit-contact-form", formData)
          .then((response) => {
            this.form.submit_button.loading = false;
            this.form.submitted = true;
            this.transitionName = "slide-right";

            this.form.submit_button.disabled = false;

            this.form.recaptchaResponse = "";
            this.form.recaptchaMessage = "";
            this.form.recaptchaVerified = false;
          })
          .catch((errors) => {
            this.disableSubmitButton();
          });
      }
    },
    resetForm() {
      this.form.full_name = "";
      this.form.email = "";
      this.form.message = "";

      this.form.submitted = false;
      this.transitionName = "slide-left";
    },
    disableSubmitButton() {
      this.form.submit_button.loading = false;
      this.form.submit_button.disabled = true;
    },
  },
};
</script>
