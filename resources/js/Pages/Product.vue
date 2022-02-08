<template>

    <nav-bar/>

    <div class="container" v-for="product in products" :key="product.id">
        <div class="card mb-3 mt-5 rounded-3">
            <div class="row g-0">

                <div class="col-3 d-flex">
                    <div class="align-self-center justify-content-center mx-auto">
                        <img src="/img/qr-card.png" class="img-fluid rounded-start" alt="QR Ticket">
                    </div>
                </div>

                <div class="col-7">
                    <div class="card-body">
                        <h5 class="card-title">{{ product.name }}</h5>
                        <p class="card-text small">{{ product.description }}</p>
                    </div>
                </div>

                <div class="col-2 d-flex">
                    <div class="align-self-center justify-content-center mx-auto">
                        <i class="fas h1 fa-chevron-right"></i>
                        <Link :href="product.url" class="stretched-link"></Link>
                    </div>
                </div>

            </div>
        </div>
    </div>

</template>

<script>

    import NavBar from "../Shared/NavBar";
    import {Link} from '@inertiajs/inertia-vue3'

    export default {
        props: {
            products: Array
        },
        name: "Product",
        components: {NavBar, Link}
    }
</script>

<style scoped>

</style>
