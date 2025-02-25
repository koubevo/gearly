import { mergeProps, useSSRContext, computed, ref, watch, unref } from "vue";
import { ssrRenderAttrs, ssrInterpolate, ssrRenderSlot, ssrRenderComponent } from "vue/server-renderer";
import { usePage } from "@inertiajs/vue3";
import "@inertiajs/inertia";
import { HeartIcon as HeartIcon$1 } from "@heroicons/vue/24/solid";
import { HeartIcon } from "@heroicons/vue/24/outline";
import { _ as _sfc_main$4 } from "./NormalText-ccMf7loH.js";
const _sfc_main$3 = {
  __name: "Heading2",
  __ssrInlineRender: true,
  props: {
    text: String
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<h2${ssrRenderAttrs(mergeProps({ class: "heading2-style" }, _attrs))}>${ssrInterpolate(__props.text)} `);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</h2>`);
    };
  }
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Text/Heading2.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const _sfc_main$2 = {
  __name: "Heading3",
  __ssrInlineRender: true,
  props: {
    text: String
  },
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<h3${ssrRenderAttrs(mergeProps({ class: "heading3-style" }, _attrs))}>${ssrInterpolate(__props.text)} `);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</h3>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Text/Heading3.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const _sfc_main$1 = {
  __name: "Condition",
  __ssrInlineRender: true,
  props: {
    condition: String
  },
  setup(__props) {
    const props = __props;
    const conditionClass = computed(() => {
      switch (props.condition) {
        case "new":
          return "bg-primary-900 text-white";
        case "used":
          return "bg-yellow-500 text-black";
        case "damaged":
          return "bg-red-500 text-white";
      }
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<span${ssrRenderAttrs(mergeProps({
        class: ["h-full uppercase font-medium inline-block px-2", conditionClass.value]
      }, _attrs))}>${ssrInterpolate(__props.condition)}</span>`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/Condition.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "ConditionLike",
  __ssrInlineRender: true,
  props: {
    offer: Object
  },
  setup(__props) {
    const props = __props;
    computed(() => usePage().props.auth.user);
    const isFavorited = ref(props.offer.favorited_by_user);
    const favoritesCount = ref(props.offer.favorites_count);
    watch(() => props.offer.favorited_by_user, (newVal) => {
      isFavorited.value = newVal;
    });
    watch(() => props.offer.favorites_count, (newVal) => {
      favoritesCount.value = newVal;
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<span${ssrRenderAttrs(mergeProps({ class: "flex align-middle items-center" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$1, {
        condition: __props.offer.condition,
        class: "me-2"
      }, null, _parent));
      _push(`<button method="POST" class="hover:text-primary-900">`);
      if (!isFavorited.value) {
        _push(ssrRenderComponent(unref(HeartIcon), { class: "w-7 h-7" }, null, _parent));
      } else {
        _push(ssrRenderComponent(unref(HeartIcon$1), { class: "w-7 h-7 fill-primary-900" }, null, _parent));
      }
      _push(`</button>`);
      if (favoritesCount.value > 0) {
        _push(ssrRenderComponent(_sfc_main$4, {
          text: favoritesCount.value,
          class: "ms-1"
        }, null, _parent));
      } else {
        _push(`<!---->`);
      }
      _push(`</span>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Offer/ConditionLike.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main$3 as _,
  _sfc_main$2 as a,
  _sfc_main as b
};
