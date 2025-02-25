import { mergeProps, useSSRContext, computed, withCtx, createTextVNode, toDisplayString, unref, createVNode } from "vue";
import { ssrRenderAttrs, ssrInterpolate, ssrRenderSlot, ssrRenderComponent, ssrRenderAttr } from "vue/server-renderer";
import { Link } from "@inertiajs/vue3";
import { b as _sfc_main$3, a as _sfc_main$4 } from "./ConditionLike-BdJTfOv0.js";
import { _ as _sfc_main$5 } from "./SmallText-bh_SH4m8.js";
const _sfc_main$2 = {
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
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Text/BoldNormalText.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = {
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
      _push(ssrRenderComponent(_sfc_main$2, mergeProps({ class: "uppercase" }, _attrs), {
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
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/PriceCard.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "Card",
  __ssrInlineRender: true,
  props: {
    offer: Object
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(unref(Link), mergeProps({
        href: _ctx.route("offer.show", __props.offer.id)
      }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="bg-white shadow-gray-300 shadow-lg"${_scopeId}><div${_scopeId}><img${ssrRenderAttr("src", __props.offer.thumbnail_url)}${ssrRenderAttr("alt", __props.offer.name)} class="card-image" loading="lazy"${_scopeId}></div><div class="p-2 flex flex-col gap-2"${_scopeId}><div class="flex align-top items-start"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, { offer: __props.offer }, null, _parent2, _scopeId));
            _push2(`</div><div class="flex-1"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$4, {
              text: __props.offer.name
            }, null, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$5, {
              text: __props.offer.brand.name
            }, null, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$1, {
              price: __props.offer.price,
              currency: __props.offer.currency
            }, null, _parent2, _scopeId));
            _push2(`</div></div></div>`);
          } else {
            return [
              createVNode("div", { class: "bg-white shadow-gray-300 shadow-lg" }, [
                createVNode("div", null, [
                  createVNode("img", {
                    src: __props.offer.thumbnail_url,
                    alt: __props.offer.name,
                    class: "card-image",
                    loading: "lazy"
                  }, null, 8, ["src", "alt"])
                ]),
                createVNode("div", { class: "p-2 flex flex-col gap-2" }, [
                  createVNode("div", { class: "flex align-top items-start" }, [
                    createVNode(_sfc_main$3, { offer: __props.offer }, null, 8, ["offer"])
                  ]),
                  createVNode("div", { class: "flex-1" }, [
                    createVNode(_sfc_main$4, {
                      text: __props.offer.name
                    }, null, 8, ["text"]),
                    createVNode(_sfc_main$5, {
                      text: __props.offer.brand.name
                    }, null, 8, ["text"]),
                    createVNode(_sfc_main$1, {
                      price: __props.offer.price,
                      currency: __props.offer.currency
                    }, null, 8, ["price", "currency"])
                  ])
                ])
              ])
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/Card.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as _
};
