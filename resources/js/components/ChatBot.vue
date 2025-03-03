<template>
    <div class="p-4">
      <v-btn
        class="chat-button"
        color="primary"
        icon
        @click="toggleChat"
      >
        <v-badge color="red" content="1" overlap>
          <v-icon>mdi-message-text</v-icon>
        </v-badge>
      </v-btn>
  
      <v-card v-if="isChatOpen" class="chat-box pa-2">
        <v-card-text class="chat-text">
          <v-btn icon small class="close-btn" @click="toggleChat">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <p class="mt-6">Hey! 👋 Have any questions about anything?</p>
        </v-card-text>
      </v-card>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const isChatOpen = ref(false);
  
  const toggleChat = () => {
    isChatOpen.value = !isChatOpen.value;
  };
  </script>
  
  <style scoped>
  .chat-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
  }
  
  .chat-box {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 280px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
  }
  
  .chat-text {
    position: relative;
    padding: 16px;
  }
  
  .close-btn {
    position: absolute;
    top: 10px;
    left: 8px;
    width: 12px;
    height: 12px;
  }
  </style>
  