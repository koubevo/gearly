<template>
    <Link>
        <div class="bg-white p-2 shadow-gray-300 shadow-lg">
            <div class="relative">
                <span class="absolute top-1 right-1 py-1 flex align-middle">
                    <span class="bg-primary-900 h-full px-2 uppercase font-medium inline-block">nové</span>
                    <button class="bg-white px-2"><HeartIcon class="w-5 h-5 mt-0.5" /></button>
                </span>
            
                <img :src="'storage/imgs/nike.jpg'" alt="" class="mb-2">
            </div>
            <p class="text-xs text-gray-700">Nike</p>
            <h3 class="font-medium mb-2">Alpha Huarache NXT Tim Anderson PE HF5576-001</h3>
            <p class="font-black">2150 CZK</p>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { HeartIcon } from '@heroicons/vue/24/outline'
</script>