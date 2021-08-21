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
                            :center='{lat: -37.8136, lng: 144.9631}'
                            :options='{
                                mapTypeControl: false,
                                streetViewControl: false,
                                fullscreenControl: false,
                            }'
                        >
                            <!-- user location -->
                            <UserMarker/>

                            <!-- all carpark locations -->
                            <CarparkMarker
                                :key="index"
                                v-for="(carpark, index) in this.carparks"
                                :carpark="carpark"
                                @clicked="clickedCarpark(carpark)"
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
        };
    },

    mounted() {
        this.loadCarparks();
    },

    methods: {
        loadCarparks: async function () {
            const {data} = await axios.get('api/carparks');
            this.carparks = data;
        },

        clickedCarpark: async function (carpark) {
            const {data} = await axios.get(`api/carparks/${carpark.id}/vehicles`);
            this.selectedCarpark = Object.assign(carpark, {vehicles: data});
            console.log(this.selectedCarpark);
        },
    },
}
</script>
