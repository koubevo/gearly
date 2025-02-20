<template>
    <div class="w-full my-0.5 flex flex-col justify-center">
        <Link class="text-left w-full" :href="route('offer.index', {category: category.id})">
            <div class="hover:bg-gray-300 p-3 w-full flex flex-row justify-between items-center">
                <!-- TODO: category icon -->
                <div class="w-10 flex-shrink-0"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a6/Major_League_Baseball_logo.svg/172px-Major_League_Baseball_logo.svg.png" alt="" class="w-full"></div>
                <div class="flex-1 ps-4"><NormalText>{{ category.name }}</NormalText></div>
                <div class="flex-shrink-0 text-primary-900"><ChevronRightIcon class="w-5 h-5  stroke-[2.5]" /></div>
            </div>    
        </Link>
        <Divider/>
    </div>
    
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import NormalText from '@/Components/Text/NormalText.vue';
import Divider from '@/Components/Search/Divider.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';

defineProps({
    category: Object
})
</script>