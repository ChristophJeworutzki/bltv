<template>
  <div
    class="video-player-overlay"
    :class="{
      '-playing': playing,
      '-paused': !playing,
      '-idle': idle,
      '-not-idle': !idle,
      '-hover': mouseEntered,
      '-not-hover': !mouseEntered,
    }"
    @click.stop="togglePlay"
  >
    <slot>
      <template v-if="waiting">
        <button class="video-player-overlay__button">
          <slot name="waitingIcon">
            <icon-waiting />
          </slot>
        </button>
      </template>
      <template v-else>
        <button v-if="!playing" class="video-player-overlay__button">
          <slot name="playIcon">
            <icon-play />
          </slot>
        </button>
        <button v-else class="video-player-overlay__button">
          <slot name="pauseIcon">
            <icon-pause />
          </slot>
        </button>
      </template>
    </slot>
  </div>
</template>

<script setup lang="ts">
import { useIdle } from "@vueuse/core";
import IconPlay from "./icons/OverlayPlay.vue";
import IconPause from "./icons/OverlayPause.vue";
import IconWaiting from "./icons/Waiting.vue";
import { usePlayerMediaApi } from "../composables/usePlayerMediaApi";
import { usePlayerVideoApi } from "../composables/usePlayerVideoApi";

interface VideoPlayerOverlayProps {
  id: string;
}

const props = defineProps<VideoPlayerOverlayProps>();

const { playing, waiting } = usePlayerMediaApi({
  id: props.id,
});
const { mouseEntered, togglePlay } = usePlayerVideoApi({
  id: props.id,
});

const { idle } = useIdle(3000);
</script>

<style lang="css">
:root {
  --video-player-overlay-background: rgba(0, 0, 0, 0.3);
  --video-player-overlay-color: rgba(255, 255, 255, 1);
  --video-player-overlay-button-size: 2.5rem;
  --video-player-overlay-transition: opacity 300ms ease;
}

.video-player-overlay {
  position: absolute;
  inset: 0;
  background-color: var(--video-player-overlay-background);
  color: var(--video-player-overlay-color);
  transition: var(--video-player-overlay-transition);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.video-player-overlay__button {
  background-color: transparent;
  color: inherit;
  border: 0;
  border-radius: 0;
  padding: 0;
  outline: none;
  appearance: none;
  cursor: pointer;
  width: var(--video-player-overlay-button-size);
  height: var(--video-player-overlay-button-size);
}

.video-player-overlay.-playing.-idle,
.video-player-overlay.-playing.-not-hover {
  opacity: 0;
}
</style>
