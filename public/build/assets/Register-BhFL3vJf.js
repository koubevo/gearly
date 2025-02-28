import{o as p,d as y,a,g as _,t as w,e as g,f as l,u as o,F as h,C as x,r as b,k as N,l as q,c as C,w as V,n as $,P as k,h as S}from"./app-CuUtu08i.js";import{_ as U}from"./GuestLayout-WCTRJIz-.js";import{_ as E}from"./PrimaryButton-DjCCQ-7g.js";import{_ as c,a as B}from"./RequiredFieldsNote-CdTle3tF.js";import{C as F}from"./vue-select.es-DUTJBfwF.js";import"./SmallText-DFt21Vfu.js";const P=["for"],j={key:0,class:"required-star-style"},A={key:0,class:"input-error-message-style"},v={__name:"LocationSelect",props:{name:String,labelName:String,modelValue:[String,Object],error:String,required:Boolean,options:Array},emits:["update:modelValue"],setup(t,{emit:e}){const i=e,d=m=>{i("update:modelValue",m)};return(m,n)=>(p(),y(h,null,[a("label",{for:t.name,class:"mb-2 md:mb-0"},[_(w(t.labelName)+" ",1),t.required?(p(),y("span",j,"*")):g("",!0)],8,P),l(o(F),{options:t.options,modelValue:t.modelValue,name:t.name,label:"name","append-to-body":"",required:t.required,reduce:r=>r.name,"onUpdate:modelValue":d},null,8,["options","modelValue","name","required","reduce"]),t.error?(p(),y("div",A,w(t.error),1)):g("",!0)],64))}},M={class:"mt-4"},R={class:"mt-4"},z={class:"mt-4"},D={class:"mt-4 flex md:flex-row flex-col gap-2"},L={class:"flex-1"},O={class:"flex-1"},T={class:"my-1"},G={class:"mt-4 flex"},H={class:"mt-4"},Y={__name:"Register",setup(t){const e=x({name:"",email:"",password:"",password_confirmation:"",country:"",city:""}),i=b([]),d=b([]);N(async()=>{try{const r=await(await fetch("/api/countries")).json();r.success?i.value=r.data:console.error("Error fetching countries:",r.message)}catch(n){console.error("Error fetching countries:",n)}}),q(()=>e.country,async n=>{if(n){const r=i.value.find(u=>u.name===n),s=r?r.iso2:"";if(s)try{const f=await(await fetch(`/api/cities?iso2=${s}`)).json();f.success?d.value=f.data:console.error("Error fetching cities:",f.message)}catch(u){console.error("Error fetching cities:",u)}}});const m=()=>{e.post(route("register"),{onFinish:()=>e.reset("password","password_confirmation")})};return(n,r)=>(p(),C(U,null,{default:V(()=>[a("form",{onSubmit:S(m,["prevent"])},[a("div",null,[l(c,{name:"name",labelName:"Full Name",type:"text",modelValue:o(e).name,"onUpdate:modelValue":r[0]||(r[0]=s=>o(e).name=s),error:o(e).errors.name,required:!0},null,8,["modelValue","error"])]),a("div",M,[l(c,{name:"email",labelName:"Email",type:"email",modelValue:o(e).email,"onUpdate:modelValue":r[1]||(r[1]=s=>o(e).email=s),error:o(e).errors.email,required:!0},null,8,["modelValue","error"])]),a("div",R,[l(c,{name:"password",labelName:"Password",type:"password",modelValue:o(e).password,"onUpdate:modelValue":r[2]||(r[2]=s=>o(e).password=s),error:o(e).errors.password,required:!0},null,8,["modelValue","error"])]),a("div",z,[l(c,{name:"password_confirmation",labelName:"Password Confirmation",type:"password",modelValue:o(e).password_confirmation,"onUpdate:modelValue":r[3]||(r[3]=s=>o(e).password_confirmation=s),error:o(e).errors.password_confirmation,required:!0},null,8,["modelValue","error"])]),a("div",D,[a("div",L,[l(v,{options:i.value,modelValue:o(e).country,"onUpdate:modelValue":r[4]||(r[4]=s=>o(e).country=s),labelName:"Country",name:"country",required:!0,error:o(e).errors.country},null,8,["options","modelValue","error"])]),a("div",O,[l(v,{options:d.value,modelValue:o(e).city,"onUpdate:modelValue":r[5]||(r[5]=s=>o(e).city=s),labelName:"City",name:"city",required:!0,error:o(e).errors.city},null,8,["options","modelValue","error"])])]),a("div",T,[l(B)]),a("div",G,[l(E,{class:$({"opacity-25":o(e).processing}),disabled:o(e).processing},{default:V(()=>r[6]||(r[6]=[_(" Register ")])),_:1},8,["class","disabled"])]),a("div",H,[l(o(k),{href:n.route("login"),class:"rounded-md text-sm underline hover:text-black focus:outline-none"},{default:V(()=>r[7]||(r[7]=[_(" Already registered? ")])),_:1},8,["href"])])],32)]),_:1}))}};export{Y as default};
