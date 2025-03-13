<template>
  <div class="relative">
    <app-header />
    <app-menu />
    <nuxt-link to="/">
      <app-logo />
    </nuxt-link>
    <slot />
    <app-footer />
    <project-modal />
  </div>
</template>
