<template>
  <div
    class="x-grid-item-box absolute left-0 right-0 top-1/2 mx-auto max-h-full max-w-full -translate-y-1/2"
    :class="{ '-first': first }"
  >
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
