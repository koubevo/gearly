<template>
    <span class=" flex align-middle items-center">
       <Condition :condition="offer.condition" :type="'condition'" :conditionNumber="offer.conditionNumber" class="me-2" v-if="offer.status === 1"/>
       <Condition :condition="offer.status" :type="'status'" :conditionNumber="offer.statusNumber" class="me-2"/>
       <button 
            :disabled="user?.id === offer.user_id"
            @click.prevent="toggleFavorite" 
            method="POST" 
            :class="{'opacity-50 ': user?.id === offer.user_id}"
            v-if="offer.statusNumber === 1">
            <HeartIcon class="w-7 h-7" v-if="!isFavorited"/>
            <FullHeartIcon class="w-7 h-7 fill-primary-900" v-else/>
        </button>

       <NormalText v-if="favoritesCount > 0 && offer.statusNumber === 1" :text="favoritesCount" class="ms-1"/>
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
import axios from 'axios';

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
        return Inertia.visit(route('login'));
    }

    try {
        const response = await axios.post(route('wishlist.toggle', { id: props.offer.id }));

        if (response.data.status === 'added') {
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