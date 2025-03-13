<template>
  <div class="project-feed-section-grid relative w-full">
    <grid>
      <grid-item
        v-for="(media, index) in project?.preview"
        :key="index"
        :rect="getRect(index)"
        :sticky="index === 0"
        :inset="index !== 0"
      >
        <grid-item-box
          class="h-full"
          :style="getCssMediaAspectRatio(media)"
          :class="[index !== 0 ? 'h-full sm:h-auto' : 'py-16']"
          :first="index === 0"
        >
          <base-media :media="media" fill fit="contain" />
        </grid-item-box>
      </grid-item>
      <grid-item
        :rect="{
          x: 1,
          y: computedLastY,
          w: 24,
          h: 1,
        }"
        class="!pointer-events-none z-0"
      />
    </grid>
  </div>
</template>

<script setup lang="ts">
interface Props {
  index: number;
  project: Project;
}

defineProps<Props>();

const defaultLayout = [
  { x: 3, y: 1, w: 20, h: 24 },
  { x: 1, y: 32, w: 6, h: 10 },
  { x: 19, y: 72, w: 6, h: 10 },
];

const computedLastY = computed(() => {
  return defaultLayout.reduce((acc, { y }) => acc + y, 1);
});

function getRect(index: number) {
  return defaultLayout[index];
}
</script>
