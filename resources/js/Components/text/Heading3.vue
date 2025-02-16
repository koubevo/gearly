<template>
    <h3 class="font-medium mb-2">{{ text }} <slot /></h3>
 </template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>