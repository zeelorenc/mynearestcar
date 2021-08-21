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
            <div class="mb-2">
                <span class="mr-3"><i class="fas fa-car"></i> {{ vehicle.name }}</span>
                <span><i class="fas fa-user-friends"></i> {{ vehicle.seats }} seats</span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente, soluta!</p>

            <div class="mb-4">
                <div class="form-check mb-3">
                    <input class="form-check-input"
                           style="margin-top:0.4rem"
                           type="checkbox"
                           id="uber"
                           v-model="checked">
                    <label class="form-check-label w-100 d-flex align-items-center justify-content-between" for="uber">
                        Uber Request
                        <span class="badge badge-success">EXTRA</span>
                    </label>
                </div>

                <form action="" v-if="checked">
                    <div class="form-group mb-2">
                        <label>Datetime</label>
                        <input type="datetime-local" class="form-control">
                    </div>
                    <div class="form-group mb-0">
                        <label>Location</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>

            <a href="#" class="btn btn-primary btn-shadow btn-block">
                ORDER ({{ checked === true ? `$${vehicle.price} + UBER` : `$${vehicle.price}`}})
            </a>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: ['vehicle'],
    data() {
        return {
            checked: false
        }
    },

    methods: {}
}
</script>
