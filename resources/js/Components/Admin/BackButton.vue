<template>
    <SecondaryLink class="inline-flex items-center space-x-2 w-auto mb-4" :href="route('admin.index')">
        <ArrowUturnLeftIcon class="w-4 h-4" />
        <span>Zpět</span>
    </SecondaryLink>
</template>

<script setup>
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
import { ArrowUturnLeftIcon } from '@heroicons/vue/24/outline';
</script>