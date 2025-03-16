<template>
  <section class="project-gallery">
    <div class="grid grid-flow-row-dense gap-2 sm:grid-cols-2">
      <div
        v-for="media in gallery"
        class="relative overflow-hidden bg-black/5"
        :class="[
          getMediaOrientation(media) === 'landscape'
            ? 'sm:col-span-2'
            : 'sm:col-span-1',
        ]"
      >
        <div v-if="isVideoWithControls(media)" class="relative h-dvh">
          <base-player :video="media.video!" autoplay />
        </div>
        <div
          v-else
          :style="{
            aspectRatio: getCssMediaAspectRatio(media),
          }"
          class="relative min-h-full"
        >
          <base-media :media="media" fill />
        </div>
      </div>
    </div>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  gallery: Media[];
}

const { gallery } = defineProps<Props>();
</script>
