<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { usePage } from '@inertiajs/vue3';
import Divider from '@/Components/Search/Divider.vue';
import UserOffers from '@/Components/User/UserOffers.vue';
import UserInfo from '@/Components/User/UserInfo.vue';
import NothingHere from '@/Components/NothingHere.vue';
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue';
import Modal from "@/Components/Modal.vue";
import { ref } from 'vue';
import NormalText from '@/Components/Text/NormalText.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    activeOffers: Array ?? [],
    soldOffers: Array ?? [],
    soldOffersCount: Number,
    rating: Object,
    receivedRatings: Array
});

const page = usePage();
const user = page.props.auth?.user;

const modal = ref(false);
const activeSection = ref('profile'); 

const openModal = () => {
    activeSection.value = 'profile';
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};
</script>

<template>
    <Head :title="'Your Profile'" />
    <div class="mb-4">
        <UserInfo :user="user" :soldOffersCount="soldOffersCount" :rating="rating" :receivedRatings="receivedRatings"/>
        <div class="w-fit">
            <SecondaryButton @click="openModal">Edit profile</SecondaryButton>
        </div>
        <Divider class="md:w-full mt-4"/>
        <UserOffers :offers="activeOffers" class="py-4" v-if="activeOffers.length" :heading="'Active offers'"/>
        <UserOffers :offers="soldOffers" class="py-4" v-if="soldOffers.length" :heading="'Sold offers'"/>
        <NothingHere v-if="!activeOffers.length && !soldOffers.length" :text="'User has no active or sold offers'">We found no offers</NothingHere>
    </div>

    <Modal :show="modal" @close="closeModal">
        <div class="p-6">
            <div class="flex gap-4 justify-between">
                <div class="flex gap-4">
                    <button 
                        @click="activeSection = 'profile'" 
                        :class="{'text-green-600 font-bold border-b-2 border-green-600': activeSection === 'profile'}"
                        class="pb-1">
                        <NormalText>Profile</NormalText>
                    </button>
                    <button 
                        @click="activeSection = 'password'" 
                        :class="{'text-green-600 font-bold border-b-2 border-green-600': activeSection === 'password'}"
                        class="pb-1">
                        <NormalText>Password</NormalText>
                    </button>
                    <button 
                        @click="activeSection = 'delete'" 
                        :class="{'text-green-600 font-bold border-b-2 border-green-600': activeSection === 'delete'}"
                        class="pb-1">
                        <NormalText>Delete Account</NormalText>
                    </button>
                </div>
                <button class="text-gray-500 hover:text-black" @click="closeModal">&times;</button>
            </div>

            <Divider class="md:w-full my-4"/>

            <div v-show="activeSection === 'profile'">
                <UpdateProfileInformationForm />
            </div>

            <div v-show="activeSection === 'password'">
                <UpdatePasswordForm />
            </div>

            <div v-show="activeSection === 'delete'">
                <DeleteUserForm />
            </div>
        </div>
    </Modal>
</template>
