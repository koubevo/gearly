<template>
    <div class="flex gap-2 mb-0">
        <div class="font-medium">{{ detail }}:</div>
        <div>{{ detailValue }}</div>
    </div>
</template>
 
 <script setup>
 defineProps({
     detail: String,
     detailValue: String
 })
 </script>