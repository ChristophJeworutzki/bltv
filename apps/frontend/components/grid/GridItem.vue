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
interface Props {
  rect: Rect;
  sticky?: boolean;
  inset?: boolean;
}

const props = defineProps<Props>();

const style = computed(() => {
  return {
    "--x": props.rect.x,
    "--y": props.rect.y,
    "--w": props.rect.w,
    "--h": props.rect.h,
    top: props.sticky ? "0" : undefined,
  };
});
</script>

<style lang="postcss">
.x-grid-item {
  grid-column: var(--x) / span var(--w);
  grid-row: var(--y) / span var(--h);
}
</style>
