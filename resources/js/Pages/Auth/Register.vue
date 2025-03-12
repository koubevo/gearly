<script setup>
import { ref, onMounted, watch } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/FormInput.vue';
import RequiredFieldsNote from '@/Components/Form/RequiredFieldsNote.vue';
import 'vue-select/dist/vue-select.css';
import LocationSelect from '@/Components/Form/LocationSelect.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    country: '',
    city: '',
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
            console.error('Error fetching countries');
        }
    } catch (error) {
        console.error('Error fetching countries');
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
                    console.error('Error fetching cities');
                }
            } catch (error) {
                console.error('Error fetching cities');
            }
        }
    }
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head :title="$t('auth.register')" />
    <GuestLayout>
        <form @submit.prevent="submit">
            <div>
                <FormInput name="name" :labelName="$t('auth.full_name')" type="text" v-model="form.name" :error="form.errors.name" :required="true" />
            </div>

            <div class="mt-4">
                <FormInput name="email" :labelName="$t('auth.email')" type="email" v-model="form.email" :error="form.errors.email" :required="true" />
            </div>

            <div class="mt-4">
                <FormInput name="password" :labelName="$t('auth.password')" type="password" v-model="form.password" :error="form.errors.password" :required="true" />
            </div>

            <div class="mt-4">
                <FormInput name="password_confirmation" :labelName="$t('auth.password_confirmation')" type="password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" :required="true" />
            </div>

            <div class="mt-4 flex md:flex-row flex-col gap-2">
                <div class="flex-1">
                    <LocationSelect :options="countries" v-model="form.country" :labelName="$t('auth.country')" name="country" :required="true" :error="form.errors.country"/>
                </div>
                <div class="flex-1">
                    <LocationSelect :options="cities" v-model="form.city" :labelName="$t('auth.city')" name="city" :required="true" :error="form.errors.city"/>
                </div>
            </div>

            <div class="my-1">
                <RequiredFieldsNote />
            </div>
            
            <div class="mt-4 flex">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ $t('auth.register') }}
                </PrimaryButton>
            </div>

            <div class="mt-4">
                <Link :href="route('login')"
                    class="rounded-md text-sm underline hover:text-black focus:outline-none">
                    {{ $t('auth.already_have_an_account') }}
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
