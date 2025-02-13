<template>
    <header class="border-b-2 border-black border-solid w-full">
        <div class="container mx-auto">
            <nav class="py-3 max-md:px-2 flex items-center justify-between header-height-style">
                <div class="flex gap-3">
                    <Link :href="route('landingPage')">
                        <img :src="'storage/imgs/logo.png'" alt="Logo" class="w-20 h-auto">
                    </Link>
                    <Link :href="route('landingPage')">
                        <MagnifyingGlassIcon class="w-5 h-5 mt-0.5" />
                    </Link>
                </div>
                <div class="flex gap-2" v-if="user">
                    <Link :href="route('landingPage')">
                        <BellIcon class="w-5 h-5 mt-0.5" />
                    </Link>
                    <Link :href="route('landingPage')">
                        <HeartIcon class="w-5 h-5 mt-0.5" />
                    </Link>
                    <Link :href="route('profile.edit')">
                        <UserIcon class="w-5 h-5 mt-0.5" />   
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
        <!-- TODO: Component and better styling -->
        <div v-if="flashSuccess" class="mb-4 shadow-sm border-s-primary-900 border-4 border-e-0 border-y-0 p-2 bg-primary-500">
            {{ flashSuccess }}
        </div>
        <slot></slot>
    </main>   
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { MagnifyingGlassIcon, BellIcon, UserIcon, HeartIcon } from '@heroicons/vue/24/outline'
import SecondaryLink from '@/Components/SecondaryLink.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';


const user = computed(() => page.props.auth.user);
const page = usePage();

const flashSuccess = computed(() => page.props.flash?.success ?? '');
</script>