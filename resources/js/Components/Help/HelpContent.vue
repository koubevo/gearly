<template>
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
</template>

<script setup>
import Divider from '@/Components/Search/Divider.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import NormalText from '@/Components/Text/NormalText.vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import { ChevronDownIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

defineProps({
    user: {
        type: Object,
        required: true,
    },
})

const showBuy = ref(false)
const showSell = ref(false)
const showChat = ref(false)
</script>