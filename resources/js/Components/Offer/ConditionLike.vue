<template>
    <span
        class="flex items-center w-full"
        :class="detailView ? '' : 'justify-between'"
    >
        <div class="flex align-middle items-center">
            <Condition :condition="offer.condition" :type="'condition'" :conditionNumber="offer.conditionNumber" class="me-2" v-if="offer.statusNumber === 1"/>
            <Condition :condition="offer.status" :type="'status'" :conditionNumber="offer.statusNumber" class="me-2"/>
            <button 
                :disabled="user?.id === offer.user_id"
                @click.prevent="toggleFavorite" 
                type="button"
                :class="{'opacity-50 ': user?.id === offer.user_id}"
                v-if="offer.statusNumber === 1">
                <HeartIcon class="w-7 h-7" v-if="!isFavorited"/>
                <FullHeartIcon class="w-7 h-7 fill-primary-900" v-else/>
            </button>
            <NormalText v-if="favoritesCount > 0 && offer.statusNumber === 1" :text="favoritesCount" class="ms-1"/>
        </div>
        <div class="flex items-center" :class="detailView ? 'ms-2' : ''">
            <button @click.stop.prevent="openModal" type="button">
                <ArrowUpOnSquareIcon class="w-6 h-6 mb-0.5"/>
            </button>
        </div>
    </span>

    <Teleport to="body">
        <Modal :show="modal" @close="closeModal">
            <div class="p-6">
                <div class="flex justify-between items-end mb-2">
                  <Heading2>{{ $t('offer.share_offer') }}</Heading2>
                </div>
                <div>
                  <TinyText>
                    {{ $t('offer.share_description') }}
                  </TinyText>
                </div>
                <Divider class="md:w-full my-4"/>
                <div class="flex flex-wrap gap-2">
                    <SecondaryButton @click="share('facebook')" class="justify-center w-auto px-2">
                        <FbIcon class="w-5 h-5"/>
                    </SecondaryButton>
                    <SecondaryButton @click="share('twitter')" class="justify-center w-auto px-2">
                        <XIcon class="w-5 h-5"/>
                    </SecondaryButton>
                    <SecondaryButton @click="share('whatsapp')" class="justify-center w-auto px-2">
                        <WhatsAppIcon class="w-5 h-5"/>
                    </SecondaryButton>
                    <SecondaryButton @click="copyLink" class="justify-center w-auto px-2 inline-flex items-center gap-1">
                        <ClipboardDocumentIcon class="w-5 h-5" v-if="!isCopied"/>
                        <span v-if="!isCopied">{{ $t('offer.copy_link') }}</span>
                        <span v-else>{{ $t('offer.copied') }}</span>
                    </SecondaryButton>
                </div>
            </div>
        </Modal>
    </Teleport>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { HeartIcon as FullHeartIcon } from '@heroicons/vue/24/solid';
import { HeartIcon, ArrowUpOnSquareIcon, ClipboardDocumentIcon } from '@heroicons/vue/24/outline';
import Condition from '@/Components/Offer/Condition.vue';
import NormalText from '@/Components/Text/NormalText.vue';
import axios from 'axios';
import Modal from "@/Components/Modal.vue";
import Heading2 from "@/Components/Text/Heading2.vue";
import Divider from "@/Components/Search/Divider.vue";
import TinyText from '@/Components/Text/TinyText.vue';
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import FbIcon from '@/Components/Icons/FbIcon.vue';
import XIcon from '@/Components/Icons/XIcon.vue';
import WhatsAppIcon from '@/Components/Icons/WaIcon.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps({
    offer: Object,
    detailView: Boolean
});

const user = computed(() => usePage().props.auth.user);
const isAdmin = computed(() => user.value?.is_admin ?? false);
const isFavorited = ref(props.offer.favorited_by_user);
const favoritesCount = ref(props.offer.favorites_count);

watch(() => props.offer.favorited_by_user, (newVal) => {
    isFavorited.value = newVal;
});
watch(() => props.offer.favorites_count, (newVal) => {
    favoritesCount.value = newVal;
});

const toggleFavorite = async () => {
    if (!user.value) {
        return Inertia.visit(route('login'));
    }

    try {
        const response = await axios.post(route('wishlist.toggle', { id: props.offer.id }));

        if (response.data.status === 'added') {
            isFavorited.value = true;
            favoritesCount.value++;
        } else {
            isFavorited.value = false;
            favoritesCount.value--;
        }
    } catch (error) {
        console.error('err');
    }
};

const modal = ref(false);

const openModal = () => {
    modal.value = true;
};

const closeModal = () => {
    modal.value = false;
};

const share = (platform) => {
    const url = route('offer.show', { id: props.offer.id });
    let text = '';
    if (isAdmin.value) {
        text = 'New offer on Gearly: ' + props.offer.name + ' - ';
    } else {
        text = t('offer.found') + '! ';
    }
    
    let shareUrl = '';
    switch (platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
            break;
        case 'whatsapp':
            shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text + ' ' + url)}`;
            break;
    }
    window.open(shareUrl, '_blank');
};

const isCopied = ref(false);

const copyLink = () => {
    const url = route('offer.show', { id: props.offer.id });
    navigator.clipboard.writeText(url);
    isCopied.value = true;
    setTimeout(() => {
        isCopied.value = false;
    }, 1500);
};
</script>