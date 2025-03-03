<script setup>
import { ref, reactive } from "vue";
import Header from "../components/Header.vue";
import { useForm } from "@inertiajs/vue3";

const step = ref(0);

const dialog = ref(false);
const selectedShipment = ref(null);
const statuses = ["Pending", "Shipped", "Delivered"];


defineProps({
    shipments: Array,
});


const form = useForm({
    sender_name: "",
    sender_address: "",
    receiver_name: "",
    receiver_address: "",
    package_weight: "",
    status: "Pending",
});

// Open dialog and populate form
const openDialog = (shipment = null) => {
    selectedShipment.value = shipment;
    if (shipment) {
        form.sender_name = shipment.sender_name;
        form.sender_address = shipment.sender_address;
        form.receiver_name = shipment.receiver_name;
        form.receiver_address = shipment.receiver_address;
        form.package_weight = shipment.package_weight;
        form.status = shipment.status;
    } else {
        form.reset();
    }
    dialog.value = true;
};

// Save shipment (Create or Update)
const saveShipment = () => {
   
        form.post("/shipments", {
            onSuccess: () => {
                dialog.value = false;
            },
        });
   
};


const getStatusColor = (status) => {
    return status === "Pending"
        ? "orange"
        : status === "Shipped"
        ? "blue"
        : "green";
};
</script>

<template>
    <Header />

    <div class="shipment">
        <v-container class="p-6">
            <v-card class="shadow-lg rounded-2xl">
                <v-card-title
                    class="text-2xl font-bold p-4 bg-blue-500 text-white"
                    >Manage Shipments</v-card-title
                >

                <v-card-text>
                    <!-- Add Shipment Button -->
                    <div class="flex justify-end m-4">
                        <v-btn
                            color="primary"
                            prepend-icon="mdi-plus"
                            @click="openDialog"
                            >Add Shipment</v-btn
                        >
                    </div>

                    <!-- Shipment Table -->
                    
                </v-card-text>
            </v-card>

            <!-- Shipment Dialog -->
            <v-dialog
                v-model="dialog"
                persistent
                max-width="600px"
                max-height="600px"
            >
                <v-card>
                    <v-card-title
                        class="text-xl font-bold p-4 bg-gray-800 text-white"
                    >
                        {{
                            selectedShipment ? "Edit Shipment" : "Add Shipment"
                        }}
                    </v-card-title>

                    <v-card-text class="p-4">
                        <v-stepper v-model="step">
                            <!-- Stepper Header -->
                            <v-stepper-header>
                                <v-stepper-item :complete="step > 1" step="1"
                                    >Sender</v-stepper-item
                                >
                                <v-divider></v-divider>
                                <v-stepper-item :complete="step > 2" step="2"
                                    >Receiver</v-stepper-item
                                >
                                <v-divider></v-divider>
                                <v-stepper-item step="3"
                                    >Package</v-stepper-item
                                >
                            </v-stepper-header>

                            <!-- Stepper Content -->
                            <v-stepper-window>
                                <!-- Step 1: Sender Details -->
                                <v-stepper-window-item value="1">
                                    <div>
                                        <label class="font-semibold"
                                            >Sender Name</label
                                        >
                                        <v-text-field
                                            v-model="form.sender_name"
                                            variant="outlined"
                                            placeholder="Sender Name"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="form.sender_address"
                                            variant="outlined"
                                            placeholder="Sender Address"
                                        ></v-text-field>
                                    </div>
                                    <div class="flex justify-end">
                                        <v-btn color="blue" @click="step++"
                                            >Next</v-btn
                                        >
                                    </div>
                                </v-stepper-window-item>

                                <!-- Step 2: Receiver Details -->
                                <v-stepper-window-item value="2">
                                    <div>
                                        <label class="font-semibold"
                                            >Receiver Name</label
                                        >
                                        <v-text-field
                                            v-model="form.receiver_name"
                                            variant="outlined"
                                            placeholder="Receiver Name"
                                        ></v-text-field>
                                    </div>
                                    <div>
                                        <label class="font-semibold"
                                            >Receiver Address</label
                                        >
                                        <v-text-field
                                            v-model="form.receiver_address"
                                            variant="outlined"
                                            placeholder="Receiver Name"
                                        ></v-text-field>
                                    </div>
                                    <div class="flex justify-between">
                                        <v-btn color="gray" @click="step--"
                                            >Back</v-btn
                                        >
                                        <v-btn color="blue" @click="step++"
                                            >Next</v-btn
                                        >
                                    </div>
                                </v-stepper-window-item>

                                <!-- Step 3: Package Details -->
                                <v-stepper-window-item value="3">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="font-semibold"
                                                >Weight (kg)</label
                                            >
                                            <v-text-field
                                                v-model="form.package_weight"
                                                type="number"
                                                variant="outlined"
                                            ></v-text-field>
                                        </div>
                                        <div>
                                            <label class="font-semibold"
                                                >Status</label
                                            >
                                            <v-select
                                                v-model="form.status"
                                                :items="statuses"
                                                variant="outlined"
                                            ></v-select>
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <v-btn color="gray" @click="step--"
                                            >Back</v-btn
                                        >
                                        <v-btn
                                            color="green"
                                            @click="saveShipment"
                                            >Save</v-btn
                                        >
                                    </div>
                                </v-stepper-window-item>
                            </v-stepper-window>
                        </v-stepper>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-container>
    </div>
</template>
