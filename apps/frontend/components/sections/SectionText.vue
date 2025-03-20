<template>
  <section class="section-text py-8">
    <div class="container">
      <div
        class="prose"
        :class="{
          'md:w-3/4': width === '3/4',
          'md:w-1/2': width === '1/2',
          'md:w-1/2 lg:w-1/3': width === '1/3',
        }"
        v-html="text"
      />
    </div>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  text: string;
  width?: string;
}

defineProps<Props>();
</script>
