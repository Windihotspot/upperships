<template>
    <Header />

    <div class="p-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-bold">Shipment Details</h2>

            <div v-if="shipment">
                <p><strong>Tracking ID:</strong> {{ shipment.tracking_id }}</p>
                <p><strong>Sender:</strong> {{ shipment.sender_name }}</p>
                <p><strong>Receiver:</strong> {{ shipment.receiver_name }}</p>
                <p><strong>Weight:</strong> {{ shipment.package_weight }} kg</p>
                <p><strong>Status:</strong> {{ shipment.status }}</p>
            </div>

            <div v-if="error" class="text-red-500 mt-4">
                <p>{{ error }}</p>
            </div>

            <v-btn class="mt-4" color="primary" @click="goBack">
                Go Back
            </v-btn>
        </div>
    </div>

    <Footer />
</template>

<script setup>

import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";

defineProps({
    shipment: Object,
    error: String,
});


</script>
