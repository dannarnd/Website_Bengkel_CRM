<template>
  <div class="relative" ref="container">
    <div 
      class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between focus-within:ring-2 focus-within:ring-indigo-500 transition-all shadow-sm group"
      @click="isOpen = !isOpen"
    >
      <input 
        v-model="search" 
        @input="isOpen = true"
        @focus="isOpen = true"
        :placeholder="placeholder"
        class="bg-transparent border-none outline-none w-full text-slate-700 text-sm font-medium placeholder-slate-400 cursor-text"
      >
      <svg :class="['w-5 h-5 text-slate-400 transition-transform duration-200 cursor-pointer', isOpen ? 'rotate-180 text-indigo-500' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </div>
    
    <transition name="dropdown-fade">
      <div v-if="isOpen" class="absolute z-[999] w-full mt-2 bg-white rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-slate-100 max-h-60 overflow-y-auto custom-scrollbar">
        <ul class="py-1">
          <li v-if="filteredOptions.length === 0" class="px-4 py-3 text-slate-500 text-sm text-center font-medium">Tidak ditemukan...</li>
          <li 
            v-for="opt in filteredOptions" 
            :key="opt.value"
            @click.stop="selectOption(opt)"
            class="px-4 py-2.5 hover:bg-indigo-50 cursor-pointer text-slate-700 text-sm transition-colors border-b border-slate-50 last:border-0 flex items-center justify-between group/item"
          >
            <span class="font-medium group-hover/item:text-indigo-700">{{ opt.label }}</span>
            <svg v-if="modelValue === opt.value" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
          </li>
        </ul>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: ''
  },
  options: {
    type: Array,
    required: true,
    // Format wajib: [{ label: 'Teks Tampil', value: 'ID/Nilai' }]
  },
  placeholder: {
    type: String,
    default: 'Ketik untuk mencari...'
  }
});

const emit = defineEmits(['update:modelValue', 'change']);

const isOpen = ref(false);
const search = ref('');
const container = ref(null);

watch(() => props.modelValue, (newVal) => {
  if (newVal) {
    const selected = props.options.find(o => String(o.value) === String(newVal));
    if (selected && search.value !== selected.label) {
      search.value = selected.label;
    }
  } else {
    search.value = '';
  }
}, { immediate: true });

const filteredOptions = computed(() => {
  if (!search.value) return props.options;
  const s = search.value.toLowerCase();
  
  // Jika search sama persis dengan yang di-select, tampilkan semua (karena anggap sedang tidak mencari teks baru)
  const selected = props.options.find(o => String(o.value) === String(props.modelValue));
  if (selected && selected.label.toLowerCase() === s) {
    return props.options;
  }

  return props.options.filter(opt => 
    opt.label.toLowerCase().includes(s)
  );
});

const selectOption = (opt) => {
  search.value = opt.label;
  emit('update:modelValue', opt.value);
  emit('change', opt.value);
  isOpen.value = false;
};

// Tutup dropdown jika klik di luar
const handleClickOutside = (e) => {
  if (container.value && !container.value.contains(e.target)) {
    isOpen.value = false;
    
    // Validasi apakah teks yang diketik asal-asalan
    const selected = props.options.find(o => String(o.value) === String(props.modelValue));
    if (selected && search.value !== selected.label) {
       search.value = selected.label; // kembalikan ke yang benar
    } else if (!selected) {
       search.value = ''; // kosongkan jika tidak valid
       emit('update:modelValue', '');
    }
  }
};

onMounted(() => document.addEventListener('click', handleClickOutside));
onUnmounted(() => document.removeEventListener('click', handleClickOutside));
</script>

<style scoped>
.dropdown-fade-enter-active, .dropdown-fade-leave-active {
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.dropdown-fade-enter-from, .dropdown-fade-leave-to {
  opacity: 0;
  transform: translateY(-5px);
}
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #cbd5e1;
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: #94a3b8;
}
</style>
