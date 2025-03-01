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
            <Heading2 class="mb-2">Delete Account</Heading2>
            <NormalText>
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </NormalText>
        </header>

        <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <Heading2 class="mb-2">Are you sure you want to delete your account?</Heading2>

                <TinyText :text="'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'"/>

                <div class="mt-6">
                    <div class="mt-4">
                        <input type="password" placeholder="Password" name="password" v-model="form.password" class="input-style" required />
                        <div v-if="form.errors.password" class="input-error-message-style">{{ form.errors.password }}</div>
                    </div>
                </div>
                <!-- TODO: 1st attempt wrong password, 2nd correct -> deletes -> user dont see (still logged in, kinda) -->
                <div class="mt-2 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
