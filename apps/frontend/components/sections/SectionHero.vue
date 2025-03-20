<template>
  <section class="section-hero">
    <base-hero :media="media">
      <h1
        class="type-headline [&>br]:hidden sm:[&>br]:block"
        v-html="headline"
      />
    </base-hero>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  headline: string;
  media: Media;
}

defineProps<Props>();
</script>
