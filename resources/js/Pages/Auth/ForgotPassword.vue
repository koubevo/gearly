<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>

        <!-- TODO: change text, translations -->
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email
            address and we will email you a password reset link that will allow
            you to choose a new one.
        </div>

        <!-- TODO: replace with success message -->
        <div v-if="status" class="mb-4 text-sm font-medium text-primary-900">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <input type="email" placeholder="Email" name="email" v-model="form.email" class="input-style" required />
                <div v-if="form.errors.email" class="input-error-message-style">{{ form.errors.email }}</div>
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
