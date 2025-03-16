<template>
  <section class="project-feed-section mt-[-12.5svh]">
    <project-feed-section-title :project="project" />
    <project-feed-section-grid :index="index" :project="project" />
  </section>
</template>

<script lang="ts" setup>
interface Props {
  index: number;
  project: Project;
}

defineProps<Props>();
</script>
