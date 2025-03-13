<template>
  <div ref="el" class="base-lottie" />
</template>

<script lang="ts" setup>
import { useElementVisibility } from "@vueuse/core";
import lottie from "lottie-web";

import type {
  AnimationItem,
  BMCompleteEvent,
  BMCompleteLoopEvent,
  BMDestroyEvent,
  BMEnterFrameEvent,
  BMSegmentStartEvent,
} from "lottie-web";

const defaultRendererSettings = {
  preserveAspectRatio: "xMidYMid slice",
  clearCanvas: true,
  progressiveLoad: false,
};

interface BaseLottieProps {
  src: Record<string, unknown> | string;
  loop?: boolean;
  autoplay?: boolean;
  rendererSettings?: Record<string, unknown>;
  events?: (
    | "complete"
    | "loopComplete"
    | "drawnFrame"
    | "enterFrame"
    | "segmentStart"
    | "config_ready"
    | "data_ready"
    | "data_failed"
    | "loaded_images"
    | "DOMLoaded"
    | "destroy"
  )[];
}

const {
  src,
  loop = false,
  autoplay = false,
  rendererSettings,
  events = ["complete"],
} = defineProps<BaseLottieProps>();

interface Emits {
  complete: [BMCompleteEvent];
  loopComplete: [BMCompleteLoopEvent];
  drawnFrame: [undefined];
  enterFrame: [BMEnterFrameEvent];
  segmentStart: [BMSegmentStartEvent];
  config_ready: [undefined];
  data_ready: [undefined];
  data_failed: [undefined];
  loaded_images: [undefined];
  destroy: [BMDestroyEvent];
}

const emit = defineEmits<Emits>();

const el = ref();
const animation = ref<AnimationItem>();
const state = reactive({
  started: false,
  playing: false,
  paused: false,
  visible: false,
  ended: false,
});

const isVisible = useElementVisibility(el);

const rendererSettingsMapped = computed(() => {
  return { ...defaultRendererSettings, ...rendererSettings };
});

function addEventListener() {
  events?.forEach((event) => {
    animation.value?.addEventListener(event, (e) => {
      // @ts-expect-error The event name is known
      emit(event, e);
    });
  });
}

function removeEventListener() {
  events.forEach((event) => {
    animation.value?.removeEventListener(event);
  });
}

async function init() {
  const path = typeof src === "string" ? src : undefined;
  const mappedSrc = typeof src === "object" ? src : undefined;
  animation.value = await lottie.loadAnimation({
    container: toRaw(el.value),
    renderer: "svg",
    loop: loop,
    autoplay: false,
    path: path,
    animationData: mappedSrc,
    rendererSettings: rendererSettingsMapped.value,
  });

  addEventListener();
}

function play() {
  animation.value?.play();
  state.started = true;
  state.paused = false;
  state.playing = true;
  state.ended = false;
}

function pause() {
  state.paused = true;
  state.playing = false;
}

onMounted(async () => {
  await init();
});

watch(
  () => src,
  async () => {
    animation.value?.destroy();
    await init();
    if (isVisible.value && autoplay) {
      play();
    }
  },
);

onBeforeUnmount(() => {
  removeEventListener();
  animation.value?.destroy();
});

watch(isVisible, (visible) => {
  if (visible && autoplay) {
    play();
  } else {
    pause();
  }
});
</script>

<style lang="postcss">
.base-lottie {
  position: relative;
  width: 100%;

  svg {
    height: 100%;
    path {
      fill: currentColor;
      stroke: currentColor;
    }
  }
}
</style>
