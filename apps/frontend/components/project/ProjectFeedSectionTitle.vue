<template>
  <div
    class="project-feed-title pointer-events-none sticky inset-0 z-20 flex h-lvh w-full items-center justify-center"
  >
    <div
      class="pointer-events-auto relative flex w-full max-w-xs flex-col items-center gap-4 p-2 text-center sm:max-w-xl"
    >
      <h2 class="type-headline">{{ project.title }}</h2>
      <div class="w-full border-b border-t py-1">
        {{ project.client }}
      </div>
      <project-link :project="project" class="absolute inset-0" />
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  project: Project;
}

defineProps<Props>();
</script>
