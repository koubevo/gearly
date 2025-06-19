<template>
    <span class="inline-flex items-center justify-center rounded-full w-5 h-5 relative" :title="$t('user.verified_user')" :aria-label="$t('user.verified_user')">
        <CheckBadgeIcon class="w-4.5 h-4.5 text-primary-900" />
    </span>
</template>

<script setup>
import { CheckBadgeIcon } from '@heroicons/vue/24/solid'
</script>