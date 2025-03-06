import { withQuery } from "ufo";
import type { ProviderGetImage } from "@nuxt/image";
import { createOperationsGenerator } from "#image";

const operationsGenerator = createOperationsGenerator({
  keyMap: {
    width: "w",
    height: "h",
  },
  joinWith: "&",
  formatter: (key: string, value: string) => `${key}=${value}`,
});

export const getImage: ProviderGetImage = (src, { modifiers = {} } = {}) => {
  const operations = operationsGenerator(modifiers);
  const params = new URLSearchParams(operations);
  const queryObject = Object.fromEntries(params.entries());
  return {
    url: withQuery(src, queryObject),
  };
};
