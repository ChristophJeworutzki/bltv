<template>
  <main class="flex min-h-dvh items-center justify-center">
    <h1 class="type-headline">
      {{ page?.title }}
    </h1>
  </main>
</template>

<script lang="ts" setup>
const { query } = useRoute();

const { data: page } = await useApi<Page>(`/api/v1/pages/contact`, {
  query: {
    preview: query.preview,
  },
});

useSeoMeta({
  title: page.value?.title,
});
</script>
