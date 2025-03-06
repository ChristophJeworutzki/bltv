<template>
  <transition
    name="modal"
    @enter="onEnter"
    @leave="onLeave"
    @after-leave="onAfterLeave"
  >
    <div
      v-show="isOpen"
      class="project-modal fixed left-0 top-0 z-50 h-full w-full"
    >
      <div
        v-if="project"
        ref="scrollRef"
        class="project-modal__content absolute left-0 top-0 z-10 h-full w-full overflow-auto pb-[100dvh]"
      ></div>
      <div
        class="project-modal__backdrop absolute left-0 top-0 z-0 h-full w-full bg-black bg-opacity-90"
        :style="{ opacity: 1 - scrollOutProgress }"
      />
    </div>
  </transition>
</template>

<script lang="ts" setup>
import {
  useScrollLock,
  defaultDocument,
  useScroll,
  useWindowSize,
} from "@vueuse/core";
const { isOpen, project } = storeToRefs(useProjectStore());

const router = useRouter();
const isLocked = useScrollLock(defaultDocument);

const scrollRef = ref<HTMLElement | null>(null);
const scrollOutProgress = ref(1);
const isEnd = ref(false);

const { y, arrivedState } = useScroll(scrollRef);
const { height: vh } = useWindowSize();

function close() {
  if (isOpen.value) {
    isOpen.value = false;
    if (router.currentRoute.value?.fullPath) {
      window.history.pushState({}, "", router.currentRoute.value.fullPath);
    }
  }
}

function onEnter() {
  isLocked.value = true;
  if (project.value) {
    window.history.pushState({}, "", `/projects/${project.value.slug}`);
  }
  addEventListeners();
}

function onLeave() {
  removeEventListeners();
}

function onAfterLeave() {
  project.value = undefined;
  isLocked.value = false;
}

function onPopState() {
  if (isOpen.value) {
    isOpen.value = false;
  }
}

function onKeyDown(e: KeyboardEvent) {
  if (e.key === "Escape") {
    e.preventDefault();
    close();
  }
}

function addEventListeners() {
  window.addEventListener("popstate", onPopState);
  window.addEventListener("keydown", onKeyDown);
}

function removeEventListeners() {
  window.removeEventListener("popstate", onPopState);
  window.removeEventListener("keydown", onKeyDown);
}

watch(arrivedState, (arrived) => {
  if (arrived.bottom) {
    close();
  }
});

watch(y, (value) => {
  if (!scrollRef.value) return;
  const scrollHeight = scrollRef.value.scrollHeight;
  const offsetHeight = scrollRef.value.offsetHeight;

  isEnd.value = value > scrollHeight - offsetHeight - vh.value;

  if (isEnd.value) {
    scrollOutProgress.value =
      (value - (scrollHeight - offsetHeight - vh.value)) / vh.value;
  } else {
    scrollOutProgress.value = 0;
  }
});
</script>

<style lang="postcss">
.modal-enter-active {
  transition: 0.5s ease;
  .project-modal__content {
    animation: modal-content-in 0.5s ease forwards;
  }
  .project-modal__backdrop {
    animation: modal-backdrop-in 0.5s ease forwards;
  }
}

.modal-leave-active {
  animation: fade-out 0.3s ease forwards;
}

@keyframes modal-content-in {
  from {
    transform: translateY(100%);
  }
  to {
    transform: translateY(0);
  }
}

@keyframes modal-content-out {
  from {
    transform: translateY(0);
  }
  to {
    transform: translateY(100%);
  }
}

@keyframes modal-backdrop-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes modal-backdrop-out {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
  }
}
</style>
