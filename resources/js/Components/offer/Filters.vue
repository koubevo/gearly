<template>
    <div class="z-50 mb-6">
        <div class="flex justify-between items-end">
        <Heading2>{{ $t('offer.filter_offers') }}</Heading2>
        </div>
        <Divider class="md:w-full my-4"/>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <!-- TODO: text search, sport, značka, stav, kategorie, (filters) -->
            <form @submit.prevent="handleSubmit">
                <div class="z-50">
                    <FormSelect :options="brands" v-model="form.brand" :labelName="$t('common.brand')" name="brand" :error="form.errors.brand_id"/>
                </div>
                <div>
                    <FormSelect :options="categories" v-model="form.category" :labelName="$t('common.category')" name="category" :error="form.errors.category_id"/>
                </div>
                <!--  
                <div>
                    <FormSelect :options="categories" v-model="form.category_id" :labelName="$t('common.brand')" name="brand_id" :required="true" :error="form.errors.brand_id"/>
                </div>
                <div>
                    <FormSelect :options="conditions" v-model="form.condition" :labelName="$t('common.brand')" name="brand_id" :required="true" :error="form.errors.brand_id"/>
                </div>
                -->
            </form>
        </div>
    </div>    
</template>

<script setup>
import FormSelect from "@/Components/Form/FormSelect.vue";
import { useForm } from '@inertiajs/vue3';
import Heading2 from "@/Components/Text/Heading2.vue";
import Divider from "@/Components/Search/Divider.vue";

const props = defineProps({
    brands: Array,
    categories: Array,
    sports: Array ?? [],
    conditions: Array ?? [],
    filters: Array ?? [],
});

const form = useForm({
    brand: Number(props.filters?.brand) ?? null,
    category: Number(props.filters?.category) ?? null,
});

const handleSubmit = () => {
    form.post(route('offer.index'));
}
</script>