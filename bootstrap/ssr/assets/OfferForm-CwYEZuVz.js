import { useSSRContext, withCtx, createTextVNode, createVNode, unref, ref, resolveComponent, computed, watch, onMounted } from "vue";
import { ssrRenderAttr, ssrInterpolate, ssrIncludeBooleanAttr, ssrRenderComponent, ssrRenderAttrs, ssrRenderList, ssrLooseEqual } from "vue/server-renderer";
import { _ as _sfc_main$6 } from "./Heading1-B5GMPk_G.js";
import { useForm } from "@inertiajs/vue3";
import { _ as _sfc_main$9 } from "./PrimaryButton-DRqOrSj4.js";
import axios from "axios";
import { _ as _sfc_main$7, a as _sfc_main$8 } from "./RequiredFieldsNote-C7WE28xO.js";
import { _ as _sfc_main$5 } from "./SmallText-bh_SH4m8.js";
import vSelect from "vue-select";
/* empty css                    */
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import { _ as _export_sfc } from "./_plugin-vue_export-helper-1tPrXgE0.js";
const _sfc_main$4 = {
  __name: "FormTextArea",
  __ssrInlineRender: true,
  props: {
    name: String,
    labelName: String,
    modelValue: String,
    error: String,
    required: Boolean
  },
  emits: ["update:modelValue"],
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><label${ssrRenderAttr("for", __props.name)} class="mb-2 md:mb-0">${ssrInterpolate(__props.labelName)} `);
      if (__props.required) {
        _push(`<span class="required-star-style">*</span>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</label><textarea${ssrRenderAttr("name", __props.name)} class="input-style"${ssrIncludeBooleanAttr(__props.required) ? " required" : ""}>${ssrInterpolate(__props.modelValue)}</textarea>`);
      if (__props.error) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(__props.error)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/FormTextArea.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const _sfc_main$3 = {
  __name: "FiltersNote",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$5, _attrs, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`Filters are optional, but using them can help your items get noticed faster and improve your chances of selling. Plus, they make it easier for buyers to find exactly what they’re looking for. If a specific filter is missing, feel free to include any extra details in the description. <span class="font-bold"${_scopeId}>Filters are available only for certain categories of products.</span>`);
          } else {
            return [
              createTextVNode("Filters are optional, but using them can help your items get noticed faster and improve your chances of selling. Plus, they make it easier for buyers to find exactly what they’re looking for. If a specific filter is missing, feel free to include any extra details in the description. "),
              createVNode("span", { class: "font-bold" }, "Filters are available only for certain categories of products.")
            ];
          }
        }),
        _: 1
      }, _parent));
    };
  }
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/FiltersNote.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = {
  __name: "FormSelect",
  __ssrInlineRender: true,
  props: {
    name: String,
    labelName: String,
    modelValue: [String, Object],
    error: String,
    required: Boolean,
    options: Array
  },
  emits: ["update:modelValue"],
  setup(__props, { emit: __emit }) {
    const emit = __emit;
    const updateValue = (value) => {
      emit("update:modelValue", value);
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><label${ssrRenderAttr("for", __props.name)} class="mb-2 md:mb-0">${ssrInterpolate(__props.labelName)} `);
      if (__props.required) {
        _push(`<span class="required-star-style">*</span>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</label>`);
      _push(ssrRenderComponent(unref(vSelect), {
        options: __props.options,
        modelValue: __props.modelValue,
        name: __props.name,
        label: "name",
        "append-to-body": "",
        required: __props.required,
        reduce: (option) => option.id,
        "onUpdate:modelValue": updateValue
      }, null, _parent));
      if (__props.error) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(__props.error)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/FormSelect.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);
const _sfc_main$1 = {
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
function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  const _component_file_pond = resolveComponent("file-pond");
  _push(`<div${ssrRenderAttrs(_attrs)}>`);
  _push(ssrRenderComponent(_component_file_pond, {
    name: "images",
    ref: "pond",
    "label-idle": "📂 Drop images here...",
    "allow-multiple": "true",
    "allow-reorder": "true",
    "max-files": "10",
    "accepted-file-types": "image/jpeg, image/png, image/webp",
    "max-file-size": "5MB",
    "image-resize-target-width": "1024",
    "image-resize-target-height": "1024",
    "image-resize-mode": "contain",
    onUpdatefiles: $setup.handleFileUpdate
  }, null, _parent));
  _push(`</div>`);
}
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/ImageUploader.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const ImageUploader = /* @__PURE__ */ _export_sfc(_sfc_main$1, [["ssrRender", _sfc_ssrRender]]);
const _sfc_main = {
  __name: "OfferForm",
  __ssrInlineRender: true,
  props: {
    offer: {
      type: Object,
      default: () => ({
        name: "",
        description: "",
        price: null,
        currency: "czk",
        condition: "new",
        sport_id: 1,
        category_id: 14,
        brand_id: 49,
        delivery_option_id: 1,
        delivery_detail: ""
      })
    },
    isEditMode: {
      type: Boolean,
      default: false
    },
    brands: {
      type: Array
    },
    categories: {
      type: Array
    },
    deliveryOptions: {
      type: Array
    },
    filterCategories: {
      type: Array
    }
  },
  setup(__props) {
    const imageErrors = computed(
      () => Object.keys(form.errors).filter((key) => key.startsWith("images.")).map((key) => form.errors[key])
    );
    const props = __props;
    const form = useForm({
      name: props.offer.name,
      description: props.offer.description,
      price: props.offer.price,
      currency: props.offer.currency,
      condition: props.offer.condition,
      sport_id: props.offer.sport_id,
      category_id: props.offer.category_id,
      brand_id: props.offer.brand_id,
      delivery_option_id: props.offer.delivery_option_id,
      delivery_detail: props.offer.delivery_detail,
      images: []
    });
    const updateImages = (images) => {
      form.images = images;
    };
    const filteredFilterCategories = ref([]);
    const fetchFilterOptions = async (categoryId) => {
      try {
        const selectedCategory = props.categories.find((cat) => cat.id === categoryId);
        if (selectedCategory) {
          const responses = await Promise.all(
            selectedCategory.filters.map((filter) => axios.get(`/api/filters/${filter.id}`))
          );
          filteredFilterCategories.value = selectedCategory.filters.map((filter, index) => ({
            ...filter,
            options: responses[index].data
          }));
        }
      } catch (error) {
        console.error("Chyba při načítání filtrů:", error);
      }
    };
    watch(
      () => form.category_id,
      async (newCategoryId, oldCategoryId) => {
        if (newCategoryId !== oldCategoryId) {
          await fetchFilterOptions(newCategoryId);
        }
      },
      { deep: true }
    );
    watch(filteredFilterCategories, (newFilters) => {
      newFilters.forEach((filter) => {
        const key = `fc${filter.id}`;
        if (!(key in form)) {
          delete form[key];
        }
      });
    }, { deep: true });
    onMounted(async () => {
      await fetchFilterOptions(form.category_id);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<form${ssrRenderAttrs(_attrs)}><div class="md:w-2/4 mx-auto mb-3">`);
      _push(ssrRenderComponent(_sfc_main$6, { class: "mb-6 mt-6" }, null, _parent));
      _push(`<div class="grid grid-cols-12 gap-y-4 gap-x-2">`);
      if (!__props.isEditMode) {
        _push(`<div class="col-span-12">`);
        _push(ssrRenderComponent(ImageUploader, { "onUpdate:modelValue": updateImages }, null, _parent));
        if (unref(form).errors.images) {
          _push(`<div class="input-error-message-style">${ssrInterpolate(unref(form).errors.images)}</div>`);
        } else {
          _push(`<!---->`);
        }
        if (imageErrors.value.length) {
          _push(`<div class="input-error-message-style"><ul><!--[-->`);
          ssrRenderList(imageErrors.value, (error, index) => {
            _push(`<li>${ssrInterpolate(error)}</li>`);
          });
          _push(`<!--]--></ul></div>`);
        } else {
          _push(`<!---->`);
        }
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="col-span-12">`);
      _push(ssrRenderComponent(_sfc_main$7, {
        name: "name",
        labelName: "Name",
        type: "text",
        modelValue: unref(form).name,
        "onUpdate:modelValue": ($event) => unref(form).name = $event,
        error: unref(form).errors.name,
        required: true
      }, null, _parent));
      _push(`</div><div class="col-span-12">`);
      _push(ssrRenderComponent(_sfc_main$4, {
        name: "description",
        labelName: "Description",
        modelValue: unref(form).description,
        "onUpdate:modelValue": ($event) => unref(form).description = $event,
        error: unref(form).errors.description,
        required: true
      }, null, _parent));
      _push(`</div><div class="col-span-7 md:col-span-9">`);
      _push(ssrRenderComponent(_sfc_main$7, {
        name: "price",
        labelName: "Price",
        type: "number",
        modelValue: unref(form).price,
        "onUpdate:modelValue": ($event) => unref(form).price = $event,
        error: unref(form).errors.price,
        required: true
      }, null, _parent));
      _push(`</div><div class="col-span-5 md:col-span-3">`);
      _push(ssrRenderComponent(_sfc_main$2, {
        options: [{ "id": "czk", "name": "CZK" }, { "id": "eur", "name": "EUR" }],
        modelValue: unref(form).currency,
        "onUpdate:modelValue": ($event) => unref(form).currency = $event,
        labelName: "Currency",
        name: "currency",
        required: true,
        error: unref(form).errors.currency
      }, null, _parent));
      _push(`</div><div class="md:col-span-5 col-span-12">`);
      _push(ssrRenderComponent(_sfc_main$2, {
        options: __props.deliveryOptions,
        modelValue: unref(form).delivery_option_id,
        "onUpdate:modelValue": ($event) => unref(form).delivery_option_id = $event,
        labelName: "Delivery Option",
        name: "delivery_option_id",
        required: true,
        error: unref(form).errors.delivery_option_id
      }, null, _parent));
      _push(`</div><div class="md:col-span-7 col-span-12">`);
      _push(ssrRenderComponent(_sfc_main$7, {
        name: "delivery_detail",
        labelName: "Delivery Detail",
        type: "text",
        modelValue: unref(form).delivery_detail,
        "onUpdate:modelValue": ($event) => unref(form).delivery_detail = $event,
        error: unref(form).errors.delivery_detail,
        required: false
      }, null, _parent));
      _push(`</div><div class="col-span-12 flex flex-col"><label class="mb-2 md:mb-0">Sport</label><div class="flex flex-col sm:flex-row gap-2"><label class="cursor-pointer w-full sm:flex-1"><input type="radio" name="sport_id" class="hidden peer" value="1"${ssrIncludeBooleanAttr(ssrLooseEqual(unref(form).sport_id, "1")) ? " checked" : ""}><div class="sport-selector-style"> BOTH </div></label><label class="cursor-pointer w-full sm:flex-1"><input type="radio" name="sport_id" class="hidden peer" value="2"${ssrIncludeBooleanAttr(ssrLooseEqual(unref(form).sport_id, "2")) ? " checked" : ""}><div class="sport-selector-style"> BASEBALL </div></label><label class="cursor-pointer w-full sm:flex-1"><input type="radio" name="sport_id" class="hidden peer" value="3"${ssrIncludeBooleanAttr(ssrLooseEqual(unref(form).sport_id, "3")) ? " checked" : ""}><div class="sport-selector-style"> SOFTBALL </div></label></div>`);
      if (unref(form).errors.sport_id) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(unref(form).errors.sport_id)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="col-span-12 flex flex-col md:flex-row gap-2 justify-between"><div class="w-full">`);
      _push(ssrRenderComponent(_sfc_main$2, {
        options: __props.brands,
        modelValue: unref(form).brand_id,
        "onUpdate:modelValue": ($event) => unref(form).brand_id = $event,
        labelName: "Brand",
        name: "brand",
        required: true,
        error: unref(form).errors.brand_id
      }, null, _parent));
      _push(`</div><div class="w-full">`);
      _push(ssrRenderComponent(_sfc_main$2, {
        options: [{ "id": "new", "name": "NEW" }, { "id": "used", "name": "USED" }, { "id": "damaged", "name": "DAMAGED" }],
        modelValue: unref(form).condition,
        "onUpdate:modelValue": ($event) => unref(form).condition = $event,
        labelName: "Condition",
        name: "condition",
        required: true,
        error: unref(form).errors.condition
      }, null, _parent));
      _push(`</div>`);
      if (!__props.isEditMode) {
        _push(`<div class="w-full">`);
        _push(ssrRenderComponent(_sfc_main$2, {
          options: __props.categories,
          modelValue: unref(form).category_id,
          "onUpdate:modelValue": ($event) => unref(form).category_id = $event,
          labelName: "Category",
          name: "category",
          required: true,
          error: unref(form).errors.category_id
        }, null, _parent));
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (!__props.isEditMode && filteredFilterCategories.value.length) {
        _push(`<div class="col-span-12">`);
        _push(ssrRenderComponent(_sfc_main$3, null, null, _parent));
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      if (!__props.isEditMode) {
        _push(`<div class="col-span-12 flex flex-col md:flex-row gap-2 justify-between"><!--[-->`);
        ssrRenderList(filteredFilterCategories.value, (filterCategory) => {
          _push(`<div class="w-full">`);
          _push(ssrRenderComponent(_sfc_main$2, {
            options: filterCategory.options,
            modelValue: unref(form)[`fc${filterCategory.id}`],
            "onUpdate:modelValue": ($event) => unref(form)[`fc${filterCategory.id}`] = $event,
            labelName: filterCategory.name,
            name: "fc" + filterCategory.id,
            required: false
          }, null, _parent));
          _push(`</div>`);
        });
        _push(`<!--]--></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="col-span-12">`);
      _push(ssrRenderComponent(_sfc_main$8, null, null, _parent));
      _push(`</div><div class="col-span-12">`);
      _push(ssrRenderComponent(_sfc_main$9, {
        type: "submit",
        text: __props.isEditMode ? "Edit offer" : "Add offer",
        class: "md:w-auto"
      }, null, _parent));
      _push(`</div></div></div></form>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/OfferForm.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
