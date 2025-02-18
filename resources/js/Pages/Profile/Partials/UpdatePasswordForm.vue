<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <!-- TODO: component -->
            <h2 class="text-lg font-medium text-gray-900">
                Update Password
            </h2>
            <!-- TODO: text, translations -->
            <TinyText :text="'Ensure your account is using a long, random password to stay secure.'"/>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div class="mt-4">
                <input type="password" placeholder="Current password" name="current_password" v-model="form.current_password" class="input-style" required />
                <div v-if="form.errors.current_password" class="input-error-message-style">{{ form.errors.current_password }}</div>
            </div>

            <div class="mt-4">
                <input type="password" placeholder="Password" name="password" v-model="form.password" class="input-style" required />
                <div v-if="form.errors.password" class="input-error-message-style">{{ form.errors.password }}</div>
            </div>

            <div class="mt-4">
                <input type="password" placeholder="Password confirmation" name="password_confirmation" v-model="form.password_confirmation" class="input-style" required />
                <div v-if="form.errors.password_confirmation" class="input-error-message-style">{{ form.errors.password_confirmation }}</div>
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
