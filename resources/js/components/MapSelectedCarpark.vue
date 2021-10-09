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
                v-for="(vehicle, index) in this.sortedCarparkVehicles"
                class="list-group-item list-group-item-action"
                v-bind:class="filter.vehicleModel === vehicle.model ? 'glow-border' : ''"
            >
                <div class="d-flex w-100 align-items-start justify-content-between">
                    <h6 class="mb-2">
                        {{ vehicle.name }}

                        <span :class="['badge', {
                                'text-capitalize': true,
                                'badge-danger': vehicle.status !== 'available',
                                'badge-success': vehicle.status === 'available'
                            }]">
                                {{ vehicle.status }}
                            </span>
                    </h6>
                    <b class="text-black">${{ vehicle.price }}</b>
                </div>
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <small class="mr-2">{{ vehicle.seats }} seats</small>
                        <small class="mr-2">{{ vehicle.type }}</small>
                        <small class="mr-2">{{ vehicle.brand }}</small>
                        <small class="mr-2">{{ vehicle.model }}</small>
                    </div>
                    <div class="d-flex">
                        <div>
                            <button
                                class="btn btn-sm"
                                v-bind:class="{
                                'btn-outline-dark': favourites && favourites.includes(vehicle.id),
                                'btn-outline-danger': !favourites || !favourites.includes(vehicle.id)
                            }"
                                @click="favourite(vehicle)"
                            >
                                <i
                                    class="fas"
                                    v-bind:class="{
                                        'fa-check': favourites && favourites.includes(vehicle.id),
                                        'fa-heart': !favourites || !favourites.includes(vehicle.id)
                                    }"
                                ></i>
                            </button>
                        </div>
                        <MapSelectedVehicle
                            v-if="vehicle.status === 'available'"
                            class="ml-2"
                            :vehicle="vehicle"
                            :carpark="carpark"
                        />
                    </div>
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
    props: ['carpark', 'filter'],

    data() {
        return {
            favourites: [],
        }
    },

    computed: {
        sortedCarparkVehicles: function () {
            return this.carpark.vehicles.sort((a, b) => {
                return !this.favourites || this.favourites.includes(a.id) === this.favourites.includes(b.id)
                    ? 0
                    : (this.favourites.includes(b.id) ? 1 : -1);
            })
        },

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

    mounted() {
        this.loadFavourites();
    },

    methods: {
        loadFavourites: async function () {
            const {data} = await axios.get(`/api/favourite/${window.currentUser.id}`);
            this.favourites = data.map(v => v.id);
            console.log(this.favourites);
        },

        favourite: async function (vehicle) {
            const {data} = await axios.post(`/api/favourite/${window.currentUser.id}/vehicle/${vehicle.id}`);
            this.loadFavourites();
        },

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
