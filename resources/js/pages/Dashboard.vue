<template>
    <!-- Header -->
    <Header />

    <!-- Main Container -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-8 p-6">
        <!-- Timeline (60%) -->
        <div class="md:col-span-3 bg-white p-6 rounded-2xl shadow-lg">
            <TimeLine />
        </div>

        <!-- Tracking Form (40%) -->
        <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-lg h-[300px]">
            <p class="mb-6 text-lg font-semibold">
                Track Another Parcel
            </p>
            <v-text-field
                label="Tracking Number"
                variant="outlined"
                dense
                required
                color="blue"
                class="w-full"
            ></v-text-field>
            <div class="mt-4">
                <v-btn variant="outlined" rounded="pill" color="primary"
                    >Track</v-btn
                >
            </div>
        </div>
    </div>

    <Footer />
</template>

<script setup>
import { ref, computed } from "vue";
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
import TimeLine from "../components/TimeLine.vue";

const events = ref([]);
const input = ref(null);
const nonce = ref(0);

const timeline = computed(() => {
    return [...events.value].reverse();
});

const comment = () => {
    const time = new Date().toTimeString();
    events.value.push({
        id: nonce.value++,
        text: input.value,
        time: time.replace(
            /:\d{2}\sGMT-\d{4}\s\((.*)\)/,
            (_, contents) =>
                ` ${contents
                    .split(" ")
                    .map((v) => v.charAt(0))
                    .join("")}`
        ),
    });

    input.value = null;
};

const items = [
    {
        color: "red-lighten-2",
        icon: "mdi-star",
    },
    {
        color: "purple-lighten-2",
        icon: "mdi-book-variant",
    },
    {
        color: "green-lighten-1",
        icon: "mdi-airballoon",
    },
    {
        color: "indigo-lighten-2",
        icon: "mdi-layers-triple",
    },
];
</script>

<style scoped>
.v-tab {
    text-transform: none !important;
}
.btn {
    text-transform: none;
}
</style>
