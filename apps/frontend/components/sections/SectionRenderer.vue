<template>
  <section>
    <template v-for="(section, index) in sections">
      <section-hero
        v-if="section.acf_fc_layout === 'hero' && section.hero"
        :key="`section-hero-${index}`"
        :headline="section.hero.headline"
        :media="section.hero.media"
      />
      <section-text
        v-else-if="section.acf_fc_layout === 'text' && section.text"
        :key="`section-text-${index}`"
        :text="section.text"
        :width="section.width"
      />
      <section-gallery
        v-else-if="section.acf_fc_layout === 'gallery' && section.gallery"
        :key="`section-gallery-${index}`"
        :gallery="section.gallery"
      />
      <section-stream
        v-else-if="section.acf_fc_layout === 'stream' && section.stream"
        :key="`section-stream-${index}`"
        :stream="section.stream"
      />
      <section-blocks
        v-else-if="section.acf_fc_layout === 'blocks' && section.blocks"
        :key="`section-blocks-${index}`"
        :columns="section.columns"
        :blocks="section.blocks"
      />
    </template>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  sections: {
    acf_fc_layout: string;
    [key: string]: any;
  }[];
}
defineProps<Props>();
</script>
