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
import { watch, onMounted } from 'vue';

const props = defineProps({
    name: String,
    labelName: String,
    modelValue: [Number, String, Object],
    error: String,
    required: Boolean,
    options: Array,
    default: Boolean ?? true,
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (value) => {
    emit("update:modelValue", value);
};

watch(() => props.options, (newOptions) => {
    if (props.default && newOptions?.length > 0 && !props.modelValue) {
        emit("update:modelValue", newOptions[0].id); 
    }
}, { immediate: true });

onMounted(() => {
    if (props.default && props.options.length > 0 && !props.modelValue) {
        emit("update:modelValue", props.options[0].id);
    }
});
</script>
