// import this after install `@mdi/font` package
import '@mdi/font/css/materialdesignicons.css';

import '@/scss/variables.scss';
import { createVuetify } from 'vuetify';

export default defineNuxtPlugin((app) => {
  const vuetify = createVuetify({
    theme: {
      defaultTheme: 'dark',
    },
  });
  app.vueApp.use(vuetify);
});
