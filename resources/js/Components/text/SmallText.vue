<template>
    <p class="text-sm text-gray-700">{{ text }}</p>
</template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>