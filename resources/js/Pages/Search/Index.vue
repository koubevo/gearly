<template>
    <div class="w-full sm:w-2/3 md:w-1/2 mx-auto">
        <form @submit.prevent="handleSubmit">
            <SearchInput v-model="searchForm.search"/>
            <PrimaryButton text="Search" class="w-full md:w-auto mt-2"/>
        </form>
        <div class="flex flex-col items-center py-6 w-full">
            <label for="search-input" class="w-full">Search by category</label>
            <div class="w-full grid grid-cols-1 gap-1 md:grid-cols-2 mt-2"> 
                <CategoryItem v-for="category in categories" :key="category.id" :category="category"/>
            </div>
            <!-- TODO: mlb item -->
        </div>
    </div>
</template>

<script setup>
import CategoryItem from '@/Components/Search/CategoryItem.vue';
import SearchInput from '@/Components/Search/SearchInput.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array
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
