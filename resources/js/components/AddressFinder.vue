<template>
    <div>
        <gmap-autocomplete
            @place_changed="this.setPlace"
            class="form-control"
            placeholder="Enter the address"
            required="required"
            :class="this.errorClass"
            :options="{
                componentRestrictions: {country: 'au'}
            }"
        />
        <input type="hidden" name="latitude" :value="this.latitude">
        <input type="hidden" name="longitude" :value="this.longitude">

        <span class="invalid-feedback" role="alert" v-if="this.errorClass.trim() !== ''">
            <strong>Please select a valid location</strong>
        </span>
    </div>
</template>

<script>
export default {
    props: ['errorClass'],

    mounted() {
        console.log(this.errorClass);
    },

    data() {
        return {
            latitude: null,
            longitude: null
        }
    },

    methods: {
        setPlace: function (response) {
            this.latitude = response.geometry.location.lat()
            this.longitude = response.geometry.location.lng()
        }
    },
}
</script>
