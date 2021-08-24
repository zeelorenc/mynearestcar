<template>
    <div class="mt-4">
        <!-- test card:  4242424242424242 -->
        <stripe-element-card
            ref="elementRef"
            :pk="pulishableKey"
            @token="tokenCreated"
            @error="tokenError"
            style="width: 100%"
        />
        <button
            class="btn btn-primary btn-lg ml-4"
            @click.prevent="submit"
            :disabled="processing"
        >
            <span v-if="processing"><i class="fas fa-spinner fa-spin fa-lg"></i></span>
            <span v-else>Pay Now</span>
        </button>
    </div>
</template>

<script>
import {StripeElementCard} from '@vue-stripe/vue-stripe';

export default {
    props: ['order'],
    components: {
        StripeElementCard,
    },
    data() {
        this.pulishableKey = process.env.MIX_STRIPE_PUBLISHABLE_KEY;
        return {
            token: null,
            processing: false,
        };
    },
    methods: {
        submit: async function () {
            console.log("submitted")
            this.processing = true;
            this.$refs.elementRef.submit();
        },
        tokenCreated: async function (token) {
            const { data } = axios.post(`/order/${this.order.id}/payment`, {
                payment_token: token,
            });
            console.log(data)
        },
        tokenError: function (e) {
            this.processing = false;
        }
    }
};
</script>
