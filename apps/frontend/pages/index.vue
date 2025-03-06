<template>
  <main class="flex min-h-dvh items-center justify-center">
    <h1 class="type-headline">
      We combine precision and creativity to deliver <br />
      exceptional light design for event productions.
    </h1>
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
