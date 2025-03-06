<template>
  <div class="base-grid-item" :style="style">
    <slot />
  </div>
</template>

<script lang="ts" setup>
type Props = {
  rect: {
    x: number;
    y: number;
    w: number;
    h: number;
  };
};

const props = defineProps<Props>();

const style = computed(() => ({
  "--x": props.rect.x,
  "--y": props.rect.y,
  "--w": props.rect.w,
  "--h": props.rect.h,
}));
</script>

<style lang="postcss">
.base-grid-item {
  position: relative;
  grid-column: var(--x) / span var(--w);
  grid-row: var(--y) / span var(--h);
}
</style>
