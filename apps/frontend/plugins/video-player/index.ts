import VideoPlayer from "./src/components/VideoPlayer.vue";
import VideoPlayerControls from "./src/components/VideoPlayerControls.vue";
import VideoPlayerDisplayTime from "./src/components/VideoPlayerDisplayTime.vue";
import VideoPlayerPoster from "./src/components/VideoPlayerPoster.vue";
import VideoPlayerOverlay from "./src/components/VideoPlayerOverlay.vue";
import VideoPlayerMuxPopover from "./src/components/VideoPlayerMuxPopover.vue";
import VideoPlayerTimeline from "./src/components/VideoPlayerTimeline.vue";

export default defineNuxtPlugin({
  async setup(nuxtApp) {
    nuxtApp.vueApp.component("VideoPlayer", VideoPlayer);
    nuxtApp.vueApp.component("VideoPlayerControls", VideoPlayerControls);
    nuxtApp.vueApp.component("VideoPlayerDisplayTime", VideoPlayerDisplayTime);
    nuxtApp.vueApp.component("VideoPlayerPoster", VideoPlayerPoster);
    nuxtApp.vueApp.component("VideoPlayerOverlay", VideoPlayerOverlay);
    nuxtApp.vueApp.component("VideoPlayerMuxPopover", VideoPlayerMuxPopover);
    nuxtApp.vueApp.component("VideoPlayerTimeline", VideoPlayerTimeline);
  },
});
