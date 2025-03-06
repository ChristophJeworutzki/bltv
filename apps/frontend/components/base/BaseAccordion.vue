<template>
  <details class="base-accordion" @toggle="onToggle" :open="open">
    <summary class="cursor-pointer select-none">
      <slot name="summery" :open="internalOpen" />
    </summary>
    <slot :open="internalOpen" />
  </details>
</template>

<script lang="ts" setup>
interface Props {
  open?: boolean;
}

const props = defineProps<Props>();

const internalOpen = ref(props.open);

function onToggle(event: Event) {
  internalOpen.value = (event.target as HTMLDetailsElement)?.open;
}
</script>

<style lang="postcss">
.base-accordion {
  summary {
    list-style-type: none;
  }
  summary::-webkit-details-marker,
  summary::marker {
    display: none;
  }
}
</style>
