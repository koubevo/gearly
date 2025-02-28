<template>
    <div class="w-full my-0.5 flex flex-col justify-center">
        <Link class="text-left w-full" :href="link">
            <div class="p-3 w-full flex flex-row justify-between items-center">
                <div class="w-10 flex-shrink-0"><img :src="'/storage/icons/' + category.logo" alt="Logo" class="w-full object-cover object-center scale-150"></div>
                <div class="flex-1 ps-4"><NormalText>{{ category.name }} ({{ category.offers_count }})</NormalText></div>
                <div class="flex-shrink-0 text-primary-900"><ChevronRightIcon class="w-5 h-5  stroke-[2.5]" /></div>
            </div>    
        </Link>
        <Divider class="md:w-full"/>
    </div>
    
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import NormalText from '@/Components/Text/NormalText.vue';
import Divider from '@/Components/Search/Divider.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';

defineProps({
    category: Object,
    link: String
})
</script>