<template>
  <a
    :href="`/projects/${project.slug}`"
    :class="{ 'cursor-wait': isPending }"
    @click.prevent="handleProjectClick"
  >
    <slot />
  </a>
</template>

<script lang="ts" setup>
import { computed } from "vue";

interface Props {
  project: project;
}

const { project } = defineProps<Props>();

const { fetchProject } = useProjectStore();
const { isPending } = storeToRefs(useProjectStore());

async function handleProjectClick() {
  if (!project?.slug || isPending.value) return;
  await fetchProject(project.slug);
}
</script>
