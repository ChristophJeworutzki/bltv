<template>
  <main class="min-h-svh">
    <page-hero
      :headline="page?.fields?.hero?.headline!"
      :media="page?.fields?.hero.media"
    />
  </main>
</template>

<script lang="ts" setup>
const { query } = useRoute();

const { data: page } = await useApi<Page>(`/api/v1/pages/events`, {
  query: {
    preview: query.preview,
  },
});

useSeoMeta({
  title: page.value?.title,
});
</script>
