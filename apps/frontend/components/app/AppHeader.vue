<template>
  <header class="app-header fixed left-0 top-0 z-50 w-full">
    <button
      class="absolute right-3 top-2 flex size-10 items-center justify-center rounded-full bg-white/10 backdrop-blur-lg md:hidden"
      @click="toggleMenu"
    >
      <icon-menu class="size-5" />
    </button>
    <nav class="absolute left-0 top-0 hidden p-2 md:block">
      <ul class="flex flex-col gap-0.5">
        <li>
          <nuxt-link
            to="/"
            class="app-header-nav-item"
            :class="{ active: route.path.includes('/projects') }"
          >
            Projects
          </nuxt-link>
        </li>
        <li>
          <nuxt-link to="/about" class="app-header-nav-item">About</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/events" class="app-header-nav-item">
            Events
          </nuxt-link>
        </li>
        <li>
          <nuxt-link to="/contact" class="app-header-nav-item">
            Contact
          </nuxt-link>
        </li>
      </ul>
    </nav>
    <nuxt-link to="/" @click.prevent="handleLogoClick">
      <app-logo />
    </nuxt-link>
    <div
      class="absolute right-0 top-0 hidden p-2 lg:block"
      v-if="!route.fullPath.includes('/contact')"
    >
      <app-contact compact />
    </div>
  </header>
</template>

<script lang="ts" setup>
import IconMenu from "~/assets/svg/icons/menu.svg";

const route = useRoute();
const router = useRouter();

const { menuOpen } = storeToRefs(useAppStore());

function toggleMenu() {
  menuOpen.value = !menuOpen.value;
}

function handleLogoClick() {
  if (route.path === "/") {
    window?.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  } else {
    router.push("/");
  }
}
</script>

<style lang="postcss">
.app-header-nav-item {
  @apply type-headline-sm leading-none;
  &.active {
    @apply italic;
  }
}
</style>
