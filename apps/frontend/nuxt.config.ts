import dotenv from "dotenv";
import svgLoader from "vite-svg-loader";

dotenv.config({ path: "./../../.env" });

export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: false },
  vite: {
    plugins: [
      svgLoader({
        svgoConfig: {
          multipass: true,
          plugins: [
            "removeDimensions",
            "sortAttrs",
            {
              name: "convertColors",
              params: {
                currentColor: true,
              },
            },
          ],
        },
      }),
    ],
  },
  app: {
    head: {
      meta: [{ name: "apple-mobile-web-app-title", content: "BLTV GmbH" }],
      link: [
        {
          rel: "icon",
          type: "image/png",
          href: "/favicon-96x96.png",
          sizes: "96x96",
        },
        { rel: "icon", type: "image/svg+xml", href: "/favicon.svg" },
        { rel: "shortcut icon", href: "/favicon.ico" },
        {
          rel: "apple-touch-icon",
          sizes: "180x180",
          href: "/apple-touch-icon.png",
        },
        { rel: "manifest", href: "/site.webmanifest" },
      ],
    },
  },
  router: {
    options: {
      linkActiveClass: "active",
      linkExactActiveClass: "exact-active",
    },
  },
  components: [{ path: "~/components", pathPrefix: false }],
  css: [
    "~/assets/fonts/aeonik-mono/stylesheet.css",
    "~/assets/fonts/denton-cond/stylesheet.css",
    "~/assets/css/main.css",
  ],
  plugins: ["~/plugins/video-player"],
  modules: ["@pinia/nuxt", "@nuxtjs/tailwindcss", "@maas/magic-image"],
  tailwindcss: {
    viewer: false,
  },
  magicImage: {
    image: {
      providers: {
        mux: {
          name: "mux",
          provider: "~/providers/image/mux.ts",
        },
      },
      provider: "weserv",
      weserv: {
        baseURL: "https://wsrv.nl",
      },
    },
  },
  runtimeConfig: {
    public: {
      api: {
        baseUrl: process.env.APP_URL,
      },
    },
  },
});
