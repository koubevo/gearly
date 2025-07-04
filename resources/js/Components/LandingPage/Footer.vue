<template>
    <section class="bg-primary-900 text-center py-4">
        <Heading2 class="text-white">
            Built for the <span class="text-black">community.</span>
        </Heading2>
    </section>
    <section class="bg-black px-8 pt-8 pb-6 md:px-14 md:pt-14">
        <div class="flex gap-16 mb-8">
            <div>
                <BoldNormalText class="text-white border-b-2 border-white mb-2">About</BoldNormalText>
                <Link>
                    <SmallText class="text-white">Zásady</SmallText>
                </Link>
                <Link>
                    <SmallText class="text-white">Changelog</SmallText>
                </Link>
                <Link>
                    <SmallText class="text-white">Blog</SmallText>
                </Link>
                <Link>
                    <SmallText class="text-white">Contact</SmallText>
                </Link>
            </div>
            <div>
                <BoldNormalText class="text-white border-b-2 border-white mb-2">About</BoldNormalText>
                <Link>
                    <SmallText class="text-white">Zásady</SmallText>
                </Link>
                <Link>
                    <SmallText class="text-white">Changelog</SmallText>
                </Link>
                <Link>
                    <SmallText class="text-white">Blog</SmallText>
                </Link>
                <Link>
                    <SmallText class="text-white">Contact</SmallText>
                </Link>
            </div>
            <div class="hidden lg:flex text-center text-white align-middle ">
                <span class="w-full text-8xl">GEARLY</span>
            </div>
        </div>
        <div class="flex justify-between">
            <div class="flex gap-2 align-middle">
                <span class="bg-white w-8 h-8">
                
                </span>
                <span class="bg-white w-8 h-8">
                
                </span>
            </div>
            <div class="text-white">
                <Link>EN</Link> / <Link>CZ</Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Heading2 from '@/Components/Text/Heading2.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import SmallText from '@/Components/Text/SmallText.vue';
//import { InstagramIcon } from '@heroicons/vue/24/outline';


</script>