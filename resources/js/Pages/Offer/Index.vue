<template>
    <div v-for="offer in offers" :key="offer.id">
        <Link :href="route('offer.show', {offer: offer.id})">{{ offer.name }}</Link>
        <span style="color: red;">
            <Link :href="route('offer.destroy', {offer: offer.id})" method="DELETE" as="button">Delete</Link>
        </span>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import MainLayout from '@/Layouts/MainLayout.vue';

    defineOptions({ layout: MainLayout })

    defineProps({
        offers: Array,
    })
</script>