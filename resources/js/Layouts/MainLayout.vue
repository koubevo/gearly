<template>
    <header class="border-b-2 border-black border-solid w-full mb-4">
        <div class="container mx-auto">
            <nav class="py-3 max-md:px-2 flex items-center justify-between header-height-style">
                <div class="flex gap-3 md:gap-5 align-middle items-center mt-0.5">
                    <Link :href="route('landingPage')">
                        <img :src="'/storage/imgs/logo.png'" alt="Logo" class="w-16 md:w-20 h-auto align-middle">
                    </Link>
                    <Link :href="route('search.index')">
                        <MagnifyingGlassIcon class="w-5 h-5  stroke-[2.5]" />
                    </Link>
                </div>
                <div class="flex gap-2 md:gap-5" v-if="user">
                    <Link :href="route('offer.create')">
                        <div class="relative w-6 h-6 mt-0.5">
                            <svg class="w-full h-full stroke-[3]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="animatedGradient" x1="-100%" y1="0%" x2="200%" y2="0%">
                                        <stop offset="0%" stop-color="#1D9E1D">
                                            <animate attributeName="offset" values="-1;2" keyTimes="0;1" dur="10s" repeatCount="indefinite"/>
                                        </stop>
                                        <stop offset="50%" stop-color="black">
                                            <animate attributeName="offset" values="-0.5;2.5" keyTimes="0;1" dur="10s" repeatCount="indefinite"/>
                                        </stop>
                                        <stop offset="100%" stop-color="#1D9E1D">
                                            <animate attributeName="offset" values="0;3" keyTimes="0;1" dur="10s" repeatCount="indefinite"/>
                                        </stop>
                                    </linearGradient>
                                </defs>
                                <path stroke="url(#animatedGradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m-8-8h16"/>
                            </svg>
                        </div>
                    </Link>
                    <Link :href="route('landingPage')">
                        <BellIcon class="w-6 h-6 mt-0.5" />
                    </Link>
                    <Link :href="route('landingPage')">
                        <HeartIcon class="w-6 h-6 mt-0.5" />
                    </Link>
                    <Link :href="route('profile.edit')">
                        <UserIcon class="w-6 h-6 mt-0.5" />   
                    </Link>
                </div>
                <div class="flex gap-2 mt-0.5" v-else>
                    <SecondaryLink :href="route('login')">Log in</SecondaryLink>
                    <PrimaryLink :href="route('register')">Register</PrimaryLink>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mx-auto max-md:px-2">
        <div v-if="flashSuccess" class="flash-message-success-style">
            {{ flashSuccess }}
        </div>

        <div v-if="flashError" class="flash-message-error-style">
            {{ flashError }}
        </div>
        <slot></slot>
    </main>   
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import { MagnifyingGlassIcon, BellIcon, UserIcon, HeartIcon } from '@heroicons/vue/24/outline';
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
import PrimaryLink from '@/Components/Buttons/PrimaryLink.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const flashSuccess = computed(() => page.props.flash?.success ?? '');
const flashError = computed(() => page.props.errors?.error ?? '');

onMounted(() => {
    if (flashSuccess.value || flashError.value) {
        setTimeout(() => {
            flashSuccess.value = '';
            flashError.value = '';
        }, 10000);
    }
});
</script>