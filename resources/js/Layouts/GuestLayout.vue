<template>
    <div 
        class="flex flex-col justify-center items-center"
        :style="{ height: `calc(100vh - ${menuHeight}px - 20px)` }"
    >
        <div class="mb-6">
            <Link href="/">
                <img :src="'storage/imgs/logo.png'" alt="Logo" class="w-40 h-auto">
            </Link>
        </div>

        <div class="w-full overflow-hidden bg-white px-4 pb-4 md:p-8 sm:max-w-lg shadow-gray-200 shadow-lg">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const menuHeight = ref(0);

onMounted(() => {
    const menu = document.querySelector('header');
    if (menu) {
        menuHeight.value = menu.offsetHeight;
    }
});
</script>
