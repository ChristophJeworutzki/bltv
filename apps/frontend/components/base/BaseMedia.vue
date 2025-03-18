<template>
  <div
    class="base-media relative overflow-hidden"
    :style="`--ratio: ${getCssMediaAspectRatio(media)}`"
    :class="[fill ? 'h-full w-full' : 'aspect-[var(--ratio)]']"
  >
    <magic-image
      v-if="media.type === 'image' && media.image?.url"
      :src="media.image.url"
      :alt="media.image.alt"
      class="h-full w-full"
      :class="{
        'object-cover': fit === 'cover',
        'object-contain': fit === 'contain',
      }"
    />
    <base-video
      v-else-if="media.type === 'video' && media.video"
      :src="computedVideoSrc"
      :thumbnail-src="media.video.poster"
      :autoplay="media.video.duration < 20"
      :fit="fit"
      fill
    />
  </div>
</template>

<script lang="ts" setup>
interface Props {
  media: Media;
  fill?: boolean;
  fit?: "contain" | "cover";
  ratio?: string;
  videoQuality?: "high" | "medium" | "low";
}

const props = withDefaults(defineProps<Props>(), {
  fit: "cover",
  videoQuality: "high",
});

const computedVideoSrc = computed(() => {
  return props.media?.video?.files?.[props.videoQuality]?.url || "";
});
</script>
