<template>
  <main class="min-h-svh">
    <base-hero :media="page?.fields?.hero.media">
      <h1
        class="type-headline [&>br]:hidden sm:[&>br]:block"
        v-html="page?.fields?.hero.headline"
      />
    </base-hero>
    <section-text />
    <section-blocks />
    <section-feed />
  </main>
</template>

<script lang="ts" setup>
const { query } = useRoute();

const { data: page } = await useApi<Page>(`/api/v1/pages/about`, {
  query: {
    preview: query.preview,
  },
});

useSeoMeta({
  title: "About",
});
</script>
