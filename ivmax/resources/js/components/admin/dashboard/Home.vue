<template>
    <div>
        <div class="col-12">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center pt-5 mb-5">
                    <h1 class="mt-5" style="color: #343a40">Welcome to Ivmax admin panel</h1>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-5">
                        <img src="/ivmax-black.png" alt="" width="400">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    mounted() {
        this.$emit("loadBreadcrumbLink", {
            pageName: "",
        });
    }
}


</script>

