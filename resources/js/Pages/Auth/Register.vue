<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <!-- TODO: autocomplete -->
        <form @submit.prevent="submit">
            <div>
                <input type="text" placeholder="Name" name="name" v-model="form.name" class="input-style" required />
                <div v-if="form.errors.name" class="input-error-message-style">{{ form.errors.name }}</div>
            </div>

            <div class="mt-4">
                <input type="email" placeholder="Email" name="email" v-model="form.email" class="input-style" required />
                <div v-if="form.errors.email" class="input-error-message-style">{{ form.errors.email }}</div>
            </div>

            <div class="mt-4">
                <input type="password" placeholder="Password" name="password" v-model="form.password" class="input-style" required />
                <div v-if="form.errors.password" class="input-error-message-style">{{ form.errors.password }}</div>
            </div>

            <div class="mt-4">
                <input type="password" placeholder="Password confirmation" name="password_confirmation" v-model="form.password_confirmation" class="input-style" required />
                <div v-if="form.errors.password_confirmation" class="input-error-message-style">{{ form.errors.password_confirmation }}</div>
            </div>

            <div class="mt-4 flex">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>

            <div class="mt-4">
                <Link :href="route('login')"
                    class="rounded-md text-sm underline hover:text-black focus:outline-none">
                    Already registered?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
