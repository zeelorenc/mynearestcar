<template>

    <div class="row" v-show="visible">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0 overflow-hidden rounded">
                    <div class="google-map-container map-modal">
                        <GmapMap
                            ref='uberMapRef'
                            :zoom='12'
                            map-type-id='terrain'
                            :center="{ lat: -37.8136, lng: 144.9631 }"
                            :options='{
                                mapTypeControl: false,
                                streetViewControl: false,
                                fullscreenControl: false,
                                zoomControl: false,
                            }'
                        >
                            <!-- user location -->
                            <UserMarker />

                            <!-- carpark location -->
                            <CarparkMarker :carpark="carpark"/>
                        </GmapMap>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['vehicle', 'carpark', 'visible', 'route'],

    data() {
        return {
            directionsRender: null,
            uberMapRef: null,
            directionsResponse: null,
        };
    },

    watch: {
        visible: function () {
            if (this.visible === true && this.directionsResponse !== null) {
                this.directionsRender.setDirections(this.directionsResponse);
            }
        }
    },

    mounted() {
        this.$refs.uberMapRef.$mapPromise.then(() => {
            this.setDirections(
                this.$root.currentLocation,
                {'lat': this.carpark.lat, 'lng': this.carpark.lng}
            );
        });
    },

    methods: {
        setDirections: function (start, finish) {
            const mapObject = this.$refs.uberMapRef.$mapObject;
            if (this.directionsRender !== null) {
                this.directionsRender.setMap(null);
            }
            this.directionsRender = new google.maps.DirectionsRenderer({suppressMarkers: true});
            this.directionsRender.setMap(mapObject);

            // if this.route is set (in the view order page), then it will preset the route from the database
            if (this.route) {
                this.directionsRender.setDirections(this.directionsResponse = this.route);
            } else {
                new google.maps.DirectionsService().route(
                    {
                        origin: start,
                        destination: finish,
                        optimizeWaypoints: true,
                        travelMode: 'DRIVING'
                    },
                    (response, status) => {
                        if (status === 'OK') {
                            this.directionsResponse = response;
                            this.directionsRender.setDirections(response);
                            this.$emit('calculated', response);
                        }
                    }
                );
            }
        }
    },
}
</script>
