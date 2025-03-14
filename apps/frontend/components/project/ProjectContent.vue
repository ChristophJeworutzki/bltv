<template>
  <div class="project-content relative z-50 min-h-dvh bg-black">
    <div
      class="sticky top-0 z-40 flex h-16 w-full items-center justify-between px-4"
    >
      <div
        class="flex items-center gap-4 rounded-lg bg-black/15 px-3 py-1.5 leading-none text-white backdrop-blur-3xl"
      >
        <span>{{ project.title }}</span>
        <span v-if="project.client">{{ project.client }}</span>
      </div>
      <button
        @click="$emit('close')"
        class="flex size-10 items-center justify-center rounded-full bg-black/15 text-white backdrop-blur-3xl"
      >
        <icon-x class="size-5" />
      </button>
    </div>
    <div class="-mt-20">
      <project-gallery :gallery="project.gallery!" />
      <project-credits :credits="project.credits!" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import IconX from "~/assets/svg/icons/x.svg";

type Props = {
  project: Project;
};

defineProps<Props>();
defineEmits(["close"]);
</script>
