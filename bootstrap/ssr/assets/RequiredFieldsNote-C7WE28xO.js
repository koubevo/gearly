import { ssrRenderAttr, ssrInterpolate, ssrIncludeBooleanAttr, ssrRenderComponent } from "vue/server-renderer";
import { computed, useSSRContext, withCtx, createVNode, createTextVNode } from "vue";
import { _ as _sfc_main$2 } from "./SmallText-bh_SH4m8.js";
const _sfc_main$1 = {
  __name: "FormInput",
  __ssrInlineRender: true,
  props: {
    name: String,
    labelName: String,
    type: String,
    modelValue: String,
    error: String,
    required: Boolean
  },
  emits: ["update:modelValue"],
  setup(__props) {
    const props = __props;
    const inputStep = computed(() => props.type === "number" ? "0.01" : null);
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><label${ssrRenderAttr("for", __props.name)} class="mb-2 md:mb-0">${ssrInterpolate(__props.labelName)} `);
      if (__props.required) {
        _push(`<span class="required-star-style">*</span>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</label><input${ssrRenderAttr("type", __props.type)}${ssrRenderAttr("name", __props.name)}${ssrRenderAttr("value", __props.modelValue)}${ssrRenderAttr("step", inputStep.value)}${ssrIncludeBooleanAttr(__props.required) ? " required" : ""} class="input-style">`);
      if (__props.error) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(__props.error)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/FormInput.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "RequiredFieldsNote",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$2, _attrs, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<span class="required-star-style"${_scopeId}>*</span> Required Fields`);
          } else {
            return [
              createVNode("span", { class: "required-star-style" }, "*"),
              createTextVNode(" Required Fields")
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/RequiredFieldsNote.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main$1 as _,
  _sfc_main as a
};
