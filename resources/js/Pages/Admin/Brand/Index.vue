<template>
    <Head title="Správa značek" />
    <Heading1 class="mb-8">Správa značek</Heading1>
    <Heading2 class="mb-4">Přidat novou značku</Heading2>
    <form @submit.prevent="handleSubmit">
        <div class="grid grid-cols-12 gap-y-4 gap-x-2">
            <div class="col-span-12 md:col-span-6">
                <FormInput name="name" labelName="Název značky (EN)" type="text" v-model="form.name"
                    :required="true" />
            </div>
            <div class="col-span-12">
                <PrimaryButton type="submit" text="Přidat" class="md:w-auto capitalize"/>
            </div>
        </div>
    </form>
    <Heading2 class="mt-10 mb-4">Existující značky</Heading2>
    <ul class="divide-y border overflow-hidden">
        <li v-for="brand in brands" :key="brand.id" class="flex items-center justify-between px-4 py-2 hover:bg-gray-100">
            <span>{{ brand.name }}</span>
            <Link :href="route('admin.brands.destroy', { brand: brand.id })" method="delete">
                <BoldNormalText class="text-red-600 hover:underline">Smazat</BoldNormalText>
            </Link>
        </li>
    </ul>

</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Heading1 from '@/Components/Text/Heading1.vue';
import FormInput from '@/Components/Form/FormInput.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import Heading2 from '@/Components/Text/Heading2.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';


const form = useForm({
    name: "",
    cs: ""
});

function handleSubmit() {
    form.post(route('admin.brands.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset()
    });
}

const props = defineProps({
    brands: Array,
});
</script>
