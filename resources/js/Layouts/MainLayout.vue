<template>
    <header class="border-b-2 border-black border-solid w-full">
        <div class="container mx-auto">
            <nav class="py-3 px-2 3xl:px-0 flex items-center justify-between header-height-style">
                <div class="flex gap-3 md:gap-5 align-middle items-center mt-0.5">
                    <Link :href="route('landingPage')">
                        <img :src="'/storage/imgs/logo.png'" alt="Logo" class="w-16 md:w-20 h-auto align-middle">
                    </Link>
                    <Link :href="route('search.index')">
                        <MagnifyingGlassIcon class="w-5 h-5 stroke-[2.5]" />
                    </Link>
                    <Button @click="openModal" :class="user ? '' : 'hidden sm:block'">
                      <QuestionMarkCircleIcon class="w-5 h-5" />
                    </Button>
                </div>
                <div class="flex gap-3 md:gap-5" v-if="user">
                    <Link :href="route('offer.create')">
                        <div class="relative w-6 h-6 mt-0.5">
                            <svg class="w-full h-full stroke-[3]" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="animatedGradient" x1="-100%" y1="0%" x2="200%" y2="0%">
                                        <stop offset="0%" stop-color="#1D9E1D">
                                            <animate attributeName="offset" values="-1;2" keyTimes="0;1" dur="10s"
                                                repeatCount="indefinite" />
                                        </stop>
                                        <stop offset="50%" stop-color="black">
                                            <animate attributeName="offset" values="-0.5;2.5" keyTimes="0;1" dur="10s"
                                                repeatCount="indefinite" />
                                        </stop>
                                        <stop offset="100%" stop-color="#1D9E1D">
                                            <animate attributeName="offset" values="0;3" keyTimes="0;1" dur="10s"
                                                repeatCount="indefinite" />
                                        </stop>
                                    </linearGradient>
                                </defs>
                                <path stroke="url(#animatedGradient)" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="3" d="M12 4v16m-8-8h16" />
                            </svg>
                        </div>
                    </Link>
                    <Link :href="route('chat.index')">
                    <div class="relative">
                        <div v-if="unreadChatsCount > 0"
                            class="text-white bg-primary-900 rounded-full w-4 h-4 flex items-center justify-center absolute -top-1.5 -right-1.5 text-[11px]">
                            {{ unreadChatsCount }}
                        </div>
                        <ChatBubbleLeftIcon class="w-6 h-6 mt-0.5" />
                    </div>
                    </Link>
                    <Link :href="route('wishlist.index')">
                    <HeartIcon class="w-6 h-6 mt-0.5" />
                    </Link>
                    <Link :href="route('profile.show')">
                    <UserIcon class="w-6 h-6 mt-0.5" />
                    </Link>
                </div>
                <div class="flex gap-1 mt-0.5 ms-2" v-else>
                    <SecondaryLink :href="route('login')">{{ $t('auth.login') }}</SecondaryLink>
                    <PrimaryLink :href="route('register')">{{ $t('auth.register') }}</PrimaryLink>
                </div>
            </nav>
        </div>
    </header>
    <div class="bg-primary-900 py-1 sm:hidden">
      <button @click="openModal" class="flex items-center justify-center w-full">
        <TinyText class="text-white text-center font-bold">{{ $t('help.do_you_need_help') }}</TinyText>
      </button>
    </div>

    <main class="container mx-auto px-2 mt-6">
        <Modal :show="helpModal" @close="closeModal">
          <div class="p-6 overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-end mb-6">
              <Heading2>{{ $t('common.help') }}</Heading2>
            </div>        
            <div class="mb-4">
              <div
                class="flex items-center justify-between cursor-pointer select-none"
                @click="showBuy = !showBuy">
                <Heading3>{{ $t('help.how_to_buy') }}</Heading3>
                <ChevronDownIcon
                  class="w-5 h-5"
                  :class="{ 'rotate-180': showBuy }"
                />
              </div>
              <div v-if="showBuy" class="mt-2">
                <ol class="list-decimal ml-5 my-2">
                  <li v-if="!user"><NormalText v-html="$t('help.login_first')" /></li>
                  <li><NormalText v-html="$t('help.how_to_buy_text_1')" /></li>
                  <li><NormalText v-html="$t('help.how_to_buy_text_2')" /></li>
                  <li><NormalText v-html="$t('help.how_to_buy_text_3_a')" /></li>
                  <li><NormalText v-html="$t('help.how_to_buy_text_4')" /></li>
                  <li><NormalText v-html="$t('help.how_to_buy_text_5')" /></li>
                  <li><NormalText v-html="$t('help.how_to_buy_text_6')" /></li>
                </ol>
                <BoldNormalText class="text-primary-900">
                  {{ $t('help.how_to_buy_text_7') }}
                </BoldNormalText>
              </div>
            </div>
            <Divider class="my-4 md:w-full" />
            <div class="mb-4">
                <div class="flex items-center justify-between cursor-pointer select-none"
                      @click="showSell = !showSell">
                    <Heading3 class="cursor-pointer" @click="showSell = !showSell">
                      {{ $t('help.how_to_sell') }}
                    </Heading3>
                    <ChevronDownIcon
                        class="w-5 h-5"
                        :class="{ 'rotate-180': showSell }"
                      />
                </div>
              <div v-if="showSell">
                <ol class="list-decimal ml-5 my-2">
                  <li v-if="!user"><NormalText v-html="$t('help.login_first')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_1')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_2')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_3')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_4')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_5')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_6')" /></li>
                  <li><NormalText v-html="$t('help.how_to_sell_text_7')" /></li>
                </ol>
                <BoldNormalText class="text-primary-900">{{ $t('help.how_to_sell_text_8') }}</BoldNormalText>
              </div>
            </div>
            <Divider class="my-4 md:w-full" />        
            <div class="mb-4">
                <div class="flex items-center justify-between cursor-pointer select-none"
                      @click="showChat = !showChat">
                    <Heading3 class="cursor-pointer" @click="showChat = !showChat">
                      {{ $t('help.how_to_chat') }}
                    </Heading3>
                    <ChevronDownIcon
                        class="w-5 h-5"
                        :class="{ 'rotate-180': showChat }" />
                </div>
              <div v-if="showChat">
                <ol class="list-decimal ml-5 my-2">
                  <li v-if="!user"><NormalText v-html="$t('help.login_first')" /></li>
                  <li><NormalText v-html="$t('help.how_to_chat_text_1')" /></li>
                  <li><NormalText v-html="$t('help.how_to_chat_text_2')" /></li>
                  <li><NormalText v-html="$t('help.how_to_chat_text_3')" /></li>
                  <li><NormalText v-html="$t('help.how_to_chat_text_4')" /></li>
                  <li><NormalText v-html="$t('help.how_to_chat_text_5')" /></li>
                </ol>
              </div>
            </div>
          </div>
        </Modal>
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
import { computed, ref, onMounted, onUnmounted, watch } from 'vue';
import { MagnifyingGlassIcon, BellIcon, UserIcon, HeartIcon, ChatBubbleLeftIcon, QuestionMarkCircleIcon, ChevronDownIcon } from '@heroicons/vue/24/outline';
import PrimaryLink from '@/Components/Buttons/PrimaryLink.vue';
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import Heading2 from '@/Components/Text/Heading2.vue';
import Divider from '@/Components/Search/Divider.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import NormalText from '@/Components/Text/NormalText.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import TinyText from '@/Components/Text/TinyText.vue';

const showBuy = ref(false)
const showSell = ref(false)
const showChat = ref(false)

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flashSuccess = computed(() => page.props.flash?.success ?? '');
const flashError = computed(() => page.props.errors?.error ?? '');
const unreadChatsCount = ref(page.props.notifications?.unreadChatsCount || 0);
let intervalId = null;

const fetchUnreadChatsCount = async () => {
    try {
        const response = await axios.get(route('chat.unreadChatsCount'));
        unreadChatsCount.value = response.data.unreadChatsCount;
    } catch (error) {
        console.error('err');
    }
};

watch(
    () => user.value,
    (newUser) => {
        if (newUser) {
            fetchUnreadChatsCount();
            intervalId = setInterval(fetchUnreadChatsCount, 10000);
        } else {
            clearInterval(intervalId);
        }
    },
    { immediate: true }
);

onUnmounted(() => {
    clearInterval(intervalId);
});

const helpModal = ref(false);

const openModal = () => {
    helpModal.value = true;
};

const closeModal = () => {
    helpModal.value = false;
};
</script>