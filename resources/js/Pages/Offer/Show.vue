<template>
    <div class="grid grid-cols-12 gap-10">
        <div class="col-span-12 md:col-span-6">
            <!-- TODO: images with swiping, better link without ../  -->
            <!-- TODO: conditon, wishlist -->
            <img :src="'../storage/imgs/nike.jpg'" :alt="offer.name" class="mb-2">
        </div>
        <!-- TODO: move to middle -->
        <div class="col-span-12 md:col-span-6 md:pt-10">
            <section class="grid mb-6">
                <!-- TODO: brand -->
                <TinyText :text="offer.brand"/>
                <Heading1 :text="offer.name"/>
                <!-- TODO: bigger price maybe? -->
                <Price :price="offer.price" :currency="offer.currency"/>
            </section>
            <section class="grid mb-6">
                <p>{{ offer.description }}</p>
            </section>
            <!-- TODO: move seller to new component -->
            <Link>
                <section class="border-s-gray-900 border-4 border-e-0 border-y-0 p-2">
                    <!-- TODO: section about seller, move to component -->
                    <Heading3 :text="'Jan Vobrovský'"/>
                    <p class="mb-1">Feedback</p>
                    <!-- TODO: count of selled items -->
                    <TinyText :text="'Praha | Česká Republika'"/>
                </section>
            </Link>
            <section class="grid my-6">
                <!-- TODO: send what to do -->
                <PrimaryButton :text="'Chat with seller'"/>
            </section>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { HeartIcon } from '@heroicons/vue/24/outline'
import Price from '@/Components/Price.vue';
import Condition from '@/Components/Condition.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Heading1 from '@/Components/Heading1.vue';
import Heading3 from '@/Components/Heading3.vue';
import TinyText from '@/Components/TinyText.vue';

defineProps({
    offer: Object
})
</script>