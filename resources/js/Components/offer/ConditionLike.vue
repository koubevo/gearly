<template>
    <span class=" flex align-middle items-center">
       <Condition :condition="offer.condition" class="me-2"/>
       <button @click.prevent="toggleFavorite" method="POST" class="hover:text-primary-900" v-if="user?.id !== offer.user_id">
           <HeartIcon class="w-7 h-7" v-if="!isFavorited"/>
           <FullHeartIcon class="w-7 h-7 fill-primary-900" v-else/>
       </button>
       <NormalText v-if="favoritesCount > 0" :text="favoritesCount" class="ms-1"/>
    </span>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { HeartIcon as FullHeartIcon } from '@heroicons/vue/24/solid';
import { HeartIcon } from '@heroicons/vue/24/outline';
import Condition from '@/Components/Offer/Condition.vue';
import NormalText from '@/Components/Text/NormalText.vue';

const props = defineProps({
    offer: Object,
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
        console.error('err');
    }
};
</script>