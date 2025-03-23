<template>
  <div class="project-feed-section-grid mt-[-100lvh] pb-[25lvh] sm:mt-[-25lvh]">
    <grid>
      <grid-item
        v-for="(layoutItem, index) in computedLayout"
        :key="index"
        :rect="layoutItem.rect"
        :sm-rect="layoutItem.smRect"
        :sticky="index === 0"
        :inset="index !== 0"
        :class="{
          'z-0': index === 0,
          'z-10': index !== 0,
        }"
      >
        <div
          class="relative h-full"
          :style="getCssMediaAspectRatio(layoutItem.media)"
          :class="[index == 0 ? 'sm:p-16' : '']"
        >
          <base-media
            :media="layoutItem.media"
            fill
            fit="contain"
            :video-quality="index === 0 ? 'high' : 'low'"
          />
          <project-link :project="project" class="absolute inset-0" />
        </div>
      </grid-item>
      <grid-item
        :rect="{
          x: 1,
          y: computedLastY,
          w: 24,
          h: 1,
        }"
        :sm-rect="{
          x: 1,
          y: computedLastYSm,
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

interface Rect {
  x: number;
  y: number;
  w: number;
  h: number;
}

interface LayoutItem {
  rect: Rect;
  smRect: Rect;
  media: Media;
}

interface OrientationLayout {
  default: Rect;
  sm: Rect;
}

interface PositionConfig {
  portrait: OrientationLayout;
  landscape: OrientationLayout;
}

const props = defineProps<Props>();

const layoutConfig: PositionConfig[] = [
  {
    portrait: {
      default: { x: 1, y: 1, w: 24, h: 24 },
      sm: { x: 1, y: 1, w: 24, h: 24 },
    },
    landscape: {
      default: { x: 1, y: 1, w: 24, h: 24 },
      sm: { x: 1, y: 1, w: 24, h: 24 },
    },
  },
  {
    portrait: {
      default: { x: 1, y: 32, w: 6, h: 12 },
      sm: { x: 1, y: 24, w: 10, h: 12 },
    },
    landscape: {
      default: { x: 1, y: 32, w: 8, h: 8 },
      sm: { x: 1, y: 24, w: 12, h: 8 },
    },
  },
  {
    portrait: {
      default: { x: 18, y: 72, w: 6, h: 12 },
      sm: { x: 15, y: 48, w: 10, h: 12 },
    },
    landscape: {
      default: { x: 17, y: 72, w: 8, h: 8 },
      sm: { x: 14, y: 48, w: 12, h: 8 },
    },
  },
];

// Compute the layout based on available media
const computedLayout = computed<LayoutItem[]>(() => {
  if (!props.project?.preview?.length) return [];

  return props.project.preview.map((media, index) => {
    // Determine orientation and aspect ratio
    const orientation = getMediaOrientation(media);
    const ratio = getMediaAspectRatio(media);

    // Get configuration for this index position or use the last one if out of bounds
    const posConfig =
      index < layoutConfig.length
        ? layoutConfig[index]
        : layoutConfig[layoutConfig.length - 1];

    // Select layout based on orientation
    const orientationConfig =
      orientation === "portrait" ? posConfig.portrait : posConfig.landscape;

    // For first item or if no aspect ratio available, use the base configuration
    if (index === 0 || !ratio) {
      return {
        rect: orientationConfig.default,
        smRect: orientationConfig.sm,
        media,
      };
    }

    // For other items, calculate dynamic dimensions based on aspect ratio
    const [w, h] = ratio.split(":").map(Number);
    const inverseRatio = h / w;

    // Calculate adjusted dimensions for desktop
    const defaultRect = { ...orientationConfig.default };
    defaultRect.h = Math.round(defaultRect.w * (h / w) * 1.75);

    // Calculate adjusted dimensions for mobile
    const smRect = { ...orientationConfig.sm };
    smRect.h = Math.round(smRect.w * inverseRatio * 0.666);

    return {
      rect: defaultRect,
      smRect: smRect,
      media,
    };
  });
});

// Calculate the final Y position for the spacer item (desktop)
const computedLastY = computed(() => {
  if (!computedLayout.value || computedLayout.value.length === 0) return 1;
  return (
    computedLayout.value.reduce((max, item) => {
      const itemBottom = item.rect.y + item.rect.h;
      return Math.max(max, itemBottom);
    }, 1) + 24
  );
});

// Calculate the final Y position for the spacer item (mobile)
const computedLastYSm = computed(() => {
  if (!computedLayout.value || computedLayout.value.length === 0) return 1;
  return (
    computedLayout.value.reduce((max, item) => {
      const itemBottom = item.smRect.y + item.smRect.h;
      return Math.max(max, itemBottom);
    }, 1) + 24
  );
});
</script>
