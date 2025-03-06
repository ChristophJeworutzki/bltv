<template>
  <div
    class="base-media relative overflow-hidden"
    :style="`--ratio: ${computedCssRatio}`"
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
      :thumbnail-src="media.video.thumbnail"
      :autoplay="videoAutoplay"
      :muted="videoMuted"
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
  videoAutoplay?: "inview" | "hover";
  videoMuted?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  fit: "cover",
  videoQuality: "high",
  videoMuted: true,
});

const computedVideoSrc = computed(() => {
  return props.media?.video?.files?.[props.videoQuality]?.url || "";
});

const computedCssRatio = computed(() => {
  if (props.ratio) return props.ratio.split(":").join("/");
  if (props.media.type === "image" && props.media.image?.aspectRatio) {
    return props.media.image.aspectRatio.split(":").join("/");
  } else if (props.media.type === "video" && props.media.video?.aspectRatio) {
    return props.media.video.aspectRatio.split(":").join("/");
  }
});
</script>
