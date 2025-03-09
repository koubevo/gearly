<template>
    <div class="z-50 mb-6">
        <div class="flex justify-between items-end">
        <Heading2>{{ $t('offer.filter_offers') }}</Heading2>
        </div>
        <Divider class="md:w-full my-4"/>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 md:mb-20">
                <!-- TODO: text search, sport, značka, stav, kategorie, (filters) -->
                <div class="z-50">
                    <FormSelect :options="brands" v-model="form.brand" :default="false" :labelName="$t('common.brand')" name="brand" :error="form.errors.brand_id"/>
                </div>
                <div>
                    <FormSelect :options="categories" v-model="form.category" :default="false" :labelName="$t('common.category')" name="category" :error="form.errors.category_id"/>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 md:mb-0 capitalize">Sport</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="1" v-model="form.sport" />
                            <div class="sport-selector-style uppercase">
                                {{ $t('common.both') }}
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="2" v-model="form.sport" />
                            <div class="sport-selector-style uppercase">
                                BASEBALL
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="3" v-model="form.sport" />
                            <div class="sport-selector-style uppercase">
                                SOFTBALL
                            </div>
                        </label>
                    </div>
                    <div v-if="form.errors.sport" class="input-error-message-style">{{ form.errors.sport }}</div>
                </div>
                <div class="md:col-span-2">
                    <SearchInput v-model="form.search" class="w-full"/>
                </div>
                <div>
                    <PrimaryButton text="Search" class="w-full md:w-auto" type="submit" />
                </div>
            </div>
        </form>
    </div>    
</template>

<script setup>
import FormSelect from "@/Components/Form/FormSelect.vue";
import { useForm } from '@inertiajs/vue3';
import Heading2 from "@/Components/Text/Heading2.vue";
import Divider from "@/Components/Search/Divider.vue";
import SearchInput from "@/Components/Search/SearchInput.vue";
import PrimaryButton from "../Buttons/PrimaryButton.vue";

const props = defineProps({
    brands: Array,
    categories: Array,
    filters: Array ?? [],
});

const form = useForm({
    brand: props.filters?.brand != null ? Number(props.filters?.brand) : null,
    category: props.filters?.category != null ? Number(props.filters?.category) : null,
    sport: props.filters?.sport != null ? Number(props.filters.sport) : 1,
    search: props.filters?.search ?? '',
    order: props.filters?.order ?? null,
});

const handleSubmit = () => {
    form.get(route('offer.index'));
}
</script>