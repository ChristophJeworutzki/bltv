<template>
  <section class="relative h-svh w-full">
    <div
      class="relative z-10 flex min-h-dvh items-center justify-center px-4 text-center"
    >
      <h1 class="type-headline" v-html="headline" />
    </div>
    <div class="absolute inset-0 z-0 bg-black">
      <base-media v-if="media" :media="media" fill class="opacity-60" />
    </div>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  headline: string;
  media: Media;
}
defineProps<Props>();
</script>
