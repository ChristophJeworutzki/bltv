<template>
  <div class="overlay-pause-icon">
    <div class="overlay-pause-icon__clip">
      <svg width="0" height="0" viewBox="0 0 24 24">
        <clipPath
          id="overlay-pause-icon-clip"
          clipPathUnits="objectBoundingBox"
        >
          <path
            transform="scale(0.0475, 0.0475)"
            d="M8 4a2 2 0 0 0-2 2v12a2 2 0 1 0 4 0V6a2 2 0 0 0-2-2ZM16 4a2 2 0 0 0-2 2v12a2 2 0 1 0 4 0V6a2 2 0 0 0-2-2Z"
          />
        </clipPath>
      </svg>
    </div>
  </div>
</template>

<style scoped>
.overlay-pause-icon {
  width: 2.5rem;
  height: 2.5rem;
}

.overlay-pause-icon__clip {
  width: 100%;
  height: 100%;
  clip-path: url(#overlay-pause-icon-clip);
  background: rgba(255, 255, 255, 0.25);
  backdrop-filter: blur(2rem);
}
</style>
