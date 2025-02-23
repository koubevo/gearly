<template>
    <section>
        <div class="flex justify-between items-center mb-2">
            <Heading2>{{ heading }}</Heading2>
            <Link class="text-left" :href="link">
                <div class="flex flex-row justify-between items-center gap-2">
                    <!-- TODO: category icon -->
                    <div class="flex-1"><TinyText>Check all <span class="lowercase">{{ heading }}</span></TinyText></div>
                    <div class="flex-shrink-0 text-primary-900"><ChevronRightIcon class="w-5 h-5  stroke-[2.5]" /></div>
                </div>    
            </Link>
        </div>
        <div>
            <UserOffersGrid :offers="offers"/>
        </div>
    </section>
</template>

<script setup>
import Heading2 from '@/Components/Text/Heading2.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
import UserOffersGrid from '@/Components/Offer/UserOffersGrid.vue';

defineProps({
    offers: {
        type: Array ?? [],
    },
    heading: String,
    link: String,
});
</script>