<template>
  <div>
    <section class="grid grid-cols-2 items-center my-6">
      <div>
        <Heading1>{{ $t('common.offers') }}</Heading1>
      </div>
      <div class="flex justify-end">
        <div class="flex gap-2">
          <FiltersButton @click="openFiltersModal" />
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
          <span v-if="loading">{{ $t('common.loading') }}...</span>
          <span v-else>{{ $t('common.load_more') }}</span>
        </PrimaryButton>
      </div>
    </div>
  </div>
  <div v-if="!offersList.length">
    <NothingHere :text="$t('common.try_searching_for_something_else')">{{ $t('common.we_found_no_offers') }}</NothingHere>
  </div>
  <Modal :show="modal" @close="closeModal">
      <div class="p-6">
          <div class="flex justify-between items-end">
            <Heading2>{{ $t('offer.sort_offers') }}</Heading2>
            <button class="text-gray-500 hover:text-black" @click="closeModal">&times;</button>
          </div>
          <Divider class="md:w-full my-4"/>
          <div class="flex flex-col md:flex-row gap-2">
             <SecondaryLink :href="route('offer.index', { brand: filters?.brand, category: filters?.category, sport: filters?.sport, search: filters?.search})">{{ $t('offer.most_recent') }}</SecondaryLink>
             <SecondaryLink :href="route('offer.index', {order: 0, brand: filters?.brand, category: filters?.category, sport: filters?.sport, search: filters?.search})">{{ $t('offer.cheapest') }}</SecondaryLink>
             <SecondaryLink :href="route('offer.index', {order: 1, brand: filters?.brand, category: filters?.category, sport: filters?.sport, search: filters?.search})">{{ $t('offer.most_expensive') }}</SecondaryLink>
          </div>
      </div>
  </Modal>
  <Modal :show="filtersModal" @close="closeFiltersModal">
      <div class="p-6">
          <Filters :brands :categories :sports :conditions :filters />
      </div>
  </Modal>
</template>

<script setup>
import { ref, useAttrs } from "vue";
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
import FiltersButton from "@/Components/Buttons/FiltersButton.vue";
import Filters from "@/Components/Offer/Filters.vue";

const attrs = useAttrs(); 
const initialOffers = usePage().props.offers?.data || [];
const offersList = ref([...initialOffers]);
const nextPageUrl = ref(usePage().props.offers?.next_page_url || null);
const loading = ref(false);

defineProps({
  categories: Array,
  brands: Array,
  sports: Array,
  conditions: Array,
  filters: Array
});

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

const modal = ref(false);

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};

const filtersModal = ref(false);

const openFiltersModal = () => {
    filtersModal.value = true;
};

const closeFiltersModal = () => {
    filtersModal.value = false;
};
</script>
