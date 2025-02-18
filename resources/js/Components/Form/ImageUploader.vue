<template>
    <div>
      <input type="file" multiple @change="handleFiles" accept="image/*" class="hidden-input" ref="fileInput" />
      
      <div class="upload-area" @dragover.prevent @drop="handleDrop">
        <p v-if="!images.length">Přetáhni sem obrázky nebo klikni</p>
        <div v-for="(image, index) in images" :key="index" class="image-preview">
          <img :src="image.thumbnail_url || image.localUrl" class="thumb" />
          <button @click="removeImage(index)">X</button>
        </div>
      </div>
  
      <button @click="uploadImages" :disabled="!images.length">Nahrát</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        images: [], // Uložené obrázky
      };
    },
    methods: {
      handleFiles(event) {
        const files = event.target.files;
        this.previewImages(files);
      },
      handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        this.previewImages(files);
      },
      previewImages(files) {
        for (const file of files) {
          if (this.images.length < 10) {
            const reader = new FileReader();
            reader.onload = (e) => {
              this.images.push({ localUrl: e.target.result, file });
            };
            reader.readAsDataURL(file);
          }
        }
      },
      removeImage(index) {
        this.images.splice(index, 1);
      },
      async uploadImages() {
        const formData = new FormData();
        this.images.forEach((image) => formData.append('images[]', image.file));
  
        try {
          const response = await axios.post('/offers/upload-images', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
          });
          this.images = response.data.images;
        } catch (error) {
          console.error('Chyba při nahrávání:', error);
        }
      },
    },
  };
  </script>
  
  <style>
  .upload-area {
    border: 2px dashed #ccc;
    padding: 20px;
    text-align: center;
    cursor: pointer;
  }
  
  .image-preview {
    display: inline-block;
    position: relative;
  }
  
  .thumb {
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin: 5px;
    border-radius: 5px;
  }
  
  button {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border: none;
    cursor: pointer;
  }
  </style>
  