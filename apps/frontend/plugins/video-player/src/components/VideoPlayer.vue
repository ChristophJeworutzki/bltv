<template>
  <div
    ref="playerRef"
    class="video-player"
    @mouseenter="onMouseenter"
    @mouseleave="onMouseleave"
  >
    <video
      ref="videoRef"
      class="video-player__video"
      playsinline
      disablePictureInPicture
      :preload="preload"
      :loop="loop"
      :muted="muted"
    />
    <slot />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from "vue";
import { useIntersectionObserver } from "@vueuse/core";
import { usePlayerVideoApi } from "../composables/usePlayerVideoApi";
import { usePlayerMediaApi } from "../composables/usePlayerMediaApi";
import { usePlayerRuntime } from "../composables/usePlayerRuntime";

import type { VideoPlayerSourceType } from "./../types";

interface VideoPlayerProps {
  id: string;
  srcType?: VideoPlayerSourceType;
  src: string;
  autoplay?: boolean;
  preload?: "auto" | "metadata" | "none";
  loop?: boolean;
}

const props = withDefaults(defineProps<VideoPlayerProps>(), {
  srcType: "native",
  src: "",
  autoplay: false,
  preload: "metadata",
  loop: false,
  muted: false,
});

const playerRef = ref<HTMLDivElement | undefined>(undefined);
const videoRef = ref<HTMLVideoElement | undefined>(undefined);

const { playing, muted } = usePlayerMediaApi({
  id: props.id,
  mediaRef: videoRef,
});

const { initialize, destroy } = usePlayerRuntime({
  id: props.id,
  mediaRef: videoRef,
  src: props.src,
  srcType: props.srcType,
});

const { onMouseenter, onMouseleave, play, pause } = usePlayerVideoApi({
  id: props.id,
  videoRef: videoRef,
  playerRef: playerRef,
});

useIntersectionObserver(
  playerRef,
  ([{ isIntersecting }]) => {
    if (!isIntersecting && playing.value) {
      pause();
    } else if (isIntersecting && !playing.value && props.autoplay) {
      play();
    }
  },
  {
    immediate: true,
  },
);

onMounted(() => {
  initialize();
});

onBeforeUnmount(() => {
  destroy();
});
</script>

<style lang="css">
:root {
  --video-player-aspect-ratio: auto;
  --video-player-background: transparent;
  --video-player-height: 100dvh;
  --video-player-object-fit: contain;
}

.video-player {
  position: relative;
  width: 100%;
  overflow: hidden;
  height: var(--video-player-height);
  aspect-ratio: var(--video-player-aspect-ratio);
  background: var(--video-player-background);
}

.video-player__video {
  position: absolute;
  width: 100%;
  height: 100%;
  inset: 0;
  object-fit: var(--video-player-object-fit);
}
</style>
