<template>
  <section class="section-feed relative">
    <div class="sticky top-0 z-10 flex h-svh w-full flex-col justify-center">
      <div class="container max-w-[54rem]">
        <div
          class="type-headline flex flex-col items-center justify-center gap-1 whitespace-nowrap leading-none"
        >
          <span>Es werde Licht.</span>
          <span>Que la lumière soit.</span>
          <span>Let there be light.</span>
          <span>光よあれ</span>
          <span>Laat daar Lig wees.</span>
        </div>
      </div>
    </div>
    <div class="relative z-10 -mt-[100svh] min-h-screen w-full px-1">
      <grid>
        <grid-item
          v-for="(item, index) in items"
          :rect="item.rect"
          :key="index"
        >
          <base-media :media="item.media" fill fit="contain" />
        </grid-item>
      </grid>
    </div>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  stream: Media[];
}

const { stream } = defineProps<Props>();

const layout = [
  { x: 16, y: 2, w: 8, h: 8 },
  { x: 1, y: 10, w: 8, h: 8 },
  { x: 17, y: 14, w: 8, h: 8 },
  { x: 4, y: 20, w: 8, h: 8 },
  { x: 14, y: 24, w: 8, h: 8 },
  { x: 2, y: 30, w: 8, h: 8 },
  { x: 17, y: 36, w: 8, h: 8 },
  { x: 6, y: 42, w: 8, h: 8 },
  { x: 16, y: 48, w: 8, h: 8 },
  { x: 1, y: 54, w: 8, h: 8 },
  { x: 17, y: 60, w: 8, h: 8 },
  { x: 4, y: 66, w: 8, h: 8 },
  { x: 14, y: 72, w: 8, h: 8 },
  { x: 2, y: 78, w: 8, h: 8 },
  { x: 17, y: 84, w: 8, h: 8 },
  { x: 6, y: 90, w: 8, h: 8 },
  { x: 16, y: 96, w: 8, h: 8 },
  { x: 1, y: 102, w: 8, h: 8 },
  { x: 17, y: 108, w: 8, h: 8 },
  { x: 4, y: 114, w: 8, h: 8 },
  { x: 14, y: 120, w: 8, h: 8 },
  { x: 2, y: 126, w: 8, h: 8 },
  { x: 17, y: 132, w: 8, h: 8 },
  { x: 6, y: 138, w: 8, h: 8 },
  { x: 16, y: 144, w: 8, h: 8 },
  { x: 1, y: 150, w: 8, h: 8 },
  { x: 17, y: 156, w: 8, h: 8 },
  { x: 4, y: 162, w: 8, h: 8 },
  { x: 14, y: 168, w: 8, h: 8 },
  { x: 2, y: 174, w: 8, h: 8 },
  { x: 17, y: 180, w: 8, h: 8 },
  { x: 6, y: 186, w: 8, h: 8 },
  { x: 16, y: 192, w: 8, h: 8 },
  { x: 1, y: 198, w: 8, h: 8 },
  { x: 17, y: 204, w: 8, h: 8 },
  { x: 4, y: 210, w: 8, h: 8 },
  { x: 14, y: 216, w: 8, h: 8 },
  { x: 2, y: 222, w: 8, h: 8 },
  { x: 17, y: 228, w: 8, h: 8 },
  { x: 6, y: 234, w: 8, h: 8 },
  { x: 16, y: 240, w: 8, h: 8 },
  { x: 1, y: 246, w: 8, h: 8 },
  { x: 17, y: 252, w: 8, h: 8 },
  { x: 4, y: 258, w: 8, h: 8 },
  { x: 14, y: 264, w: 8, h: 8 },
  { x: 2, y: 270, w: 8, h: 8 },
  { x: 17, y: 276, w: 8, h: 8 },
  { x: 6, y: 282, w: 8, h: 8 },
  { x: 16, y: 288, w: 8, h: 8 },
  { x: 1, y: 294, w: 8, h: 8 },
  { x: 17, y: 300, w: 8, h: 8 },
  { x: 4, y: 306, w: 8, h: 8 },
  { x: 14, y: 312, w: 8, h: 8 },
  { x: 2, y: 318, w: 8, h: 8 },
  { x: 17, y: 324, w: 8, h: 8 },
  { x: 6, y: 330, w: 8, h: 8 },
];

const items = computed(() => {
  if (!stream) return [];
  const slicedStream = stream.slice(0, layout.length);
  return slicedStream.map((item, index) => ({
    media: item,
    rect: {
      ...layout[index],
    },
  }));
});
</script>
