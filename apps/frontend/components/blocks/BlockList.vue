<template>
  <div class="block-list flex flex-col gap-2">
    <h2 v-if="headline" class="type-headline">
      {{ headline }}
    </h2>
    <ul v-if="items.length" class="border-b">
      <li
        v-for="({ title }, index) in items"
        :key="index"
        class="border-t py-1"
      >
        {{ title }}
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
interface Props {
  headline: string;
  items: {
    title: string;
  }[];
}

defineProps<Props>();
</script>
