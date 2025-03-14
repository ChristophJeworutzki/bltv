<template>
  <nuxt-link
    v-if="link && isNormalLink"
    :to="link.url || '#'"
    :target="link.target"
    class="base-link"
  >
    <slot />
  </nuxt-link>
  <a
    v-else-if="link && isProjectLink"
    href="#"
    class="base-link"
    :class="{ 'cursor-wait': isPending }"
    @click.prevent="handleProjectClick"
  >
    <slot />
  </a>
  <template v-else>
    <slot />
  </template>
</template>

<script lang="ts" setup>
import { computed } from "vue";

interface Props {
  link?: Link;
}

const props = defineProps<Props>();

const { fetchProject } = useProjectStore();
const { isPending } = storeToRefs(useProjectStore());

const isProjectLink = computed(() => {
  return (
    props.link?.type === "post" &&
    props.link?.post_type === "project" &&
    !!props.link?.slug
  );
});

const isNormalLink = computed(() => {
  return props.link && !isProjectLink.value;
});

async function handleProjectClick() {
  if (!props.link?.slug || isPending.value) return;
  await fetchProject(props.link.slug);
}
</script>
