import { ref, watch, toValue, type MaybeRef } from "vue";
import { usePlayerStateEmitter } from "./usePlayerStateEmitter";

import type Hls from "hls.js";
import type { VideoPlayerSourceType } from "../types";
import { useEventListener } from "@vueuse/core";

export type UsePlayerRuntimeArgs = {
  id: MaybeRef<string>;
  mediaRef?: MaybeRef<HTMLVideoElement | undefined>;
  srcType?: VideoPlayerSourceType;
  src?: string;
};

export function usePlayerRuntime(args: UsePlayerRuntimeArgs) {
  let hls: Hls | undefined;
  const loaded = ref(false);
  const deferredLoading = ref(false);

  const { mediaRef, srcType, src } = args;

  // Private functions
  const useNative = () => {
    const el = toValue(mediaRef);
    if (!el || !src) return;
    el.src = src;
    el.addEventListener(
      "loadeddata",
      () => {
        loaded.value = true;
      },
      { once: true },
    );
  };

  const useHlsJS = async () => {
    const el = toValue(mediaRef);
    if (!el) return;

    useEventListener(mediaRef, "play", () => {
      // Since the autoplay event is faster than the hls initialization,
      // hls.startLoad() needs to be deferred until hls is ready
      deferredLoading.value = true;
    });

    const { default: Hls } = await import("hls.js");

    hls = new Hls({ autoStartLoad: false });
    if (!Hls.isSupported()) {
      useNative();
    } else if (src) {
      hls.on(Hls.Events.FRAG_LOADED, () => {
        loaded.value = true;
      });

      hls.on(Hls.Events.MEDIA_ATTACHED, () => {
        toValue(mediaRef)?.dispatchEvent(new Event("suspend"));
      });

      hls.on(Hls.Events.MANIFEST_PARSED, () => {
        if (deferredLoading.value) {
          hls?.startLoad();
        }
      });

      useEventListener(mediaRef, "pause", () => {
        hls?.stopLoad();
      });

      // If the user pauses the video and then plays it again,
      // hls.startLoad() needs to be called. Best to use a seperate watcher for this
      useEventListener(mediaRef, "play", () => {
        hls?.startLoad();
      });

      hls.loadSource(src);
      hls.attachMedia(el);
    }
  };

  // Public functions
  function initialize() {
    if (srcType === "native") {
      useNative();
    } else if (srcType === "hls") {
      useHlsJS();
    }
  }

  function destroy() {
    hls?.destroy();
    deferredLoading.value = false;
  }

  const emitter = usePlayerStateEmitter();

  // Listen to updates
  emitter.on("update", (payload) => {
    if (payload.id !== toValue(args.id)) return;

    if (payload.api === "runtime") {
      switch (payload.key) {
        case "loaded":
          loaded.value = payload.value as boolean;
          break;
      }
    }
  });

  // Emit updates
  watch(loaded, (value) => {
    emitter.emit("update", {
      id: toValue(args.id),
      api: "runtime",
      key: "loaded",
      value,
    });
  });

  return {
    loaded,
    initialize,
    destroy,
  };
}

export type UsePlayerRuntimeReturn = ReturnType<typeof usePlayerRuntime>;
