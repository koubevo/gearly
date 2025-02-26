import { withCtx, createTextVNode, toDisplayString, useSSRContext, onMounted, mergeProps } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrRenderAttrs } from "vue/server-renderer";
import { usePage } from "@inertiajs/vue3";
import { D as Divider } from "./Divider-D99dPSph.js";
import { _ as _sfc_main$5 } from "./UserOffers-Cgcx66Cc.js";
import { _ as _sfc_main$2 } from "./Heading1-B5GMPk_G.js";
import { _ as _sfc_main$4 } from "./TinyText-DdKyE_L8.js";
import { _ as _sfc_main$3 } from "./NormalText-ccMf7loH.js";
import { _ as _sfc_main$6 } from "./NothingHere-C5j-DxuH.js";
import { Inertia } from "@inertiajs/inertia";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
import "./UserOffersGrid-wj8fEnAa.js";
import "./Card-DceVe3xJ.js";
import "./PriceCard-sxzlgNGX.js";
import "./Heading3-q7V9h2MZ.js";
import "./SmallText-bh_SH4m8.js";
import "./ConditionLike-B8gmHh2g.js";
import "@heroicons/vue/24/solid";
import "@heroicons/vue/24/outline";
const _sfc_main$1 = {
  __name: "UserInfo",
  __ssrInlineRender: true,
  props: {
    user: Object,
    soldOffersCount: Number
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><section class="mb-4 flex gap-4 items-center">`);
      _push(ssrRenderComponent(_sfc_main$2, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(__props.user.name)}`);
          } else {
            return [
              createTextVNode(toDisplayString(__props.user.name), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</section><section class="mb-4">`);
      _push(ssrRenderComponent(_sfc_main$3, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`Feedback`);
          } else {
            return [
              createTextVNode("Feedback")
            ];
          }
        }),
        _: 1
      }, _parent));
      if (__props.soldOffersCount > 0) {
        _push(ssrRenderComponent(_sfc_main$3, { class: "mb-2" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`Already sold items: ${ssrInterpolate(__props.soldOffersCount)}`);
            } else {
              return [
                createTextVNode("Already sold items: " + toDisplayString(__props.soldOffersCount), 1)
              ];
            }
          }),
          _: 1
        }, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(ssrRenderComponent(_sfc_main$4, {
        text: __props.user.location,
        class: "mb-0.5"
      }, null, _parent));
      if (__props.user.phone) {
        _push(ssrRenderComponent(_sfc_main$4, {
          text: __props.user.phone
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</section><!--]-->`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/User/UserInfo.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "Show",
  __ssrInlineRender: true,
  props: {
    user: Object,
    activeOffers: Array ?? [],
    soldOffers: Array ?? [],
    soldOffersCount: Number
  },
  setup(__props) {
    var _a;
    const props = __props;
    const page = usePage();
    const currentUser = (_a = page.props.auth) == null ? void 0 : _a.user;
    onMounted(() => {
      if (currentUser.id === props.user.id) {
        Inertia.visit("/profile");
      }
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "mb-4" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$1, {
        user: __props.user,
        soldOffersCount: __props.soldOffersCount
      }, null, _parent));
      _push(ssrRenderComponent(Divider, { class: "md:w-full mt-8" }, null, _parent));
      if (__props.activeOffers.length) {
        _push(ssrRenderComponent(_sfc_main$5, {
          offers: __props.activeOffers,
          class: "py-4",
          heading: "Active offers"
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (__props.soldOffers.length) {
        _push(ssrRenderComponent(_sfc_main$5, {
          offers: __props.soldOffers,
          class: "py-4",
          heading: "Sold offers"
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      if (!__props.activeOffers.length && !__props.soldOffers.length) {
        _push(ssrRenderComponent(_sfc_main$6, { text: "User has no active or sold offers" }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/User/Show.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
