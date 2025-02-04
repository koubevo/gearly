<template>
    <form @submit.prevent="update">
        <input type="text" placeholder="Name" name="name" v-model="form.name" />
        <div v-if="form.errors.name">{{ form.errors.name }}</div>
        <!-- TODO: pridat datove typy v-model.number atd -->
        <div>
            <label class="cursor-pointer">
                <input type="radio" name="phone" value="1" v-model="form.phone" />
                <span>yes</span>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="phone" value="0" v-model="form.phone" />
                <span>no</span>
            </label>
            <div v-if="form.errors.phone">{{ form.errors.phone }}</div>
        </div>

        <textarea placeholder="Description" name="description" v-model="form.description"></textarea>
        <div v-if="form.errors.description">{{ form.errors.description }}</div>

        <input type="number" placeholder="Price" v-model="form.price" name="price"/>
        <div v-if="form.errors.price">{{ form.errors.price }}</div>

        <select name="currency" v-model="form.currency">
            <option value="czk">CZK</option>
            <option value="eur">EUR</option>
        </select>
        <div v-if="form.errors.currency">{{ form.errors.currency }}</div>

        <select name="condition" v-model="form.condition">
            <option value="new">NEW</option>
            <option value="used">USED</option>
        </select>
        <div v-if="form.errors.condition">{{ form.errors.condition }}</div>

        <div>
            <label class="cursor-pointer">
                <input type="radio" name="sport" value="1" v-model="form.sport" />
                <span>all</span>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="sport" value="2" v-model="form.sport" />
                <span>baseball</span>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="sport" value="3" v-model="form.sport" />
                <span>softball</span>
            </label>
            <div v-if="form.errors.sport">{{ form.errors.sport }}</div>
        </div>

        <select name="category" v-model="form.category_id">
            <option value="1">Bats</option>
            <option value="2">Gloves</option>
        </select>
        <div v-if="form.errors.category_id">{{ form.errors.category_id }}</div>

        <select name="brand" v-model="form.brand_id">
            <option value="1">Nike</option>
            <option value="2">Rawlings</option>
        </select>
        <div v-if="form.errors.brand_id">{{ form.errors.brand_id }}</div>
        <input type="hidden" name="user_id" value="1">
        <input type="submit" value="Edit offer" />
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3' 

const props = defineProps({
    offer: Object,
})

const form = useForm({
    name: props.offer.name,
    phone: props.offer.phone,
    description: props.offer.description,
    price: props.offer.price,
    currency: props.offer.currency,
    condition: props.offer.condition,
    sport: props.offer.sport,
    category_id: props.offer.category_id,
    brand_id: props.offer.brand_id,
    user_id: 1 //TODO: edit user id & add more columns
});

const update = () => form.put(route('offer.update', {offer: props.offer.id}));
</script>
