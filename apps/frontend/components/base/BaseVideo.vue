<template>
  <div
    ref="el"
    class="base-video group w-full"
    :class="[fill ? 'absolute h-full' : 'relative']"
    :style="computedStyle"
  >
    <video
      ref="video"
      :src="src"
      :loop="loop"
      :muted="muted"
      :preload="preload"
      :playsinline="playsinline"
      @playing="state.playing = true"
      @pause="state.playing = false"
      @load="onLoaded"
      draggable="false"
      class="w-full"
      :class="classNames"
    />
    <transition name="fade">
      <magic-image
        v-if="thumbnailSrc"
        v-show="!state.playing"
        ref="thumbnail"
        :provider="imageProvider"
        :src="thumbnailSrc"
        draggable="false"
        class="absolute left-0 top-0 z-10 h-full w-full"
        :class="classNames"
      />
    </transition>
  </div>
</template>

<script lang="ts" setup>
import { useIntersectionObserver, useIdle } from "@vueuse/core";

interface Props {
  src: string;
  thumbnailSrc?: string;
  ratio?: string | false;
  loop?: boolean;
  muted?: boolean;
  playsinline?: boolean;
  fit?: "cover" | "contain";
  fill?: boolean;
  imageProvider?: "mux" | "weserv";
  preload?: "auto" | "metadata" | "none";
  autoplay?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  loop: true,
  muted: true,
  playsinline: true,
  ratio: "16:9",
  fit: "cover",
  fill: false,
  autoplay: true,
  imageProvider: "mux",
  preload: "metadata",
});

const { src, muted, autoplay, fill, fit, ratio } = toRefs(props);

const el = ref();
const video = ref();
const thumbnail = ref();

const state = reactive({
  loaded: false,
  playing: false,
  inview: false,
  muted: muted.value,
});

const emit = defineEmits(["loaded"]);

const { idle } = useIdle(5 * 60 * 1000);

const classNames = computed(() => [
  fill.value ? "absolute h-full" : "",
  fit.value === "cover" ? "object-cover" : "",
  fit.value === "contain" ? "object-contain" : "",
]);

const computedStyle = computed(() => ({
  "aspect-ratio":
    ratio.value && !fill.value
      ? `${ratio.value.split(":")[0]}/${ratio.value.split(":")[1]}`
      : undefined,
}));

const play = () => {
  if (!video.value) return;

  const playPromise = video.value.play();
  if (playPromise !== undefined) {
    playPromise.catch((e: DOMException) => {
      if (e.name === "NotAllowedError" && video.value) {
        video.value.muted = true;
        state.muted = true;
        video.value.play();
      }
    });
  }
};

const pause = () => video.value?.pause();

const onLoaded = () => {
  state.loaded = true;
  emit("loaded");
};

useIntersectionObserver(
  el,
  ([{ isIntersecting }]) => {
    state.inview = isIntersecting;
    if (isIntersecting) {
      if (autoplay.value && !state.playing) {
        play();
      }
    } else {
      pause();
    }
  },
  { threshold: 0.1 },
);

watch(idle, (isIdle) => {
  if (isIdle && state.playing) {
    pause();
  } else if (!isIdle && state.inview) {
    play();
  }
});
</script>
