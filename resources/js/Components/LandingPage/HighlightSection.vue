<template>
    <section class="bg-gray-200 py-4 lg:py-0 lg:pt-14 mb-8">
      <div class="max-w-7xl mx-auto px-4 lg:px-14 flex flex-col md:flex-row md:items-center justify-between">
        <div class="mb-6 md:mb-0">
            <Heading2>{{ heading }}</Heading2>   
            <PrimaryLink class="mt-4 inline-flex items-center gap-2 w-auto" :href="link">
            {{ linkText }} <ArrowRightIcon class="w-5 h-5"/>
            </PrimaryLink>
        </div>
        <div class="w-full md:w-1/2 lg:w-2/3">
          <img
            :src="image"
            :alt="altText"
            class="w-full object-cover"
          />
        </div>
      </div>
    </section>
</template>

<script setup>
import Heading2 from '@/Components/Text/Heading2.vue';
import PrimaryLink from '@/Components/Buttons/PrimaryLink.vue';
import { ArrowRightIcon } from '@heroicons/vue/24/outline';

defineProps({
    heading: String,
    linkText: String,
    link: String,
    image: String,
    altText: String,
})
</script>