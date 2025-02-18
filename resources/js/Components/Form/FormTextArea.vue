<template>
    <label :for="name" class="mb-2 md:mb-0">{{ labelName }} <span v-if="required" class="required-star-style">*</span></label>
    <textarea :name="name" :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" class="input-style" :required="required">
    </textarea>
    <div v-if="error" class="input-error-message-style">{{ error }}</div>
</template>

<script setup>
defineProps({
    name: String,
    labelName: String,
    modelValue: String,
    error: String,
    required: Boolean
})

defineEmits(["update:modelValue"]);
</script>
