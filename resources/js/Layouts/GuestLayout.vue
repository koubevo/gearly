<template>
    <div class="min-h-[calc(100vh-100px)] grid place-items-center px-4 pb-8 pt-4">
        <div class="w-full overflow-hidden bg-white px-4 pb-4 md:p-8 sm:max-w-lg shadow-gray-200 shadow-lg">
            <div class="mb-6 flex justify-center">
                <Link href="/">
                    <img :src="'/storage/imgs/logo.png'" alt="Logo" class="w-40 h-auto">
                </Link>
            </div>
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>