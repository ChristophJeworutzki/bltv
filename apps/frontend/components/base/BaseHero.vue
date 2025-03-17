<template>
  <div ref="elRef" class="base-hero relative h-svh w-full clip-inset">
    <div
      class="relative z-10 flex h-svh items-center justify-center px-4 text-center opacity-[var(--opacity)]"
      :style="{
        '--opacity': mapValue(progress, 0, 0.33, 1, 0),
      }"
    >
      <slot />
    </div>
    <div class="absolute inset-0 z-0 bg-black">
      <base-media
        v-if="media"
        :media="media"
        fill
        class="translate-y-[var(--translate)] opacity-[var(--opacity)]"
        :style="{
          '--opacity': mapValue(progress, 0, 1, 0.6, 0),
          '--translate': `${mapValue(progress, 0, 1, 0, 20)}%`,
        }"
      />
    </div>
  </div>
</template>

<script lang="ts" setup>
import {
  useScroll,
  useElementBounding,
  useRafFn,
  useIntersectionObserver,
  defaultWindow,
} from "@vueuse/core";

interface Props {
  media?: Media;
}

defineProps<Props>();

const elRef = useTemplateRef("elRef");
const progress = shallowRef(0);

const { y } = useScroll(defaultWindow);
const { height } = useElementBounding(elRef);

const { pause, resume } = useRafFn(
  () => {
    progress.value = clampValue(y.value / height.value, 0, 1);
  },
  {
    immediate: false,
  },
);

useIntersectionObserver(elRef, ([{ isIntersecting }]) => {
  if (isIntersecting) {
    resume();
  } else {
    pause();
  }
});
</script>
