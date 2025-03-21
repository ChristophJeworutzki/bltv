<template>
  <transition name="menu">
    <div
      v-show="menuOpen"
      class="app-menu fixed left-0 top-0 z-50 h-dvh w-full overflow-auto bg-white text-black sm:hidden"
    >
      <button
        class="absolute right-3 top-2 z-10 flex size-10 items-center justify-center rounded-full bg-black/10 backdrop-blur-lg"
        @click="closeMenu"
      >
        <icon-x class="size-5" />
      </button>
      <app-logo />
      <div class="absolute left-0 top-0 h-dvh w-full">
        <div class="flex h-full w-full grow flex-col justify-between pt-20">
          <nav class="flex grow flex-col items-center justify-center">
            <ul class="flex w-full flex-col items-center gap-2 px-4">
              <li>
                <nuxt-link
                  to="/"
                  class="app-menu-nav-item"
                  :class="{ active: route.path.includes('/projects') }"
                >
                  Projects
                </nuxt-link>
              </li>
              <li>
                <nuxt-link to="/about" class="app-menu-nav-item">
                  About
                </nuxt-link>
              </li>
              <li>
                <nuxt-link to="/events" class="app-menu-nav-item">
                  Events
                </nuxt-link>
              </li>
              <li>
                <nuxt-link to="/contact" class="app-menu-nav-item">
                  Contact
                </nuxt-link>
              </li>
            </ul>
          </nav>
          <div
            class="flex w-full flex-col items-center justify-center gap-6 px-2 pb-5"
          >
            <nuxt-link
              v-if="globalData?.profile?.instagram"
              :href="globalData.profile.instagram"
              target="_blank"
            >
              Follow us on instagram
            </nuxt-link>
            <ul class="flex w-full flex-col items-center border-b text-center">
              <li class="w-full border-t py-1">
                <nuxt-link to="/contact">Impressum</nuxt-link>
              </li>
              <li class="w-full border-t py-1">
                <nuxt-link to="/privacy-policy">Privacy Policy</nuxt-link>
              </li>
              <li class="w-full border-t py-1">
                <nuxt-link to="/terms">Terms & Conditions</nuxt-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script lang="ts" setup>
import IconX from "~/assets/svg/icons/x.svg";

const route = useRoute();
const { menuOpen } = storeToRefs(useAppStore());
const { globalData } = storeToRefs(useDataStore());

watch(
  () => route.fullPath,
  () => {
    menuOpen.value = false;
  },
);

function closeMenu() {
  menuOpen.value = false;
}
</script>

<style lang="postcss">
.app-menu-nav-item {
  @apply type-display leading-none;
  &.active {
    @apply italic;
  }
}

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
