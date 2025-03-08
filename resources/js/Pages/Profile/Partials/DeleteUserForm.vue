<script setup>
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import NormalText from '@/Components/Text/NormalText.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <Heading2 class="mb-2">{{ $t('user.delete_account') }}</Heading2>
            <NormalText>{{ $t('user.delete_account_info') }}</NormalText>
        </header>

        <DangerButton @click="confirmUserDeletion">{{ $t('user.delete_account') }}</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <Heading2 class="mb-2">{{ $t('user.are_you_sure') }}</Heading2>

                <TinyText :text="$t('user.delete_info_two')"/>

                <div class="mt-6">
                    <div class="mt-4">
                        <input type="password" :placeholder="$t('user.password')" name="password" v-model="form.password" class="input-style" required />
                        <div v-if="form.errors.password" class="input-error-message-style">{{ form.errors.password }}</div>
                    </div>
                </div>
                <div class="mt-2 flex justify-end">
                    <SecondaryButton @click="closeModal">{{ $t('common.cancel') }}</SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        {{ $t('user.delete_account') }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
