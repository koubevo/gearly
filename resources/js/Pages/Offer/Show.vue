<template>
    <div class="grid grid-cols-12 md:gap-16 gap-0 pb-20">
        <div class="col-span-12 md:col-span-6">
            <!-- TODO: images with swiping, better link without ../  -->
            <!-- TODO: conditon, wishlist -->
            
            <ImageViewer :images="images" />
        </div>
        <!-- TODO: move to middle -->
        <div class="col-span-12 md:col-span-6 md:pt-10">
            <section class="grid mb-6">
                <Heading1 :text="offer.name" class="mb-3"/>
                <Price :price="offer.price" :currency="offer.currency"/>
            </section>
            <section class="grid mb-6">
                <NormalText class="mb-4 pe-2">{{ offer.description }}</NormalText>
                <div class="flex flex-col gap-x-2 gap-y-0.5 text-sm mb-6">
                    <OfferDetail :detail="'Brand'" :detailValue="brand.name"/>
                    <OfferDetail :detail="'Sport'" :detailValue="offer.sport"/>
                    <OfferDetail :detail="'Category'" :detailValue="category.name"/>
                    <!-- TODO: filter category name without units -->
                    <OfferDetail :detail="filter.filter_category_name" :detailValue="filter.filter_name" v-for="filter in filters"/>
                </div>
                <div class="flex flex-col gap-x-2 gap-y-0.5 text-sm">
                    <OfferDetail :detail="'Delivery Option'" :detailValue="deliveryOption.name"/>
                    <OfferDetail :detail="'Delivery Detail'" :detailValue="offer.delivery_detail" v-if="offer.delivery_detail"/>
                </div>
            </section>
            <!-- TODO: add link destination -->
            <Link>
                <section class="border-s-gray-900 border-4 border-e-0 border-y-0 p-2">
                    <Heading3>{{ seller.name }} <span v-if="seller.team">({{ seller.team }})</span></Heading3>
                    <!-- TODO: feedback -->
                    <NormalText class="mb-1">Feedback</NormalText>
                    <!-- TODO: count of selled items, premium badge, verified badge -->
                    <TinyText :text="'Praha | Česká Republika'" class="mb-0.5"/>
                    <TinyText :text="seller.phone" v-if="seller.phone"/>
                </section>
            </Link>
            
            <div v-if="seller.id !== user.id">
               <section class="my-6 hidden md:grid">
                   <PrimaryLink :text="'Chat with seller'"/>
               </section>
               <section class="grid mb-2 md:relative fixed bottom-0 left-0 w-full p-2 md:hidden">
                   <PrimaryLink :text="'Chat with seller'" class="w-full"/>
               </section>
            </div>
            <div v-else>
                <section class="my-6 flex gap-2">
                    <SecondaryLink :text="'Edit'" :href="route('offer.edit', {offer: offer.id})"/>
                    <DangerButton @click="confirmOfferDeletion">Delete</DangerButton>

                    <Modal :show="confirmingOfferDeletion" @close="closeModal">
                        <div class="p-6">
                            <Heading3 class="text-lg text-gray-900">
                                Are you sure you want to delete offer <span class="font-bold">{{ offer.name }}</span>?
                            </Heading3>
                            
                            <div class="mt-6 flex justify-end gap-2">
                                <SecondaryButton @click="closeModal">
                                    Cancel
                                </SecondaryButton>
                            
                                <DangerLink :href="route('offer.destroy', {offer: offer.id})" method="delete">
                                    Delete Offer
                                </DangerLink>
                            </div>
                        </div>
                    </Modal>
                </section>
            </div>
        </div>
        <!-- TODO: related offers section, recently viewed  -->
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { HeartIcon } from '@heroicons/vue/24/outline'
import Price from '@/Components/Offer/Price.vue';
import Condition from '@/Components/Offer/Condition.vue';
import PrimaryLink from '@/Components/Buttons/PrimaryLink.vue';
import Heading1 from '@/Components/Text/Heading1.vue';
import Heading3 from '@/Components/Text/Heading3.vue';
import TinyText from '@/Components/Text/TinyText.vue';
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import DangerLink from '@/Components/Buttons/DangerLink.vue';
import Modal from '@/Components/Modal.vue';
import SmallText from '@/Components/Text/SmallText.vue';
import NormalText from '@/Components/Text/NormalText.vue';
import OfferDetail from '@/Components/Offer/OfferDetail.vue';
import ImageViewer from '@/Components/Offer/ImageViewer.vue';

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
    images: Array
});
</script>