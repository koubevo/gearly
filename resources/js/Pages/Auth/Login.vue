<script setup>
import Checkbox from '@/Components/Form/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInput from '@/Components/Form/FormInput.vue';

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
    <Head :title="$t('auth.login')" />
    <GuestLayout>
        <form @submit.prevent="submit">
            <div>
                <FormInput name="email" :labelName="$t('auth.email')" type="email" v-model="form.email" :error="form.errors.email" :required="true" />
            </div>

            <div class="mt-4">
                <FormInput name="password" :labelName="$t('auth.password')" type="password" v-model="form.password" :error="form.errors.password" :required="true" />
            </div>

            <div class="mt-4 flex justify-between items-center">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm">{{ $t('auth.remember_me') }}</span>
                </label>
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="rounded-md text-sm underline hover:text-black focus:outline-none">
                    {{ $t('auth.forgot_your_password') }}
                </Link>
            </div>

            <div class="mt-4 flex">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ $t('auth.login') }}
                </PrimaryButton>
            </div>

            <div class="mt-4 flex gap-4">
                <Link :href="route('register')"
                    class="rounded-md text-sm underline hover:text-black focus:outline-none text-primary-900">
                    {{ $t('auth.are_you_new_here') }}
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
