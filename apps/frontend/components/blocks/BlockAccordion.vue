<template>
  <div class="block-accordion flex flex-col gap-2">
    <h2 v-if="headline" class="type-headline">
      {{ headline }}
    </h2>
    <div v-if="items.length" class="flex flex-col border-t">
      <base-accordion v-for="(item, index) in items" :key="index">
        <template #summery>
          <h3>{{ item.title }}</h3>
        </template>
        <p v-html="item.content" />
      </base-accordion>
    </div>
  </div>
</template>

<script lang="ts" setup>
interface Props {
  headline: string;
  items: {
    title: string;
    content: string;
  }[];
}

defineProps<Props>();
</script>
