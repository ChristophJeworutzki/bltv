<template>
  <section class="section-blocks py-8">
    <div class="container">
      <div
        class="grid gap-x-4 gap-y-8"
        :class="{
          'sm:grid-cols-2': columns === '2',
          'md:grid-cols-3': columns === '3',
          'sm:grid-cols-2 lg:grid-cols-4': columns === '4',
        }"
      >
        <template v-for="(block, index) in blocks">
          <block-list
            v-if="block.acf_fc_layout === 'list'"
            :key="`block-list-${index}`"
            :headline="block.headline"
            :items="block.items"
          />
          <block-accordion
            v-else-if="block.acf_fc_layout === 'accordion'"
            :key="`block-accordion-${index}`"
            :headline="block.headline"
            :items="block.items"
          />
          <block-text
            v-else-if="block.acf_fc_layout === 'text'"
            :key="`block-text-${index}`"
            :text="block.text"
          />
        </template>
      </div>
    </div>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  columns?: string;
  blocks: {
    acf_fc_layout: string;
    [key: string]: any;
  }[];
}

defineProps<Props>();
</script>
