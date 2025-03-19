<template>
    <div class="flex gap-2 mb-0">
        <div class="font-medium capitalize">{{ detail }}:</div>
        <div class="capitalize">{{ detailValue }}</div>
    </div>
</template>
 
 <script setup>
 defineProps({
     detail: String,
     detailValue: String
 })
 </script>