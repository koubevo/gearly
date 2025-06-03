<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    notifications_new_message: props.user.notifications_new_message,
});

const emit = defineEmits(['close-modal']);

const updateNotifications = () => {
    form.patch(route('profile.updateNotifications'), {
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
            <Heading2 class="mb-2">{{ $t('user.update_notifications_preferences') }}</Heading2>
            <TinyText :text="$t('user.notifications_text')"/>
        </header>

        <form @submit.prevent="updateNotifications" class="mt-6">
            <div class="my-2">
                <label>{{ $t('user.new_message_notification') }}</label>
                <div class="w-full mt-1">
                    <div class="flex flex-col sm:flex-row gap-2">
                    <label class="cursor-pointer w-full sm:flex-1">
                        <input type="radio" name="notifications_new_message" class="hidden peer" :value="1" v-model="form.notifications_new_message" />
                        <div class="sport-selector-style uppercase">
                            {{ $t('user.enabled') }}
                        </div>
                    </label>
                    <label class="cursor-pointer w-full sm:flex-1">
                        <input type="radio" name="notifications_new_message" class="hidden peer" :value="0" v-model="form.notifications_new_message" />
                        <div class="sport-selector-style uppercase">
                            {{ $t('user.disabled') }}
                        </div>
                    </label>
                </div>
                </div>
                <div v-if="form.errors.notifications_new_message" class="input-error-message-style">{{ form.errors.notifications_new_message }}</div>
            </div>
            <PrimaryButton :disabled="form.processing">{{ $t('common.save') }}</PrimaryButton>
        </form>
    </section>
</template>
