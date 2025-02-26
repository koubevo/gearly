import { mergeProps, unref, withCtx, createTextVNode, toDisplayString, createVNode, useSSRContext, ref, watch } from "vue";
import { ssrRenderAttrs, ssrRenderComponent, ssrRenderAttr, ssrInterpolate, ssrRenderList } from "vue/server-renderer";
import { Link, useForm } from "@inertiajs/vue3";
import { _ as _sfc_main$3 } from "./NormalText-ccMf7loH.js";
import { D as Divider } from "./Divider-D99dPSph.js";
import { ChevronRightIcon, MagnifyingGlassIcon } from "@heroicons/vue/24/outline";
import { _ as _sfc_main$4 } from "./PrimaryButton-DRqOrSj4.js";
import "./_plugin-vue_export-helper-1tPrXgE0.js";
const _sfc_main$2 = {
  __name: "CategoryItem",
  __ssrInlineRender: true,
  props: {
    category: Object
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-full my-0.5 flex flex-col justify-center" }, _attrs))}>`);
      _push(ssrRenderComponent(unref(Link), {
        class: "text-left w-full",
        href: _ctx.route("offer.index", { category: __props.category.id })
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="p-3 w-full flex flex-row justify-between items-center"${_scopeId}><div class="w-10 flex-shrink-0"${_scopeId}><img${ssrRenderAttr("src", "/storage/icons/" + __props.category.logo)} alt="Logo" class="w-full object-cover object-center scale-150"${_scopeId}></div><div class="flex-1 ps-4"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, null, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(`${ssrInterpolate(__props.category.name)} (${ssrInterpolate(__props.category.offers_count)})`);
                } else {
                  return [
                    createTextVNode(toDisplayString(__props.category.name) + " (" + toDisplayString(__props.category.offers_count) + ")", 1)
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
              createVNode("div", { class: "p-3 w-full flex flex-row justify-between items-center" }, [
                createVNode("div", { class: "w-10 flex-shrink-0" }, [
                  createVNode("img", {
                    src: "/storage/icons/" + __props.category.logo,
                    alt: "Logo",
                    class: "w-full object-cover object-center scale-150"
                  }, null, 8, ["src"])
                ]),
                createVNode("div", { class: "flex-1 ps-4" }, [
                  createVNode(_sfc_main$3, null, {
                    default: withCtx(() => [
                      createTextVNode(toDisplayString(__props.category.name) + " (" + toDisplayString(__props.category.offers_count) + ")", 1)
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
      _push(ssrRenderComponent(Divider, null, null, _parent));
      _push(`</div>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Search/CategoryItem.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = {
  __name: "SearchInput",
  __ssrInlineRender: true,
  props: {
    modelValue: String
  },
  emits: ["update:modelValue"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const emit = __emit;
    const search = ref(props.modelValue);
    watch(search, (newValue) => {
      emit("update:modelValue", newValue);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><label for="search-input" class="mb-2 md:mb-0">Search by text</label><div class="relative w-full inline-block mt-1"><span class="absolute inset-y-0 left-3 flex items-center">`);
      _push(ssrRenderComponent(unref(MagnifyingGlassIcon), { class: "w-5 h-5 stroke-[2.5]" }, null, _parent));
      _push(`</span><input type="text" placeholder="Search" class="pl-10 pr-10 input-style bg-white focus:ring-0 focus:border-black" id="search-input" name="search"${ssrRenderAttr("value", search.value)} required></div><!--]-->`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Search/SearchInput.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "Index",
  __ssrInlineRender: true,
  props: {
    categories: Array
  },
  setup(__props) {
    const searchForm = useForm({
      search: ""
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-full sm:w-2/3 md:w-1/2 mx-auto" }, _attrs))}><form>`);
      _push(ssrRenderComponent(_sfc_main$1, {
        modelValue: unref(searchForm).search,
        "onUpdate:modelValue": ($event) => unref(searchForm).search = $event
      }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$4, {
        text: "Search",
        class: "w-full md:w-auto mt-2"
      }, null, _parent));
      _push(`</form><div class="flex flex-col items-center py-6 w-full"><label for="search-input" class="w-full">Search by category</label><div class="w-full grid grid-cols-1 gap-1 md:grid-cols-2 mt-2"><!--[-->`);
      ssrRenderList(__props.categories, (category) => {
        _push(ssrRenderComponent(_sfc_main$2, {
          key: category.id,
          category
        }, null, _parent));
      });
      _push(`<!--]--></div></div></div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Search/Index.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
