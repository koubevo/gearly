<template>
    <div class="gallery">
      <div class="main-image">
        <button v-if="images.length > 1" @click="prevImage" class="nav left">‹</button>
        <img :src="currentImage" alt="Offer image" />
        <button v-if="images.length > 1" @click="nextImage" class="nav right">›</button>
      </div>
  
      <div class="thumbnails">
        <img
          v-for="(img, index) in images"
          :key="index"
          :src="img"
          :class="{ active: index === currentIndex }"
          @click="currentIndex = index"
          alt="Thumbnail"
        />
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from "vue";
  
  const props = defineProps({
    images: Array
  });
  
  const currentIndex = ref(0);
  const currentImage = computed(() => props.images?.[currentIndex.value] || "");
  
  const prevImage = () => {
    currentIndex.value =
      currentIndex.value > 0 ? currentIndex.value - 1 : props.images.length - 1;
  };
  
  const nextImage = () => {
    currentIndex.value =
      currentIndex.value < props.images.length - 1 ? currentIndex.value + 1 : 0;
  };
  </script>

