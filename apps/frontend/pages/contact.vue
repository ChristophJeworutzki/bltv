<template>
  <main class="min-h-svh">
    <section class="flex min-h-dvh items-center justify-center">
      <app-contact />
    </section>
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
