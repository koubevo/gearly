import { unref, useSSRContext, ref, onMounted, watch, withCtx, createTextVNode, createVNode, withModifiers } from "vue";
import { ssrRenderAttr, ssrInterpolate, ssrRenderComponent } from "vue/server-renderer";
import { _ as _sfc_main$2 } from "./GuestLayout-B_RCzzgd.js";
import { _ as _sfc_main$5 } from "./PrimaryButton-DRqOrSj4.js";
import { useForm, Link } from "@inertiajs/vue3";
import { _ as _sfc_main$3, a as _sfc_main$4 } from "./RequiredFieldsNote-C7WE28xO.js";
/* empty css                    */
import vSelect from "vue-select";
import "./SmallText-bh_SH4m8.js";
const _sfc_main$1 = {
  __name: "LocationSelect",
  __ssrInlineRender: true,
  props: {
    name: String,
    labelName: String,
    modelValue: [String, Object],
    error: String,
    required: Boolean,
    options: Array
  },
  emits: ["update:modelValue"],
  setup(__props, { emit: __emit }) {
    const emit = __emit;
    const updateValue = (value) => {
      emit("update:modelValue", value);
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><label${ssrRenderAttr("for", __props.name)} class="mb-2 md:mb-0">${ssrInterpolate(__props.labelName)} `);
      if (__props.required) {
        _push(`<span class="required-star-style">*</span>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</label>`);
      _push(ssrRenderComponent(unref(vSelect), {
        options: __props.options,
        modelValue: __props.modelValue,
        name: __props.name,
        label: "name",
        "append-to-body": "",
        required: __props.required,
        reduce: (option) => option.name,
        "onUpdate:modelValue": updateValue
      }, null, _parent));
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Components/Form/LocationSelect.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "Register",
  __ssrInlineRender: true,
  setup(__props) {
    const form = useForm({
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      country: "",
      city: ""
    });
    const countries = ref([]);
    const cities = ref([]);
    onMounted(async () => {
      try {
        const response = await fetch("/api/countries");
        const result = await response.json();
        if (result.success) {
          countries.value = result.data;
        } else {
          console.error("Error fetching countries:", result.message);
        }
      } catch (error) {
        console.error("Error fetching countries:", error);
      }
    });
    watch(() => form.country, async (newCountry) => {
      if (newCountry) {
        const selectedCountry = countries.value.find((country) => country.name === newCountry);
        const iso2 = selectedCountry ? selectedCountry.iso2 : "";
        if (iso2) {
          try {
            const response = await fetch(`/api/cities?iso2=${iso2}`);
            const result = await response.json();
            if (result.success) {
              cities.value = result.data;
            } else {
              console.error("Error fetching cities:", result.message);
            }
          } catch (error) {
            console.error("Error fetching cities:", error);
          }
        }
      }
    });
    const submit = () => {
      form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation")
      });
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(ssrRenderComponent(_sfc_main$2, _attrs, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<form${_scopeId}><div${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, {
              name: "name",
              labelName: "Full Name",
              type: "text",
              modelValue: unref(form).name,
              "onUpdate:modelValue": ($event) => unref(form).name = $event,
              error: unref(form).errors.name,
              required: true
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="mt-4"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, {
              name: "email",
              labelName: "Email",
              type: "email",
              modelValue: unref(form).email,
              "onUpdate:modelValue": ($event) => unref(form).email = $event,
              error: unref(form).errors.email,
              required: true
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="mt-4"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, {
              name: "password",
              labelName: "Password",
              type: "password",
              modelValue: unref(form).password,
              "onUpdate:modelValue": ($event) => unref(form).password = $event,
              error: unref(form).errors.password,
              required: true
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="mt-4"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$3, {
              name: "password_confirmation",
              labelName: "Password Confirmation",
              type: "password",
              modelValue: unref(form).password_confirmation,
              "onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
              error: unref(form).errors.password_confirmation,
              required: true
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="mt-4 flex md:flex-row flex-col gap-2"${_scopeId}><div class="flex-1"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$1, {
              options: countries.value,
              modelValue: unref(form).country,
              "onUpdate:modelValue": ($event) => unref(form).country = $event,
              labelName: "Country",
              name: "country",
              required: true,
              error: unref(form).errors.country
            }, null, _parent2, _scopeId));
            _push2(`</div><div class="flex-1"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$1, {
              options: cities.value,
              modelValue: unref(form).city,
              "onUpdate:modelValue": ($event) => unref(form).city = $event,
              labelName: "City",
              name: "city",
              required: true,
              error: unref(form).errors.city
            }, null, _parent2, _scopeId));
            _push2(`</div></div><div class="my-1"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$4, null, null, _parent2, _scopeId));
            _push2(`</div><div class="mt-4 flex"${_scopeId}>`);
            _push2(ssrRenderComponent(_sfc_main$5, {
              class: { "opacity-25": unref(form).processing },
              disabled: unref(form).processing
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` Register `);
                } else {
                  return [
                    createTextVNode(" Register ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div><div class="mt-4"${_scopeId}>`);
            _push2(ssrRenderComponent(unref(Link), {
              href: _ctx.route("login"),
              class: "rounded-md text-sm underline hover:text-black focus:outline-none"
            }, {
              default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                if (_push3) {
                  _push3(` Already registered? `);
                } else {
                  return [
                    createTextVNode(" Already registered? ")
                  ];
                }
              }),
              _: 1
            }, _parent2, _scopeId));
            _push2(`</div></form>`);
          } else {
            return [
              createVNode("form", {
                onSubmit: withModifiers(submit, ["prevent"])
              }, [
                createVNode("div", null, [
                  createVNode(_sfc_main$3, {
                    name: "name",
                    labelName: "Full Name",
                    type: "text",
                    modelValue: unref(form).name,
                    "onUpdate:modelValue": ($event) => unref(form).name = $event,
                    error: unref(form).errors.name,
                    required: true
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"])
                ]),
                createVNode("div", { class: "mt-4" }, [
                  createVNode(_sfc_main$3, {
                    name: "email",
                    labelName: "Email",
                    type: "email",
                    modelValue: unref(form).email,
                    "onUpdate:modelValue": ($event) => unref(form).email = $event,
                    error: unref(form).errors.email,
                    required: true
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"])
                ]),
                createVNode("div", { class: "mt-4" }, [
                  createVNode(_sfc_main$3, {
                    name: "password",
                    labelName: "Password",
                    type: "password",
                    modelValue: unref(form).password,
                    "onUpdate:modelValue": ($event) => unref(form).password = $event,
                    error: unref(form).errors.password,
                    required: true
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"])
                ]),
                createVNode("div", { class: "mt-4" }, [
                  createVNode(_sfc_main$3, {
                    name: "password_confirmation",
                    labelName: "Password Confirmation",
                    type: "password",
                    modelValue: unref(form).password_confirmation,
                    "onUpdate:modelValue": ($event) => unref(form).password_confirmation = $event,
                    error: unref(form).errors.password_confirmation,
                    required: true
                  }, null, 8, ["modelValue", "onUpdate:modelValue", "error"])
                ]),
                createVNode("div", { class: "mt-4 flex md:flex-row flex-col gap-2" }, [
                  createVNode("div", { class: "flex-1" }, [
                    createVNode(_sfc_main$1, {
                      options: countries.value,
                      modelValue: unref(form).country,
                      "onUpdate:modelValue": ($event) => unref(form).country = $event,
                      labelName: "Country",
                      name: "country",
                      required: true,
                      error: unref(form).errors.country
                    }, null, 8, ["options", "modelValue", "onUpdate:modelValue", "error"])
                  ]),
                  createVNode("div", { class: "flex-1" }, [
                    createVNode(_sfc_main$1, {
                      options: cities.value,
                      modelValue: unref(form).city,
                      "onUpdate:modelValue": ($event) => unref(form).city = $event,
                      labelName: "City",
                      name: "city",
                      required: true,
                      error: unref(form).errors.city
                    }, null, 8, ["options", "modelValue", "onUpdate:modelValue", "error"])
                  ])
                ]),
                createVNode("div", { class: "my-1" }, [
                  createVNode(_sfc_main$4)
                ]),
                createVNode("div", { class: "mt-4 flex" }, [
                  createVNode(_sfc_main$5, {
                    class: { "opacity-25": unref(form).processing },
                    disabled: unref(form).processing
                  }, {
                    default: withCtx(() => [
                      createTextVNode(" Register ")
                    ]),
                    _: 1
                  }, 8, ["class", "disabled"])
                ]),
                createVNode("div", { class: "mt-4" }, [
                  createVNode(unref(Link), {
                    href: _ctx.route("login"),
                    class: "rounded-md text-sm underline hover:text-black focus:outline-none"
                  }, {
                    default: withCtx(() => [
                      createTextVNode(" Already registered? ")
                    ]),
                    _: 1
                  }, 8, ["href"])
                ])
              ], 32)
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
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/Auth/Register.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
export {
  _sfc_main as default
};
