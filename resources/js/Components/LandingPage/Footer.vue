<template>
    <footer class="mt-16">
        <section class="bg-primary-900 text-center py-6">
        <Heading2 class="text-white uppercase oxanium">
            Built for the community.
        </Heading2>
    </section>
    <section class="bg-black px-8 pt-8 pb-6 lg:pb-12 md:px-14 xl:px-24 md:pt-14">
        <div class="flex flex-col md:flex-row md:items-center md:gap-8 mb-8 md:mb-14 items-center">
            <div class="md:w-1/3 w-full flex md:flex-row gap-4">
                <div class="flex-1">
                    <BoldNormalText class="text-white border-b-2 border-white mb-2 inline-block w-auto">{{ $t('common.app') }}</BoldNormalText>
                    <Link :href="route('help')">
                        <SmallText class="text-white mb-0.5">{{ $t('help.full_help') }}</SmallText>
                    </Link>
                    <Link :href="route('search.index')">
                        <SmallText class="text-white mb-0.5">{{ $t('search.search') }}</SmallText>
                    </Link>
                    <Link :href="route('offer.index', {sport: 2})">
                        <SmallText class="text-white mb-0.5">Baseball</SmallText>
                    </Link>
                    <Link :href="route('offer.index', {sport: 3})">
                        <SmallText class="text-white mb-0.5">Softball</SmallText>
                    </Link>
                </div>
                <div class="flex-1">
                    <BoldNormalText class="text-white border-b-2 border-white mb-2 inline-block w-auto">{{ $t('common.about') }}</BoldNormalText>
                    <Link>
                        <SmallText class="text-white mb-0.5">{{ $t('common.about_app') }}</SmallText>
                    </Link>
                    <Link>
                        <SmallText class="text-white mb-0.5">{{ $t('common.changelog') }}</SmallText>
                    </Link>
                    <a href="https://blog.gearly.eu/" target="_blank">
                        <SmallText class="text-white mb-0.5">{{ $t('common.blog') }}</SmallText>
                    </a>
                    <a href="mailto:info@gearly.eu">
                        <SmallText class="text-white mb-0.5">{{ $t('common.contact') }}</SmallText>
                    </a>
                </div>
            </div>
            <div class="md:w-2/3 w-full hidden md:flex flex-col items-center md:items-start mt-8 md:mt-0 select-none relative">
                <span
                    class="w-full text-7xl lg:text-9xl uppercase oxanium text-end text-primary-900 absolute top-1 left-1 pointer-events-none"
                    aria-hidden="true"
                >
                    Gearly
                </span>
                <span class="w-full text-7xl lg:text-9xl uppercase oxanium text-end text-white relative">
                    Gearly
                </span>
            </div>
        </div>
        <div class="flex justify-between items-end">
            <div class="flex gap-2 align-middle">
                <a href="https://www.instagram.com/gearly.eu/" target="_blank">
                    <span class="bg-white w-8 h-8 flex items-center justify-center" aria-label="Instagram">
                        <IgIcon/>
                    </span>
                </a>
                <a href="https://x.com/gearly" target="_blank">
                    <span class="bg-white w-8 h-8 flex items-center justify-center" aria-label="X/Twitter">
                        <XIcon/>
                    </span>
                </a>
            </div>
            <div class="text-white self-center">
            <!-- 
                <Link>EN</Link> / <Link>CZ</Link>
            -->
            </div>
        </div>
    </section>
    </footer>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Heading2 from '@/Components/Text/Heading2.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import SmallText from '@/Components/Text/SmallText.vue';
import IgIcon from '@/Components/Icons/IgIcon.vue';
import XIcon from '@/Components/Icons/XIcon.vue';

</script>