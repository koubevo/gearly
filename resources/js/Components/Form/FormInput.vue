<template>
    <label :for="name" class="mb-2 md:mb-0 capitalize">{{ labelName }} <span v-if="required" class="required-star-style">*</span></label>
    <input :type="type" :name="name" :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        :step="inputStep"
        :required="required"
        class="input-style" />
    <div v-if="error" class="input-error-message-style">{{ error }}</div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: String,
    labelName: String,
    type: String,
    modelValue: String,
    error: String,
    required: Boolean
});

defineEmits(["update:modelValue"]);

const inputStep = computed(() => props.type === 'number' ? '0.01' : null);
</script>
