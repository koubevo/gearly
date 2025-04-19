<script setup>
import SmallText from '@/Components/Text/SmallText.vue';
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/outline';
</script>

<template>
    
    <SmallText>
        <QuestionMarkCircleIcon class="w-4 h-4 inline-block align-text-top stroke-[2]" />
        {{ $t('offer.filters_description') }}
        <span class="font-bold">
            {{ $t('offer.filters_description_bold') }}
        </span>
    </SmallText>
</template>