<template>
  <div class="p-4 md:p-0">
    <file-pond
      name="images"
      ref="pond"
      :label-idle="'📂 ' + $t('offer.drop_images')"
      allow-multiple="true"
      allow-reorder="true"
      max-files="10"
      accepted-file-types="image/jpeg, image/png, image/webp"
      max-file-size="3MB"
      image-resize-target-width="1024"
      image-resize-target-height="1024"
      image-resize-mode="contain"
      @updatefiles="handleFileUpdate"
      @reorderfiles="handleFileUpdate"
    />
  </div>
</template>

<script>
import { ref, defineEmits } from "vue";
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

export default {
  name: "ImageUploader",
  components: { FilePond },
  setup(_, { emit }) {
    const files = ref([]);

    const handleFileUpdate = (fileItems) => {
      files.value = fileItems.map((fileItem) => fileItem.file);
      emit("update:modelValue", files.value);
    };

    return { handleFileUpdate, files };
  }
};
</script>
