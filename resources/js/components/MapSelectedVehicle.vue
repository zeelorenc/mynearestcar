<template>
    <div>
        <b-button v-b-modal="`vehicle_${vehicle.id}`" variant="primary" size="sm">Order</b-button>
        <b-modal
            :id="`vehicle_${vehicle.id}`"
            scrollable
            content-class="shadow"
            hide-footer
            title="Order Rental Vehicle"
            size="lg"
        >
            <div class="mb-4">
                <span class="mr-3"><i class="fas fa-car mr-1"></i> {{ vehicle.name }}</span>
                <span class="mr-3"><i class="fas fa-user-friends mr-1"></i> {{ vehicle.seats }} seats</span>
                <span class="mr-3"><i class="fas fa-vr-cardboard mr-1"></i> {{ vehicle.type }}</span>
                <span class="mr-3"><i class="fas fa-copyright mr-1"></i> {{ vehicle.brand }}</span>
                <span class="mr-3"><i class="fas fa-car-side mr-1"></i> {{ vehicle.model }}</span>
            </div>

            <form @submit.prevent="createOrder">
                <div class="mb-3">
                    <div class="form-group mb-2">
                        <label>From Date</label>
                        <input
                            type="datetime-local"
                            :class="{
                                'form-control': true,
                                'is-invalid': errors.from_date || false,
                            }"
                            v-model="from_date"
                        >

                        <span class="invalid-feedback" role="alert" v-if="errors.from_date">
                            <strong>{{ errors.from_date[0] }}</strong>
                        </span>
                    </div>

                    <div class="form-group mb-2">
                        <label>To Date</label>
                        <input
                            type="datetime-local"
                            :class="{
                                'form-control': true,
                                'is-invalid': errors.to_date || false,
                            }"
                            v-model="to_date"
                        >
                        <span class="invalid-feedback" role="alert" v-if="errors.to_date">
                            <strong>{{ errors.to_date[0] }}</strong>
                        </span>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-check-label w-100 d-flex align-items-center justify-content-between">
                        Grand Total (${{ vehicle.price }} per day)
                        <span>{{ grandTotal > 0 ? `$${grandTotal}` : '?' }}</span>
                    </label>
                </div>

                <div class="form-group mb-3">
                    <label class="form-check-label w-100 d-flex align-items-center justify-content-between">
                        Security Deposit ({{ this.securityDepositPercentage }}%)
                        <span>{{ securityDeposit > 0 ? `$${securityDeposit}` : '?' }}</span>
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input"
                           style="margin-top:0.4rem"
                           type="checkbox"
                           id="uber"
                           :disabled="this.$root.currentLocation === null"
                           v-model="uber_pickup">
                    <label class="form-check-label w-100 d-flex align-items-center justify-content-between"
                           for="uber">
                        Uber Request
                        <span class="badge badge-success">
                            EXTRA <span v-if="uber_route !== null">${{ uberCost }}</span>
                        </span>
                    </label>
                </div>

                <OrderMap
                    :vehicle="vehicle"
                    :carpark="carpark"
                    v-if="this.$root.currentLocation !== null"
                    :visible="uber_pickup === true"
                    @calculated="calculatedUber"
                />

                <button type="submit" class="btn btn-primary btn-shadow btn-block"
                        :disabled="uber_pickup === true && uber_route === null || this.grandTotal <= 0">
                    ORDER NOW
                    <span v-show="this.grandTotal > 0">
                        ${{ (parseFloat(this.grandTotal) + parseFloat(this.securityDeposit)).toFixed(2) }}
                    </span>
                </button>
            </form>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: ['vehicle', 'carpark'],
    data() {
        return {
            from_date: null,
            to_date: null,
            uber_pickup: false,
            uber_route: null,
            errors: {},
            securityDepositPercentage: 20,
        }
    },

    computed: {
        uberCost: function () {
            const distance = this.uber_route.routes[0].legs[0].distance.value;
            const kilometers = distance / 1000;
            return (5 + kilometers * 2.5).toFixed(2);
        },
        grandTotal: function () {
            try {
                const ONE_DAY = 1000 * 60 * 60 * 24;
                const differenceMs = new Date(this.to_date) - new Date(this.from_date);
                const rentalPeriod = differenceMs / ONE_DAY;
                if (rentalPeriod < 0 || rentalPeriod > 1000) {
                    throw 'Both dates not valid'
                }
                const uber = this.uber_pickup === true ? parseFloat(this.uberCost) : 0.0;
                return (parseFloat(this.vehicle.price * rentalPeriod) + uber).toFixed(2);
            } catch (e) {
                console.log(e);
                return 0
            }
        },
        securityDeposit: function () {
            try {
                return parseFloat(this.grandTotal * this.securityDepositPercentage / 100).toFixed(2);
            } catch (e) {
                return 0
            }
        }
    },

    methods: {
        calculatedUber: function (response) {
            this.uber_route = response;
        },

        createOrder: async function (e) {
            try {
                const {data} = await axios.post(`/api/order/create`, {
                    user_id: this.$root.currentUser.id,
                    vehicle_id: this.vehicle.id,
                    from_date: new Date(this.from_date),
                    to_date: new Date(this.to_date),
                    uber_pickup: this.uber_pickup,
                    user_location: this.$root.currentLocation,
                    uber_route: this.uber_route,
                });
                if (data.id) {
                    window.location.href = `/order/${data.id}`;
                }
            } catch (e) {
                this.errors = e.response.data.errors || {}
            }
        }
    }
}
</script>
