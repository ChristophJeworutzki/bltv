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

type Segment = [number, number];

interface Props {
  src: Record<string, unknown> | string;
  loop?: boolean;
  autoplay?: boolean;
  rendererSettings?: Record<string, unknown>;
  segments?: Segment | Segment[];
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
  segments,
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
const animationLoaded = ref(false);
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

  // Add DOMLoaded listener to know when animation is ready
  animation.value?.addEventListener("DOMLoaded", () => {
    animationLoaded.value = true;

    // Apply segments immediately if they exist and BEFORE playing
    if (segments && animation.value) {
      // First, go to the first frame
      animation.value.goToAndStop(0, true);

      // Then, set up the segments
      if (Array.isArray(segments) && Array.isArray(segments[0])) {
        // Multiple segments
        animation.value.setSegment(segments[0][0], segments[0][1]);
      } else if (Array.isArray(segments)) {
        // Single segment
        animation.value.setSegment(segments[0], segments[1]);
      }
    }

    // Now play if autoplay is enabled and animation is visible
    if (autoplay && isVisible.value) {
      playAnimation();
    }
  });
}

function removeEventListener() {
  if (!animation.value) return;

  events.forEach((event) => {
    animation.value?.removeEventListener(event);
  });

  animation.value?.removeEventListener("DOMLoaded");
}

async function init() {
  if (!isClient || !el.value) return;

  try {
    if (!lottie) {
      lottie = (await import("lottie-web")).default;
    }

    const path = typeof src === "string" ? src : undefined;
    const mappedSrc = typeof src === "object" ? src : undefined;

    // Reset animation loaded state
    animationLoaded.value = false;

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

function playAnimation() {
  if (!animation.value) return;

  if (segments) {
    playSegments();
  } else {
    animation.value.play();
  }

  state.started = true;
  state.paused = false;
  state.playing = true;
  state.ended = false;
}

function playSegments() {
  if (!animation.value || !segments) return;

  // Use forceFlag=true to ensure it plays the segments
  if (Array.isArray(segments) && Array.isArray(segments[0])) {
    // Multiple segments
    animation.value.playSegments(segments as Segment[], true);
  } else {
    // Single segment
    animation.value.playSegments(segments as Segment, true);
  }
}

function pause() {
  if (!animation.value) return;

  animation.value.pause();
  state.paused = true;
  state.playing = false;
}

function stop() {
  if (!animation.value) return;

  // Stop at first frame of segment or animation
  const firstFrame = segments
    ? Array.isArray(segments[0])
      ? segments[0][0]
      : segments[0]
    : 0;

  animation.value.goToAndStop(firstFrame, true);
  state.paused = false;
  state.playing = false;
  state.started = false;
}

defineExpose({
  play: playAnimation,
  pause,
  stop,
  playSegments,
  animation,
});

watch(
  () => src,
  async () => {
    if (!isClient) return;
    removeEventListener();
    animation.value?.destroy();
    await init();
  },
  { immediate: false },
);

watch(
  () => segments,
  () => {
    if (!isClient || !animation.value || !animationLoaded.value) return;

    // First stop the animation
    stop();

    // Then play segments with the updated segments
    if (state.playing || autoplay) {
      playSegments();
    }
  },
);

// Watch for changes in visibility
watch(isVisible, (visible) => {
  if (!isClient || !animationLoaded.value) return;

  if (visible && autoplay) {
    // If it's already playing, restart from beginning of segment
    if (state.playing) {
      stop();
    }
    playAnimation();
  } else if (!visible && state.playing) {
    pause();
  }
});

// Watch for animation loaded state
watch(animationLoaded, (loaded) => {
  if (loaded && isVisible.value && autoplay) {
    playAnimation();
  }
});

onBeforeUnmount(() => {
  if (!isClient) return;
  removeEventListener();
  animation.value?.destroy();
});

onMounted(async () => {
  await init();
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
