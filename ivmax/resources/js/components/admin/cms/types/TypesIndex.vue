<template>
    <div class="row">
        <div class="col-6">
            <toothbrush-index/>
        </div>
        <div class="col-6">
            <toothpaste-index/>
        </div>
    </div>
</template>

<script>

import ToothbrushIndex from "./toothbrush-types/ToothbrushIndex";
import ToothpasteIndex from "./toothpaste-types/ToothpasteIndex";

export default {
    components: {
        ToothbrushIndex,
        ToothpasteIndex,
    },
    data() {
        return {}
    },
    mounted() {
        this.$emit("loadBreadcrumbLink", {
            pageName: "Types",
        });
    },
};
</script>
