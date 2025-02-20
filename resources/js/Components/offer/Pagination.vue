<template>
    <div class="flex justify-center mt-14 mb-8 w-60 mx-auto gap-2">
        <!-- TODO: add disabled state when empty -->
        <SecondaryLink :href="previous" class="page-link" aria-label="Previous">
             <span aria-hidden="true">&laquo;</span>
        </SecondaryLink>
         <!-- TODO: 3 pages -->
          
         <!-- TODO: add disabled state when empty -->
         <SecondaryLink :href="next" class="page-link" aria-label="Next">
             <span aria-hidden="true">&raquo;</span>
         </SecondaryLink>
    </div>
</template>

<script setup>
import SecondaryLink from '@/Components/Buttons/SecondaryLink.vue';
defineProps({
    links: Array,
    previous: String,
    next: String
});
</script>