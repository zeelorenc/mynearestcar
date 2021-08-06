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
        </GmapMap>
    </div>
</template>

<script>
    import { gmapApi } from 'vue2-google-maps';

    export default {
        mounted() {
        },
        computed: {
            google: gmapApi,
        }
    }
</script>
