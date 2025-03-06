<template>
  <div class="base-grid">
    <slot />
  </div>
</template>

<style lang="postcss">
.base-grid {
  --gw: 100vw;
  --gc: 24;
  --gg: 0;
  --y-offset: 0;
  --x-offset: 0;

  width: 100%;
  overflow: hidden;
  display: grid;
  grid-template-columns: repeat(var(--gc), 1fr);
  grid-auto-rows: minmax(
    calc((100vh - (var(--y-offset) * 2)) / var(--gc)),
    max-content
  );
  grid-auto-flow: row dense;
  gap: 0 var(--gg);
  padding: 0 var(--x-offset);
}
</style>
