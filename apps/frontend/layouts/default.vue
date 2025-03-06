<template>
  <app-intro @completed="onIntroCompleted" />
  <div v-show="!introSkipped" class="relative">
    <app-header
      :class="{
        '!absolute': !introCompleted,
      }"
    />
    <app-menu v-if="introCompleted" />
    <nuxt-link to="/">
      <app-logo
        :class="{
          '!absolute': !introCompleted,
        }"
      />
    </nuxt-link>
    <slot />
    <app-footer />
    <project-modal />
  </div>
</template>

<script lang="ts" setup>
const { introSkipped, introCompleted } = storeToRefs(useAppStore());

function onIntroCompleted() {
  introCompleted.value = true;
}
</script>
