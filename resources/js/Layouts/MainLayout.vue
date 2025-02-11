<template>
    <header class="border-b-2 border-black border-solid w-full mb-2">
        <div class="container mx-auto">
            <nav class="py-3 max-md:px-2 flex items-center justify-between">
                <div class="flex gap-3">
                    <Link :href="route('landingPage')">
                        <img :src="'storage/imgs/logo.png'" alt="Logo" class="w-20 h-auto">
                    </Link>
                    <Link :href="route('landingPage')">
                        <MagnifyingGlassIcon class="w-5 h-5 mt-0.5" />
                    </Link>
                </div>
                <div class="flex gap-2">
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
                <!-- TODO: v-if and components - btn pripary, secondary
                <div class="flex gap-2 mt-0.5">
                    <Link :href="route('landingPage')">Sign in</Link>
                    <Link :href="route('landingPage')">Sign up</Link>
                </div>
                 -->
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

const page = usePage();

const flashSuccess = computed(() => page.props.flash?.success ?? '');
</script>