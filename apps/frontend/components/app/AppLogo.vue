<template>
  <div
    class="app-logo absolute left-[50%] top-2 z-50 h-auto w-[11.5rem] -translate-x-1/2 sm:w-[17.5rem]"
  >
    <base-lottie
      :key="currentIndex"
      :src="animation.src"
      :segments="animation.segment"
      autoplay
    />
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { useNuxtApp } from "#app";

const animations = [
  { src: "/animations/logos/a.json", segment: [0, 50] },
  { src: "/animations/logos/b.json", segment: [0, 50] },
];

const animation = ref(animations[0]);
const currentIndex = ref(0);

onMounted(() => {
  const nuxtApp = useNuxtApp();
  nuxtApp.hook("page:finish", () => {
    let newIndex;
    do {
      newIndex = Math.floor(Math.random() * animations.length);
    } while (newIndex === currentIndex.value && animations.length > 1);

    currentIndex.value = newIndex;
    animation.value = animations[currentIndex.value];
  });
});
</script>
