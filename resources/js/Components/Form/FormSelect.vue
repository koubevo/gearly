<template>
    <label :for="name" class="mb-2 md:mb-0 capitalize">{{ labelName }} <span v-if="required" class="required-star-style">*</span></label>
    <v-select
        :options="options"
        :modelValue="modelValue"
        :name="name"
        label="name"
        append-to-body
        :required="required"
        :reduce="option => option.id" 
        @update:modelValue="updateValue"
    />
    <div v-if="error" class="input-error-message-style">{{ error }}</div>
</template>

<script setup>
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

const props = defineProps({
    name: String,
    labelName: String,
    modelValue: [String, Object],
    error: String,
    required: Boolean,
    options: Array
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (value) => {
    emit("update:modelValue", value);
};
</script>
