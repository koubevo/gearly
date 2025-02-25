import { computed, onMounted, unref, withCtx, createVNode, openBlock, createBlock, createTextVNode, useSSRContext, mergeProps, ref } from "vue";
import { ssrRenderComponent, ssrRenderAttr, ssrInterpolate, ssrRenderSlot, ssrRenderAttrs, ssrRenderList } from "vue/server-renderer";
import { usePage, Link } from "@inertiajs/vue3";
import { MagnifyingGlassIcon, BellIcon, HeartIcon, UserIcon, ChevronUpIcon } from "@heroicons/vue/24/outline";
import { _ as _sfc_main$4, a as _sfc_main$5 } from "./PrimaryLink-BhP3udGA.js";
import axios from "axios";
import { _ as _sfc_main$7 } from "./Card-C0FeGnw2.js";
import { _ as _sfc_main$8 } from "./PrimaryButton-DRqOrSj4.js";
import { D as Divider } from "./Divider-D99dPSph.js";
import { _ as _sfc_main$6 } from "./Heading1-B5GMPk_G.js";
import { _ as _sfc_main$a } from "./Modal-q1Rna5Y2.js";
import { _ as _sfc_main$b } from "./ConditionLike-BdJTfOv0.js";
import { _ as _sfc_main$9 } from "./NothingHere-C5j-DxuH.js";
import "./SmallText-bh_SH4m8.js";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
import "@inertiajs/inertia";
import "@heroicons/vue/24/solid";
import "./NormalText-ccMf7loH.js";
const _sfc_main$3 = {
  __name: "MainLayout",
  __ssrInlineRender: true,
  setup(__props) {
    const page = usePage();
    const user = computed(() => page.props.auth.user);
    const flashSuccess = computed(() => {
      var _a;
      return ((_a = page.props.flash) == null ? void 0 : _a.success) ?? "";
    });
    const flashError = computed(() => {
      var _a;
      return ((_a = page.props.errors) == null ? void 0 : _a.error) ?? "";
    });
    onMounted(() => {
      if (flashSuccess.value || flashError.value) {
        setTimeout(() => {
          flashSuccess.value = "";
          flashError.value = "";
        }, 1e4);
      }
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><header class="border-b-2 border-black border-solid w-full mb-4"><div class="container mx-auto"><nav class="py-3 px-2 md:px-0 max-md:px-2 flex items-center justify-between header-height-style"><div class="flex gap-3 md:gap-5 align-middle items-center mt-0.5">`);
      _push(ssrRenderComponent(unref(Link), {
        href: _ctx.route("landingPage")
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<img${ssrRenderAttr("src", "/storage/imgs/logo.png")} alt="Logo" class="w-16 md:w-20 h-auto align-middle"${_scopeId}>`);
          } else {
            return [
              createVNode("img", {
                src: "/storage/imgs/logo.png",
                alt: "Logo",
                class: "w-16 md:w-20 h-auto align-middle"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(unref(Link), {
        href: _ctx.route("search.index")
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(ssrRenderComponent(unref(MagnifyingGlassIcon), { class: "w-5 h-5 stroke-[2.5]" }, null, _parent2, _scopeId));
          } else {
            return [
              createVNode(unref(MagnifyingGlassIcon), { class: "w-5 h-5 stroke-[2.5]" })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div>`);
      if (user.value) {
        _push(`<div class="flex gap-2 md:gap-5">`);
        _push(ssrRenderComponent(unref(Link), {
          href: _ctx.route("offer.create")
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<div class="relative w-6 h-6 mt-0.5"${_scopeId}><svg class="w-full h-full stroke-[3]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"${_scopeId}><defs${_scopeId}><linearGradient id="animatedGradient" x1="-100%" y1="0%" x2="200%" y2="0%"${_scopeId}><stop offset="0%" stop-color="#1D9E1D"${_scopeId}><animate attributeName="offset" values="-1;2" keyTimes="0;1" dur="10s" repeatCount="indefinite"${_scopeId}></animate></stop><stop offset="50%" stop-color="black"${_scopeId}><animate attributeName="offset" values="-0.5;2.5" keyTimes="0;1" dur="10s" repeatCount="indefinite"${_scopeId}></animate></stop><stop offset="100%" stop-color="#1D9E1D"${_scopeId}><animate attributeName="offset" values="0;3" keyTimes="0;1" dur="10s" repeatCount="indefinite"${_scopeId}></animate></stop></linearGradient></defs><path stroke="url(#animatedGradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m-8-8h16"${_scopeId}></path></svg></div>`);
            } else {
              return [
                createVNode("div", { class: "relative w-6 h-6 mt-0.5" }, [
                  (openBlock(), createBlock("svg", {
                    class: "w-full h-full stroke-[3]",
                    viewBox: "0 0 24 24",
                    fill: "none",
                    xmlns: "http://www.w3.org/2000/svg"
                  }, [
                    createVNode("defs", null, [
                      createVNode("linearGradient", {
                        id: "animatedGradient",
                        x1: "-100%",
                        y1: "0%",
                        x2: "200%",
                        y2: "0%"
                      }, [
                        createVNode("stop", {
                          offset: "0%",
                          "stop-color": "#1D9E1D"
                        }, [
                          createVNode("animate", {
                            attributeName: "offset",
                            values: "-1;2",
                            keyTimes: "0;1",
                            dur: "10s",
                            repeatCount: "indefinite"
                          })
                        ]),
                        createVNode("stop", {
                          offset: "50%",
                          "stop-color": "black"
                        }, [
                          createVNode("animate", {
                            attributeName: "offset",
                            values: "-0.5;2.5",
                            keyTimes: "0;1",
                            dur: "10s",
                            repeatCount: "indefinite"
                          })
                        ]),
                        createVNode("stop", {
                          offset: "100%",
                          "stop-color": "#1D9E1D"
                        }, [
                          createVNode("animate", {
                            attributeName: "offset",
                            values: "0;3",
                            keyTimes: "0;1",
                            dur: "10s",
                            repeatCount: "indefinite"
                          })
                        ])
                      ])
                    ]),
                    createVNode("path", {
                      stroke: "url(#animatedGradient)",
                      "stroke-linecap": "round",
                      "stroke-linejoin": "round",
                      "stroke-width": "3",
                      d: "M12 4v16m-8-8h16"
                    })
                  ]))
                ])
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(ssrRenderComponent(unref(Link), {
          href: _ctx.route("landingPage")
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(ssrRenderComponent(unref(BellIcon), { class: "w-6 h-6 mt-0.5" }, null, _parent2, _scopeId));
            } else {
              return [
                createVNode(unref(BellIcon), { class: "w-6 h-6 mt-0.5" })
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(ssrRenderComponent(unref(Link), {
          href: _ctx.route("wishlist.index")
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(ssrRenderComponent(unref(HeartIcon), { class: "w-6 h-6 mt-0.5" }, null, _parent2, _scopeId));
            } else {
              return [
                createVNode(unref(HeartIcon), { class: "w-6 h-6 mt-0.5" })
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(ssrRenderComponent(unref(Link), {
          href: _ctx.route("profile.edit")
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(ssrRenderComponent(unref(UserIcon), { class: "w-6 h-6 mt-0.5" }, null, _parent2, _scopeId));
            } else {
              return [
                createVNode(unref(UserIcon), { class: "w-6 h-6 mt-0.5" })
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</div>`);
      } else {
        _push(`<div class="flex gap-2 mt-0.5">`);
        _push(ssrRenderComponent(_sfc_main$4, {
          href: _ctx.route("login")
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`Log in`);
            } else {
              return [
                createTextVNode("Log in")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(ssrRenderComponent(_sfc_main$5, {
          href: _ctx.route("register")
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`Register`);
            } else {
              return [
                createTextVNode("Register")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</div>`);
      }
      _push(`</nav></div></header><main class="container mx-auto max-md:px-2">`);
      if (flashSuccess.value) {
        _push(`<div class="flash-message-success-style">${ssrInterpolate(flashSuccess.value)}</div>`);
      } else {
        _push(`<!---->`);
      }
      if (flashError.value) {
        _push(`<div class="flash-message-error-style">${ssrInterpolate(flashError.value)}</div>`);
      } else {
        _push(`<!---->`);
      }
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</main><!--]-->`);
    };
  }
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/MainLayout.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = {
  __name: "SortingButton",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<button${ssrRenderAttrs(mergeProps({
        class: "bg-white border-2 border-black border-solid px-4 py-2 text-black font-medium",
        onclick: "openModal()"
      }, _attrs))}>`);
      _push(ssrRenderComponent(unref(ChevronUpIcon), { class: "w-5 h-5 stroke-[2.5]" }, null, _parent));
      _push(`</button>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Buttons/SortingButton.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = {
  __name: "OffersGrid",
  __ssrInlineRender: true,
  setup(__props) {
    const initialOffers = usePage().props.offers.data;
    const offersList = ref([...initialOffers]);
    const nextPageUrl = ref(usePage().props.offers.next_page_url);
    const loading = ref(false);
    const loadMore = async () => {
      if (!nextPageUrl.value || loading.value) return;
      loading.value = true;
      try {
        const response = await axios.get(nextPageUrl.value);
        offersList.value.push(...response.data.data);
        nextPageUrl.value = response.data.next_page_url;
      } catch (error) {
        console.error("Error loading more offers:", error);
      } finally {
        loading.value = false;
      }
    };
    const modal = ref(false);
    const openModal = () => {
      modal.value = true;
    };
    const closeModal = () => {
      modal.value = false;
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><div><section class="grid grid-cols-2 items-center my-6"><div>`);
      _push(ssrRenderComponent(_sfc_main$6, null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`Offers`);
          } else {
            return [
              createTextVNode("Offers")
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><div class="flex justify-end"><div>`);
      _push(ssrRenderComponent(_sfc_main$2, { onClick: openModal }, null, _parent));
      _push(`</div></div></section>`);
      _push(ssrRenderComponent(Divider, { class: "md:w-full mb-4" }, null, _parent));
      if (offersList.value.length) {
        _push(`<section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8"><!--[-->`);
        ssrRenderList(offersList.value, (offer) => {
          _push(ssrRenderComponent(_sfc_main$7, {
            key: offer.id,
            offer
          }, null, _parent));
        });
        _push(`<!--]--></section>`);
      } else {
        _push(`<!---->`);
      }
      if (offersList.value.length) {
        _push(`<div class="flex justify-center my-6"><div>`);
        if (nextPageUrl.value) {
          _push(ssrRenderComponent(_sfc_main$8, {
            onClick: loadMore,
            disabled: loading.value
          }, {
            default: withCtx((_, _push2, _parent2, _scopeId) => {
              if (_push2) {
                if (loading.value) {
                  _push2(`<span${_scopeId}>Loading...</span>`);
                } else {
                  _push2(`<span${_scopeId}>Load More</span>`);
                }
              } else {
                return [
                  loading.value ? (openBlock(), createBlock("span", { key: 0 }, "Loading...")) : (openBlock(), createBlock("span", { key: 1 }, "Load More"))
                ];
              }
            }),
            _: 1
          }, _parent));
        } else {
          _push(`<!---->`);
        }
        _push(`</div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (!offersList.value.length) {
        _push(`<div>`);
        _push(ssrRenderComponent(_sfc_main$9, { text: "Try searching for something else" }, null, _parent));
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(ssrRenderComponent(_sfc_main$a, {
        show: modal.value,
        onClose: closeModal
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="p-6"${_scopeId}><div class="flex justify-between items-end"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$b, null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`Sort Offers`);
                } else {
                  return [
                    createTextVNode("Sort Offers")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`<button class="text-gray-500 hover:text-black"${_scopeId}>×</button></div>`);
            _push2(ssrRenderComponent(Divider, { class: "md:w-full my-4" }, null, _parent2, _scopeId));
            _push2(`<div class="flex flex-col md:flex-row gap-2"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$4, {
              href: _ctx.route("offer.index")
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`Most recent`);
                } else {
                  return [
                    createTextVNode("Most recent")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$4, {
              href: _ctx.route("offer.index", { order: 0 })
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`Cheapest`);
                } else {
                  return [
                    createTextVNode("Cheapest")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$4, {
              href: _ctx.route("offer.index", { order: 1 })
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`Most expensive`);
                } else {
                  return [
                    createTextVNode("Most expensive")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div></div>`);
          } else {
            return [
              createVNode("div", { class: "p-6" }, [
                createVNode("div", { class: "flex justify-between items-end" }, [
                  createVNode(_sfc_main$b, null, {
                    default: withCtx(() => [
                      createTextVNode("Sort Offers")
                    ]),
                    _: 1
                  }),
                  createVNode("button", {
                    class: "text-gray-500 hover:text-black",
                    onClick: closeModal
                  }, "×")
                ]),
                createVNode(Divider, { class: "md:w-full my-4" }),
                createVNode("div", { class: "flex flex-col md:flex-row gap-2" }, [
                  createVNode(_sfc_main$4, {
                    href: _ctx.route("offer.index")
                  }, {
                    default: withCtx(() => [
                      createTextVNode("Most recent")
                    ]),
                    _: 1
                  }, 8, ["href"]),
                  createVNode(_sfc_main$4, {
                    href: _ctx.route("offer.index", { order: 0 })
                  }, {
                    default: withCtx(() => [
                      createTextVNode("Cheapest")
                    ]),
                    _: 1
                  }, 8, ["href"]),
                  createVNode(_sfc_main$4, {
                    href: _ctx.route("offer.index", { order: 1 })
                  }, {
                    default: withCtx(() => [
                      createTextVNode("Most expensive")
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
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/OffersGrid.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = /* @__PURE__ */ Object.assign({ layout: _sfc_main$3 }, {
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    offers: Object
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$1, mergeProps({ offers: __props.offers }, _attrs), null, _parent));
    };
  }
});
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Offer/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
