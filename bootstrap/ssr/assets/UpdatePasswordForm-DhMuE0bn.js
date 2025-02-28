import { ref, unref, withCtx, createTextVNode, useSSRContext } from "vue";
import { ssrRenderAttrs, ssrRenderComponent, ssrRenderAttr, ssrInterpolate } from "vue/server-renderer";
import { _ as _sfc_main$2 } from "./PrimaryButton-DRqOrSj4.js";
import { _ as _sfc_main$1 } from "./TinyText-DdKyE_L8.js";
import { useForm } from "@inertiajs/vue3";
const _sfc_main = {
  __name: "UpdatePasswordForm",
  __ssrInlineRender: true,
  setup(__props) {
    ref(null);
    ref(null);
    const form = useForm({
      current_password: "",
      password: "",
      password_confirmation: ""
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(_attrs)}><header><h2 class="text-lg font-medium text-gray-900"> Update Password </h2>`);
      _push(ssrRenderComponent(_sfc_main$1, { text: "Ensure your account is using a long, random password to stay secure." }, null, _parent));
      _push(`</header><form class="mt-6 space-y-6"><div class="mt-4"><input type="password" placeholder="Current password" name="current_password"${ssrRenderAttr("value", unref(form).current_password)} class="input-style" required>`);
      if (unref(form).errors.current_password) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(unref(form).errors.current_password)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="mt-4"><input type="password" placeholder="Password" name="password"${ssrRenderAttr("value", unref(form).password)} class="input-style" required>`);
      if (unref(form).errors.password) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(unref(form).errors.password)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="mt-4"><input type="password" placeholder="Password confirmation" name="password_confirmation"${ssrRenderAttr("value", unref(form).password_confirmation)} class="input-style" required>`);
      if (unref(form).errors.password_confirmation) {
        _push(`<div class="input-error-message-style">${ssrInterpolate(unref(form).errors.password_confirmation)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="flex items-center gap-4">`);
      _push(ssrRenderComponent(_sfc_main$2, {
        disabled: unref(form).processing
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`Save`);
          } else {
            return [
              createTextVNode("Save")
            ];
          }
        }),
        _: 1
      }, _parent));
      if (unref(form).recentlySuccessful) {
        _push(`<p class="text-sm text-gray-600"> Saved. </p>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></form></section>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Profile/Partials/UpdatePasswordForm.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
