<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import LocationSelect from '@/Components/Form/LocationSelect.vue';
import { ref, watch, onMounted } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const countries = ref([]);
const cities = ref([]);

onMounted(async () => {
    try {
        const response = await fetch('/api/countries');
        const result = await response.json();
        if (result.success) {
            countries.value = result.data;
        } else {
            console.error('Error fetching countries:', result.message);
        }
    } catch (error) {
        console.error('Error fetching countries:', error);
    }
});

watch(() => form.country, async (newCountry) => {
    if (newCountry) {
        const selectedCountry = countries.value.find(country => country.name === newCountry);
        const iso2 = selectedCountry ? selectedCountry.iso2 : '';
        if (iso2) {
            try {
                const response = await fetch(`/api/cities?iso2=${iso2}`);
                const result = await response.json();
                if (result.success) {
                    cities.value = result.data;
                } else {
                    console.error('Error fetching cities:', result.message);
                }
            } catch (error) {
                console.error('Error fetching cities:', error);
            }
        }
    }
});
</script>

<template>
    <section>
        <header>
            <Heading2 class="mb-2">Update Profile Information</Heading2>
            <TinyText :text="'To change other information, please contact our support.'"/>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6">
            <div class="my-2 flex md:flex-row flex-col gap-2">
                <div class="flex-1">
                    <LocationSelect :options="countries" v-model="form.country" labelName="Country" name="country" :required="true" :error="form.errors.country"/>
                </div>
                <div class="flex-1">
                    <LocationSelect :options="cities" v-model="form.city" labelName="City" name="city" :required="true" :error="form.errors.city"/>
                </div>
            </div>
            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
        </form>
    </section>
</template>
