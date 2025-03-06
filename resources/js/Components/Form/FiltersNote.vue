<script setup>
import SmallText from '@/Components/Text/SmallText.vue';
</script>

<template>
    
    <SmallText>
        {{ $t('offer.filters_description') }}
        <span class="font-bold">
            {{ $t('offer.filters_description_bold') }}
        </span>
    </SmallText>
</template>