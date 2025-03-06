<template>
  <div
    ref="el"
    class="base-video group w-full"
    :class="[fill ? 'absolute h-full' : 'relative']"
    :style="computedStyle"
    @mouseenter="onMouseEnter"
    @mouseleave="onMouseLeave"
  >
    <video
      ref="video"
      :src="props.src"
      :loop="loop"
      :muted="muted"
      :playsinline="playsinline"
      @playing="onPlaying"
      @pause="onPause"
      @load="onLoaded"
      draggable="false"
      class="w-full"
      :class="[
        fill ? 'absolute h-full' : '',
        fit === 'cover' ? 'object-cover' : '',
        fit === 'contain' ? 'object-contain' : '',
      ]"
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
        :class="[
          fill ? 'absolute h-full' : '',
          fit === 'cover' ? 'object-cover' : '',
          fit === 'contain' ? 'object-contain' : '',
        ]"
      />
    </transition>
    <button
      v-if="autoplay !== 'hover' && !muted"
      class="absolute left-1/2 top-1/2 z-10 hidden -translate-x-1/2 -translate-y-1/2 text-white text-opacity-80 group-hover:block"
      @click="toggleMute"
    >
      <icon-volume-off v-if="state.muted" class="h-8 w-8" />
      <icon-volume-on v-else class="h-8 w-8" />
    </button>
  </div>
</template>

<script lang="ts" setup>
import IconVolumeOn from "@/assets/svg/icons/volume-on.svg";
import IconVolumeOff from "@/assets/svg/icons/volume-off.svg";
import { useIntersectionObserver, useIdle } from "@vueuse/core";

type Props = {
  src: string;
  thumbnailSrc?: string;
  ratio?: string | false;
  loop?: boolean;
  muted?: boolean;
  playsinline?: boolean;
  autoplay?: "inview" | "hover";
  fit?: "cover" | "contain";
  fill?: boolean;
  imageProvider?: "mux" | "weserv";
};

const props = withDefaults(defineProps<Props>(), {
  loop: true,
  muted: true,
  playsinline: true,
  ratio: "16:9",
  fit: "cover",
  fill: false,
  autoplay: "inview",
  imageProvider: "mux",
});

const el = ref();
const video = ref();
const thumbnail = ref();

const state = ref({
  loaded: false,
  playing: false,
  inview: false,
  muted: props.muted,
});

const emit = defineEmits(["loaded"]);

const { idle } = useIdle(5 * 60 * 1000);

const computedRatio = computed(() => {
  if (props.ratio) {
    return props.ratio.split(":");
  } else {
    return undefined;
  }
});

const computedStyle = computed(() => {
  return {
    "aspect-ratio":
      computedRatio.value && !props.fill
        ? `${computedRatio.value[0]}/${computedRatio.value[1]}`
        : undefined,
  };
});

const play = () => {
  const playPromise = video.value.play();
  if (playPromise !== null) {
    playPromise.catch((e: Error) => {
      if (e.name === "NotAllowedError" && video.value) {
        video.value.muted = true;
        state.value.muted = true;
        video?.value.play();
      }
    });
  }
};

const pause = () => {
  video.value?.pause();
};

const onPlaying = () => {
  state.value.playing = true;
};

const onPause = () => {
  state.value.playing = false;
};

const onLoaded = () => {
  state.value.loaded = true;
  emit("loaded");
};

const toggleMute = () => {
  video.value.muted = !video.value.muted;
  state.value.muted = video.value.muted;
};

function onVisibilityChange(inview: boolean) {
  state.value.inview = inview;
  if (props.autoplay === "inview") {
    if (inview) {
      play();
    } else {
      pause();
    }
  }
}

function onMouseEnter() {
  if (props.autoplay === "hover") {
    play();
  }
}

function onMouseLeave() {
  if (props.autoplay === "hover") {
    pause();
  }
}

useIntersectionObserver(
  toRaw(el),
  ([{ isIntersecting }]) => {
    onVisibilityChange(isIntersecting);
  },
  { threshold: 0.1 },
);

watch(idle, (idle) => {
  if (idle && state.value.playing) {
    pause();
  } else if (!idle && state.value.inview) {
    play();
  }
});
</script>
