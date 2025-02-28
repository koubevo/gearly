import{y as g,C as x,d as i,a,f as n,b as d,v as y,u as t,t as v,e as l,g as u,w as f,m as _,T as h,h as k,o,P as V}from"./app-CuUtu08i.js";import{_ as S}from"./PrimaryButton-DjCCQ-7g.js";import{_ as b}from"./TinyText-CjSjlZie.js";const w={key:0,class:"input-error-message-style"},N={class:"mt-4"},B={key:0,class:"input-error-message-style"},C={key:0},E={class:"mt-2 text-sm text-gray-800"},P={class:"mt-2 text-sm font-medium text-green-600"},T={class:"flex items-center gap-4"},U={key:0,class:"text-sm text-gray-600"},I={__name:"UpdateProfileInformationForm",props:{mustVerifyEmail:{type:Boolean},status:{type:String}},setup(p){const m=g().props.auth.user,s=x({name:m.name,email:m.email});return(c,e)=>(o(),i("section",null,[a("header",null,[e[3]||(e[3]=a("h2",{class:"text-lg font-medium text-gray-900"}," Profile Information ",-1)),n(b,{text:"Update your profile information and email address."})]),a("form",{onSubmit:e[2]||(e[2]=k(r=>t(s).patch(c.route("profile.update")),["prevent"])),class:"mt-6 space-y-6"},[a("div",null,[d(a("input",{type:"text",placeholder:"Name",name:"name","onUpdate:modelValue":e[0]||(e[0]=r=>t(s).name=r),class:"input-style",required:""},null,512),[[y,t(s).name]]),t(s).errors.name?(o(),i("div",w,v(t(s).errors.name),1)):l("",!0)]),a("div",N,[d(a("input",{type:"email",placeholder:"Email",name:"email","onUpdate:modelValue":e[1]||(e[1]=r=>t(s).email=r),class:"input-style",required:""},null,512),[[y,t(s).email]]),t(s).errors.email?(o(),i("div",B,v(t(s).errors.email),1)):l("",!0)]),p.mustVerifyEmail&&t(m).email_verified_at===null?(o(),i("div",C,[a("p",E,[e[5]||(e[5]=u(" Your email address is unverified. ")),n(t(V),{href:c.route("verification.send"),method:"post",as:"button",class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"},{default:f(()=>e[4]||(e[4]=[u(" Click here to re-send the verification email. ")])),_:1},8,["href"])]),d(a("div",P," A new verification link has been sent to your email address. ",512),[[_,p.status==="verification-link-sent"]])])):l("",!0),a("div",T,[n(S,{disabled:t(s).processing},{default:f(()=>e[6]||(e[6]=[u("Save")])),_:1},8,["disabled"]),n(h,{"enter-active-class":"transition ease-in-out","enter-from-class":"opacity-0","leave-active-class":"transition ease-in-out","leave-to-class":"opacity-0"},{default:f(()=>[t(s).recentlySuccessful?(o(),i("p",U," Saved. ")):l("",!0)]),_:1})])],32)]))}};export{I as default};
