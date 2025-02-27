<template>
  <div>
    <section class="grid grid-cols-2 items-center my-6">
      <div>
        <!-- TODO: most expensive, cheapest, most recent, name of category/name of brand/offers -->
        <Heading1>Offers</Heading1>
      </div>
      <div class="flex justify-end">
        <div>
          <SortingButton @click="openModal"/>
        </div>
      </div>
    </section>

    
    
    <Divider class="md:w-full mb-4"/>
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8" v-if="offersList.length">
      <Card v-for="offer in offersList" :key="offer.id" :offer="offer" />
    </section>

    <div class="flex justify-center my-6" v-if="offersList.length">
      <div>
        <PrimaryButton v-if="nextPageUrl" @click="loadMore" 
          :disabled="loading">
          <span v-if="loading">Loading...</span>
          <span v-else>Load More</span>
        </PrimaryButton>
      </div>
    </div>
  </div>
  <div v-if="!offersList.length">
    <NothingHere :text="'Try searching for something else'">We found no offers</NothingHere>
  </div>
  <Modal :show="modal" @close="closeModal">
      <div class="p-6">
          <div class="flex justify-between items-end">
            <Heading2>Sort Offers</Heading2>
            <button class="text-gray-500 hover:text-black" @click="closeModal">&times;</button>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
             <SecondaryLink :href="route('offer.index')">Most recent</SecondaryLink>
             <SecondaryLink :href="route('offer.index', {order: 0})">Cheapest</SecondaryLink>
             <SecondaryLink :href="route('offer.index', {order: 1})">Most expensive</SecondaryLink>
          </div>
      </div>
  </Modal>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import Card from "@/Components/Offer/Card.vue";
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Divider from "@/Components/Search/Divider.vue";
import Heading1 from "@/Components/Text/Heading1.vue";
import SortingButton from "@/Components/Buttons/SortingButton.vue";
import Modal from "@/Components/Modal.vue";
import Heading2 from "@/Components/Text/Heading2.vue";
import SecondaryLink from "@/Components/Buttons/SecondaryLink.vue";
import NothingHere from "@/Components/NothingHere.vue";

const initialOffers = usePage().props.offers.data;
const offersList = ref([...initialOffers]);
const nextPageUrl = ref(usePage().props.offers.next_page_url);
const loading = ref(false);

const loadMore = async () => {
  if (!nextPageUrl.value || loading.value) return;

  loading.value = true;

  try {
    const response = await axios.get(nextPageUrl.value);
    offersList.value.push(...response.data.data);
    nextPageUrl.value = response.data.next_page_url;
  } catch (error) {
    console.error("Error loading more offers:", error);
  } finally {
    loading.value = false;
  }
};


const modal = ref(false);

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};
</script>