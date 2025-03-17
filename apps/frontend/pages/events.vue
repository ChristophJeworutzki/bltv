<template>
  <main class="min-h-svh">
    <base-hero :media="page?.fields?.hero.media">
      <h1 class="type-headline" v-html="page?.fields?.hero.headline" />
    </base-hero>
  </main>
</template>

<script lang="ts" setup>
const { query } = useRoute();

const { data: page, error } = await useApi<Page>(`/api/v1/pages/events`, {
  query: {
    preview: query.preview,
  },
});

if (error.value) throw createError({ ...error.value, fatal: true });

useSeoMeta({
  title: "Events",
});
</script>
