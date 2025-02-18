<template>
    <form @submit.prevent="handleSubmit">
        <!-- TODO: pridat datove typy v-model.number atd -->
        <!-- TODO: add size, --> 
        <!-- TODO: add required to inputs -->
        <div class="md:w-2/4 mx-auto mb-3">
            <Heading1 class="mb-6 mt-6" v-html="isEditMode ? 'Edit offer <span class=\'text-primary-900\'>' + form.name + '</span>' : 'Add new offer'"></Heading1>
            <!-- TODO: photos -->
            <div class="grid grid-cols-12 gap-y-4 gap-x-2">
                <div class="col-span-12">
                    <h4 class="mb-2 md:mb-0">Name</h4>
                    <input type="text" name="name" v-model="form.name" class="input-style" />
                    <div v-if="form.errors.name" class="input-error-message-style">{{ form.errors.name }}</div>
                </div>
                <div class="col-span-12">
                    <h4 class="mb-2 md:mb-0">Description</h4>
                    <textarea name="description" v-model="form.description" class="input-style"></textarea>
                    <div v-if="form.errors.description" class="input-error-message-style">{{ form.errors.description }}</div>
                </div>
                <div class="col-span-7 md:col-span-9">
                    <h4 class="mb-2 md:mb-0">Price</h4>
                    <input type="number" v-model.number="form.price" name="price" class="input-style" step="0.01"/>
                    <div v-if="form.errors.price" class="input-error-message-style">{{ form.errors.price }}</div>
                </div>
                <div class="col-span-5 md:col-span-3">
                    <h4 class="mb-2 md:mb-0">Currency</h4>
                    <select name="currency" v-model="form.currency" class="input-style">
                        <option value="czk" selected>CZK</option>
                        <option value="eur">EUR</option>
                    </select>
                    <div v-if="form.errors.currency" class="input-error-message-style">{{ form.errors.currency }}</div>
                </div>
                <div class="md:col-span-5 col-span-12">
                    <h4 class="mb-2 md:mb-0">Delivery Option</h4>
                        <select name="delivery_option" v-model="form.delivery_option_id" class="input-style">
                            <option v-for="deliveryOption in deliveryOptions" :key="deliveryOption.id" :value="deliveryOption.id">
                                {{ deliveryOption.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.delivery_option_id" class="input-error-message-style">{{ form.errors.delivery_option_id }}</div>
                </div>
                <div class="md:col-span-7 col-span-12">
                    <h4 class="mb-2 md:mb-0">Delivery Detail</h4>
                    <input type="text" name="delivery_detail" v-model="form.delivery_detail" class="input-style" />
                    <div v-if="form.errors.delivery_detail" class="input-error-message-style">{{ form.errors.delivery_detail }}</div>
                </div>
                <div class="col-span-12 flex flex-col">
                    <h4 class="mb-2 md:mb-0">Sport</h4>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport_id" class="hidden peer" value="1" v-model.number="form.sport_id" />
                            <div class="sport-selector-style">
                                BOTH
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport_id" class="hidden peer" value="2" v-model.number="form.sport_id" />
                            <div class="sport-selector-style">
                                BASEBALL
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport_id" class="hidden peer" value="3" v-model.number="form.sport_id" />
                            <div class="sport-selector-style">
                                SOFTBALL
                            </div>
                        </label>
                    </div>
                    <div v-if="form.errors.sport_id" class="input-error-message-style">{{ form.errors.sport_id }}</div>
                </div>
                <div class="col-span-12 flex flex-col md:flex-row gap-2 justify-between">
                    <div class="w-full">
                        <h4 class="mb-2 md:mb-0">Brand</h4>
                        <select name="brand" v-model="form.brand_id" class="input-style">
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.brand_id" class="input-error-message-style">{{ form.errors.brand_id }}</div>
                    </div>
                    <div class="w-full">
                        <h4 class="mb-2 md:mb-0">Condition</h4>
                        <select name="condition" v-model="form.condition" class="input-style">
                            <option value="new" selected>NEW</option>
                            <option value="used">USED</option>
                            <option value="damaged">DAMAGED</option>
                        </select>
                        <div v-if="form.errors.condition" class="input-error-message-style">{{ form.errors.condition }}</div>
                    </div>
                    <!-- TODO: sort by name -->
                    <div class="w-full" v-if="!isEditMode">
                        <h4 class="mb-2 md:mb-0">Category</h4>
                        <select name="category" v-model="form.category_id" class="input-style">
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.category_id" class="input-error-message-style">{{ form.errors.category_id }}</div>
                    </div>
                </div>
                <div class="col-span-12 flex flex-col md:flex-row gap-2 justify-between" v-if="!isEditMode">
                    <div class="w-full" v-for="filterCategory in filteredFilterCategories" :key="filterCategory.id">
                        <h4 class="mb-2 md:mb-0">{{ filterCategory.name }}</h4>
                        <select :name="'fc' + filterCategory.id" 
                                v-model="form[`fc${filterCategory.id}`]" 
                                class="input-style">
                            <option value="" disabled selected>Choose filter</option>
                            <option v-for="option in filterCategory.options" 
                                    :key="option.id" 
                                    :value="option.id">
                                {{ option.name }}
                            </option>
                        </select>

                        <div v-if="form.errors.category_id" class="input-error-message-style">{{ form.errors.category_id }}</div>
                    </div>
                </div>
                <div class="col-span-12 text-end">
                    <PrimaryButton type="submit" :text="isEditMode ? 'Edit offer' : 'Add offer'" class="md:w-auto" />
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

const props = defineProps({
    offer: {
        type: Object,
        default: () => ({
            name: "",
            description: "",
            price: null,
            currency: "czk",
            condition: "new",
            sport_id: 1,
            category_id: 12,
            brand_id: 48,
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
    }
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
});

const handleSubmit = () => {
    let dataToSend = { ...form.data() }; 

    if (props.isEditMode) {
        form.transform(() => dataToSend).put(route('offer.update', {offer: props.offer.id}), {
            preserveScroll: true,
            headers: {
                "Content-Type": "application/json"
            }
        });
    }
    else {
            filteredFilterCategories.value.forEach(filter => {
            const key = `fc${filter.id}`;
            dataToSend[key] = form[key] || null;
        });

        form.transform(() => dataToSend).post(route('offer.store'), {
            preserveScroll: true,
            headers: {
                "Content-Type": "application/json"
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
                selectedCategory.filters.map(filter => axios.get(`http://127.0.0.1:8000/api/filters/${filter.id}`))
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
            form[key] = null;
        }
    });
}, { deep: true });


onMounted(async () => {
    await fetchFilterOptions(form.category_id);
});
</script>