<template>
  <div class="x-grid">
    <slot />
  </div>
</template>

<style lang="postcss">
.x-grid {
  --gc: 24;
  --gg: 0.5rem;
  --y-offset: 0rem;
  --x-offset: 0.5rem;

  display: grid;
  grid-template-columns: repeat(var(--gc), 1fr);
  grid-auto-rows: minmax(
    calc((100lvh - (var(--y-offset))) / var(--gc)),
    max-content
  );

  grid-auto-flow: row dense;
  gap: 0 var(--gg);
  padding: 0 var(--x-offset);
  pointer-events: none;
}
</style>
