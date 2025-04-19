<template>

    <Head :title="offer.name" />
    <div class="grid grid-cols-12 md:gap-16 gap-0 pb-20">
        <div class="col-span-12 md:col-span-6 items-center justify-center flex relative">
            <ImageViewer :images="images" />
        </div>
        <div class="col-span-12 md:col-span-6 md:pt-10">
            <section class="grid mb-6">
                <Heading1 :text="offer.name" class="mb-3" />
                <Price :price="offer.price" :currency="offer.currency" />
                <ConditionLike :offer="offer" class="mt-2" />
            </section>
            <section class="grid mb-6">
                <NormalText class="mb-4 pe-2">{{ offer.description }}</NormalText>
                <div class="flex flex-col gap-x-2 gap-y-0.5 text-sm mb-6">
                    <OfferDetail :detail="$t('common.brand')" :detailValue="brand.name" />
                    <OfferDetail :detail="'Sport'" :detailValue="offer.sport" />
                    <OfferDetail :detail="$t('common.category')" :detailValue="category.name" class="mb-2" />
                    <OfferDetail :detail="filter.filter_category_name" :detailValue="filter.filter_name"
                        v-for="filter in filters" />
                </div>
                <div class="flex flex-col gap-x-2 gap-y-0.5 text-sm">
                    <OfferDetail :detail="$t('offer.delivery_option')" :detailValue="deliveryOption.name" />
                    <OfferDetail :detail="$t('offer.delivery_detail')" :detailValue="offer.delivery_detail"
                        v-if="offer.delivery_detail" />
                </div>
                <div class="mt-6">
                    <Link :href="route('chat.show', { offer: offer.id, buyer: user.id })" v-if="seller.id !== user.id">
                        <BoldNormalText>
                            <QuestionMarkCircleIcon class="w-5 h-5 inline-block align-text-bottom stroke-[2]" />
                            {{ $t('common.interest') }}
                        </BoldNormalText>
                    </Link>
                    <BoldNormalText v-if="seller.id === user.id && offer.statusNumber === 1">
                            <QuestionMarkCircleIcon class="w-5 h-5 inline-block align-text-bottom stroke-[2]" />
                            {{ $t('common.want_to_sell') }}
                    </BoldNormalText>
                    <Link :href="route('login')" v-if="!user.id">
                        <BoldNormalText>
                            <QuestionMarkCircleIcon class="w-5 h-5 inline-block align-text-bottom stroke-[2]" />
                            {{ $t('common.interest') }}
                        </BoldNormalText>
                    </Link>
                </div>
            </section>
            <Link :href="seller.id === user.id ? '/profile' : route('user.show', { user: seller.id })">
            <OfferUserDetail :seller="seller" :soldOffersCount="soldOffersCount" :rating="rating" />
            </Link>

            <div v-if="seller.id !== user.id && offer.statusNumber === 1">
                <section class="my-6 hidden md:grid">
                    <PrimaryLink :text="$t('common.chat_with_seller')"
                        :href="user.id ? route('chat.show', { offer: offer.id, buyer: user.id }) : route('login', { redirect: route('offer.show', { offer: offer.id }) })" />
                </section>
                <section class="grid mb-2 md:relative fixed bottom-0 left-0 w-full p-2 md:hidden">
                    <PrimaryLink :text="$t('common.chat_with_seller')" class="w-full"
                        :href="user.id ? route('chat.show', { offer: offer.id, buyer: user.id }) : route('login', { redirect: route('offer.show', { offer: offer.id }) })" />
                </section>
            </div>
            <div v-else>
                <section class="my-6 flex gap-2" v-if="offer.statusNumber === 1">
                    <SecondaryLink :text="$t('common.edit')" :href="route('offer.edit', { offer: offer.id })" />
                    <DangerButton @click="confirmOfferDeletion">{{ $t('common.delete') }}</DangerButton>

                    <Modal :show="confirmingOfferDeletion" @close="closeModal">
                        <div class="p-6">
                            <Heading3 class="text-lg text-gray-900">
                                {{ $t('offer.are_you_sure_delete') }} <span class="font-bold">{{ offer.name }}</span>?
                            </Heading3>

                            <div class="mt-6 flex justify-end gap-2">
                                <SecondaryButton @click="closeModal">
                                    {{ $t('common.cancel') }}
                                </SecondaryButton>

                                <DangerLink :href="route('offer.destroy', { offer: offer.id })" method="delete">
                                    {{ $t('offer.delete_offer') }}
                                </DangerLink>
                            </div>
                        </div>
                    </Modal>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Price from '@/Components/Offer/Price.vue';
import PrimaryLink from '@/Components/Buttons/PrimaryLink.vue';
import Heading1 from '@/Components/Text/Heading1.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import DangerLink from '@/Components/Buttons/DangerLink.vue';
import Modal from '@/Components/Modal.vue';
import NormalText from '@/Components/Text/NormalText.vue';
import OfferDetail from '@/Components/Offer/OfferDetail.vue';
import ImageViewer from '@/Components/Offer/ImageViewer.vue';
import OfferUserDetail from '@/Components/User/OfferUserDetail.vue';
import ConditionLike from '@/Components/Offer/ConditionLike.vue';
import { Head } from '@inertiajs/vue3';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';
import { QuestionMarkCircleIcon } from '@heroicons/vue/24/outline';


onMounted(() => {
    window.scrollTo(0, 0);
});

const user = usePage().props.auth.user ?? {};

const confirmingOfferDeletion = ref(false);

function confirmOfferDeletion() {
    confirmingOfferDeletion.value = true;
}

function closeModal() {
    confirmingOfferDeletion.value = false;
}

defineProps({
    offer: Object,
    seller: Object,
    category: Object,
    deliveryOption: Object,
    brand: Object,
    filters: Object,
    images: Array,
    soldOffersCount: Number,
    rating: Object
});
</script>