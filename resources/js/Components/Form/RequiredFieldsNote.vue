<script setup>
import SmallText from '@/Components/Text/SmallText.vue';
</script>

<template>
    
    <SmallText><span class="required-star-style">*</span> {{ $t('common.required_fields') }}</SmallText>
</template>