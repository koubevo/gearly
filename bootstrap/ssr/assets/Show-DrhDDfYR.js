import { computed, mergeProps, withCtx, createTextVNode, toDisplayString, useSSRContext, unref, renderSlot, ref, openBlock, createBlock, createCommentVNode, createVNode } from "vue";
import { ssrRenderComponent, ssrInterpolate, ssrRenderSlot, ssrRenderAttrs, ssrRenderAttr, ssrRenderList, ssrRenderClass } from "vue/server-renderer";
import { Link, usePage } from "@inertiajs/vue3";
import { _ as _sfc_main$6, a as _sfc_main$7, b as _sfc_main$b } from "./ConditionLike-BdJTfOv0.js";
import { a as _sfc_main$c, _ as _sfc_main$d } from "./PrimaryLink-BhP3udGA.js";
import { _ as _sfc_main$a } from "./Heading1-B5GMPk_G.js";
import { D as DangerButton, _ as _sfc_main$f } from "./DangerButton-B4SyKRsB.js";
import { _ as _sfc_main$e } from "./Modal-q1Rna5Y2.js";
import { _ as _sfc_main$8 } from "./NormalText-ccMf7loH.js";
import { _ as _sfc_main$9 } from "./TinyText-DdKyE_L8.js";
import "@inertiajs/inertia";
import "@heroicons/vue/24/solid";
import "@heroicons/vue/24/outline";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
const _sfc_main$5 = {
  __name: "Price",
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
      _push(ssrRenderComponent(_sfc_main$6, mergeProps({ class: "uppercase" }, _attrs), {
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
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/Price.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const _sfc_main$4 = {
  __name: "DangerLink",
  __ssrInlineRender: true,
  props: {
    text: String
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(unref(Link), mergeProps({ class: "danger-button-style" }, _attrs), {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(__props.text)}`);
            ssrRenderSlot(_ctx.$slots, "default", {}, null, _push2, _parent2, _scopeId);
          } else {
            return [
              createTextVNode(toDisplayString(__props.text), 1),
              renderSlot(_ctx.$slots, "default")
            ];
          }
        }),
        _: 3
      }, _parent));
    };
  }
};
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Buttons/DangerLink.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const _sfc_main$3 = {
  __name: "OfferDetail",
  __ssrInlineRender: true,
  props: {
    detail: String,
    detailValue: String
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex gap-2 mb-0" }, _attrs))}><div class="font-medium">${ssrInterpolate(__props.detail)}:</div><div>${ssrInterpolate(__props.detailValue)}</div></div>`);
    };
  }
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/OfferDetail.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = {
  __name: "ImageViewer",
  __ssrInlineRender: true,
  props: {
    images: Array
  },
  setup(__props) {
    const props = __props;
    const currentIndex = ref(0);
    const currentImage = computed(() => {
      var _a;
      return ((_a = props.images) == null ? void 0 : _a[currentIndex.value]) || "";
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "gallery w-full mb-4" }, _attrs))}><div class="main-image">`);
      if (__props.images.length > 1) {
        _push(`<button class="nav left">‹</button>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<img${ssrRenderAttr("src", currentImage.value)} alt="Offer image">`);
      if (__props.images.length > 1) {
        _push(`<button class="nav right">›</button>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="thumbnails"><!--[-->`);
      ssrRenderList(__props.images, (img, index) => {
        _push(`<img${ssrRenderAttr("src", img)} class="${ssrRenderClass({ active: index === currentIndex.value })}" alt="Thumbnail">`);
      });
      _push(`<!--]--></div></div>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/ImageViewer.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = {
  __name: "OfferUserDetail",
  __ssrInlineRender: true,
  props: {
    seller: Object,
    soldOffersCount: Number
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({ class: "border-s-gray-900 border-4 border-e-0 border-y-0 p-2" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$7, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(__props.seller.name)} `);
            if (__props.seller.team) {
              _push2(`<span${_scopeId}>(${ssrInterpolate(__props.seller.team)})</span>`);
            } else {
              _push2(`<!---->`);
            }
          } else {
            return [
              createTextVNode(toDisplayString(__props.seller.name) + " ", 1),
              __props.seller.team ? (openBlock(), createBlock("span", { key: 0 }, "(" + toDisplayString(__props.seller.team) + ")", 1)) : createCommentVNode("", true)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(_sfc_main$8, null, {
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
        _push(ssrRenderComponent(_sfc_main$8, { class: "mb-2" }, {
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
      _push(ssrRenderComponent(_sfc_main$9, {
        text: __props.seller.location,
        class: "mb-0.5"
      }, null, _parent));
      if (__props.seller.phone) {
        _push(ssrRenderComponent(_sfc_main$9, {
          text: __props.seller.phone
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</section>`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/User/OfferUserDetail.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "Show",
  __ssrInlineRender: true,
  props: {
    offer: Object,
    seller: Object,
    category: Object,
    deliveryOption: Object,
    brand: Object,
    filters: Object,
    images: Array,
    soldOffersCount: Number
  },
  setup(__props) {
    const user = usePage().props.auth.user ?? {};
    const confirmingOfferDeletion = ref(false);
    function confirmOfferDeletion() {
      confirmingOfferDeletion.value = true;
    }
    function closeModal() {
      confirmingOfferDeletion.value = false;
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "grid grid-cols-12 md:gap-16 gap-0 pb-20" }, _attrs))}><div class="col-span-12 md:col-span-6 items-center justify-center flex relative">`);
      _push(ssrRenderComponent(_sfc_main$2, { images: __props.images }, null, _parent));
      _push(`</div><div class="col-span-12 md:col-span-6 md:pt-10"><section class="grid mb-6">`);
      _push(ssrRenderComponent(_sfc_main$a, {
        text: __props.offer.name,
        class: "mb-3"
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$5, {
        price: __props.offer.price,
        currency: __props.offer.currency
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$b, {
        offer: __props.offer,
        class: "mt-2"
      }, null, _parent));
      _push(`</section><section class="grid mb-6">`);
      _push(ssrRenderComponent(_sfc_main$8, { class: "mb-4 pe-2" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`${ssrInterpolate(__props.offer.description)}`);
          } else {
            return [
              createTextVNode(toDisplayString(__props.offer.description), 1)
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<div class="flex flex-col gap-x-2 gap-y-0.5 text-sm mb-6">`);
      _push(ssrRenderComponent(_sfc_main$3, {
        detail: "Brand",
        detailValue: __props.brand.name
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$3, {
        detail: "Sport",
        detailValue: __props.offer.sport
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$3, {
        detail: "Category",
        detailValue: __props.category.name
      }, null, _parent));
      _push(`<!--[-->`);
      ssrRenderList(__props.filters, (filter) => {
        _push(ssrRenderComponent(_sfc_main$3, {
          detail: filter.filter_category_name,
          detailValue: filter.filter_name
        }, null, _parent));
      });
      _push(`<!--]--></div><div class="flex flex-col gap-x-2 gap-y-0.5 text-sm">`);
      _push(ssrRenderComponent(_sfc_main$3, {
        detail: "Delivery Option",
        detailValue: __props.deliveryOption.name
      }, null, _parent));
      if (__props.offer.delivery_detail) {
        _push(ssrRenderComponent(_sfc_main$3, {
          detail: "Delivery Detail",
          detailValue: __props.offer.delivery_detail
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</div></section>`);
      _push(ssrRenderComponent(unref(Link), {
        href: __props.seller.id === unref(user).id ? "/profile" : _ctx.route("user.show", { user: __props.seller.id })
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(_sfc_main$1, {
              seller: __props.seller,
              soldOffersCount: __props.soldOffersCount
            }, null, _parent2, _scopeId));
          } else {
            return [
              createVNode(_sfc_main$1, {
                seller: __props.seller,
                soldOffersCount: __props.soldOffersCount
              }, null, 8, ["seller", "soldOffersCount"])
            ];
          }
        }),
        _: 1
      }, _parent));
      if (__props.seller.id !== unref(user).id) {
        _push(`<div><section class="my-6 hidden md:grid">`);
        _push(ssrRenderComponent(_sfc_main$c, { text: "Chat with seller" }, null, _parent));
        _push(`</section><section class="grid mb-2 md:relative fixed bottom-0 left-0 w-full p-2 md:hidden">`);
        _push(ssrRenderComponent(_sfc_main$c, {
          text: "Chat with seller",
          class: "w-full"
        }, null, _parent));
        _push(`</section></div>`);
      } else {
        _push(`<div><section class="my-6 flex gap-2">`);
        _push(ssrRenderComponent(_sfc_main$d, {
          text: "Edit",
          href: _ctx.route("offer.edit", { offer: __props.offer.id })
        }, null, _parent));
        _push(ssrRenderComponent(DangerButton, { onClick: confirmOfferDeletion }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`Delete`);
            } else {
              return [
                createTextVNode("Delete")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(ssrRenderComponent(_sfc_main$e, {
          show: confirmingOfferDeletion.value,
          onClose: closeModal
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<div class="p-6"${_scopeId}>`);
              _push2(ssrRenderComponent(_sfc_main$7, { class: "text-lg text-gray-900" }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(` Are you sure you want to delete offer <span class="font-bold"${_scopeId2}>${ssrInterpolate(__props.offer.name)}</span>? `);
                  } else {
                    return [
                      createTextVNode(" Are you sure you want to delete offer "),
                      createVNode("span", { class: "font-bold" }, toDisplayString(__props.offer.name), 1),
                      createTextVNode("? ")
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`<div class="mt-6 flex justify-end gap-2"${_scopeId}>`);
              _push2(ssrRenderComponent(_sfc_main$f, { onClick: closeModal }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(` Cancel `);
                  } else {
                    return [
                      createTextVNode(" Cancel ")
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(ssrRenderComponent(_sfc_main$4, {
                href: _ctx.route("offer.destroy", { offer: __props.offer.id }),
                method: "delete"
              }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(` Delete Offer `);
                  } else {
                    return [
                      createTextVNode(" Delete Offer ")
                    ];
                  }
                }),
                _: 1
              }, _parent2, _scopeId));
              _push2(`</div></div>`);
            } else {
              return [
                createVNode("div", { class: "p-6" }, [
                  createVNode(_sfc_main$7, { class: "text-lg text-gray-900" }, {
                    default: withCtx(() => [
                      createTextVNode(" Are you sure you want to delete offer "),
                      createVNode("span", { class: "font-bold" }, toDisplayString(__props.offer.name), 1),
                      createTextVNode("? ")
                    ]),
                    _: 1
                  }),
                  createVNode("div", { class: "mt-6 flex justify-end gap-2" }, [
                    createVNode(_sfc_main$f, { onClick: closeModal }, {
                      default: withCtx(() => [
                        createTextVNode(" Cancel ")
                      ]),
                      _: 1
                    }),
                    createVNode(_sfc_main$4, {
                      href: _ctx.route("offer.destroy", { offer: __props.offer.id }),
                      method: "delete"
                    }, {
                      default: withCtx(() => [
                        createTextVNode(" Delete Offer ")
                      ]),
                      _: 1
                    }, 8, ["href"])
                  ])
                ])
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</section></div>`);
      }
      _push(`</div></div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Offer/Show.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
