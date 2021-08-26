<template>
    <div class="card" v-if="carpark !== null">
        <div class="card-header">
            <h4>{{ carpark.name }}</h4>
            <span class="badge badge-light p-1"
                  data-toggle="tooltip"
                  ata-original-title="Available car quantity">{{ carpark.vehicles.length }}</span>
        </div>
        <div class="card-body d-flex justify-content-between" v-if="carpark.distance">
            <small class="mr-2"><i class="fas fa-route mr-1"></i> {{ distanceKm }}</small>
            <small class="mr-2"><i class="fas fa-walking mr-1"></i> {{ walkingMinutes }}</small>
            <small class="mr-2"><i class="fas fa-taxi mr-1"></i> {{ drivingMinutes }}</small>
        </div>
        <div class="list-group list-group-flush">
            <a
                :key="index"
                v-for="(vehicle, index) in this.carpark.vehicles"
                class="list-group-item list-group-item-action"
            >
                <div class="d-flex w-100 align-items-start justify-content-between">
                    <h6 class="mb-1">{{ vehicle.name }}</h6>
                    <b class="text-black">${{ vehicle.price }}</b>
                </div>
                <div class="d-flex w-100">
                    <small class="mr-2">{{ vehicle.seats }} seats</small>
                    <small :class="{ 'mr-2': true, 'text-danger': vehicle.status !== 'available' }">
                        {{ vehicle.status }}
                    </small>
                    <MapSelectedVehicle
                        v-if="vehicle.status === 'available'"
                        class="ml-auto"
                        :vehicle="vehicle"
                    />
                </div>
            </a>
            <div v-if="!carpark.vehicles.length" class="list-group-item text-center font-italic mb-2">
                No vehicles to show
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['carpark'],

    computed: {
        distanceKm: function () {
            return (this.carpark.distance / 1000).toFixed(0) + ' km';
        },

        walkingMinutes: function () {
            const metersPerMinute = 90;
            return this.formatTime(this.carpark.distance / metersPerMinute);
        },

        drivingMinutes: function () {
            const metersPerMinute = 360;
            return this.formatTime(this.carpark.distance / metersPerMinute);
        },

    },

    methods: {
        formatTime: function (time) {
            if (time > 60) {
                time /= 60;
                return time.toFixed(0) + ' hrs';
            } else {
                return time.toFixed(0) + ' mins';
            }
        }
    }
}
</script>
