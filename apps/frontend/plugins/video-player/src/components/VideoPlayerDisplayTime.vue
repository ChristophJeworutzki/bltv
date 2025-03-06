<template>
  <div class="video-player-time-display">
    {{ stringifiedTime }}
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { usePlayerMediaApi } from "../composables/usePlayerMediaApi";
import { formatTime } from "./../utils";

interface VideoPlayerDisplayTimeProps {
  id: string;
  type: "current" | "remaining" | "duration";
}

const props = withDefaults(defineProps<VideoPlayerDisplayTimeProps>(), {
  type: "current",
});

const { currentTime, remainingTime, duration } = usePlayerMediaApi({
  id: props.id,
});

const stringifiedTime = computed(() => {
  switch (props.type) {
    case "current":
      return formatTime(currentTime.value, currentTime.value);
    case "remaining":
      return `-${formatTime(remainingTime.value, remainingTime.value)}`;
    case "duration":
      return formatTime(duration.value, duration.value);
    default:
      return "";
  }
});
</script>

<style>
:root {
  --video-player-time-display-font-size: 0.75rem;
  --video-player-time-display-color: inherit;
  --video-player-time-display-width: 4rem;
  --video-player-time-display-justify-content: center;
  --video-player-time-display-font-variant-numeric: tabular-nums;
}
.video-player-time-display {
  height: 100%;
  width: var(--video-player-time-display-width);
  font-size: var(--video-player-time-display-font-size);
  color: var(--video-player-time-display-color);
  display: flex;
  align-items: center;
  justify-content: var(--video-player-time-display-justify-content);
  font-variant-numeric: var(--video-player-time-display-font-variant-numeric);
}
</style>
