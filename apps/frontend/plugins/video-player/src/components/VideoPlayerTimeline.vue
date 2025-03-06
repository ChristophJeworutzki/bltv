<template>
  <div class="video-player-timeline">
    <div
      class="video-player-timeline__target"
      @mouseenter="onMouseenter"
      @mouseleave="onMouseleave"
      @pointerdown="onPointerdown"
      @pointerup="onPointerup"
      @pointermove="onPointermove"
    >
      <div class="video-player-timeline__slider-track">
        <div
          class="video-player-timeline__slider-thumb"
          :style="{ left: `${scrubbedPercentage}%` }"
        >
          <div class="video-player-timeline__slider-thumb-handle" />
        </div>
        <div class="video-player-timeline__slider-inner-track">
          <div
            class="video-player-timeline__slider-buffered"
            :style="{ left: `${bufferedPercentage}%` }"
          />
          <div
            v-show="mouseEntered"
            class="video-player-timeline__slider-seeked"
            :style="{ left: `${seekedPercentage}%` }"
          />
          <div
            class="video-player-timeline__slider-scrubbed"
            :style="{ left: `${scrubbedPercentage}%` }"
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { usePlayerControlsApi } from "../composables/usePlayerControlsApi";

interface VideoPlayerTimelineProps {
  id: string;
}

const props = defineProps<VideoPlayerTimelineProps>();

const {
  mouseEntered,
  seekedPercentage,
  scrubbedPercentage,
  bufferedPercentage,
  onMouseenter,
  onMouseleave,
  onPointerdown,
  onPointerup,
  onPointermove,
} = usePlayerControlsApi({
  id: props.id,
});
</script>

<style lang="css">
:root {
  --video-player-target-height: 56px;
  --video-player-track-height: 4px;
  --video-player-track-background: rgba(250, 250, 250, 0.15);
  --video-player-thumb-size: 0.75rem;
  --video-player-thumb-background: rgba(250, 250, 250, 1);
}

.video-player-timeline {
  position: relative;
  width: 100%;
  height: var(--video-player-track-height);
  display: flex;
  align-items: center;
}

.video-player-timeline__target {
  position: relative;
  width: 100%;
  height: var(--video-player-target-height);
  display: flex;
  align-items: center;
  cursor: pointer;
}

.video-player-timeline__slider-track {
  position: relative;
  width: 100%;
  height: var(--video-player-track-height);
  background: var(--video-player-track-background);
  border-radius: 50rem;
}

.video-player-timeline__slider-inner-track {
  position: relative;
  border-radius: 50rem;
  overflow: hidden;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 1;
}

.video-player-timeline__slider-thumb {
  position: absolute;
  width: var(--video-player-track-height);
  height: var(--video-player-track-height);
  z-index: 10;
}

.video-player-timeline__slider-thumb-handle {
  position: absolute;
  width: var(--video-player-thumb-size);
  height: var(--video-player-thumb-size);
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) scale(0);
  transition: transform 300ms ease;
  z-index: 10;
  background-color: var(--video-player-thumb-background);
  border-radius: 50rem;
}

.video-player-timeline__slider-scrubbed,
.video-player-timeline__slider-seeked,
.video-player-timeline__slider-buffered {
  position: absolute;
  left: 0;
  width: 100%;
  height: 100%;
  margin-left: calc(-100% + var(--video-player-track-height));
  background: currentColor;
  border-radius: 50rem;
}

.video-player-timeline__slider-scrubbed {
  z-index: 1;
  min-width: var(--video-player-track-height);
  display: flex;
}

.video-player-timeline__slider-seeked {
  opacity: 0.25;
}

.video-player-timeline__slider-buffered {
  opacity: 0.15;
}

.video-player-timeline:hover .video-player-timeline__slider-thumb-handle {
  transform: translate(-50%, -50%) scale(1);
}

.video-player-timeline__seek-popover {
  position: absolute;
  left: 0;
  bottom: 100%;
  transform: translateX(-50%);
}
</style>
