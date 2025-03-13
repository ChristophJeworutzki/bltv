<template>
  <transition name="intro" @afterLeave="onAfterLeave">
    <div
      v-if="introSkipped"
      class="app-intro cursor-pointe relative z-[9999] h-dvh w-full cursor-pointer clip-inset"
      @click="skip"
      @wheel="onWheel"
    >
      <div
        class="absolute left-0 top-0 flex h-dvh w-full items-center justify-center"
      >
        <div
          class="type-display flex select-none flex-col items-center justify-center whitespace-nowrap"
        >
          <span>Es werde Licht.</span>
          <span>Que la lumière soit.</span>
          <span>Let there be light.</span>
          <span>光よあれ</span>
          <span>Laat daar Lig wees.</span>
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts" setup>
import { useScrollLock, useSwipe, defaultDocument } from "@vueuse/core";

const { introSkipped } = storeToRefs(useAppStore());
const isLocked = useScrollLock(defaultDocument);
const { isSwiping, direction, stop: stopSwipe } = useSwipe(defaultDocument);
const emit = defineEmits(["completed"]);

function skip() {
  introSkipped.value = false;
}

function onAfterLeave() {
  setTimeout(() => {
    isLocked.value = false;
    emit("completed");
  }, 300);
}

function onWheel(event: WheelEvent) {
  if (event.deltaY > 1) {
    skip();
  }
}

watch(
  introSkipped,
  (value) => {
    if (value) {
      nextTick(() => {
        isLocked.value = true;
      });
    }
  },
  {
    immediate: true,
  },
);

watch(isSwiping, (value) => {
  if (value && direction.value === "up") {
    skip();
    stopSwipe();
  }
});
</script>

<style lang="postcss">
.intro-leave-active {
  animation: intro-out 0.6s cubic-bezier(0.65, 0, 0.35, 1);
}

@keyframes intro-out {
  100% {
    height: 0;
    transform: scale(0.9);
  }
}
</style>
