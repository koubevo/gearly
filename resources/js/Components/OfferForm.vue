<template>
    <form @submit.prevent="handleSubmit">
        <!-- TODO: pridat datove typy v-model.number atd -->
        <!-- TODO: add size, add delivery option --> 
        <!-- TODO: add required to inputs -->
        <div class="md:w-2/4 mx-auto mb-3">
            <Heading1 :text="isEditMode ? 'Edit offer ' + form.name : 'Add new offer'" class="mb-6 mt-6"/>
            <!-- TODO: photos -->
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <input type="text" placeholder="Name" name="name" v-model="form.name" class="input-style" />
                    <div v-if="form.errors.name" class="input-error-message-style">{{ form.errors.name }}</div>
                </div>
                <div class="col-span-12">
                    <textarea placeholder="Description" name="description" v-model="form.description" class="input-style"></textarea>
                    <div v-if="form.errors.description" class="input-error-message-style">{{ form.errors.description }}</div>
                </div>
                <div class="col-span-7 md:col-span-9">
                    <input type="number" placeholder="Price" v-model.number="form.price" name="price" class="input-style" step="0.01"/>
                    <div v-if="form.errors.price" class="input-error-message-style">{{ form.errors.price }}</div>
                </div>
                <div class="col-span-5 md:col-span-3">
                    <select name="currency" v-model="form.currency" class="input-style">
                        <option value="czk" selected>CZK</option>
                        <option value="eur">EUR</option>
                    </select>
                    <div v-if="form.errors.currency" class="input-error-message-style">{{ form.errors.currency }}</div>
                </div>
                <div class="col-span-12 2xl:col-span-6 flex flex-col">
                    <h4 class="mb-2 md:mb-0">Sport</h4>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="1" v-model="form.sport" />
                            <div class="sport-selector-style">
                                BOTH
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="2" v-model="form.sport" />
                            <div class="sport-selector-style">
                                BASEBALL
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="3" v-model="form.sport" />
                            <div class="sport-selector-style">
                                SOFTBALL
                            </div>
                        </label>
                    </div>
                    <div v-if="form.errors.sport" class="input-error-message-style">{{ form.errors.sport }}</div>
                </div>
                <!-- TODO: add delivery method -->
                <div class="col-span-12 2xl:col-span-6 flex flex-col md:flex-row gap-2 justify-between 2-xl:justify-end">
                    <div class="w-full md:flex-1">
                        <h4 class="mb-2 md:mb-0">Condition</h4>
                        <select name="condition" v-model="form.condition" class="input-style">
                            <option value="new" selected>NEW</option>
                            <option value="used">USED</option>
                            <option value="damaged">USED</option>
                        </select>
                        <div v-if="form.errors.condition" class="input-error-message-style">{{ form.errors.condition }}</div>
                    </div>
                    <div class="w-full md:flex-1">
                        <h4 class="mb-2 md:mb-0">Category</h4>
                        <select name="category" v-model="form.category_id" class="input-style">
                            <option value="1" selected>Bats</option>
                            <option value="2">Gloves</option>
                        </select>
                        <div v-if="form.errors.category_id" class="input-error-message-style">{{ form.errors.category_id }}</div>
                    </div>
                    <div class="w-full md:flex-1">
                        <h4 class="mb-2 md:mb-0">Brand</h4>
                        <select name="brand" v-model="form.brand_id" class="input-style">
                            <option value="1" selected>Nike</option>
                            <option value="2">Rawlings</option>
                        </select>
                        <div v-if="form.errors.brand_id" class="input-error-message-style">{{ form.errors.brand_id }}</div>
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
import Heading1 from '@/Components/Heading1.vue';
import { useForm } from '@inertiajs/vue3' 
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    offer: {
        type: Object,
        default: () => ({
            name: "",
            phone: "",
            description: "",
            price: null,
            currency: "czk",
            condition: "new",
            sport: 1,
            category_id: 1,
            brand_id: 1
        })
    },
    isEditMode: {
        type: Boolean,
        default: false
    }
});

const form = useForm({
    name: props.offer.name,
    phone: props.offer.phone,
    description: props.offer.description,
    price: props.offer.price,
    currency: props.offer.currency,
    condition: props.offer.condition,
    sport: props.offer.sport,
    category_id: props.offer.category_id,
    brand_id: props.offer.brand_id
});

const handleSubmit = () => {
    if (props.isEditMode) {
        form.put(route('offer.update', {offer: props.offer.id}));
    } else {
        form.post(route('offer.store'));
    }
};
</script>