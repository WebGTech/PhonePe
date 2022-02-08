<template class="container">
    <div class="row m-2">

        <div class="col-1 p-1 my-1 rounded-circle text-center bg-white d-flex">
            <i class="fas fa-angle-left align-self-center justify-content-center mx-auto p-1"></i>
        </div>

        <div class="col-10 d-flex">
            <div class="align-self-center mx-auto">
                <h1 class="h3 text-dark">Mumbai Metro One</h1>
            </div>
        </div>

        <div class="col-1 p-1 my-1 rounded-circle text-center bg-white d-flex">
            <i class="fas fa-bars align-self-center p-1 justify-content-center mx-auto" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu" aria-labelledby="options">
                <li><Link class="dropdown-item" href="/">Home</Link></li>
                <li><Link class="dropdown-item" href="/history">Booking History</Link></li>
                <li><Link class="dropdown-item" href="/terms">Terms & Conditions</Link></li>
            </ul>
        </div>

    </div>
</template>

<script>

    import {Link} from '@inertiajs/inertia-vue3'

    export default {
        name: "NavBar",
        components: {Link}
    }
</script>

<style scoped>

</style>
