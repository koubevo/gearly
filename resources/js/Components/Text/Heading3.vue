<template>
    <h3 class="heading3-style">{{ text }} <slot /></h3>
 </template>
 
 <script setup>
 defineProps({
     text: String
 })
 </script>