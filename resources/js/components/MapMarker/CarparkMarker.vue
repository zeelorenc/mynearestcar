<template>
    <GmapMarker
        :position="this.position"
        :clickable="true"
        @click="this.clicked"
        :icon="{
            url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
        }"
    />
</template>

<script>
export default {
    props: ['carpark'],

    methods: {
        clicked: () => {
            // TODO: add expand sidebar
            alert("Clicked a carpark");
        },
    } ,

    computed: {
        position: function () {
            return { lat: this.carpark.lat, lng: this.carpark.lng };
        }
    }
}
</script>
