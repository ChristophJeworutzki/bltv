<template>
  <nuxt-layout>
    <nuxt-page />
  </nuxt-layout>
</template>

<script lang="ts" setup>
const { globalData } = storeToRefs(useDataStore());
const { getImage } = useImage();

const { data } = await useApi<GlobalData>(`/api/v1/globals`);
globalData.value = data.value;

const ogImage = computed(() => {
  if (globalData.value?.seo?.image?.url) {
    return getImage(globalData.value.seo.image.url, {
      modifiers: {
        width: 1200,
        height: 630,
        fit: "crop",
      },
    })?.url;
  } else {
    return undefined;
  }
});

useSeoMeta({
  titleTemplate(title) {
    return title ? `${title} | BLTV GmbH` : "BLTV GmbH";
  },
  description: globalData.value?.seo?.description,
  ogSiteName: "BLTV",
  ogImage: ogImage,
  twitterCard: "summary_large_image",
  twitterImage: ogImage,
});
</script>
