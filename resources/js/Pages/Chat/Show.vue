<template>
    <section class="flex flex-col h-[calc(100vh-90px)] max-w-5xl mx-auto">
        <InfoSection :seller="seller" :offer="offer" :buyer="buyer" class="mb-4 flex-shrink-0"/>
        <ChatSection ref="chatSectionRef" :seller="seller" :offer="offer" :buyer="buyer" class="mb-4 flex-grow overflow-auto"/>
        <section class="flex items-center justify-between gap-2 flex-shrink-0">
            <button class="primary-button-chat-style" v-if="chatSectionRef?.messagesCount > 2 && offer.user_id === currentUser.id && offer.status === 'active'" @click="openModal">Sell</button>
            <button class="primary-button-chat-style" v-if="offer.buyer_id === currentUser.id && offer.status === 'sold'" @click="openModal">Receive</button>
            <input type="text" name="message" v-model="message" @keyup.enter="sendMessage" class="input-style" placeholder="Type a message...">
            <button @click="sendMessage" class="mx-2"><PaperAirplaneIcon class="w-5 h-5 stroke-[2]"/></button>
        </section>
    </section>
    <Modal :show="modal" @close="closeModal" v-if="chatSectionRef?.messagesCount > 2 && offer.user_id === currentUser.id && offer.status === 'active'">
      <div class="p-6">
          <div class="flex justify-between items-end">
            <Heading2>Do you want to sell <span class="text-primary-900">{{ offer.name }}</span> to <span class="text-primary-900">{{ buyer.name }}</span>?</Heading2>
            <button class="text-gray-500 hover:text-black" @click="closeModal">&times;</button>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
            <PrimaryButton class="flex-1" @click="sellOffer">Yes</PrimaryButton>
            <SecondaryButton class="flex-1" @click="closeModal">Close</SecondaryButton>
          </div>
      </div>
  </Modal>
  <Modal :show="modal" @close="closeModal" v-if="offer.buyer_id === currentUser.id && offer.status === 'sold'">
      <div class="p-6">
          <div class="flex justify-between items-end">
            <Heading2>Do you want to confirm receiving offer <span class="text-primary-900">{{ offer.name }}</span> from <span class="text-primary-900">{{ seller.name }}</span>?</Heading2>
            <button class="text-gray-500 hover:text-black" @click="closeModal">&times;</button>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
            <PrimaryButton class="flex-1" @click="receiveOffer">Yes</PrimaryButton>
            <SecondaryButton class="flex-1" @click="closeModal">Close</SecondaryButton>
          </div>
      </div>
  </Modal>
</template>

<script setup>
import { ref } from 'vue';
import ChatSection from "@/Components/Chat/ChatSection.vue";
import InfoSection from "@/Components/Chat/InfoSection.vue";
import { PaperAirplaneIcon } from "@heroicons/vue/24/outline";
import Modal from "@/Components/Modal.vue";
import Heading2 from "@/Components/Text/Heading2.vue";
import Divider from "@/Components/Search/Divider.vue";
import { usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';

const page = usePage();
const currentUser = page.props.auth?.user;

const message = ref('');
const chatSectionRef = ref(null);

const props = defineProps({
    buyer: Object,
    seller: Object,
    offer: Object,
});

const sendMessage = () => {
    if(message.value.trim() !== '') {
        axios.post(route('chat.send', {offer: props.offer, buyer: props.buyer}), {
            message: message.value,
            type_id: 1
        })
        .then(() => {
            message.value = '';
        });
    }
};

const sellOffer = () => {
    axios.post(route('offer.sell', {offer: props.offer, buyer: props.buyer}))
    .then(() => {
        closeModal();
        props.offer.status = 'sold';
    });
};

const receiveOffer = () => {
    axios.post(route('offer.receive', {offer: props.offer}))
    .then(() => {
        closeModal();
        props.offer.status = 'received';
    });
};

const modal = ref(false);

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};
</script>