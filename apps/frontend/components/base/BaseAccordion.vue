<template>
  <details
    class="base-accordion flex flex-col border-b"
    @toggle="onToggle"
    :open="open"
  >
    <summary
      class="flex cursor-pointer select-none justify-between py-2 pr-1 leading-none"
    >
      <slot name="summery" :open="internalOpen" />
      <span v-if="internalOpen" aria-hidden="true">-</span>
      <span v-else aria-hidden="true">+</span>
    </summary>
    <div v-show="internalOpen" class="pb-4 pt-2">
      <slot :open="internalOpen" />
    </div>
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
