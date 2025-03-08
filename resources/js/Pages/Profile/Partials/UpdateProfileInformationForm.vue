<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

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
    lang: user.lang,
});

const emit = defineEmits(['close-modal']);

const updateProfile = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            window.location.reload(true);
        },
        onError: () => {
            console.log(form.errors);
        },
    });
};
</script>

<template>
    <section>
        <header>
            <Heading2 class="mb-2">{{ $t('user.update_profile_information') }}</Heading2>
            <TinyText :text="$t('user.change_others')"/>
        </header>

        <form @submit.prevent="updateProfile" class="mt-6">
            <div class="my-2">
                <label class="capitalize">Language/Jazyk/Taal/Lingua/Sprache</label>
                <div class="w-full mt-1">
                    <div class="flex flex-col sm:flex-row gap-2">
                    <label class="cursor-pointer w-full sm:flex-1">
                        <input type="radio" name="lang" class="hidden peer" value="en" v-model="form.lang" />
                        <div class="sport-selector-style uppercase">
                            🇺🇸 ENGLISH
                        </div>
                    </label>
                    <label class="cursor-pointer w-full sm:flex-1">
                        <input type="radio" name="lang" class="hidden peer" value="cs" v-model="form.lang" />
                        <div class="sport-selector-style uppercase">
                            🇨🇿 ČEŠTINA
                        </div>
                    </label>
                </div>
                </div>
                <div v-if="form.errors.lang" class="input-error-message-style">{{ form.errors.lang }}</div>
            </div>
            <PrimaryButton :disabled="form.processing">{{ $t('common.save') }}</PrimaryButton>
        </form>
    </section>
</template>
