<template>
    <!-- Header -->
    <Header />

    <!-- Main Container -->
    <div class="p-6">
        <!-- Timeline (60%) -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <p class="mb-6 text-lg font-semibold">Track Parcel</p>
            <p class="mb-6 text-sm font-normal">Enter Tracking details</p>
            <v-text-field
                 v-model="trackingNumber"
                label="Tracking Number"
                variant="outlined"
                dense
                required
                color="blue"
                class="w-full"
            ></v-text-field>
            <div class="mt-4">
                <v-btn @click="trackShipment" color="#FFC400" class="mx-2 btn p-2" rounded="pill">
                    
                    Track
                    <i class="fa-solid fa-arrow-right ml-2"></i>
                </v-btn>
            </div>
        </div>

        <div class="mt-4">
            <span class="text-primary">Login</span>  or <span class="text-primary">Signup</span> to view your recently tracked shipments
        </div>
       
    </div>

    <Footer />
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";

const trackingNumber = ref("");

const trackShipment = () => {
    if (!trackingNumber.value) {
        alert("Please enter a tracking number");
        return;
    }

    router.visit(route("shipments.track", { tracking_id: trackingNumber.value }));
};
</script>

<style scoped>
.v-tab {
    text-transform: none !important;
}
.btn {
    text-transform: none;
}
</style>
