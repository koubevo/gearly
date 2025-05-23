<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const user = usePage().props.auth.user;

const form = useForm({
    notifications_inactive: user.notifications_inactive,
    notifications_new_messages: user.notifications_new_messages,
});

const emit = defineEmits(['close-modal']);

const updateNotifications = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            window.location.reload(true);
        },
        onError: () => {
            console.log('err');
        },
    });
};
</script>

<template>
    <section>
        <header>
            <Heading2 class="mb-2">{{ $t('user.update_profile_information') }}</Heading2>
            <TinyText :text="$t('user.notifications_text')"/>
        </header>

        <form @submit.prevent="updateNotifications" class="mt-6">
            <div class="my-2">
                <label class="capitalize"></label>
                <div class="w-full mt-1">
                    <div class="flex flex-col sm:flex-row gap-2">
                    <label class="cursor-pointer w-full sm:flex-1">
                        <input type="radio" name="notifications_inactive" class="hidden peer" :value="1" v-model="form.notifications_inactive" />
                        <div class="sport-selector-style uppercase">
                            {{ $t('user.enabled') }}
                        </div>
                    </label>
                    <label class="cursor-pointer w-full sm:flex-1">
                        <input type="radio" name="notifications_inactive" class="hidden peer" :value="0" v-model="form.notifications_inactive" />
                        <div class="sport-selector-style uppercase">
                            {{ $t('user.disabled') }}
                        </div>
                    </label>
                </div>
                </div>
                <div v-if="form.errors.notifications_inactive" class="input-error-message-style">{{ form.errors.notifications_inactive }}</div>
            </div>
            <PrimaryButton :disabled="form.processing">{{ $t('common.save') }}</PrimaryButton>
        </form>
    </section>
</template>
