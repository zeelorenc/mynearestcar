<template>
    <div>
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
            />
        </GmapMap>
    </div>
</template>

<script>
export default {
    data() {
        return {
            carparks: [],
        };
    },

    mounted() {
        this.loadCarparks();
    },

    methods: {
        loadCarparks: async function () {
            const { data } = await axios.get('api/carparks');
            this.carparks = data;
        },
    },
}
</script>
