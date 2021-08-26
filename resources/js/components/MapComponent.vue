<template>

    <div class="row">
        <div v-bind:class="[selectedCarpark ? 'col-8' : 'col-12']">
            <div class="card">
                <div class="card-body p-0 overflow-hidden rounded">
                    <div class="google-map-container">
                        <GmapMap
                            ref='mapRef'
                            :zoom='12'
                            map-type-id='terrain'
                            :center='focusLocation'
                            :options='{
                                mapTypeControl: false,
                                streetViewControl: false,
                                fullscreenControl: false,
                            }'
                        >
                            <!-- user location -->
                            <UserMarker @loaded="loadedLocation"/>

                            <!-- all carpark locations -->
                            <CarparkMarker
                                :key="index"
                                v-for="(carpark, index) in this.carparks"
                                :carpark="carpark"
                                @clicked="clickedCarpark(carpark)"
                            />

                            <gmap-polygon
                                v-if="focusCarparkPaths !== null"
                                :paths="focusCarparkPaths"
                                :options="{ strokeColor: '#ff0000ff' }"
                            />
                        </GmapMap>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4" v-show="selectedCarpark">
            <MapSelectedCarpark
                :carpark="selectedCarpark"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            carparks: [],
            selectedCarpark: null,
            focusLocation: {lat: -37.8136, lng: 144.9631},
            focusCarparkPaths: null,
        };
    },

    mounted() {
        this.loadCarparks();
    },

    methods: {
        loadedLocation: async function (location) {
            const {data: carparks} = await axios.post('api/carparks/nearest', location);
            this.$root.currentLocation = location;
            this.carparks = carparks;

            // select closest carpark if they have not selected one
            if (this.selectedCarpark === null) {
                this.clickedCarpark(carparks[0]);
            } else {
                this.drawLineToCarpark({
                    lat: this.selectedCarpark.lat,
                    lng: this.selectedCarpark.lng
                });
            }
        },

        loadCarparks: async function () {
            const {data} = await axios.get('api/carparks');
            this.carparks = data;
        },

        clickedCarpark: async function (carpark) {
            const {data} = await axios.get(`api/carparks/${carpark.id}/vehicles`);
            this.selectedCarpark = Object.assign(carpark, {vehicles: data});

            const carparkLocation = {lat: carpark.lat, lng: carpark.lng};
            if (this.$root.currentLocation !== null) {
                this.focusLocation = this.getMidPoint(this.$root.currentLocation, carparkLocation);
                this.drawLineToCarpark(carparkLocation);
            } else {
                this.focusLocation = carparkLocation;
            }
        },

        drawLineToCarpark: function (carparkLocation) {
            if (this.$root.currentLocation !== null) {
                this.focusCarparkPaths = [
                    carparkLocation,
                    this.$root.currentLocation,
                ];
            }
        },

        getMidPoint: function (locationOne, locationTwo) {
            return {
                lat: (locationOne.lat + locationTwo.lat) / 2,
                lng: (locationOne.lng + locationTwo.lng) / 2,
            }
        }
    },
}
</script>
