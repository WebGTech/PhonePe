<!--suppress ALL -->
<template>

    <div class="m-3 my-5">
        <div class="row">
            <small>Feb 6, 2022</small>
        </div>
        <div class="row">
            <h5 class="h3">Welcome, Govind Yadav</h5>
        </div>
    </div>

    <RecentTicket />
    <UpcomingTicket />

    <div class="m-2 p-2 fixed-bottom">
        <Link href="/qr/order" as="button" class="btn btn-primary w-100">BUY NEW TICKET </Link>
    </div>

</template>

<script>

    import Layout from "../../Shared/Layout";
    import RecentTicket from "../../Shared/RecentTicket";
    import UpcomingTicket from "../../Shared/UpcomingTicket";
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        name: "Dashboard",
        components: {
            UpcomingTicket,
            RecentTicket,
            Layout,
            Link
        }
    }
</script>

<style scoped>

</style>
