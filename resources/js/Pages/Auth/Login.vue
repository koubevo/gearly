<script setup>
import Checkbox from '@/Components/Form/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/FormInput.vue';
import RequiredFieldsNote from '@/Components/Form/RequiredFieldsNote.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <!-- TODO: whats this -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <!-- TODO: add autocomplete -->
        <form @submit.prevent="submit">
            <div>
                <FormInput name="email" labelName="Email" type="email" v-model="form.email" :error="form.errors.email" :required="true" />
            </div>

            <div class="mt-4">
                <FormInput name="password" labelName="Password" type="password" v-model="form.password" :error="form.errors.password" :required="true" />
            </div>

            <div class="my-1">
                <RequiredFieldsNote />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm">Remember me</span>
                </label>
            </div>

            <div class="mt-4 flex">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
            <!-- TODO: register? -->
            <div class="mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm underline hover:text-black focus:outline-none">
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
