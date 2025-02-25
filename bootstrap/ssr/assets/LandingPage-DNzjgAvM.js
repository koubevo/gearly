import { ssrRenderAttrs, ssrRenderComponent, ssrInterpolate } from "vue/server-renderer";
import { mergeProps, withCtx, createTextVNode, toDisplayString, unref, createVNode, useSSRContext } from "vue";
import { _ as _sfc_main$2 } from "./ConditionLike-BdJTfOv0.js";
import { _ as _sfc_main$3 } from "./TinyText-DdKyE_L8.js";
import { ChevronRightIcon } from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/vue3";
import { _ as _sfc_main$4 } from "./UserOffersGrid-CWlHY5yY.js";
import "@inertiajs/inertia";
import "@heroicons/vue/24/solid";
import "./NormalText-ccMf7loH.js";
import "./Card-C0FeGnw2.js";
import "./SmallText-bh_SH4m8.js";
const _sfc_main$1 = {
  __name: "OffersSection",
  __ssrInlineRender: true,
  props: {
    offers: {
      type: Array ?? []
    },
    heading: String,
    link: String
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({ class: "mb-8" }, _attrs))}><div class="flex justify-between items-center mb-2 gap-4">`);
      _push(ssrRenderComponent(_sfc_main$2, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(__props.heading)}`);
          } else {
            return [
              createTextVNode(toDisplayString(__props.heading), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(unref(Link), {
        class: "text-left",
        href: __props.link
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="flex flex-row justify-between items-center gap-2"${_scopeId}><div class="flex-1"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`Check all <span class="lowercase"${_scopeId2}>${ssrInterpolate(__props.heading)}</span>`);
                } else {
                  return [
                    createTextVNode("Check all "),
                    createVNode("span", { class: "lowercase" }, toDisplayString(__props.heading), 1)
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="flex-shrink-0 text-primary-900"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(ChevronRightIcon), { class: "w-5 h-5 stroke-[2.5]" }, null, _parent2, _scopeId));
            _push2(`</div></div>`);
          } else {
            return [
              createVNode("div", { class: "flex flex-row justify-between items-center gap-2" }, [
                createVNode("div", { class: "flex-1" }, [
                  createVNode(_sfc_main$3, null, {
                    default: withCtx(() => [
                      createTextVNode("Check all "),
                      createVNode("span", { class: "lowercase" }, toDisplayString(__props.heading), 1)
                    ]),
                    _: 1
                  })
                ]),
                createVNode("div", { class: "flex-shrink-0 text-primary-900" }, [
                  createVNode(unref(ChevronRightIcon), { class: "w-5 h-5 stroke-[2.5]" })
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><div>`);
      _push(ssrRenderComponent(_sfc_main$4, { offers: __props.offers }, null, _parent));
      _push(`</div></section>`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/LandingPage/OffersSection.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "LandingPage",
  __ssrInlineRender: true,
  props: {
    newArrivals: Array,
    brandWithMostActiveOffers: Array,
    baseballBats: Array ?? [],
    softballBats: Array ?? [],
    baseballGear: Array ?? [],
    softballGear: Array ?? []
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(_sfc_main$1, {
        offers: __props.newArrivals,
        heading: "New Arrivals",
        link: _ctx.route("offer.index")
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$1, {
        offers: __props.brandWithMostActiveOffers,
        heading: "New Arrivals from " + __props.brandWithMostActiveOffers[0].brand.name,
        link: _ctx.route("offer.index", { brand: __props.brandWithMostActiveOffers[0].brand_id })
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$1, {
        offers: __props.baseballBats,
        heading: "Baseball Bats",
        link: _ctx.route("offer.index", { category: 1, sport: 2 })
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$1, {
        offers: __props.softballBats,
        heading: "Softball Bats",
        link: _ctx.route("offer.index", { category: 1, sport: 3 })
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$1, {
        offers: __props.baseballGear,
        heading: "Baseball Gear",
        link: _ctx.route("offer.index", { sport: 2 })
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$1, {
        offers: __props.softballGear,
        heading: "Softball Gear",
        link: _ctx.route("offer.index", { sport: 3 })
      }, null, _parent));
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/LandingPage.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
