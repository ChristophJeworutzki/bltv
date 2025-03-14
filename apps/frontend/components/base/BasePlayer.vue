<template>
  <video-player src-type="hls" :src="video.url" :id="id" :autoplay="autoplay">
    <video-player-poster :id="id">
      <magic-image
        provider="mux"
        :src="video.thumbnail"
        class="h-full w-full object-contain"
      />
    </video-player-poster>
    <video-player-overlay :id="id" />
    <video-player-controls :id="id">
      <template #seekPopover>
        <video-player-mux-popover
          v-if="video.playbackId"
          :id="id"
          :playbackId="video.playbackId"
        />
      </template>
      <template #timelineBefore>
        <video-player-display-time
          v-if="video.playbackId"
          :id="id"
          type="current"
        />
      </template>
      <template #timelineAfter>
        <video-player-display-time
          v-if="video.playbackId"
          :id="id"
          type="duration"
        />
      </template>
    </video-player-controls>
  </video-player>
</template>

<script lang="ts" setup>
interface Props {
  video: Video;
  autoplay?: boolean;
}

const { video, autoplay = false } = defineProps<Props>();

const id = useId();
</script>
