<template>
  <main class="min-h-svh">
    <section-renderer :sections="page?.fields?.sections" />
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
