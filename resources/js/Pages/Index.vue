<template>
    <div class="position-absolute top-50 start-50 translate-middle">
        <img src="/img/logo.png" class="img-fluid" alt="logo">
    </div>

    <div class="position-absolute top-50 start-50 translate-middle mt-5 pt-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="position-absolute bottom-0 start-50 translate-middle">
        <img src="/img/atek_logo.png" class="img-fluid" alt="logo">
    </div>
</template>

<script>

    export default {

        name: "Index",
        mounted() {
            PhonePe.PhonePe.build(PhonePe.Constants.Species.web).then((sdk) => {
                sdk.fetchAuthToken().then((res) => {

                    const newRes = JSON.parse(JSON.stringify(res))
                    const {grantToken: token} = newRes

                    this.authenticate(token)

                }).catch((err) => {
                    alert(err);
                })
            })
        },
        authenticate: function (token) {
            this.$inertia.post('login', {token: token})
        }
    }
</script>

<style scoped>

</style>
