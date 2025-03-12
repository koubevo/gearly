<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, defineEmits } from 'vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import FormInput from '@/Components/Form/FormInput.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const emit = defineEmits(['close-modal']);

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emit('close-modal');
        },
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
            <Heading2 class="mb-2">{{ $t('user.update_password') }}</Heading2>
            <TinyText :text="$t('user.password_info')"/>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6">
            <div class="mb-2">
                <FormInput name="current_password" :labelName="$t('user.current_password')" type="password" v-model="form.current_password" :error="form.errors.current_password" :required="true"/>
            </div>
            <div class="mb-2">            
                <FormInput name="password" :labelName="$t('user.new_password')" type="password" v-model="form.password" :error="form.errors.password" :required="true" />
            </div>
            <div class="mb-2">
                <FormInput name="password_confirmation" :labelName="$t('user.confirm_password')" type="password" v-model="form.password_confirmation" :error="form.errors.password_confirmation" :required="true" />
            </div>

            <PrimaryButton :disabled="form.processing">{{ $t('common.save') }}</PrimaryButton>
        </form>
    </section>
</template>
