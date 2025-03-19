<template>
    <p class="tiny-text-style">{{ text }}<slot/></p>
</template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>