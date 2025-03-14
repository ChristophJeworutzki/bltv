<template>
  <div
    class="project-feed-title sticky inset-0 z-10 flex h-dvh w-full items-center justify-center"
  >
    <a
      :href="`/projects/${project.slug}`"
      class="flex w-full max-w-2xl flex-col items-center gap-4 px-2 py-12 text-center"
      @click.prevent="openProject"
    >
      <h2 class="type-headline">{{ project.title }}</h2>
      <div class="w-full border-b border-t py-1">
        {{ project.client }}
      </div>
    </a>
  </div>
</template>

<script setup lang="ts">
interface Props {
  project: Project;
}

const { project } = defineProps<Props>();

const { fetchProject } = useProjectStore();
const { isPending } = storeToRefs(useProjectStore());

async function openProject() {
  if (!project?.slug || isPending.value) return;
  await fetchProject(project.slug);
}
</script>
