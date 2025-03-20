<template>
  <section class="project-feed-section mt-[-50svh] sm:mt-[-25svh]">
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
