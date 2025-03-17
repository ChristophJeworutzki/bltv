import { ref, computed, watch, onMounted } from "vue";
import { useScroll, defaultWindow } from "@vueuse/core";

export function useHeadroom(options = {}) {
  const defaults = {
    offset: 0,
    tolerance: 0,
    scroller: defaultWindow,
  };

  const config = { ...defaults, ...options };

  const isEnabled = ref(true);
  const isPinned = ref(true);
  const lastScrollY = ref(0);
  const lastDirection = ref("none");

  const { y, directions, arrivedState } = useScroll(config.scroller, {
    throttle: 100,
    behavior: "smooth",
  });

  const isTop = computed(() => arrivedState.top || y.value <= config.offset);
  const isNotTop = computed(() => !isTop.value);
  const isBottom = computed(() => arrivedState.bottom);
  const isNotBottom = computed(() => !isBottom.value);

  const hasPassedTolerance = computed(() => {
    return Math.abs(y.value - lastScrollY.value) >= config.tolerance;
  });

  const updatePinState = () => {
    if (!isEnabled.value) return;

    if (isTop.value) {
      isPinned.value = true;
      return;
    }

    if (hasPassedTolerance.value) {
      if (directions.top && lastDirection.value !== "up") {
        isPinned.value = true;
        lastDirection.value = "up";
      } else if (directions.bottom && lastDirection.value !== "down") {
        isPinned.value = false;
        lastDirection.value = "down";
      }

      lastScrollY.value = y.value;
    }
  };

  watch(y, () => {
    if (isEnabled.value) {
      updatePinState();
    }
  });

  const pin = () => {
    if (isEnabled.value) {
      isPinned.value = true;
    }
  };

  const unpin = () => {
    if (isEnabled.value && !isTop.value) {
      isPinned.value = false;
    }
  };

  const freeze = () => {
    isEnabled.value = false;
  };

  const unfreeze = () => {
    isEnabled.value = true;
    updatePinState();
  };

  onMounted(() => {
    lastScrollY.value = y.value;
    updatePinState();
  });

  return {
    isPinned,
    isTop,
    isNotTop,
    isBottom,
    isNotBottom,
    isEnabled,
    pin,
    unpin,
    freeze,
    unfreeze,
    enable: unfreeze,
    disable: freeze,
  };
}
