import { unref, mergeProps, withCtx, createVNode, useSSRContext } from "vue";
import { ssrRenderComponent, ssrRenderAttr } from "vue/server-renderer";
import { Link } from "@inertiajs/vue3";
import { _ as _sfc_main$4 } from "./PriceCard-sxzlgNGX.js";
import { _ as _sfc_main$2 } from "./Heading3-q7V9h2MZ.js";
import { _ as _sfc_main$3 } from "./SmallText-bh_SH4m8.js";
import { a as _sfc_main$1 } from "./ConditionLike-B8gmHh2g.js";
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
            _push2(`<div class="bg-white shadow-gray-300 shadow-lg h-full"${_scopeId}><div${_scopeId}><img${ssrRenderAttr("src", __props.offer.thumbnail_url)}${ssrRenderAttr("alt", __props.offer.name)} class="card-image" loading="lazy"${_scopeId}></div><div class="p-2 flex flex-col gap-2"${_scopeId}><div class="flex align-top items-start"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$1, { offer: __props.offer }, null, _parent2, _scopeId));
            _push2(`</div><div class="flex-1"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$2, {
              text: __props.offer.name,
              class: "line-clamp-2 lg:line-clamp-1"
            }, null, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$3, {
              text: __props.offer.brand.name
            }, null, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$4, {
              price: __props.offer.price,
              currency: __props.offer.currency
            }, null, _parent2, _scopeId));
            _push2(`</div></div></div>`);
          } else {
            return [
              createVNode("div", { class: "bg-white shadow-gray-300 shadow-lg h-full" }, [
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
                    createVNode(_sfc_main$1, { offer: __props.offer }, null, 8, ["offer"])
                  ]),
                  createVNode("div", { class: "flex-1" }, [
                    createVNode(_sfc_main$2, {
                      text: __props.offer.name,
                      class: "line-clamp-2 lg:line-clamp-1"
                    }, null, 8, ["text"]),
                    createVNode(_sfc_main$3, {
                      text: __props.offer.brand.name
                    }, null, 8, ["text"]),
                    createVNode(_sfc_main$4, {
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
