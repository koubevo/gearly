<template>
    <Head :title="$t('search.search')" />
    <div class="w-full max-w-5xl mx-auto">
        <Heading1 class="mb-4">{{ $t('search.heading') }}</Heading1>
        <form @submit.prevent="handleSubmit" class="flex items-end w-full gap-2 mb-2">
            <div class="flex-grow">
                <SearchInput v-model="searchForm.search" class="w-full" :required="true"/>
            </div>
            <button text="Search" class="primary-button-chat-style">{{ $t('search.search') }}</button>
        </form>
        <div class="flex flex-col items-center py-6 w-full">
            <label for="search-input" class="w-full">{{ $t('search.search_by_category') }}</label>
            <div class="w-full grid grid-cols-1 gap-x-4 gap-y-0 md:gap-y-2 md:grid-cols-2 mt-2"> 
                <CategoryItem v-for="category in categories" :key="category.id" :category="category" :link="route('offer.index', {category: category.id})" :logo="'/storage/icons/' + category.logo"/>
            </div>
        </div>
        <div class="flex flex-col items-center pt-2 pb-6 w-full">
            <label for="search-input" class="w-full">{{ $t('search.search_by_brand') }}</label>
            <div class="w-full grid grid-cols-1 gap-x-4 gap-y-2 md:grid-cols-2 mt-2"> 
                <CategoryItem v-for="brand in brands" :key="brand.id" :category="brand" :link="route('offer.index', {brand: brand.id})" :logo="'/storage/imgs/' + brand.logo"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import CategoryItem from '@/Components/Search/CategoryItem.vue';
import SearchInput from '@/Components/Search/SearchInput.vue';
import Heading1 from '@/Components/Text/Heading1.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array,
    brands: Array
});

const searchForm = useForm({
    search: ''
});

const handleSubmit = () => {
    searchForm.get(
        route('offer.index', { search: searchForm.search })
    )
};
</script>
