<script setup>
import { ref, reactive } from "vue";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";

const shipments = ref([
    {
        id: 1,
        trackingId: "123ABC",
        sender: { name: "John Doe" },
        receiver: { name: "Jane Smith" },
        package: { weight: 2 },
        status: "Pending",
    },
    {
        id: 2,
        trackingId: "456DEF",
        sender: { name: "Alice" },
        receiver: { name: "Bob" },
        package: { weight: 5 },
        status: "Shipped",
    },
]);
const step = ref(1);

const dialog = ref(false);
const selectedShipment = ref(null);
const statuses = ["Pending", "Shipped", "Delivered"];

const form = reactive({
    sender: { name: "" },
    receiver: { name: "" },
    package: { weight: "" },
    status: "Pending",
});

const openDialog = (shipment) => {
    selectedShipment.value = shipment;
    if (shipment) {
        Object.assign(form, JSON.parse(JSON.stringify(shipment))); // Clone shipment
    } else {
        Object.assign(form, {
            sender: { name: "" },
            receiver: { name: "" },
            package: { weight: "" },
            status: "Pending",
        });
    }
    dialog.value = true;
};

const saveShipment = () => {
    if (selectedShipment.value) {
        // Update existing shipment
        const index = shipments.value.findIndex(
            (s) => s.id === selectedShipment.value.id
        );
        shipments.value[index] = { ...selectedShipment.value, ...form };
    } else {
        // Add new shipment
        shipments.value.push({
            id: Date.now(),
            trackingId: `TRK-${Date.now().toString().slice(-5)}`,
            ...form,
        });
    }
    dialog.value = false;
};

const deleteShipment = (id) => {
    shipments.value = shipments.value.filter((s) => s.id !== id);
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
                            @click="openDialog(null)"
                            >Add Shipment</v-btn
                        >
                    </div>

                    <!-- Shipment Table -->
                    <v-table class="shadow rounded-lg">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-3">Tracking ID</th>
                                <th class="p-3">Sender</th>
                                <th class="p-3">Receiver</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="shipment in shipments"
                                :key="shipment.id"
                                class="border-b"
                            >
                                <td class="p-3">{{ shipment.trackingId }}</td>
                                <td class="p-3">{{ shipment.sender.name }}</td>
                                <td class="p-3">
                                    {{ shipment.receiver.name }}
                                </td>
                                <td class="p-3">
                                    <v-chip
                                        :color="getStatusColor(shipment.status)"
                                        >{{ shipment.status }}</v-chip
                                    >
                                </td>
                                <td class="p-3 space-x-2">
                                    <v-btn
                                        size="small"
                                        color="blue"
                                        @click="openDialog(shipment)"
                                        >Edit</v-btn
                                    >
                                    <v-btn
                                        size="small"
                                        color="red"
                                        @click="deleteShipment(shipment.id)"
                                        >Delete</v-btn
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
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
                                            v-model="form.sender.name"
                                            variant="outlined"
                                            placeholder="Sender Name"
                                        ></v-text-field>
                                        <v-text-field
                                            v-model="form.sender.address"
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
                                            v-model="form.receiver.name"
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
                                                v-model="form.package.weight"
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
