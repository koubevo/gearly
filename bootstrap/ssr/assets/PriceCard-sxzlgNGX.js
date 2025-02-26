import { mergeProps, useSSRContext, computed, withCtx, createTextVNode, toDisplayString } from "vue";
import { ssrRenderAttrs, ssrInterpolate, ssrRenderSlot, ssrRenderComponent } from "vue/server-renderer";
const _sfc_main$1 = {
  __name: "BoldNormalText",
  __ssrInlineRender: true,
  props: {
    text: String
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<p${ssrRenderAttrs(mergeProps({ class: "bold-normal-text-style" }, _attrs))}>${ssrInterpolate(__props.text)}`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</p>`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Text/BoldNormalText.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "PriceCard",
  __ssrInlineRender: true,
  props: {
    price: Number,
    currency: String
  },
  setup(__props) {
    const props = __props;
    const price = computed(() => {
      if (props.price == null) return "0";
      const numericPrice = Number(props.price);
      return new Intl.NumberFormat("cs-CZ").format(numericPrice);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$1, mergeProps({ class: "uppercase" }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(price.value)} ${ssrInterpolate(__props.currency)}`);
          } else {
            return [
              createTextVNode(toDisplayString(price.value) + " " + toDisplayString(__props.currency), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/PriceCard.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
