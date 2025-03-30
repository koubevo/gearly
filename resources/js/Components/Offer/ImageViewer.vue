<template>
  <div class="gallery w-full mb-4">
    <div class="main-image relative flex items-center justify-center mx-auto w-[500px] h-[500px]">
      <button v-if="images.length > 1" @click="prevImage" class="nav left">‹</button>
      <picture class="w-full h-full flex justify-center items-center">
        <source :srcset="currentImage.medium" type="image/webp">
        <img
          :src="currentImage.medium"
          alt="Offer image"
          class="max-w-full max-h-full object-contain"
          loading="lazy"
        />
      </picture>
      <button v-if="images.length > 1" @click="nextImage" class="nav right">›</button>
    </div>

    <div class="thumbnails-container overflow-x-auto flex gap-2 mt-2 pl-2">
      <div class="thumbnails flex flex-nowrap">
        <img
          v-for="(img, index) in images"
          :key="index"
          :src="img.thumb"
          :class="{ 'border-2 border-primary-900': index === currentIndex }"
          class="h-16 object-cover cursor-pointer"
          @click="currentIndex = index"
          alt="Thumbnail"
          loading="lazy"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  images: Array
});

const currentIndex = ref(0);
const currentImage = computed(() => props.images?.[currentIndex.value] || {});

const prevImage = () => {
  currentIndex.value =
    currentIndex.value > 0 ? currentIndex.value - 1 : props.images.length - 1;
};

const nextImage = () => {
  currentIndex.value =
    currentIndex.value < props.images.length - 1 ? currentIndex.value + 1 : 0;
};
</script>
