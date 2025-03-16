<template>
  <div class="x-grid-item-box relative" :class="{ '-first': first }">
    <slot />
  </div>
</template>

<script lang="ts" setup>
interface Props {
  first: boolean;
}

defineProps<Props>();
</script>

<style lang="postcss">
@media (max-width: theme("screens.sm")) {
  .x-grid-item-box.-first {
    aspect-ratio: auto !important;
  }
}
</style>
