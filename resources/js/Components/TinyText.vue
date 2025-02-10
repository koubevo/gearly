<template>
    <p class="text-xs text-gray-700">{{ text }}</p>
</template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>