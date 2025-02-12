<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
                <input type="email" placeholder="Email" name="email" v-model="form.email" class="input-style" required />
                <div v-if="form.errors.email" class="input-error-message-style">{{ form.errors.email }}</div>
            </div>

            <div class="mt-4">
                <input type="password" placeholder="Password" name="password" v-model="form.password" class="input-style" required />
                <div v-if="form.errors.password" class="input-error-message-style">{{ form.errors.password }}</div>
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

            <div class="mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm underline hover:text-black focus:outline-none">
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
