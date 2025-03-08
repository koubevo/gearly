import { createI18n } from "vue-i18n";
import { messages } from "./lang/index";

const i18n = createI18n({
  legacy: false,
  locale: "cs", 
  fallbackLocale: "cs",
  messages,
});

export default i18n;