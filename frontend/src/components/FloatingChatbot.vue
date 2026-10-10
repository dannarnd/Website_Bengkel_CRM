<template>
  <div class="fixed bottom-6 right-6 z-[9999] font-sans">
    <!-- Chat Window -->
    <transition name="chat-fade">
      <div v-if="isOpen" class="mb-5 w-[340px] sm:w-[400px] flex flex-col overflow-hidden origin-bottom-right rounded-3xl border border-white/40 bg-white/60 backdrop-blur-2xl shadow-[0_8px_32px_rgba(0,0,0,0.15)]">
        
        <!-- Header (Glassy Gradient) -->
        <div class="relative px-5 py-4 border-b border-white/40 bg-gradient-to-r from-indigo-500/10 to-fuchsia-500/10 flex justify-between items-center">
          <div class="flex items-center gap-3">
            <div class="relative w-11 h-11 rounded-full bg-gradient-to-tr from-indigo-500 to-fuchsia-500 p-[2px] shadow-sm">
              <div class="w-full h-full bg-white/90 rounded-full flex items-center justify-center text-xl backdrop-blur-sm">
                🤖
              </div>
              <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full shadow-sm"></div>
            </div>
            <div>
              <h3 class="font-extrabold text-slate-800 text-[15px] tracking-tight">Asisten Doles</h3>
              <p class="text-[11px] text-slate-500 font-semibold tracking-wide uppercase mt-0.5">Online 24/7</p>
            </div>
          </div>
          <button @click="toggleChat" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/50 text-slate-500 hover:bg-white hover:text-slate-800 transition-all shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>
        
        <!-- Body (Messages) -->
        <div class="h-[400px] p-5 overflow-y-auto flex flex-col gap-4 scroll-smooth chat-body">
          <div v-for="(msg, index) in messages" :key="index" :class="['flex flex-col', msg.isUser ? 'items-end' : 'items-start']">
            
            <!-- Message Bubble -->
            <div :class="[
              'max-w-[85%] rounded-2xl p-3.5 text-[13px] leading-relaxed shadow-sm',
              msg.isUser 
                ? 'bg-gradient-to-br from-indigo-500 to-fuchsia-600 text-white rounded-br-sm shadow-indigo-500/30' 
                : 'bg-white/80 backdrop-blur-md text-slate-700 rounded-bl-sm border border-white/60 shadow-[0_2px_10px_rgba(0,0,0,0.03)]'
            ]">
              <div v-if="msg.isUser" class="whitespace-pre-wrap">{{ msg.text }}</div>
              <div v-else v-html="formatMessage(msg.text)" class="prose prose-sm prose-slate max-w-none"></div>
            </div>
            
            <!-- Options (Glass Buttons) -->
            <div v-if="msg.options && msg.options.length > 0" class="mt-2.5 flex flex-col gap-2 w-[85%] max-w-[280px]">
              <button 
                v-for="(opt, oIdx) in msg.options" 
                :key="oIdx" 
                @click="sendOption(opt)" 
                class="text-left text-[12px] bg-white/70 hover:bg-white text-indigo-700 font-bold py-2.5 px-4 rounded-xl border border-indigo-100/50 shadow-[0_2px_8px_rgba(0,0,0,0.04)] transition-all hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(79,70,229,0.15)] hover:text-indigo-800 focus:outline-none"
              >
                {{ opt }}
              </button>
            </div>
          </div>
        </div>

        <!-- Footer (Input) -->
        <div class="p-4 bg-white/40 border-t border-white/40 backdrop-blur-xl">
          <form @submit.prevent="sendMessage" class="flex gap-2 relative">
            <input 
              v-model="inputText" 
              type="text" 
              placeholder="Ketik pesan Anda..." 
              class="w-full bg-white/80 border border-white shadow-inner rounded-full pl-5 pr-12 py-3 text-[13px] font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-400/50 transition-all"
            >
            <button 
              type="submit" 
              :disabled="isLoading || !inputText.trim()" 
              class="absolute right-1.5 top-1.5 bottom-1.5 w-9 flex items-center justify-center bg-gradient-to-tr from-indigo-500 to-fuchsia-500 text-white rounded-full hover:shadow-lg hover:shadow-indigo-500/30 transition-all disabled:opacity-50 disabled:hover:shadow-none shadow-sm"
            >
              <svg v-if="!isLoading" class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
              <span v-else class="animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
            </button>
          </form>
        </div>

      </div>
    </transition>

    <!-- Floating Toggle Button -->
    <button 
      @click="toggleChat" 
      class="w-14 h-14 rounded-full shadow-[0_8px_30px_rgb(79,70,229,0.4)] flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 ml-auto relative bg-gradient-to-tr from-indigo-600 to-fuchsia-600 text-white border-2 border-white/20"
    >
      <svg v-if="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
      <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
      <!-- Notification Dot -->
      <span v-if="!isOpen" class="absolute top-0 right-0 w-3.5 h-3.5 bg-pink-500 border-2 border-white rounded-full animate-pulse shadow-sm"></span>
    </button>
  </div>
</template>

<script setup>
import { ref, nextTick } from 'vue';
import api from '../utils/axios';

const isOpen = ref(false);
const inputText = ref('');
const messages = ref([
  { 
    isUser: false, 
    text: 'Halo! Saya Asisten Virtual Doles Radiator. Ada yang bisa dibantu?',
    options: [
      'wa',
      'jam buka',
      'alamat',
      'bocor',
      'overheat'
    ]
  }
]);
const isLoading = ref(false);

const toggleChat = () => {
  isOpen.value = !isOpen.value;
};

// Fungsi untuk mengganti markdown dasar ke HTML
const formatMessage = (text) => {
  if (!text) return '';
  // Ubah **teks** menjadi <strong>teks</strong> (dengan style bold modern)
  let formatted = text.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-800">$1</strong>');
  return formatted;
};

// Jika user mengklik tombol opsi
const sendOption = (optionText) => {
  inputText.value = optionText;
  sendMessage();
};

const scrollToBottom = async () => {
  await nextTick();
  const chatBody = document.querySelector('.chat-body');
  if (chatBody) {
    chatBody.scrollTop = chatBody.scrollHeight;
  }
};

const sendMessage = async () => {
  if (!inputText.value.trim()) return;
  
  const userMsg = inputText.value;
  messages.value.push({ isUser: true, text: userMsg });
  inputText.value = '';
  isLoading.value = true;
  
  scrollToBottom();

  try {
    const response = await api.post('/chatbot', { message: userMsg });
    // Tambahkan pesan balasan bot ke chat, beserta array options (jika ada)
    messages.value.push({ 
      isUser: false, 
      text: response.data.reply,
      options: response.data.options || []
    });
  } catch (error) {
    messages.value.push({ isUser: false, text: 'Maaf, server sedang sibuk. Coba lagi nanti.' });
  } finally {
    isLoading.value = false;
    scrollToBottom();
  }
};
</script>

<style scoped>
/* Custom Scrollbar for Chat Body */
.chat-body::-webkit-scrollbar {
  width: 4px;
}
.chat-body::-webkit-scrollbar-track {
  background: transparent;
}
.chat-body::-webkit-scrollbar-thumb {
  background-color: rgba(99, 102, 241, 0.2);
  border-radius: 10px;
}
.chat-body::-webkit-scrollbar-thumb:hover {
  background-color: rgba(99, 102, 241, 0.4);
}

/* Transition for Chat Window */
.chat-fade-enter-active, .chat-fade-leave-active {
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.chat-fade-enter-from, .chat-fade-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(20px);
}
</style>
