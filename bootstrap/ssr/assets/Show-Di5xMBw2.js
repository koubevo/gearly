import { mergeProps, unref, useSSRContext, ref, onMounted, withCtx, createTextVNode, toDisplayString, createVNode } from "vue";
import { ssrRenderAttrs, ssrInterpolate, ssrRenderList, ssrRenderComponent, ssrRenderAttr } from "vue/server-renderer";
import { usePage, Link } from "@inertiajs/vue3";
import { _ as _sfc_main$4 } from "./NormalText-ccMf7loH.js";
import axios from "axios";
import { D as Divider } from "./Divider-D99dPSph.js";
import { _ as _sfc_main$5 } from "./Heading3-q7V9h2MZ.js";
import { _ as _sfc_main$7 } from "./SmallText-bh_SH4m8.js";
import { _ as _sfc_main$6 } from "./PriceCard-sxzlgNGX.js";
import { PaperAirplaneIcon } from "@heroicons/vue/24/outline";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
const _sfc_main$3 = {
  __name: "Message",
  __ssrInlineRender: true,
  props: {
    message: Object
  },
  setup(__props) {
    var _a;
    const page = usePage();
    const currentUser = (_a = page.props.auth) == null ? void 0 : _a.user;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: ["px-3 py-2 inline-block max-w-[60%]", { "bg-primary-900 text-white self-end": __props.message.author_id === unref(currentUser).id, "bg-gray-200": __props.message.sender_id !== unref(currentUser).id }]
      }, _attrs))}>${ssrInterpolate(__props.message.message)}</div>`);
    };
  }
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Chat/Message.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = {
  __name: "ChatSection",
  __ssrInlineRender: true,
  props: {
    seller: Object,
    buyer: Object,
    offer: Object
  },
  setup(__props) {
    const props = __props;
    const messages = ref([]);
    async function loadInitialMessages() {
      try {
        const response = await axios.get(route("chat.load", { offer: props.offer, buyer: props.buyer }));
        messages.value = response.data.messages;
      } catch (error) {
        console.error("err");
      }
    }
    onMounted(() => {
      loadInitialMessages();
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({ class: "overflow-y-auto h-[80vh]" }, _attrs))}><div class="flex flex-col gap-2 items-start">`);
      if (messages.value.length) {
        _push(`<!--[-->`);
        ssrRenderList(messages.value, (message) => {
          _push(ssrRenderComponent(_sfc_main$3, {
            key: message.id,
            message
          }, null, _parent));
        });
        _push(`<!--]-->`);
      } else {
        _push(ssrRenderComponent(_sfc_main$4, { class: "text-center self-center mt-10 text-primary-900" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`Start the conversation with a message!`);
            } else {
              return [
                createTextVNode("Start the conversation with a message!")
              ];
            }
          }),
          _: 1
        }, _parent));
      }
      _push(`</div></section>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Chat/ChatSection.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = {
  __name: "InfoSection",
  __ssrInlineRender: true,
  props: {
    buyer: Object,
    seller: Object,
    offer: Object
  },
  setup(__props) {
    var _a;
    const page = usePage();
    const currentUser = (_a = page.props.auth) == null ? void 0 : _a.user;
    const props = __props;
    let name;
    if (currentUser.id === props.buyer.id) {
      name = props.seller.name;
    } else {
      name = props.buyer.name;
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({ class: "flex flex-col gap-4" }, _attrs))}>`);
      _push(ssrRenderComponent(unref(Link), {
        href: _ctx.route("offer.show", { offer: __props.offer })
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="flex gap-2 items-center"${_scopeId}><div${_scopeId}><img${ssrRenderAttr("src", __props.offer.thumbnail_url)}${ssrRenderAttr("alt", __props.offer.name)} class="h-14" loading="lazy"${_scopeId}></div><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$5, null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`${ssrInterpolate(__props.offer.name)}`);
                } else {
                  return [
                    createTextVNode(toDisplayString(__props.offer.name), 1)
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$6, {
              price: __props.offer.price,
              currency: __props.offer.currency
            }, null, _parent2, _scopeId));
            _push2(`</div></div>`);
          } else {
            return [
              createVNode("div", { class: "flex gap-2 items-center" }, [
                createVNode("div", null, [
                  createVNode("img", {
                    src: __props.offer.thumbnail_url,
                    alt: __props.offer.name,
                    class: "h-14",
                    loading: "lazy"
                  }, null, 8, ["src", "alt"])
                ]),
                createVNode("div", null, [
                  createVNode(_sfc_main$5, null, {
                    default: withCtx(() => [
                      createTextVNode(toDisplayString(__props.offer.name), 1)
                    ]),
                    _: 1
                  }),
                  createVNode(_sfc_main$6, {
                    price: __props.offer.price,
                    currency: __props.offer.currency
                  }, null, 8, ["price", "currency"])
                ])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(unref(Link), {
        href: _ctx.route("user.show", { user: __props.seller.id })
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="flex items-center gap-2"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$5, null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`${ssrInterpolate(unref(name))}`);
                } else {
                  return [
                    createTextVNode(toDisplayString(unref(name)), 1)
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(ssrRenderComponent(_sfc_main$7, null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`Rating`);
                } else {
                  return [
                    createTextVNode("Rating")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div>`);
          } else {
            return [
              createVNode("div", { class: "flex items-center gap-2" }, [
                createVNode(_sfc_main$5, null, {
                  default: withCtx(() => [
                    createTextVNode(toDisplayString(unref(name)), 1)
                  ]),
                  _: 1
                }),
                createVNode(_sfc_main$7, null, {
                  default: withCtx(() => [
                    createTextVNode("Rating")
                  ]),
                  _: 1
                })
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(ssrRenderComponent(Divider, { class: "md:w-full" }, null, _parent));
      _push(`</section>`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Chat/InfoSection.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "Show",
  __ssrInlineRender: true,
  props: {
    buyer: Object,
    seller: Object,
    offer: Object
  },
  setup(__props) {
    const message = ref("");
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(mergeProps({ class: "flex flex-col h-[calc(100vh-90px)] max-w-5xl mx-auto" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$1, {
        seller: __props.seller,
        offer: __props.offer,
        buyer: __props.buyer,
        class: "mb-4 flex-shrink-0"
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$2, {
        seller: __props.seller,
        offer: __props.offer,
        buyer: __props.buyer,
        class: "mb-4 flex-grow overflow-auto"
      }, null, _parent));
      _push(`<section class="flex items-center justify-between gap-4 flex-shrink-0"><input type="text" name="message"${ssrRenderAttr("value", message.value)} class="input-style" placeholder="Type a message..."><button>`);
      _push(ssrRenderComponent(unref(PaperAirplaneIcon), { class: "w-5 h-5 stroke-[2]" }, null, _parent));
      _push(`</button></section></section>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Chat/Show.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
