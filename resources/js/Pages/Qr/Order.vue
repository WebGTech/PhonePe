<template>

    <form @submit.prevent="ticket.post('/qr/order/create')">

        <div class="card shadow-sm m-2 p-3">

            <label for="source" class="form-label small text-muted">Source</label>
            <select id="source" class="form-select" v-model="ticket.source_id" v-on:change="getFare">
                <option disabled value="">Select source station</option>
                <option
                    v-for="station in stations"
                    :key="station.id"
                    :value="station.stn_id">
                    {{ station.stn_name }}
                </option>
            </select>
            <div class="small text-danger" v-if="ticket.errors.source_id">{{ ticket.errors.source_id }}</div>

            <label for="destination" class="form-label mt-2 small text-muted">Destination</label>
            <select id="destination" class="form-select" v-model="ticket.destination_id" v-on:change="getFare">
                <option disabled value="">Select destination station</option>
                <option v-for="station in stations"
                        :key="station.id"
                        :value="station.stn_id">
                    {{ station.stn_name }}
                </option>
            </select>
            <div class="small text-danger" v-if="ticket.errors.destination_id">{{ ticket.errors.destination_id }}</div>

            <label class="form-label mt-3 small text-muted">Type & Quantity</label>
            <div class="mt-1">
                <div class="row">
                    <div class="col-8 text-start">
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="type"
                                id="single"
                                value="11"
                                v-model="ticket.pass_id"
                                v-on:change="getFare">
                            <label class="form-check-label" for="single">Single</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio" name="type"
                                id="return" value="91"
                                v-model="ticket.pass_id"
                                v-on:change="getFare">
                            <label class="form-check-label" for="return">Return</label>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="row">
                            <div class="col-4" v-on:click="ticket.quantity < 6 ? ticket.quantity++ : ticket.quantity">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="col-4">
                                <p v-text="ticket.quantity" v-on:change="getFare"></p>
                            </div>
                            <div class="col-4" v-on:click="ticket.quantity > 1 ? ticket.quantity-- : ticket.quantity">
                                <i class="fas fa-minus-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-2 text-center" v-if="ticket.errors.pass_id||ticket.errors.quantity||ticket.errors.fare">
                <div class="small text-danger">{{ ticket.errors.pass_id }}</div>
                <div class="small text-danger">{{ ticket.errors.quantity }}</div>
                <div class="small text-danger">{{ ticket.errors.fare }}</div>
            </div>

            <div class="p-3">

                <h6 class="text-center h6">Order Details</h6>

                <div class="my-2">
                    <div class="col text-center">
                        <h1 class="h1">₹ {{ ticket.quantity * ticket.fare }}</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 text-start">Ticket Type</div>
                    <div class="col-6 text-end">{{ ticket.pass_id === "11" ? "Single" : "Return" }}</div>
                </div>
                <div class="row">
                    <div class="col-6 text-start">Ticket Quantity</div>
                    <div class="text-end col-6">{{ ticket.quantity }}</div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-6 text-start">Total Fare</div>
                    <div class="text-end col-6">{{ ticket.quantity }} x ₹ {{ ticket.fare }} = ₹ {{ ticket.quantity *
                        ticket.fare }}
                    </div>
                </div>

            </div>

            <div class="m-2 p-2 fixed-bottom">
                <button type="submit" class="btn btn-primary w-100" :disabled="ticket.processing">PROCEED</button>
            </div>

        </div>

    </form>

</template>

<script>

    import {Link} from '@inertiajs/inertia-vue3'
    import { useForm } from '@inertiajs/inertia-vue3'

    export default {

        props: {
            stations: Array
        },

        name: "Order",

        components: {
            Link
        },

        data() {
            return {
                ticket: useForm({
                    source_id: '',
                    destination_id: '',
                    quantity: 1,
                    fare: 0,
                    pass_id: "11"
                })
            }
        },

        methods: {
            getFare: async function () {
                let response = await fetch('/api/fare/', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        "source": this.ticket.source_id,
                        "destination": this.ticket.destination_id,
                        "pass_id": this.ticket.pass_id
                    })
                })
                let data = await response.json();
                if (data.status) this.ticket.fare = data.fare
                else console.log(data.errors)
            }
        }

    }
</script>

<style scoped>

</style>
