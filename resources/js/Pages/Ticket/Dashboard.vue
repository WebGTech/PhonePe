<template>

    <nav-bar />

    <div class="m-3">
        <div class="row">
            <small>Feb 6, 2022</small>
        </div>
        <div class="row">
            <h5 class="h3">Welcome, Govind Yadav</h5>
        </div>
    </div>

    <recent-ticket />

    <upcoming-ticket />

    <div class="m-2 p-2 fixed-bottom">
        <Link href="/ticket/order" class="btn btn-primary w-100">BUY NEW TICKET </Link>
    </div>

</template>

<script>

    import NavBar from "../../Shared/NavBar";
    import RecentTicket from "../../Shared/RecentTicket";
    import UpcomingTicket from "../../Shared/UpcomingTicket";
    import {Link} from '@inertiajs/inertia-vue3'

    export default {
        name: "Dashboard",
        components: {UpcomingTicket, RecentTicket, NavBar, Link}
    }

</script>

<style scoped>

</style>
