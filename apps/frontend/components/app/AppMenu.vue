<template>
  <transition name="menu">
    <div
      v-show="menuOpen"
      class="app-menu fixed left-0 top-0 z-40 h-dvh w-full overflow-auto bg-black text-white sm:hidden"
    >
      <div class="absolute left-0 top-0 h-dvh w-full">
        <div class="flex h-full w-full grow flex-col justify-between pt-20">
          <nav class="flex grow flex-col items-center justify-center">
            <ul class="flex w-full flex-col items-center px-4">
              <li>
                <nuxt-link
                  to="/projects"
                  class="menu-item"
                  :class="{ active: route.path.includes('/projects') }"
                >
                  Projects
                </nuxt-link>
              </li>
              <li>
                <nuxt-link to="/about" class="menu-item">About</nuxt-link>
              </li>
              <li>
                <nuxt-link to="/events" class="menu-item">Events</nuxt-link>
              </li>
              <li>
                <nuxt-link to="/events" class="menu-item">Contact</nuxt-link>
              </li>
            </ul>
          </nav>
          <div class="flex w-full items-center justify-center gap-4 py-5">
            <nuxt-link to="/contact">Contact</nuxt-link>
            <nuxt-link
              v-if="globalData?.profile?.instagram"
              :href="globalData.profile.instagram"
              target="_blank"
            >
              Instagram
            </nuxt-link>
            <nuxt-link
              v-if="globalData?.profile?.linkedin"
              :href="globalData.profile.linkedin"
              target="_blank"
            >
              LinkedIn
            </nuxt-link>
            <nuxt-link
              v-if="globalData?.profile?.vimeo"
              :href="globalData.profile.vimeo"
              target="_blank"
            >
              Vimeo
            </nuxt-link>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts" setup>
const route = useRoute();
const { menuOpen } = storeToRefs(useAppStore());
const { globalData } = storeToRefs(useDataStore());

watch(
  () => route.fullPath,
  () => {
    menuOpen.value = false;
  },
);
</script>

<style lang="postcss">
.menu-enter-active {
  animation: menu-in 0.5s cubic-bezier(0.65, 0, 0.35, 1);
}

.menu-leave-active {
  animation: menu-out 0.5s cubic-bezier(0.65, 0, 0.35, 1);
}

@keyframes menu-in {
  0% {
    height: 0;
  }
  100% {
    height: 100vh;
  }
}

@keyframes menu-out {
  0% {
    height: 100vh;
  }
  100% {
    height: 0;
  }
}
</style>
