<template>
  <div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
      <Card v-for="offer in offersList" :key="offer.id" :offer="offer" />
    </div>

    <div class="flex justify-center my-6">
      <div>
        <PrimaryButton v-if="nextPageUrl" @click="loadMore" 
          :disabled="loading">
          <span v-if="loading">Loading...</span>
          <span v-else>Load More</span>
        </PrimaryButton>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import Card from "@/Components/Offer/Card.vue";
import { usePage } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

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
</script>