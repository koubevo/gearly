import{C as f,i as p,c as y,w as s,o as a,a as i,d as g,e as v,f as r,g as n,n as _,u as o,P as x,h as b}from"./app-VWntmNPg.js";import{_ as h}from"./GuestLayout-CyqUMu9I.js";import{_ as k}from"./PrimaryButton-DikHGelx.js";const w={key:0,class:"mb-4 text-sm font-medium text-primary-900"},V={class:"mt-4 flex items-center justify-between"},E={__name:"VerifyEmail",props:{status:{type:String}},setup(d){const l=d,t=f({}),m=()=>{t.post(route("verification.send"))},u=p(()=>l.status==="verification-link-sent");return(c,e)=>(a(),y(h,null,{default:s(()=>[e[2]||(e[2]=i("div",{class:"mb-4 text-sm text-gray-600"}," Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another. ",-1)),u.value?(a(),g("div",w," A new verification link has been sent to the email address you provided during registration. ")):v("",!0),i("form",{onSubmit:b(m,["prevent"])},[i("div",V,[r(k,{class:_({"opacity-25":o(t).processing}),disabled:o(t).processing},{default:s(()=>e[0]||(e[0]=[n(" Resend Verification Email ")])),_:1},8,["class","disabled"]),r(o(x),{href:c.route("logout"),method:"post",as:"button",class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900"},{default:s(()=>e[1]||(e[1]=[n("Log Out")])),_:1},8,["href"])])],32)]),_:1}))}};export{E as default};
