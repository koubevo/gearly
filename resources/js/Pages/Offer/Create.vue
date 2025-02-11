<template>
    <form @submit.prevent="create">
        <!-- TODO: pridat datove typy v-model.number atd -->
        <!-- TODO: move to components -->
        <div class="md:w-2/4 mx-auto">
            <Heading1 :text="'Add new offer'" class="mb-6 mt-6"/>
            <!-- TODO: photos -->
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <input type="text" placeholder="Name" name="name" v-model="form.name" class="bg-white border-b-2 border-black focus:outline-none px-4 py-2 focus:border-b-4 w-full focus:ring-0  focus:border-black" />
                    <div v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>
                <div class="col-span-12">
                    <textarea placeholder="Description" name="description" v-model="form.description" class="bg-white border-b-2 border-black outline-none px-4 py-2 focus:border-b-4 w-full focus:ring-0 focus:border-black"></textarea>
                    <div v-if="form.errors.description">{{ form.errors.description }}</div>
                </div>
                <div class="col-span-7 md:col-span-9">
                    <input type="number" placeholder="Price" v-model="form.price" name="price" class="bg-white border-b-2 border-black outline-none px-4 py-2 focus:border-b-4 w-full focus:ring-0 focus:border-black"/>
                    <div v-if="form.errors.price">{{ form.errors.price }}</div>
                </div>
                <div class="col-span-5 md:col-span-3">
                    <select name="currency" v-model="form.currency" class="bg-white border-b-2 border-black outline-none px-4 py-2 focus:border-b-4 w-full focus:border-black focus:ring-0">
                        <option value="czk" selected>CZK</option>
                        <option value="eur">EUR</option>
                    </select>
                    <div v-if="form.errors.currency">{{ form.errors.currency }}</div>
                </div>
                <div class="col-span-12 2xl:col-span-6 flex flex-col">
                    <h4 class="mb-2 md:mb-0">Sport</h4>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="1" v-model="form.sport" />
                            <div class="bg-white border border-b-2 border-black px-6 py-2 text-black font-medium text-center peer-checked:bg-primary-900 peer-checked:text-white uppercase">
                                ALL
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="2" v-model="form.sport" />
                            <div class="bg-white border border-b-2 border-black px-6 py-2 text-black font-medium text-center peer-checked:bg-primary-900 peer-checked:text-white uppercase">
                                BASEBALL
                            </div>
                        </label>
                        <label class="cursor-pointer w-full sm:flex-1">
                            <input type="radio" name="sport" class="hidden peer" value="3" v-model="form.sport" />
                            <div class="bg-white border border-b-2 border-black px-6 py-2 text-black font-medium text-center peer-checked:bg-primary-900 peer-checked:text-white uppercase">
                                SOFTBALL
                            </div>
                        </label>
                    </div>
                    <div v-if="form.errors.sport" class="text-red-600">{{ form.errors.sport }}</div>
                </div>
                <!-- TODO: add delivery method -->
                <div class="col-span-12 2xl:col-span-6 flex flex-col md:flex-row gap-4 justify-between 2-xl:justify-end">
                    <div class="w-full md:flex-1">
                        <h4 class="mb-2 md:mb-0">Condition</h4>
                        <select name="condition" v-model="form.condition" class="bg-white border-b-2 border-black outline-none px-4 py-2 focus:border-b-4 w-full focus:border-black focus:ring-0">
                            <option value="new" selected>NEW</option>
                            <option value="used">USED</option>
                            <option value="damaged">USED</option>
                        </select>
                        <div v-if="form.errors.condition">{{ form.errors.condition }}</div>
                    </div>
                    <div class="w-full md:flex-1">
                        <h4 class="mb-2 md:mb-0">Category</h4>
                        <select name="category" v-model="form.category_id" class="bg-white border-b-2 border-black outline-none px-4 py-2 focus:border-b-4 w-full focus:border-black focus:ring-0">
                            <option value="1" selected>Bats</option>
                            <option value="2">Gloves</option>
                        </select>
                        <div v-if="form.errors.category_id">{{ form.errors.category_id }}</div>
                    </div>
                    <div class="w-full md:flex-1">
                        <h4 class="mb-2 md:mb-0">Brand</h4>
                        <select name="brand" v-model="form.brand_id" class="bg-white border-b-2 border-black outline-none px-4 py-2 focus:border-b-4 w-full focus:border-black focus:ring-0">
                            <option value="1" selected>Nike</option>
                            <option value="2">Rawlings</option>
                        </select>
                        <div v-if="form.errors.brand_id">{{ form.errors.brand_id }}</div>
                    </div>
                </div>
                <!-- TODO: remove hidden user_id input -->
                <input type="hidden" name="user_id" value="1">
                <div class="col-span-12 text-end">
                    <input type="submit" value="Add offer" class="bg-primary-900 border-2 border-black border-solid px-6 py-2 text-white hover:border-b-4 font-medium w-full md:w-auto text-center" />
                </div>
            </div>
        </div>
    </form>
</template>

<script setup>
import Heading1 from '@/Components/Heading1.vue';
import { useForm } from '@inertiajs/vue3' 

const form = useForm({
    name: "",
    phone: "",
    description: "",
    price: null,
    currency: "czk",
    condition: "new",
    sport: 1,
    category_id: 1,
    brand_id: 1,
    user_id: 1
});

const create = () => form.post(route('offer.store'));
</script>
