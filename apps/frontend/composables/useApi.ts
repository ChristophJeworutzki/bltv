import hash from "object-hash";

export const useApi: typeof useFetch = (request, opts?) => {
  const config = useRuntimeConfig();
  const baseUrl = config?.public?.api?.baseUrl;

  if (!baseUrl) {
    console.warn(
      "[composables/useApi]:",
      'No "api.baseUrl" set in runtime config',
    );
  }

  const key = hash({ request, query: opts?.query });

  return useFetch(request, {
    key,
    getCachedData(key: string) {
      const { data } = useNuxtData(key);
      return data.value;
    },
    baseURL: baseUrl,
    ...opts,
  });
};
