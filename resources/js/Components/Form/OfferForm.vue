<template>
    <form @submit.prevent="handleSubmit">
        <div class="max-w-5xl mx-auto mb-3">
            <Heading1 class="mb-4" v-html="isEditMode ? $t('offer.edit_offer') + ' <span class=\'text-primary-900\'>' + form.name + '</span>' : $t('offer.add_new_offer')"/>
            <div v-if="freeLimitExceeded && !isEditMode" class="bg-red-600 p-3 mb-4">
                <BoldNormalText class="text-white">{{ $t('offer.limit_message', {limit: limit}) }}</BoldNormalText>
            </div>
            <div class="grid grid-cols-12 gap-y-4 gap-x-2">
                <div class="col-span-12" v-if="!isEditMode">
                    <ImageUploader @update:modelValue="updateImages"/>
                    <div v-if="form.errors.images" class="input-error-message-style">{{ form.errors.images }}</div>
                    <div v-if="imageErrors.length" class="input-error-message-style">
                        <ul>
                            <li v-for="(error, index) in imageErrors" :key="index">{{ error }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-span-12">
                    <FormInput name="name" :labelName="$t('common.name')" type="text" v-model="form.name" :error="form.errors.name" :required="true" />
                </div>
                <div class="col-span-12">
                    <FormTextArea name="description" :labelName="$t('common.description')" v-model="form.description" :error="form.errors.description" :required="true" />
                </div>
                <div class="col-span-7 md:col-span-9">
                    <FormInput name="price" :labelName="$t('common.price')" type="number" v-model="form.price" :error="form.errors.price" :required="true" />
                </div>
                <div class="col-span-5 md:col-span-3">
                    <FormSelect :options="[{'id': 'czk', 'name': 'CZK'}, {'id': 'eur', 'name': 'EUR'}]" v-model="form.currency" :labelName="$t('common.currency')" name="currency" :required="true" :error="form.errors.currency"/>
                </div>
                <div class="md:col-span-5 col-span-12">
                    <FormSelect :options="deliveryOptions" v-model="form.delivery_option_id" :labelName="$t('offer.delivery_option')" name="delivery_option_id" :required="true" :error="form.errors.delivery_option_id"/>
                </div>
                <div class="md:col-span-7 col-span-12">
                    <FormInput name="delivery_detail" labelName="Delivery Detail" type="text" v-model="form.delivery_detail" :error="form.errors.delivery_detail" :required="false" />
                </div>
                <div class="col-span-12 flex flex-col">
                    <label class="mb-2 md:mb-0 capitalize">Sport</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport_id" class="hidden peer" value="1" v-model="form.sport_id" />
                            <div class="sport-selector-style uppercase">
                                {{ $t('common.both') }}
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport_id" class="hidden peer" value="2" v-model="form.sport_id" />
                            <div class="sport-selector-style uppercase">
                                BASEBALL
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport_id" class="hidden peer" value="3" v-model="form.sport_id" />
                            <div class="sport-selector-style uppercase">
                                SOFTBALL
                            </div>
                        </label>
                    </div>
                    <div v-if="form.errors.sport_id" class="input-error-message-style">{{ form.errors.sport_id }}</div>
                </div>
                <div class="col-span-12 flex flex-col md:flex-row gap-2 justify-between">
                    <div class="w-full">
                        <FormSelect :options="brands" v-model="form.brand_id" :labelName="$t('common.brand')" name="brand" :required="true" :error="form.errors.brand_id"/>
                    </div>
                    <div class="w-full">
                        <FormSelect :options="[{'id': '1', 'name': $t('offer.new')}, {'id': '2', 'name': $t('offer.used')}, {'id': '3', 'name': $t('offer.damaged')}]" v-model="form.condition" :labelName="$t('common.condition')" name="condition" :required="true" :error="form.errors.condition"/>
                    </div>
                    <div class="w-full" v-if="!isEditMode">
                        <FormSelect :options="categories" v-model="form.category_id" :labelName="$t('common.category')" name="category" :required="true" :error="form.errors.category_id"/>
                    </div>
                </div>
                <div class="col-span-12" v-if="!isEditMode && filteredFilterCategories.length">
                    <FiltersNote/>
                </div>
                <div class="col-span-12 flex flex-col md:flex-row gap-2 justify-between" v-if="!isEditMode">
                    <div class="w-full" v-for="filterCategory in filteredFilterCategories" :key="filterCategory.id">
                        <FormSelect :options="filterCategory.options" v-model="form[`fc${filterCategory.id}`]" :labelName="filterCategory[lang]" :name="'fc' + filterCategory.id" :required="false"/>
                    </div>
                </div>
                <div class="col-span-12">
                    <RequiredFieldsNote/>
                </div>
                <div class="col-span-12">
                    <PrimaryButton 
                        type="submit" 
                        :text="isEditMode ? $t('offer.edit_offer') :  $t('offer.add_offer')" 
                        class="md:w-auto capitalize" 
                        :disabled="freeLimitExceeded && !isEditMode" 
                        :class="{'bg-gray-400 border-gray-500': freeLimitExceeded && !isEditMode}" 
                    />
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import Heading1 from '@/Components/Text/Heading1.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';
import FormInput from '@/Components/Form/FormInput.vue';
import RequiredFieldsNote from '@/Components/Form/RequiredFieldsNote.vue';
import FormTextArea from '@/Components/Form/FormTextArea.vue';
import FiltersNote from '@/Components/Form/FiltersNote.vue';
import FormSelect from '@/Components/Form/FormSelect.vue';
import ImageUploader from '@/Components/Form/ImageUploader.vue';
import { computed } from 'vue';
import BoldNormalText from '@/Components/Text/BoldNormalText.vue';

const imageErrors = computed(() =>
    Object.keys(form.errors)
        .filter(key => key.startsWith("images."))
        .map(key => form.errors[key])
);


const props = defineProps({
    offer: {
        type: Object,
        default: () => ({
            name: "",
            description: "",
            price: null,
            currency: "czk",
            condition: null,
            sport_id: 1,
            category_id: 14,
            brand_id: 49,
            delivery_option_id: 1,
            delivery_detail: "",
        })
    },
    isEditMode: {
        type: Boolean,
        default: false
    },
    brands: {
        type: Array
    },
    categories: {
        type: Array
    },
    deliveryOptions: {
        type: Array
    },
    filterCategories: {
        type: Array
    },
    freeLimitExceeded: {
        type: Boolean
    },
    limit: {
        type: Number
    },
    lang: String ?? 'name'
});

const form = useForm({
    name: props.offer.name,
    description: props.offer.description,
    price: props.offer.price,
    currency: props.offer.currency,
    condition: props.offer.condition,
    sport_id: props.offer.sport_id,
    category_id: props.offer.category_id,
    brand_id: props.offer.brand_id,
    delivery_option_id: props.offer.delivery_option_id,
    delivery_detail: props.offer.delivery_detail,
    images: [],
});

const updateImages = (images) => {
    form.images = images;
};

const handleSubmit = () => {
    let dataToSend = new FormData();
    Object.keys(form).forEach(key => {
        if (key === 'images') {
            form.images.forEach((image, index) => {
                dataToSend.append(`images[${index}]`, image);
            });
        } else {
            dataToSend.append(key, form[key]);
        }
    });

    if (props.isEditMode) {
        dataToSend.append('_method', 'PUT');
        form.transform(() => dataToSend).post(route('offer.update', { offer: props.offer }), {
            preserveScroll: true,
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    } else {
        filteredFilterCategories.value.forEach(filter => {
            const key = `fc${filter.id}`;
            if (form[key]) {
            dataToSend.append(key, form[key]);
            }
        });

        form.transform(() => dataToSend).post(route('offer.store'), {
            preserveScroll: true,
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    }
};

const filteredFilterCategories = ref([]);

const fetchFilterOptions = async (categoryId) => {
    try {
        const selectedCategory = props.categories.find(cat => cat.id === categoryId);
        if (selectedCategory) {
            const responses = await Promise.all(
                selectedCategory.filters.map(filter => axios.get(`/api/filters/${filter.id}`))
            );
            filteredFilterCategories.value = selectedCategory.filters.map((filter, index) => ({
                ...filter,
                options: responses[index].data
            }));
        }
    } catch (error) {
        console.error("Chyba při načítání filtrů:", error);
    }
};

watch(
    () => form.category_id,
    async (newCategoryId, oldCategoryId) => {
        if (newCategoryId !== oldCategoryId) {
            await fetchFilterOptions(newCategoryId);
        }
    },
    { deep: true }
);

watch(filteredFilterCategories, (newFilters) => {
    newFilters.forEach(filter => {
        const key = `fc${filter.id}`;
        if (!(key in form)) {
            delete form[key];
        }
    });
}, { deep: true });

onMounted(async () => {
    await fetchFilterOptions(form.category_id);
});
</script>