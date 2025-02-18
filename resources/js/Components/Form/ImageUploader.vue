<template>
    <input type="file" multiple @change="handleFiles" accept="image/*" />
   <div v-if="previewImages.length">
      <p>Náhledy:</p>
      <div v-for="(image, index) in previewImages" :key="index" class="image-preview">
        <img :src="image.localUrl" class="thumb" />
        <button @click="removeImage(index)">X</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        form: {
          title: '',
          description: '',
          price: '',
        },
        images: [], // Soubory pro nahrání
        previewImages: [], // Náhledy obrázků
      };
    },
    methods: {
      handleFiles(event) {
        const files = event.target.files;
        for (const file of files) {
          if (this.images.length < 10) {
            const reader = new FileReader();
            reader.onload = (e) => {
              this.previewImages.push({ localUrl: e.target.result, file });
            };
            reader.readAsDataURL(file);
            this.images.push(file);
          }
        }
      },
      removeImage(index) {
        this.previewImages.splice(index, 1);
        this.images.splice(index, 1);
      },
      async submitOffer() {
        const formData = new FormData();
        formData.append('title', this.form.title);
        formData.append('description', this.form.description);
        formData.append('price', this.form.price);
        this.images.forEach((file) => formData.append('images[]', file));
  
        try {
          await axios.post('/offers', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
          });
          alert('Nabídka byla vytvořena!');
        } catch (error) {
          console.error('Chyba při nahrávání:', error);
        }
      },
    },
  };
  </script>
  
  <style>
  .thumb {
    width: 100px;
    height: 100px;
    object-fit: cover;
  }
  .image-preview {
    display: inline-block;
    position: relative;
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