<template>
  <div
    class="video-player-controls"
    :class="{
      '-fullscreen': isFullscreen,
      '-touched': touched,
      '-untouched': !touched,
      '-playing': playing,
      '-paused': !playing,
      '-waiting': waiting,
      '-idle': idle,
      '-not-idle': !idle,
      '-hover': mouseEntered,
      '-not-hover': !mouseEntered,
      '-standalone': standalone,
    }"
  >
    <transition :name="transition">
      <div class="video-player-controls__bar" v-show="!hidden">
        <div
          v-if="$slots.seekPopover"
          v-show="!!seekedTime && touched"
          ref="popoverRef"
          class="video-player-controls__popover"
          :style="{ marginLeft: `${popoverOffsetX}%` }"
        >
          <slot name="seekPopover" />
        </div>
        <div class="video-player-controls__bar--inner" ref="barRef">
          <div class="video-player-controls__item -shrink-0">
            <button v-if="!playing" @click="play">
              <slot name="playIcon">
                <icon-play />
              </slot>
            </button>
            <button v-else @click="pause">
              <slot name="pauseIcon">
                <icon-pause />
              </slot>
            </button>
          </div>
          <div class="video-player-controls__item -grow">
            <slot name="timelineBefore" />
            <div class="video-player-controls__timeline" ref="trackRef">
              <video-player-timeline :id="id" />
            </div>
            <slot name="timelineAfter" />
          </div>
          <div class="video-player-controls__item -shrink-0">
            <button v-if="muted" @click="unmute">
              <slot name="volumeOffIcon">
                <icon-volume-off />
              </slot>
            </button>
            <button v-else @click="mute">
              <slot name="volumeOnIcon">
                <icon-volume-on />
              </slot>
            </button>
          </div>
          <div class="video-player-controls__item -shrink-0">
            <button v-if="isFullscreen" @click="exitFullscreen">
              <slot name="fullscreenExitIcon">
                <icon-fullscreen-exit />
              </slot>
            </button>
            <button v-else @click="enterFullscreen">
              <slot name="fullscreenEnterIcon">
                <icon-fullscreen-enter />
              </slot>
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { useIdle } from "@vueuse/core";
import IconPlay from "./icons/Play.vue";
import IconPause from "./icons/Pause.vue";
import IconVolumeOn from "./icons/VolumeOn.vue";
import IconVolumeOff from "./icons/VolumeOff.vue";
import IconFullscreenEnter from "./icons/FullscreenEnter.vue";
import IconFullscreenExit from "./icons/FullscreenExit.vue";
import { usePlayerMediaApi } from "../composables/usePlayerMediaApi";
import { usePlayerVideoApi } from "../composables/usePlayerVideoApi";
import { usePlayerControlsApi } from "../composables/usePlayerControlsApi";

interface VideoPlayerControlsProps {
  id: string;
  standalone?: boolean;
  transition?: string;
}

const props = withDefaults(defineProps<VideoPlayerControlsProps>(), {
  transition: "video-player-controls",
});

const barRef = ref<HTMLDivElement | undefined>(undefined);
const trackRef = ref<HTMLDivElement | undefined>(undefined);
const popoverRef = ref<HTMLDivElement | undefined>(undefined);

const { playing, waiting, muted } = usePlayerMediaApi({
  id: props.id,
});

const {
  touched,
  mouseEntered,
  isFullscreen,
  play,
  pause,
  mute,
  unmute,
  enterFullscreen,
  exitFullscreen,
} = usePlayerVideoApi({ id: props.id });

const { popoverOffsetX, seekedTime } = usePlayerControlsApi({
  id: props.id,
  barRef: barRef,
  trackRef: trackRef,
  popoverRef: popoverRef,
});

const { idle } = useIdle(3000);

const hidden = computed(() => {
  switch (true) {
    case props.standalone:
      return false;
    case playing.value && idle.value:
      return true;
    case playing.value && !mouseEntered.value:
      return true;
    case !touched.value:
      return true;
    default:
      return false;
  }
});
</script>

<style lang="css">
:root {
  --video-player-controls-height: 2.5rem;
  --video-player-controls-padding: 0.25rem;
  --video-player-controls-bottom: 0.5rem;
  --video-player-controls-left: 0.5rem;
  --video-player-controls-width: calc(
    100% - (var(--video-player-controls-left) * 2)
  );
  --video-player-controls-gap: 1rem;
  --video-player-controls-border-radius: 0.5rem;
  --video-player-controls-background: rgba(0, 0, 0, 0.16);
  --video-player-controls-backdrop-filter: blur(32px);
  --video-player-controls-color: #fff;
  --video-player-controls-button-width: 2.5rem;
  --video-player-controls-icon-width: 1.25rem;
  --video-player-controls-icon-width: 1rem;
}

@media (max-width: 640px) {
  :root {
    --video-player-controls-height: 2.5rem;
    --video-player-controls-bottom: 0.75rem;
    --video-player-controls-padding: 0.5rem;
  }
}

.video-player-controls {
  position: absolute;
  inset: 0;
  width: 100%;
  pointer-events: none;
}

.video-player-controls-enter-active {
  animation: fade-up-in 150ms ease;
}

.video-player-controls-leave-active {
  animation: fade-up-out 150ms ease;
}

.video-player-controls__bar {
  position: absolute;
  width: var(--video-player-controls-width);
  bottom: var(--video-player-controls-bottom);
  left: var(--video-player-controls-left);
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: var(--video-player-controls-gap);
  pointer-events: auto;
}

.video-player-controls__bar--inner {
  width: 100%;
  box-sizing: border-box;
  height: var(--video-player-controls-height);
  padding: 0 var(--video-player-controls-padding);
  background-color: var(--video-player-controls-background);
  backdrop-filter: var(--video-player-controls-backdrop-filter);
  color: var(--video-player-controls-color);
  border-radius: var(--video-player-controls-border-radius);
  display: flex;
  align-items: center;
}

.video-player-controls__item {
  display: inline-flex;
  align-items: center;
  user-select: none;
}

.video-player-controls__item.-shrink-0 {
  flex-shrink: 0;
}

.video-player-controls__item.-grow {
  flex-grow: 1;
}

.video-player-controls__item button {
  background-color: transparent;
  color: inherit;
  border: 0;
  outline: none;
  appearance: none;
  padding: 0;
  border-radius: 0;
  cursor: pointer;
  width: var(--video-player-controls-button-width);
  height: var(--video-player-controls-height);
  display: flex;
  align-items: center;
  justify-content: center;
}

.video-player-controls__item button svg {
  display: block;
  width: var(--video-player-controls-icon-width);
  height: auto;
}

.video-player-controls__timeline {
  width: 100%;
}

.video-player-controls.-standalone {
  position: relative;
  inset: unset;
  --video-player-controls-width: 100%;
  --video-player-controls-bottom: 0;
  --video-player-controls-left: 0;
  --video-player-controls-padding: 0;
  --video-player-controls-background: unset;
  --video-player-controls-border-radius: unset;
  --video-player-controls-background: transparent;
  --video-player-controls-backdrop-filter: none;
}

.video-player-controls.-standalone .video-player-controls__bar {
  position: relative;
}

@keyframes fade-up-in {
  0% {
    opacity: 0;
    transform: translateY(1rem);
  }
  100% {
    transform: translateY(0);
  }
}

@keyframes fade-up-out {
  0% {
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(1rem);
  }
}
</style>
