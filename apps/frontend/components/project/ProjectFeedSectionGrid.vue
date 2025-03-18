<template>
  <div class="project-feed-section-grid">
    <grid>
      <grid-item
        v-for="(layoutItem, index) in computedLayout"
        :key="index"
        :rect="layoutItem.rect"
        :sticky="index === 0"
        :inset="index !== 0"
      >
        <grid-item-box
          class="relative h-full"
          :style="getCssMediaAspectRatio(layoutItem.media)"
          :class="[index == 0 ? 'py-16' : '']"
          :first="index === 0"
        >
          <base-media
            :media="layoutItem.media"
            fill
            fit="contain"
            :video-quality="index === 0 ? 'hight' : 'low'"
          />
          <project-link :project="project" class="absolute inset-0" />
        </grid-item-box>
      </grid-item>
      <grid-item
        :rect="{
          x: 1,
          y: computedLastY,
          w: 24,
          h: 1,
        }"
        class="!pointer-events-none"
      />
    </grid>
  </div>
</template>

<script setup lang="ts">
interface Props {
  index: number;
  project: Project;
}

interface LayoutItem {
  rect: Rect;
  media: Media;
}

const props = defineProps<Props>();

const baseLayout = [
  { x: 3, y: 1, w: 20, h: 24 },
  { x: 1, y: 32, w: 6, h: 10 },
  { x: 19, y: 72, w: 6, h: 10 },
];

const computedLayout = computed<LayoutItem[]>(() => {
  if (!props.project?.preview?.length) return [];

  return props.project.preview.map((media, index) => {
    // Use default rect for this index or fall back to first item if index exceeds baseLayout length
    const baseRect = baseLayout[index] || baseLayout[baseLayout.length - 1];

    // For first item, just use the base rect
    if (index === 0) {
      return { rect: baseRect, media };
    }

    // For other items, calculate based on aspect ratio
    const ratio = getMediaAspectRatio(media);
    const orientation = getMediaOrientation(media);

    if (!ratio) return { rect: baseRect, media };

    const [w, h] = ratio.split(":").map(Number);

    // Adjust width if portrait orientation
    let width = baseRect.w;
    if (orientation === "portrait") {
      width = Math.max(width - 1, 1);
    }

    // Calculate height using aspect ratio with scaling factor
    const inverseRatio = h / w;
    const scalingFactor = 1.75;
    const height = Math.round(width * inverseRatio * scalingFactor);

    return {
      rect: {
        ...baseRect,
        w: width,
        h: height,
      },
      media,
    };
  });
});

const computedLastY = computed(() => {
  if (!computedLayout.value || computedLayout.value.length === 0) return 1;

  // Find the item with the lowest position (y + h)
  const maxBottom = computedLayout.value.reduce((max, item) => {
    const itemBottom = item.rect.y + item.rect.h;
    return Math.max(max, itemBottom);
  }, 1);

  // Add the height of the sticky first item (known to be 24)
  return maxBottom + 24;
});
</script>
