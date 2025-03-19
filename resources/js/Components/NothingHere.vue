<template>
    <section class="flex flex-col items-center w-full mx-auto md:w-2/3">
        <img :src="'/storage/imgs/gearly_dog.png'" alt="Nothing here" class="w-full md:w-1/2 mx-auto mb-8 p-2"/>
        <Heading1 class="mb-2 text-center"><slot/></Heading1>
        <NormalText class="text-center">{{ text }}</NormalText>
    </section>
</template>

<script setup>
import Heading1 from '@/Components/Text/Heading1.vue';
import NormalText from '@/Components/Text/NormalText.vue';

defineProps({
    text: String,
});
</script>