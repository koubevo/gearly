<template>
  <Head :title="'Chat with ' + name" />
    <section class="flex flex-col h-[calc(100vh-100px)] max-w-5xl mx-auto">
        <InfoSection :seller="seller" :offer="offer" :buyer="buyer" :rating="rating" :name="name" :userId="userId" class="mb-4 flex-shrink-0"/>
        <ChatSection ref="chatSectionRef" :seller="seller" :offer="offer" :buyer="buyer" class="mb-4 flex-grow overflow-auto"/>
        <section class="flex items-center justify-between gap-2 flex-shrink-0">
            <button class="primary-button-chat-style" v-if="chatSectionRef?.messagesCount > 2 && offer.user_id === currentUser.id && offer.status === 'active'" @click="openModal">Sell</button>
            <button class="primary-button-chat-style" v-if="offer.buyer_id === currentUser.id && offer.status === 'sold'" @click="openModal">Receive</button>
            <button class="secondary-button-chat-style" v-if="offer.user_id === currentUser.id && offer.status === 'sold'" @click="openModal">Cancel</button>
            <button class="primary-button-chat-style" v-if="offer.status === 'received' && ableToRate" @click="openModal">Rate</button>
            <input type="text" name="message" v-model="message" @keyup.enter="sendMessage" class="input-style" placeholder="Type a message...">
            <button @click="sendMessage" class="mx-2"><PaperAirplaneIcon class="w-5 h-5 stroke-[2]"/></button>
        </section>
    </section>
    <Modal :show="modal" @close="closeModal" v-if="chatSectionRef?.messagesCount > 2 && offer.user_id === currentUser.id && offer.status === 'active'">
      <div class="p-6">
          <div class="flex justify-between items-end mb-2">
            <Heading2>Do you want to sell <span class="text-primary-900">{{ offer.name }}</span> to <span class="text-primary-900">{{ buyer.name }}</span>?</Heading2>
          </div>
          <div>
            <TinyText>
              Once the seller marks an offer as "Sold," it confirms that they have chosen to sell the item to the buyer. This status update appears in the chat, signaling to both users that the deal is finalized.
              <br>
              Marking an offer as sold is also the first step towards enabling mutual ratings. After the buyer reveives the offer and confirms it in Gearly, both users will have the opportunity to rate each other.
            </TinyText>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
            <SecondaryButton class="flex-1" @click="closeModal">Close</SecondaryButton>
            <PrimaryButton class="flex-1" @click="sellOffer">Yes</PrimaryButton>
          </div>
      </div>
  </Modal>
  <Modal :show="modal" @close="closeModal" v-if="offer.user_id === currentUser.id && offer.status === 'sold'">
      <div class="p-6">
          <div class="flex justify-between items-end mb-2">
            <Heading2>Do you want to cancel selling offer <span class="text-red-600">{{ offer.name }}</span> to <span class="text-red-600">{{ seller.name }}</span>?</Heading2>
          </div>
          <div>
            <TinyText>
              If the transaction doesn’t go through, you can cancel the "Sold" status. This will reopen the offer, and the buyer will no longer be able to confirm the purchase.
            </TinyText>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
            <SecondaryButton class="flex-1" @click="closeModal">Close</SecondaryButton>
            <DangerButton class="flex-1" @click="cancelOffer">Yes</DangerButton>
          </div>
      </div>
  </Modal>
  <Modal :show="modal" @close="closeModal" v-if="offer.buyer_id === currentUser.id && offer.status === 'sold'">
      <div class="p-6">
          <div class="flex justify-between items-end mb-2">
            <Heading2>Do you want to confirm receiving offer <span class="text-primary-900">{{ offer.name }}</span> from <span class="text-primary-900">{{ seller.name }}</span>?</Heading2>
          </div>
          <div>
            <TinyText>
              Once you receive the item, confirm the delivery in Gearly. This step finalizes the transaction and allows both you and the seller to rate each other.
              <br>
              Confirming delivery ensures transparency and helps build trust within the community.
            </TinyText>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
            <SecondaryButton class="flex-1" @click="closeModal">Close</SecondaryButton>
            <PrimaryButton class="flex-1" @click="receiveOffer">Yes</PrimaryButton>
          </div>
      </div>
  </Modal>
  <Modal :show="modal" @close="closeModal" v-if="offer.status === 'received' && ableToRate">
    <div class="p-6">
      <div class="flex justify-between items-end mb-2">
        <Heading2>Give us your opinion on <span class="text-primary-900">{{ name }}</span>.</Heading2>
      </div>
      <div>
            <TinyText>
              Now that the deal is complete, you can rate the other user based on your experience. Ratings help build trust and ensure a safe marketplace for everyone.
            </TinyText>
          </div>
      <Divider class="md:w-full my-4"/>

      <div class="flex flex-col items-center">
        <div class="flex mx-auto mb-4" @mouseleave="resetHover">
          <template v-for="star in 5" :key="star">
            <StarIcon 
              v-if="star <= (hoveredRating || selectedRating)" 
              @mouseover="hoverRating(star)" 
              @click="setRating(star)" 
              class="text-primary-900 w-10 h-10 cursor-pointer"
            />
            <StarOutlineIcon 
              v-else 
              @mouseover="hoverRating(star)" 
              @click="setRating(star)" 
              class="text-gray-300 w-10 h-10 cursor-pointer"
            />
          </template>
        </div>

        <div class="mb-4 w-full">
          <FormTextArea v-model="comment" labelName="Verbal rating" name="verbal" />
        </div>

        <div class="flex flex-col md:flex-row gap-2 w-full">
          <SecondaryButton class="flex-1" @click="closeModal">Close</SecondaryButton>
          <PrimaryButton class="flex-1" @click="rateUser">Rate</PrimaryButton>
        </div>
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
import { StarIcon } from '@heroicons/vue/24/solid';
import { StarIcon as StarOutlineIcon } from '@heroicons/vue/24/outline';
import FormTextArea from '@/Components/Form/FormTextArea.vue';
import { Head } from '@inertiajs/vue3';
import DangerButton from '@/Components/Buttons/DangerButton.vue';
import TinyText from '@/Components/Text/TinyText.vue';
  
const selectedRating = ref(0);
const hoveredRating = ref(null);

const hoverRating = (star) => {
  hoveredRating.value = star;
};

const resetHover = () => {
  hoveredRating.value = null;
};

const setRating = (star) => {
  selectedRating.value = star; 
};

const page = usePage();
const currentUser = page.props.auth?.user;

const message = ref('');
const chatSectionRef = ref(null);
const comment = ref(''); 

const props = defineProps({
    buyer: Object,
    seller: Object,
    offer: Object,
    rating: Object,
    ableToRate: Boolean ?? false
});

const ableToRate = ref(props.ableToRate);

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
        ableToRate.value = true;
    });
};

const cancelOffer = () => {
    axios.post(route('offer.cancel', {offer: props.offer}))
    .then(() => {
        closeModal();
        props.offer.status = 'active';
    });
};

const rateUser = () => {
    axios.post(route('rating.store'), {
        offer_id: props.offer.id,
        rated_user_id: userId,
        stars: selectedRating.value,
        comment: comment.value ?? ''
    })
    .then(() => {
        closeModal();
        ableToRate.value = false;
    });
};

const modal = ref(false);

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};

let name, userId;
if (currentUser.id === props.buyer.id) {
    userId = props.seller.id;
    name = props.seller.name;
} else {
    userId = props.buyer.id;
    name = props.buyer.name;
}
</script>