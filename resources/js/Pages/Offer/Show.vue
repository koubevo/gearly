<template>
    <div class="grid grid-cols-12 md:gap-16 gap-0 pb-20">
        <div class="col-span-12 md:col-span-6">
            <!-- TODO: images with swiping, better link without ../  -->
            <!-- TODO: conditon, wishlist -->
            <img :src="'../storage/imgs/nike.jpg'" :alt="offer.name" class="mb-2">
        </div>
        <!-- TODO: move to middle -->
        <div class="col-span-12 md:col-span-6 md:pt-10">
            <section class="grid mb-6">
                <Heading1 :text="offer.name"/>
                <Price :price="offer.price" :currency="offer.currency"/>
            </section>
            <section class="grid mb-6">
                <!-- TODO: filters, size -->
                <p class="mb-6 pe-2">{{ offer.description }}</p>
                <div class="flex flex-col gap-x-2 gap-y-0.5 text-sm mb-6">
                    <div class="flex gap-2 mb-0">
                        <div class="font-medium">Brand:</div>
                        <div>{{ brand.name }}</div>
                    </div>
                    <div class="flex gap-2 mb-0">
                        <div class="font-medium">Sport:</div>
                        <div>{{ offer.sport }}</div>
                    </div>
                    <div class="flex gap-2 mb-0">
                        <div class="font-medium">Category:</div>
                        <div>{{ category.name }}</div>
                    </div>
                    <div class="flex gap-2">
                        <div class="font-medium">Size:</div>
                        <div>46</div>
                    </div>
                </div>
                <div class="flex flex-col gap-x-2 gap-y-0.5 text-sm">
                    <div class="flex gap-2 mb-0">
                        <div class="font-medium">Delivery Option:</div>
                        <div>{{ deliveryOption.name }}</div>
                    </div>
                    <div class="flex gap-2 mb-0">
                        <div class="font-medium">Delivery Detail:</div>
                        <div>{{ offer.delivery_description }}</div>
                    </div>
                </div>
            </section>
            <!-- TODO: add link destination -->
            <Link>
                <section class="border-s-gray-900 border-4 border-e-0 border-y-0 p-2">
                    <Heading3>{{ seller.name }} <span v-if="seller.team">({{ seller.team }})</span></Heading3>
                    <p class="mb-1">Feedback</p>
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
                    <!-- TODO: modal -->
                    <DangerButton @click="confirmOfferDeletion">Delete</DangerButton>

                    <Modal :show="confirmingOfferDeletion" @close="closeModal">
                        <div class="p-6">
                            <!-- TODO: component -->
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
import Price from '@/Components/Price.vue';
import Condition from '@/Components/Condition.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Heading1 from '@/Components/Heading1.vue';
import Heading3 from '@/Components/Heading3.vue';
import TinyText from '@/Components/TinyText.vue';
import SecondaryLink from '@/Components/SecondaryLink.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DangerLink from '@/Components/DangerLink.vue';
import Modal from '@/Components/Modal.vue';
import SmallText from '@/Components/SmallText.vue';

const user = usePage().props.auth.user;

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
    brand: Object
});
</script>