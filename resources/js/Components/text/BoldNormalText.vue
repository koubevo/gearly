<template>
    <p class="bold-normal-text-style">{{ text }}<slot/></p>
</template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>