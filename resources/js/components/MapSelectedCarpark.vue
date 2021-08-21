<template>
    <div class="card" v-if="carpark !== null">
        <div class="card-header">
            <h4>{{ carpark.name }}</h4>
            <span class="badge badge-light p-1"
                  data-toggle="tooltip"
                  ata-original-title="Available car quantity">14</span>
        </div>
        <div class="card-body d-flex justify-content-between">
            <small class="mr-2"><i class="fas fa-route mr-1"></i> 830m</small>
            <small class="mr-2"><i class="fas fa-walking mr-1"></i> 20 min</small>
            <small class="mr-2"><i class="fas fa-taxi mr-1"></i> 8 min</small>
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
                    <small class="mr-2">{{ vehicle.status }}</small>
                    <MapSelectedVehicle
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
}
</script>
