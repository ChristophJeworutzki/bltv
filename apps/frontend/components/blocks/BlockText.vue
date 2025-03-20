<template>
  <div class="block-text">
    <div class="prose" v-html="text" />
  </div>
</template>

<script lang="ts" setup>
interface Props {
  text: string;
}

defineProps<Props>();
</script>
