<template>
    <div>
        <b-button v-b-modal="`vehicle_${vehicle.id}`" variant="primary" size="sm">Order</b-button>
        <b-modal
            :id="`vehicle_${vehicle.id}`"
            scrollable
            content-class="shadow"
            hide-footer
            title="Order Rental Vehicle"
        >
            <div class="mb-4">
                <span class="mr-3"><i class="fas fa-car mr-1"></i> {{ vehicle.name }}</span>
                <span class="mr-3"><i class="fas fa-user-friends mr-1"></i> {{ vehicle.seats }} seats</span>
                <span class="mr-3"><i class="fas fa-vr-cardboard mr-1"></i> {{ vehicle.type }}</span>
                <span class="mr-3"><i class="fas fa-copyright mr-1"></i> {{ vehicle.brand }}</span>
                <span class="mr-3"><i class="fas fa-car-side mr-1"></i> {{ vehicle.model }}</span>
            </div>

            <form @submit.prevent="createOrder">
                <div class="mb-4">
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
                        <span class="badge badge-success">EXTRA</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-shadow btn-block">
                    ORDER ({{ uber_pickup === true ? `$${vehicle.price} + UBER` : `$${vehicle.price}` }})
                </button>
            </form>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: ['vehicle'],
    data() {
        return {
            from_date: null,
            to_date: null,
            uber_pickup: false,
            errors: {},
        }
    },

    methods: {
        createOrder: async function (e) {
            try {
                const { data } = await axios.post(`/api/order/create`, {
                    user_id: this.$root.currentUser.id,
                    vehicle_id: this.vehicle.id,
                    from_date: new Date(this.from_date),
                    to_date: new Date(this.to_date),
                    uber_pickup: this.uber_pickup,
                    user_location: this.$root.currentLocation,
                });
                window.location.href = `/order/${data.id}`;
            } catch (e) {
                this.errors = e.response.data.errors || {}
            }
        }
    }
}
</script>
