import plugin from "tailwindcss/plugin";

/** @type {import('tailwindcss').Config} */
export default {
  future: {
    hoverOnlyWhenSupported: true,
  },
  theme: {
    container: {
      center: true,
      padding: "0.5rem",
      screens: false,
    },
    colors: {
      transparent: "transparent",
      current: "currentColor",
      black: "#000000",
      white: "#FFFFFF",
    },
    fontFamily: {
      monospace: ["Aeonik Mono", "monospace"],
      serif: ["Denton Text Cond", "serif"],
    },
  },
  plugins: [
    plugin(function ({ addBase, addComponents, addUtilities, theme }) {
      addBase({
        "*": {
          "@apply antialiased": "",
        },
        body: {
          backgroundColor: theme("colors.black"),
          color: theme("colors.white"),
          fontFamily: theme("fontFamily.monospace"),
          fontSize: "0.75rem",
          textTransform: "uppercase",
        },
      });
      addUtilities({
        ".no-scrollbar": {
          scrollbarWidth: "none",
          "-ms-overflow-style": "none",
          "&::-webkit-scrollbar": {
            display: "none",
          },
        },
        ".clip-inset": {
          "clip-path": "inset(0)",
        },
      });
      addComponents({
        ".type-display": {
          fontFamily: theme("fontFamily.serif"),
          fontSize: "2.5rem",
          lineHeight: "1.1",
          letterSpacing: "-0.0125em",
          textTransform: "none",
          "@screen sm": {
            fontSize: "3rem",
          },
        },
        ".type-headline": {
          fontFamily: theme("fontFamily.serif"),
          fontSize: "1.5rem",
          lineHeight: "1",
          letterSpacing: "-0.0125em",
          textTransform: "none",
          "@screen sm": {
            fontSize: "2rem",
          },
        },
        ".type-headline-sm": {
          fontFamily: theme("fontFamily.serif"),
          fontSize: "1.125rem",
          lineHeight: "1.1",
          letterSpacing: "-0.0125em",
          textTransform: "none",
          "@screen sm": {
            fontSize: "1.5rem",
          },
        },
      });
    }),
  ],
};
