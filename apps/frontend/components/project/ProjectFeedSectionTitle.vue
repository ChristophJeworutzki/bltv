<template>
  <div
    class="project-feed-title sticky inset-0 z-10 flex h-dvh w-full items-center justify-center"
  >
    <nuxt-link
      :to="`/project/${project.slug}`"
      class="flex w-full max-w-2xl flex-col items-center gap-4 px-2 py-12 text-center"
    >
      <h2 class="type-headline">{{ project.title }}</h2>
      <div class="w-full border-b border-t py-1">BSTN x NIKE</div>
    </nuxt-link>
  </div>
</template>

<script setup lang="ts">
interface Props {
  project: Project;
}

defineProps<Props>();
</script>
