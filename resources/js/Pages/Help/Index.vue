<template>    
    <Head :title="$t('common.help')" />
    <Heading1 class="mb-6">{{ $t('common.help') }}</Heading1>
    <HelpContent/>
</template>

<script setup>
import HelpContent from '@/Components/Help/HelpContent.vue';
import { Head } from '@inertiajs/vue3';
import Heading1 from '@/Components/Text/Heading1.vue';
</script>