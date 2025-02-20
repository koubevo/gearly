<template>
    <div class="gallery">
      <div class="main-image">
        <button @click="prevImage" class="nav left">‹</button>
        <img :src="currentImage" alt="Offer image" />
        <button @click="nextImage" class="nav right">›</button>
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
  
  <style scoped>
  .gallery {
    text-align: center;
  }
  
  .main-image {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 500px; /* TODO: responsive */
    height: 500px;
    aspect-ratio: 1 / 1;
    background-color: white;
    overflow: hidden;
  }
  
  .main-image img {
    width: 100%;
    /*height: 100%;*/ /*TODO: */
    object-fit: cover;
  }
  
  .nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    padding: 10px;
  }
  
  .left {
    left: 10px;
  }
  
  .right {
    right: 10px;
  }
  
  .thumbnails {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
  }
  
  .thumbnails img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
  }
  
  .thumbnails img.active {
    border-color: green;
  }
  </style>
  