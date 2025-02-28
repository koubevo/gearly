import{b as _,m as v,o as d,d as u,a as i,t as w,p as y,q as V,r as b,k,v as x,C as $,c as h,w as f,f as a,u as s,s as S,g as q,n as M,h as P}from"./app-CuUtu08i.js";import{_ as B}from"./GuestLayout-WCTRJIz-.js";import{_ as C}from"./PrimaryButton-DjCCQ-7g.js";const U={class:"text-sm text-red-600"},m={__name:"InputError",props:{message:{type:String}},setup(t){return(r,e)=>_((d(),u("div",null,[i("p",U,w(t.message),1)],512)),[[v,t.message]])}},E={class:"block text-sm font-medium text-gray-700"},I={key:0},N={key:1},p={__name:"InputLabel",props:{value:{type:String}},setup(t){return(r,e)=>(d(),u("label",E,[t.value?(d(),u("span",I,w(t.value),1)):(d(),u("span",N,[y(r.$slots,"default")]))]))}},c={__name:"TextInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(t,{expose:r}){const e=V(t,"modelValue"),n=b(null);return k(()=>{n.value.hasAttribute("autofocus")&&n.value.focus()}),r({focus:()=>n.value.focus()}),(g,o)=>_((d(),u("input",{class:"rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500","onUpdate:modelValue":o[0]||(o[0]=l=>e.value=l),ref_key:"input",ref:n},null,512)),[[x,e.value]])}},R={class:"mt-4"},T={class:"mt-4"},D={class:"mt-4 flex items-center justify-end"},F={__name:"ResetPassword",props:{email:{type:String,required:!0},token:{type:String,required:!0}},setup(t){const r=t,e=$({token:r.token,email:r.email,password:"",password_confirmation:""}),n=()=>{e.post(route("password.store"),{onFinish:()=>e.reset("password","password_confirmation")})};return(g,o)=>(d(),h(B,null,{default:f(()=>[a(s(S),{title:"Reset Password"}),i("form",{onSubmit:P(n,["prevent"])},[i("div",null,[a(p,{for:"email",value:"Email"}),a(c,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":o[0]||(o[0]=l=>s(e).email=l),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(m,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),i("div",R,[a(p,{for:"password",value:"Password"}),a(c,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":o[1]||(o[1]=l=>s(e).password=l),required:"",autocomplete:"new-password"},null,8,["modelValue"]),a(m,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),i("div",T,[a(p,{for:"password_confirmation",value:"Confirm Password"}),a(c,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:s(e).password_confirmation,"onUpdate:modelValue":o[2]||(o[2]=l=>s(e).password_confirmation=l),required:"",autocomplete:"new-password"},null,8,["modelValue"]),a(m,{class:"mt-2",message:s(e).errors.password_confirmation},null,8,["message"])]),i("div",D,[a(C,{class:M({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:f(()=>o[3]||(o[3]=[q(" Reset Password ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{F as default};
