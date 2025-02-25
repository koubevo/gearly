import { mergeProps, withCtx, createTextVNode, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderComponent } from "vue/server-renderer";
import { D as Divider } from "./Divider-D99dPSph.js";
import { _ as _sfc_main$2 } from "./UserOffers-DB1DpECR.js";
import { _ as _sfc_main$3 } from "./NothingHere-C5j-DxuH.js";
import { _ as _sfc_main$1 } from "./Heading1-B5GMPk_G.js";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
import "./UserOffersGrid-CWlHY5yY.js";
import "./Card-C0FeGnw2.js";
import "@inertiajs/vue3";
import "./ConditionLike-BdJTfOv0.js";
import "@inertiajs/inertia";
import "@heroicons/vue/24/solid";
import "@heroicons/vue/24/outline";
import "./NormalText-ccMf7loH.js";
import "./SmallText-bh_SH4m8.js";
const _sfc_main = {
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    offers: Array
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "mb-4" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$1, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`Wishlist`);
          } else {
            return [
              createTextVNode("Wishlist")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(Divider, { class: "md:w-full mt-6" }, null, _parent));
      if (__props.offers.length) {
        _push(ssrRenderComponent(_sfc_main$2, {
          offers: __props.offers,
          class: "py-4"
        }, null, _parent));
      } else {
        _push(ssrRenderComponent(_sfc_main$3, { text: "You have not liked any offers. Click the hearth icon to add your first favorite offer to a wishlist!" }, null, _parent));
      }
      _push(`</div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Wishlist/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
