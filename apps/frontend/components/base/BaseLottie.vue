<template>
  <div ref="el" class="base-lottie" />
</template>

<script lang="ts" setup>
import { useElementVisibility, isClient } from "@vueuse/core";
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

interface Props {
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
} = defineProps<Props>();

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

let lottie: any = null;

function addEventListener() {
  events?.forEach((event) => {
    animation.value?.addEventListener(event, (e: unknown) => {
      // @ts-expect-error
      emit(event, e);
    });
  });
}

function removeEventListener() {
  if (!animation.value) return;

  events.forEach((event) => {
    animation.value?.removeEventListener(event);
  });
}

async function init() {
  if (!isClient || !el.value) return;

  try {
    if (!lottie) {
      lottie = (await import("lottie-web")).default;
    }

    const path = typeof src === "string" ? src : undefined;
    const mappedSrc = typeof src === "object" ? src : undefined;

    animation.value = lottie.loadAnimation({
      container: el.value,
      renderer: "svg",
      loop: loop,
      autoplay: false,
      path: path,
      animationData: mappedSrc,
      rendererSettings: rendererSettingsMapped.value,
    });

    addEventListener();
  } catch (error) {
    console.error("Failed to initialize Lottie animation:", error);
  }
}

function play() {
  if (!animation.value) return;

  animation.value.play();
  state.started = true;
  state.paused = false;
  state.playing = true;
  state.ended = false;
}

function pause() {
  if (!animation.value) return;

  animation.value.pause();
  state.paused = true;
  state.playing = false;
}

defineExpose({
  play,
  pause,
  animation,
});

// Properly handle src changes
watch(
  () => src,
  async () => {
    if (!isClient) return;

    removeEventListener();
    animation.value?.destroy();
    await init();

    if (isVisible.value && autoplay) {
      play();
    }
  },
);

// Manage visibility and playback
watch(isVisible, (visible) => {
  if (!isClient) return;
  if (visible && autoplay) {
    play();
  } else {
    pause();
  }
});

// Clean up resources before component unmounts
onBeforeUnmount(() => {
  if (!isClient) return;
  removeEventListener();
  animation.value?.destroy();
});

onMounted(async () => {
  await init();
  if (isVisible.value && autoplay) {
    play();
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
