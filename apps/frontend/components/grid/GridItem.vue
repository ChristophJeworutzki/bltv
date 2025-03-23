<template>
  <div
    class="x-grid-item"
    :class="[
      props.sticky ? 'sticky' : 'relative',
      props.inset ? 'inset' : undefined,
    ]"
    :style="style"
  >
    <div class="absolute inset-0">
      <slot />
    </div>
  </div>
</template>

<script lang="ts" setup>
interface Rect {
  x: number;
  y: number;
  w: number;
  h: number;
}

interface Props {
  rect: Rect;
  smRect?: Rect;
  sticky?: boolean;
  inset?: boolean;
}

const props = defineProps<Props>();

const style = computed(() => {
  // Default rect values
  const defaultRect = {
    "--x": props.rect.x,
    "--y": props.rect.y,
    "--w": props.rect.w,
    "--h": props.rect.h,
    top: props.sticky ? "0" : undefined,
  };

  // Add sm breakpoint values if provided
  if (props.smRect) {
    return {
      ...defaultRect,
      "--sm-x": props.smRect.x,
      "--sm-y": props.smRect.y,
      "--sm-w": props.smRect.w,
      "--sm-h": props.smRect.h,
    };
  }

  return defaultRect;
});
</script>

<style lang="postcss">
.x-grid-item {
  grid-column: var(--x) / span var(--w);
  grid-row: var(--y) / span var(--h);
}

@media (max-width: 640px) {
  .x-grid-item {
    grid-column: var(--sm-x, var(--x)) / span var(--sm-w, var(--w));
    grid-row: var(--sm-y, var(--y)) / span var(--sm-h, var(--h));
  }
}
</style>
