<template>
    <label for="search-input" class="mb-2 md:mb-0">{{ $t('search.search_by_text') }}</label>
    <div class="relative w-full inline-block mt-1">
        <span class="absolute inset-y-0 left-3 flex items-center">
            <MagnifyingGlassIcon class="w-5 h-5 stroke-[2.5]" />
        </span>
        <input type="text" :placeholder="$t('search.search')" class="pl-10 pr-10 input-style bg-white focus:ring-0 focus:border-black" id="search-input" name="search" v-model="search" required/>
    </div>
</template>

<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { defineProps, defineEmits, ref, watch } from 'vue';

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const search = ref(props.modelValue);

watch(search, (newValue) => {
    emit('update:modelValue', newValue);
});

const clearSearch = () => {
    search.value = '';
};
</script>