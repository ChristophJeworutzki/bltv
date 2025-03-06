<template>
  <div v-show="!loaded || !touched" class="video-player-poster">
    <slot />
  </div>
</template>

<script setup lang="ts">
import { usePlayerRuntime } from "../composables/usePlayerRuntime";
import { usePlayerVideoApi } from "../composables/usePlayerVideoApi";

export type VideoPlayerPosterProps = {
  id: string;
};
const props = defineProps<VideoPlayerPosterProps>();

const { loaded } = usePlayerRuntime({
  id: props.id,
});

const { touched } = usePlayerVideoApi({
  id: props.id,
});
</script>

<style lang="css">
.video-player-poster {
  position: absolute;
  inset: 0;
}
</style>
