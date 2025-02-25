import { mergeProps, useSSRContext } from "vue";
import { ssrRenderComponent } from "vue/server-renderer";
import { _ as _sfc_main$1 } from "./OfferForm-CwYEZuVz.js";
import "./Heading1-B5GMPk_G.js";
import "@inertiajs/vue3";
import "./PrimaryButton-DRqOrSj4.js";
import "axios";
import "./RequiredFieldsNote-C7WE28xO.js";
import "./SmallText-bh_SH4m8.js";
import "vue-select";
/* empty css                    */
import "vue-filepond";
import "filepond-plugin-file-validate-type";
import "filepond-plugin-image-preview";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
const _sfc_main = {
  __name: "Edit",
  __ssrInlineRender: true,
  props: {
    offer: Object,
    brands: Array,
    categories: Array,
    deliveryOptions: Array
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$1, mergeProps({
        offer: __props.offer,
        isEditMode: true,
        brands: __props.brands,
        categories: __props.categories,
        deliveryOptions: __props.deliveryOptions
      }, _attrs), null, _parent));
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Offer/Edit.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
