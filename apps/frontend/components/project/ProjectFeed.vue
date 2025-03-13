<template>
  <div class="project-feed relative z-20 select-none pb-72">
    <project-feed-section
      v-for="(project, index) in computedProjects"
      :key="index"
      :index="index"
      :project="project"
    />
  </div>
</template>

<script lang="ts" setup>
const { data: collection } =
  await useApi<ProjectCollection>(`/api/v1/projects`);

const computedProjects = computed(() => {
  return collection?.value?.data?.filter((project) => project?.preview?.length);
});
</script>
