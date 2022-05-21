import {
    ValidationProvider,
    ValidationObserver,
    localize,
    extend
} from "vee-validate";
import {
    required,
    alpha_spaces,
    numeric,
    email,
    oneOf,
    min,
    max,
    min_value,
    max_value,
    confirmed,
    ext,
    regex
} from "vee-validate/dist/rules";
import en from "vee-validate/dist/locale/en.json";
import sr_latin from "vee-validate/dist/locale/sr_Latin.json";

export default {
    components: {
        ValidationProvider,
        ValidationObserver
    },
    mounted() {
        localize({
            en: {
                messages: { ...en.messages },
                names: {
                    full_name: "full name",
                    email: "email",
                    message: "message"
                }
            },
            sr_latin: {
                messages: { ...sr_latin.messages },
                names: {
                    full_name: "full name",
                    email: "email",
                    message: "message"
                }
            }
        });

        extend("required", required);
        extend("alpha_spaces", alpha_spaces);
        extend("numeric", numeric);
        extend("min_value", min_value);
        extend("max_value", max_value);
        extend("confirmed", confirmed);
        extend("numeric", numeric);
        extend("email", email);
        extend("oneOf", oneOf);
        extend("min", min);
        extend("max", max);
        extend("ext", ext);
        extend("regex", regex);

        // window._locale === "en" ? localize("en") : localize("sr_latin");
        window._locale === "en" ? localize("en") : localize("en");
    }
};
