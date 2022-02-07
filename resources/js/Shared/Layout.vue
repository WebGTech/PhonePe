<template class="bg-light">
    <main>

        <nav-bar />

        <slot />

        <div class="position-absolute bottom-0 start-50 translate-middle">
            <img src="/img/atek_logo.png" class="img-fluid img" alt="logo">
        </div>

    </main>
</template>

<script>

    import { Link } from '@inertiajs/inertia-vue3'
    import NavBar from "./NavBar";

    export default {
        components: {
            NavBar,
            Link,
        }
    }

</script>

<style scoped>

</style>
