<template>
    <p class="normal-text-style">{{ text }}<slot/></p>
</template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>