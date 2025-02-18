<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

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
</script>

<template>
    <section>
        <header>
            <!-- TODO: make component for these headings -->
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <!-- TODO: text, translations -->
            <TinyText :text="'Update your profile information and email address.'"/>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <!-- TODO: change other profile data (phone, address, ...) -->
            <div>
                <input type="text" placeholder="Name" name="name" v-model="form.name" class="input-style" required />
                <div v-if="form.errors.name" class="input-error-message-style">{{ form.errors.name }}</div>
            </div>

            <!-- TODO: Do we want them to change this? -->
            <div class="mt-4">
                <input type="email" placeholder="Email" name="email" v-model="form.email" class="input-style" required />
                <div v-if="form.errors.email" class="input-error-message-style">{{ form.errors.email }}</div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
