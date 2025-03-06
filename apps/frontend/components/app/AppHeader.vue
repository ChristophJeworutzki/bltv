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
            class="type-headline leading-none hover:italic"
            :class="{ active: route.path.includes('/projects') }"
          >
            Projects
          </nuxt-link>
        </li>
        <li>
          <nuxt-link
            to="/about"
            class="type-headline leading-none hover:italic"
          >
            About
          </nuxt-link>
        </li>
        <li>
          <nuxt-link
            to="/events"
            class="type-headline leading-none hover:italic"
          >
            Events
          </nuxt-link>
        </li>
        <li>
          <nuxt-link
            to="/contact"
            class="type-headline leading-none hover:italic"
          >
            Contact
          </nuxt-link>
        </li>
      </ul>
    </nav>
    <div class="absolute right-0 top-0 hidden p-2 lg:block">
      <div class="flex min-w-[22.5rem] flex-col items-center border-b">
        <div class="w-full border-t p-2 text-center leading-none">
          {{ globalData?.profile?.company }}
        </div>
        <div class="w-full border-t p-2 text-center leading-none">
          {{ globalData?.profile?.address }}
        </div>
        <div class="w-full border-t p-2 text-center leading-none">
          {{ globalData?.profile?.zip }} {{ globalData?.profile?.city }},
          {{ globalData?.profile?.country }}
        </div>
        <div
          v-if="globalData?.profile?.instagram"
          class="w-full border-t p-2 text-center leading-none"
        >
          <a
            :href="globalData.profile.instagram"
            rel="noopener noreferrer"
            target="_blank"
          >
            Follow us on instagram
          </a>
        </div>
      </div>
    </div>
  </header>
</template>

<script lang="ts" setup>
import IconMenu from "~/assets/svg/icons/menu.svg";
import IconX from "~/assets/svg/icons/x.svg";

const route = useRoute();
const { menuOpen } = storeToRefs(useAppStore());
const { globalData } = storeToRefs(useDataStore());

function toggleMenu() {
  menuOpen.value = !menuOpen.value;
}
</script>
