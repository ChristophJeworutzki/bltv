<template>
  <div class="relative">
    <app-header />
    <app-menu />
    <div class="relative">
      <slot />
      <!-- <app-sticky-icon /> -->
    </div>
    <app-footer />
    <project-modal />
  </div>
</template>
