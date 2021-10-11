<template>
    <GmapMarker
        v-if="this.location !== null"
        :position="this.location"
        :clickable="true"
        :icon="{
            url: require('../../../images/markers/user.png').default,
            size: { width: 32, height: 32, f: 'px', b: 'px' },
            scaledSize: { width: 32, height: 32, f: 'px', b: 'px' },
        }"
    />
</template>

<script>
export default {
    props: ['userLocation'],

    data() {
        return  {
            location: this.userLocation || this.$root.currentLocation,
        };
    },

    mounted() {
        if (!this.userLocation) {
            this.getUserPosition();
        }
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
