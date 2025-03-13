<template>
  <main class="min-h-dvh">
    <project-feed />
  </main>
</template>

<script lang="ts" setup>
const { query } = useRoute();

const { data: page } = await useApi<Page>(`/api/v1/pages/index`, {
  query: {
    preview: query.preview,
  },
});
</script>
