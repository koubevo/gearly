<template>
    <p class="small-text-style">{{ text }}<slot/></p>
</template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>