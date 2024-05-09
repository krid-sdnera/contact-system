import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify';

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  ssr: false,
  devtools: { enabled: true },
  runtimeConfig: {
    public: {
      baseApiUrl: `/api/v1`,
    },
  },
  vite: {
    optimizeDeps: {
      include: ['fast-deep-equal'],
    },
    vue: {
      template: {
        transformAssetUrls,
      },
    },
  },
  app: {
    /*
     ** Headers of the page
     ** Doc: https://vue-meta.nuxtjs.org/api/#metainfo-properties
     */
    head: {
      title: 'Contact System',
      meta: [],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
        {
          rel: 'stylesheet',
          type: 'text/css',
          // href: "https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css",
          href: '/materialdesignicons.min.css',
        },
      ],
    },
  },
  build: {
    transpile: ['vuetify'],
  },

  modules: [
    (_options, nuxt) => {
      nuxt.hooks.hook('vite:extendConfig', (config) => {
        // @ts-expect-error
        config.plugins.push(vuetify({ autoImport: true }));
      });
    },
    //...
  ],

  nitro: {
    devProxy: {
      '/api/v1/': {
        target: 'http://localhost:9999/',
        prependPath: false,
      },
    },
  },
});

export interface RuntimeConfig {
  public: {
    _app: {
      basePath: string;
      assetsPath: string;
      cdnURL: string;
    };
  };
  private: {};
}
