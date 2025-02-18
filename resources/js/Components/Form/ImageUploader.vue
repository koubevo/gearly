<template>
  <div>
    <file-pond
      name="images"
      ref="pond"
      label-idle="📂 Drop images here..."
      allow-multiple="true"
      allow-reorder="true"
      max-files="10"
      accepted-file-types="image/jpeg, image/png, image/webp"
      v-model="files"
      max-file-size="5MB"
      image-resize-target-width="1024"
      image-resize-target-height="1024"
      image-resize-mode="contain"
    />
  </div>
</template>

<script>
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

export default {
  name: "ImageUploader",
  data() {
    return {
      files: [],
    };
  },
  components: {
    FilePond,
  },
};
</script>
