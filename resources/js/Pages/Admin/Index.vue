<template>
    <Head title="Administrace" />
    <div class="w-full max-w-5xl mx-auto">
        <Heading1 class="mb-4">Administrace</Heading1>
        <div class="flex flex-col items-center pt-2 pb-6 w-full">
            <div class="w-full grid grid-cols-1 gap-x-4 gap-y-2 md:grid-cols-2 mt-2"> 
                <SecondaryLink :href="route('admin.brands.index')" class="w-full">
                    Správa značek
                </SecondaryLink>
                <SecondaryLink :href="route('admin.categories.index')" class="w-full">
                    Správa kategorií
                </SecondaryLink>
                <SecondaryLink :href="route('admin.delivery-options.index')" class="w-full">
                    Správa způsobů dopravy
                </SecondaryLink>
            </div>
        </div>
    </div>
</template>

<script setup>
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import Heading1 from '@/Components/Text/Heading1.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>