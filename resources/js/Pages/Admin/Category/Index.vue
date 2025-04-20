<template>
    <Head title="Správa kategorií" />
    <BackButton />
    <Heading1 class="mb-8">Správa kategorií</Heading1>
    <Heading2 class="mb-4">Přidat novou kategorii</Heading2>
    <form @submit.prevent="handleSubmit">
        <div class="grid grid-cols-12 gap-y-4 gap-x-2">
            <div class="col-span-12 md:col-span-6">
                <FormInput name="name" labelName="Název kategorie (EN)" type="text" v-model="form.name"
                    :required="true" />
            </div>
            <div class="col-span-12 md:col-span-6">
                <FormInput name="name" labelName="Název kategorie (CS)" type="text" v-model="form.cs"
                    :required="true" />
            </div>
            <div class="col-span-12">
                <PrimaryButton type="submit" text="Přidat" class="md:w-auto capitalize"/>
            </div>
        </div>
    </form>
    <Heading2 class="mt-8 mb-4">Existující kategorie</Heading2>
    <table class="table-auto w-full border-collapse border border-gray-200 mb-8">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-200 px-4 py-2 text-left">Název kategorie (EN)</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Název kategorie (CS)</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-100">
                <td class="border border-gray-200 px-4 py-2">{{ category.name }}</td>
                <td class="border border-gray-200 px-4 py-2">{{ category.cs }}</td>
            </tr>
        </tbody>
    </table>

</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Heading1 from '@/Components/Text/Heading1.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import Heading2 from '@/Components/Text/Heading2.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import BackButton from '@/Components/Admin/BackButton.vue';


const form = useForm({
    name: "",
    cs: ""
});

function handleSubmit() {
    form.post(route('admin.categories.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset()
    });
}

const props = defineProps({
    categories: Array,
});
</script>
