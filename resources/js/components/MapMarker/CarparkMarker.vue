<template>
    <GmapMarker
        :position="this.position"
        :clickable="true"
        @click="this.clicked"
        :icon="{
            url: require('../../../images/markers/carpark.png').default,
            size: { width: 32, height: 32, f: 'px', b: 'px' },
            scaledSize: { width: 32, height: 32, f: 'px', b: 'px' },
        }"
    />
</template>

<script>
export default {
    props: ['carpark'],

    methods: {
        clicked: function() {
            this.$emit('clicked');
        },
    } ,

    computed: {
        position: function () {
            return { lat: this.carpark.lat, lng: this.carpark.lng };
        }
    }
}
</script>
