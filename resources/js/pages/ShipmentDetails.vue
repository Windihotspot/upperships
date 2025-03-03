<script setup>
defineProps({
    shipment: Object,
});
</script>

<template>
    <v-container>
        <v-card>
            <v-card-title>Shipment Details</v-card-title>
            <v-card-text>
                <p><strong>Sender:</strong> {{ shipment.sender_name }}</p>
                <p><strong>Receiver:</strong> {{ shipment.receiver_name }}</p>
                <p><strong>Weight:</strong> {{ shipment.package_weight }} kg</p>
                <p>
                    <strong>Status:</strong>
                    <v-chip>
                        {{ shipment.status }}
                    </v-chip>
                </p>
            </v-card-text>
            <v-card-actions>
                <v-btn color="primary" @click="editShipment">Edit</v-btn>
                <v-btn color="red" @click="deleteShipment">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>
