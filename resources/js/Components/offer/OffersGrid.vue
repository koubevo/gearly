<template>
  <div>
    <section class="grid grid-cols-1 md:grid-cols-2 items-center">
      <div>
        <!-- TODO: most expensive, cheapest, most recent, name of category/name of brand/offers -->
        <Heading1>Offers</Heading1>
      </div>
      <div class="flex justify-end my-6">
        <div>
          <SortingButton @click="openSortingModal">
          </SortingButton>

          <SortingModal :show="openSortingModal" @close="closeModal">
              <div class="p-6">
                  <!-- TODO: component -->
                  <h2
                      class="text-lg font-medium text-gray-900"
                  >
                      Are you sure you want to delete your account?
                  </h2>

                  <!-- TODO: text, transaltion -->
                  <TinyText :text="'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'"/>

                  <div class="mt-6">
                      <div class="mt-4">
                          <input type="password" placeholder="Password" name="password" v-model="form.password" class="input-style" required />
                          <div v-if="form.errors.password" class="input-error-message-style">{{ form.errors.password }}</div>
                      </div>
                  </div>
                  <!-- TODO: 1st attempt wrong password, 2nd correct -> deletes -> user dont see (still logged in, kinda) -->
                  <div class="mt-6 flex justify-end">
                      <SecondaryButton @click="closeModal">
                          Cancel
                      </SecondaryButton>

                      <DangerButton
                          class="ms-3"
                          :class="{ 'opacity-25': form.processing }"
                          :disabled="form.processing"
                          @click="deleteUser"
                      >
                          Delete Account
                      </DangerButton>
                  </div>
              </div>
          </SortingModal>
        </div>
      </div>
    </section>
    
    <Divider class="md:w-full mb-4"/>
    <section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
      <Card v-for="offer in offersList" :key="offer.id" :offer="offer" />
    </section>

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
import Divider from "@/Components/Search/Divider.vue";
import Heading1 from "@/Components/Text/Heading1.vue";
import SortingButton from "@/Components/Buttons/SortingButton.vue";
import SortingModal from "@/Components/Offer/SortingModal.vue";

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