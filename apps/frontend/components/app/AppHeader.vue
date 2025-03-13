<template>
  <header class="fixed left-0 top-0 z-50 w-full">
    <button
      class="absolute right-4 top-4 -ml-[14px] flex size-10 items-center justify-center rounded-full bg-white/10 backdrop-blur-lg md:hidden"
      @click="toggleMenu"
    >
      <icon-x v-if="menuOpen" class="size-5" />
      <icon-menu v-else class="size-5" />
    </button>
    <nav class="absolute left-0 top-0 hidden p-2 md:block">
      <ul class="flex flex-col gap-0.5">
        <li>
          <nuxt-link
            to="/"
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
          <nuxt-link to="/contact" class="menu-item">Contact</nuxt-link>
        </li>
      </ul>
    </nav>
    <div
      class="absolute right-0 top-0 hidden p-2 lg:block"
      v-if="!route.fullPath.includes('/contact')"
    >
      <app-contact />
    </div>
  </header>
</template>

<script lang="ts" setup>
import IconMenu from "~/assets/svg/icons/menu.svg";
import IconX from "~/assets/svg/icons/x.svg";

const route = useRoute();
const { menuOpen } = storeToRefs(useAppStore());

function toggleMenu() {
  menuOpen.value = !menuOpen.value;
}
</script>
