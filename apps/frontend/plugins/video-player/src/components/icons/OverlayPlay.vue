<template>
  <div class="overlay-play-icon">
    <div class="overlay-play-icon__clip">
      <svg width="0" height="0" viewBox="0 0 24 24">
        <clipPath id="overlay-play-icon-clip" clipPathUnits="objectBoundingBox">
          <path
            transform="scale(0.0475, 0.0475)"
            d="M5 4.76619C5 3.9889 5.84797 3.50878 6.5145 3.9087L18.5708 11.1425C19.2182 11.5309 19.2182 12.4691 18.5708 12.8575L6.5145 20.0913C5.84797 20.4912 5 20.0111 5 19.2338V4.76619Z"
          />
        </clipPath>
      </svg>
    </div>
  </div>
</template>

<style scoped>
.overlay-play-icon {
  width: 2.5rem;
  height: 2.5rem;
}

.overlay-play-icon__clip {
  width: 100%;
  height: 100%;
  clip-path: url(#overlay-play-icon-clip);
  background: rgba(255, 255, 255, 0.33);
  backdrop-filter: blur(2rem);
}
</style>
