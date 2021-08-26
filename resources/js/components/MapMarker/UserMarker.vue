<template>
    <GmapMarker
        v-if="this.location !== null"
        :position="this.location"
        :clickable="true"
        :icon="{
            url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
        }"
    />
</template>

<script>
export default {
    data() {
        return  {
            location: null,
        };
    },

    mounted() {
        this.getUserPosition();
    },

    methods: {
        getUserPosition: function () {
            navigator.geolocation.getCurrentPosition(position => {
                this.location = { lat: position.coords.latitude, lng: position.coords.longitude };
                this.$emit('loaded', this.location);
            });
        }
    },
}
</script>
