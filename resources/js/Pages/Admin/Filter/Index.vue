<template>
    <Head title="Správa filtrů" />
    <BackButton />
    <Heading1 class="mb-8">Správa filtrů</Heading1>
    <Heading2 class="mb-4">Přidat nový filtr</Heading2>
    <form @submit.prevent="handleSubmit">
        <div class="grid grid-cols-12 gap-y-4 gap-x-2">
            <div class="col-span-12 md:col-span-6">
                <FormInput name="name" labelName="Název filtru (EN)" type="text" v-model="form.name"
                    :required="true" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <FormInput name="name" labelName="Název filtru (CS)" type="text" v-model="form.cs"
                    :required="true" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <FormSelect :options="filter_categories" v-model="form.filter_category_id"
                        labelName="Kategorie filtru" name="filter_category_id" :required="true"/>
            </div>
            <div class="col-span-12">
                <PrimaryButton type="submit" text="Přidat" class="md:w-auto capitalize"/>
            </div>
        </div>
    </form>
    <Heading2 class="mt-8 mb-4">Existující filtry</Heading2>
    <table class="table-auto w-full border-collapse border border-gray-200 mb-8">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-200 px-4 py-2 text-left">Název filtru (EN)</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Název filtru (CS)</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Název kategorie filtru (CS)</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="filter in filters" :key="filter.id" class="hover:bg-gray-100">
                <td class="border border-gray-200 px-4 py-2">{{ filter.name }}</td>
                <td class="border border-gray-200 px-4 py-2">{{ filter.cs }}</td>
                <td class="border border-gray-200 px-4 py-2">{{ filter.filter_category.cs }}</td>
            </tr>
        </tbody>
    </table>

</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Heading1 from '@/Components/Text/Heading1.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import BackButton from '@/Components/Admin/BackButton.vue';
import { useForm } from '@inertiajs/vue3';
import Heading2 from '@/Components/Text/Heading2.vue';


const form = useForm({
    name: "",
    cs: "",
    filter_category_id: ""
});

function handleSubmit() {
    form.post(route('admin.filters.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset()
    });
}

const props = defineProps({
    filters: Array,
    filter_categories: Array,
});
</script>
