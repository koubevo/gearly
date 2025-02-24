<template>
    <Link :href="route('offer.show', offer.id)">
        <div class="bg-white shadow-gray-300 shadow-lg">
            <div class="relative">
                <span class="absolute right-0 pt-1 px-2 pb-1 border-s-2 border-b-2 border-black border-solid flex align-middle items-center bg-white/70">
                    <Condition :condition="offer.condition" class="me-2"/>
                    <button @click.prevent="toggleFavorite" method="POST" class="hover:text-primary-900">
                        <HeartIcon class="w-7 h-7 mt-0.5" v-if="!isFavorited"/>
                        <FullHeartIcon class="w-7 h-7 mt-0.5 fill-primary-900" v-else/>
                    </button>
                    <NormalText v-if="favoritesCount > 0" :text="favoritesCount" class="ms-1"/>
                </span>
                <img :src="offer.thumbnail_url" :alt="offer.name" class="mb-2 card-image" loading="lazy">
            </div>  
            <div class="p-2">
                <!-- TODO: only 1 or 2 lines! -->  
                <Heading3 :text="offer.name"/>
                <SmallText :text="offer.brand.name"/>
                <PriceCard :price="offer.price" :currency="offer.currency"/>
            </div>         
        </div>
    </Link>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { HeartIcon as FullHeartIcon } from '@heroicons/vue/24/solid';
import { HeartIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import PriceCard from '@/Components/Offer/PriceCard.vue';
import Condition from '@/Components/Offer/Condition.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import SmallText from '@/Components/Text/SmallText.vue';
import NormalText from '@/Components/Text/NormalText.vue';

const props = defineProps({
  offer: Object
});

const user = computed(() => usePage().props.auth.user);
const isFavorited = ref(props.offer.favorited_by_user);
const favoritesCount = ref(props.offer.favorites_count);

watch(() => props.offer.favorited_by_user, (newVal) => {
    isFavorited.value = newVal;
});
watch(() => props.offer.favorites_count, (newVal) => {
    favoritesCount.value = newVal;
});

const toggleFavorite = async () => {
    if (!user.value) {
        return Inertia.visit('login');
    }

    try {
        const response = await fetch(`/api/wishlist/${props.offer.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });

        const data = await response.json();

        if (data.status === 'added') {
            isFavorited.value = true;
            favoritesCount.value++;
        } else {
            isFavorited.value = false;
            favoritesCount.value--;
        }
    } catch (error) {
        console.error('Chyba při změně oblíbených:', error);
    }
};
</script>
