<template>

    <nav-bar/>

    <hero/>

    <div class="d-flex">
        <div class="btn-group mx-auto" role="group">
            <button type="button" class="btn btn-primary">Single</button>
            <button type="button" class="btn btn-outline-info">Return</button>
        </div>
    </div>

    <swiper
        :modules="modules"
        :slides-per-view="1"
        :space-between="50"
        navigation
        @swiper="onSwiper"
        @slideChange="onSlideChange">
        <swiper-slide class="text-center">
            <img class="border img-fluid m-2" src="/img/QR.png" alt="Qr Code" />
            <h1 class="small text-muted">S1234567890 | GENERATED</h1>
            <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-outline-primary"><i class="far fa-question-circle mx-1"></i> Need Help</a>
                <a href="#" class="btn btn-outline-primary"><i class="far fa-share-square mx-1"></i> Share Ticket</a>
            </div>
        </swiper-slide>
        <swiper-slide class="text-center">
            <img class="border img-fluid m-2" src="/img/QR.png" alt="Qr Code" />
            <h1 class="small text-muted">S1234567890 | GENERATED</h1>
            <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-outline-primary"><i class="far fa-question-circle mx-1"></i> Need Help</a>
                <a href="#" class="btn btn-outline-primary"><i class="far fa-share-square mx-1"></i> Share Ticket</a>
            </div>
        </swiper-slide>
        <swiper-slide class="text-center">
            <img class="border img-fluid m-2" src="/img/QR.png" alt="Qr Code" />
            <h1 class="small text-muted">S1234567890 | GENERATED</h1>
            <div class="btn-group btn-group-sm">
                <a href="#" class="btn btn-outline-primary"><i class="far fa-question-circle mx-1"></i> Need Help</a>
                <a href="#" class="btn btn-outline-primary"><i class="far fa-share-square mx-1"></i> Share Ticket</a>
            </div>
        </swiper-slide>
    </swiper>

    <div class="card m-2 p-2">
        <div class="row">
            <div class="col-4">
                <h6 class="text-muted">From Station</h6>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4 text-end">
                <h6 class="text-muted">To Station</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h6>Ghatkopar</h6>
            </div>
            <div class="col-4 text-center">
                <i class="fas fa-long-arrow-alt-right"></i>
            </div>
            <div class="col-4 text-end">
                <h6>Varsova</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <h6>Booking Date</h6>
            </div>

            <div class="col-7 text-end">
                <h6>1 Dec, 2021 2:10</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <h6>Expiry Date</h6>
            </div>

            <div class="col-7 text-end">
                <h6>2 Dec, 2021 1:10</h6>
            </div>
        </div>
    </div>

</template>

<script>

    import NavBar from "../../Shared/NavBar";
    import Hero from "../../Shared/Hero";
    import { Navigation } from 'swiper';
    import { Swiper, SwiperSlide } from 'swiper/vue';

    import 'swiper/css';
    import 'swiper/css';
    import 'swiper/css/navigation';

    export default {
        name: "View",
        components: {
            Hero, NavBar, Swiper,
            SwiperSlide,
        },
        setup() {
            const onSwiper = (swiper) => {
                console.log(swiper);
            };
            const onSlideChange = () => {
                console.log('slide change');
            };
            return {
                onSwiper,
                onSlideChange,
                modules: [Navigation],
            };
        }
    }
</script>

<style scoped>

</style>
