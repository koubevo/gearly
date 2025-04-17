<template> 
    <Head :title="$t('common.help')" />
    <section class="mb-8 max-w-5xl mx-auto">
        <Heading1 class="mb-6">{{ $t('common.help') }}</Heading1>
        <HelpContent/>
    </section>    
</template>

<script setup>
import HelpContent from '@/Components/Help/HelpContent.vue';
import { Head } from '@inertiajs/vue3';
import Heading1 from '@/Components/Text/Heading1.vue';
</script>