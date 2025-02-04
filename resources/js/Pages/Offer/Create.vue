<template>
    <form @submit.prevent="create">
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
            <option value="CZK">CZK</option>
            <option value="EUR">EUR</option>
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

        <input type="submit" value="Add offer" />
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3' 

const form = useForm({
    name: "",
    phone: "",
    description: "",
    price: null,
    currency: "CZK",
    condition: "new",
    sport: "",
    category_id: null,
    brand_id: null,
    user_id: 1
});

const create = () => form.post('/offer');
</script>
