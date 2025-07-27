<template> 
    <Heading2 class="mb-2">{{ $t('landing.all_offers')}}</Heading2>
    <section class="offers-grid" v-if="offersList.length">
      <Card v-for="offer in offersList" :key="offer.id" :offer="offer" />
    </section>

    <div class="flex justify-center my-6" v-if="offersList.length">
      <div>
        <PrimaryButton v-if="nextPageUrl" @click="loadMore" 
          :disabled="loading">
          <span v-if="loading">{{ $t('common.loading') }}...</span>
          <span v-else>{{ $t('common.load_more') }}</span>
        </PrimaryButton>
      </div>
    </div>
</template>

<script setup>
import { ref, useAttrs } from "vue";
import axios from "axios";
import Card from "@/Components/Offer/Card.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Heading2 from "@/Components/Text/Heading2.vue";
import { watch } from "vue";

const props = defineProps({
  offers: Object
});

const initialOffers = props.offers?.data || [];
const offersList = ref([...initialOffers]);
const nextPageUrl = ref(props.offers?.next_page_url || null);
const loading = ref(false);

watch(
  () => props.offers,
  (newOffers) => {
    offersList.value = [...(newOffers?.data || [])];
    nextPageUrl.value = newOffers?.next_page_url;
  },
  { immediate: true }
);

const loadMore = async () => {
  if (!nextPageUrl.value || loading.value) return;

  loading.value = true;

  try {
    const response = await axios.get(nextPageUrl.value);
    offersList.value.push(...response.data.data);
    nextPageUrl.value = response.data.next_page_url;
  } catch (error) {
    console.error("Error loading more offers");
  } finally {
    loading.value = false;
  }
};
</script>
