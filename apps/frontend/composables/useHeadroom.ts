import { ref, computed, watch, onMounted } from "vue";
import { useScroll, defaultWindow } from "@vueuse/core";
import { useNuxtApp } from "#app";

export function useHeadroom(options = {}) {
  const defaults = {
    offset: 0,
    tolerance: 0,
    scroller: defaultWindow,
  };

  const config = { ...defaults, ...options };
  const nuxtApp = useNuxtApp();
  const isClient = import.meta.client || nuxtApp.$isClient;

  const isEnabled = ref(true);
  const isPinned = ref(true);
  const lastScrollY = ref(0);
  const lastDirection = ref("none");

  const y = ref(0);
  const directions = ref({ top: false, bottom: false });
  const arrivedState = ref({ top: true, bottom: false });

  if (isClient) {
    const scrollData = useScroll(config.scroller, {
      throttle: 100,
      behavior: "smooth",
    });

    y.value = scrollData.y.value;
    directions.value = scrollData.directions;
    arrivedState.value = scrollData.arrivedState;

    watch(scrollData.y, (newY) => {
      y.value = newY;
    });

    watch(scrollData.directions, (newDirections) => {
      directions.value = newDirections;
    });

    watch(scrollData.arrivedState, (newArrivedState) => {
      arrivedState.value = newArrivedState;
    });
  }

  const isTop = computed(
    () => arrivedState.value.top || y.value <= config.offset,
  );
  const isNotTop = computed(() => !isTop.value);
  const isBottom = computed(() => arrivedState.value.bottom);
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
      if (directions.value.top && lastDirection.value !== "up") {
        isPinned.value = true;
        lastDirection.value = "up";
      } else if (directions.value.bottom && lastDirection.value !== "down") {
        isPinned.value = false;
        lastDirection.value = "down";
      }

      lastScrollY.value = y.value;
    }
  };

  if (isClient) {
    watch(y, () => {
      if (isEnabled.value) {
        updatePinState();
      }
    });
  }

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
    if (isClient) {
      lastScrollY.value = y.value;
      updatePinState();
    }
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
