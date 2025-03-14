<template>
  <main class="min-h-svh">
    <project-content :project="project!" @close="$router.push('/')" />
  </main>
</template>

<script lang="ts" setup>
definePageMeta({
  layout: "blank",
});

const { params, query } = useRoute();

const { data: project, error } = await useApi<Project>(
  `/api/v1/projects/${params.slug}`,
  {
    query: {
      preview: query.preview,
    },
  },
);

if (error.value) throw createError({ ...error.value, fatal: true });

useSeoMeta({
  title: project.value?.title,
});
</script>
