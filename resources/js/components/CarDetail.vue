<template>
    <div>
        <b-button v-b-modal="this.carName" variant="warning" size="sm">Book</b-button>

        <b-modal :id="this.carName" scrollable  content-class="shadow" hide-footer :title="this.carName">
            <div class="mb-2">
                <span class="mr-3">Toyota</span>
                <span><i class="fas fa-user-friends"></i> 5 seats</span>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente, soluta!</p>

            <div class="mb-4">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="uber" v-model="checked">
                    <label class="form-check-label" for="uber">
                        Uber Request
                    </label>
                </div>

                <form action="" v-if="checked">
                    <div class="form-group mb-2">
                        <label>Datetime</label>
                        <input type="datetime-local" class="form-control">
                    </div>
                    <div class="form-group mb-0">
                        <label>Location</label>
                        <input type="text" class="form-control">
                    </div>
                </form>
            </div>

            <a href="#" class="btn btn-primary btn-shadow btn-block">ORDER</a>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "CarDetail",
    props: ['carName'],
    data() {
        return {
            checked: false
        }
    }
}
</script>
