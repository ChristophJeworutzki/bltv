<template>
  <footer
    class="mb-[env(safe-area-inset-bottom)] flex w-full flex-col gap-4 p-2"
  >
    <div class="flex flex-col-reverse gap-4 lg:flex-col">
      <app-footer-logo />
      <div
        class="type-headline flex flex-col items-center justify-center whitespace-nowrap sm:gap-2 lg:flex-row"
      >
        <span>Es werde Licht.</span>
        <span>Que la lumière soit.</span>
        <span>Let there be light.</span>
        <span>光よあれ</span>
        <span>Laat daar Lig wees.</span>
      </div>
    </div>
    <app-contact compact class="sm:hidden" />
    <div
      class="flex w-full flex-col items-center text-center sm:border-b sm:border-t sm:py-2 lg:flex-row lg:justify-between lg:text-left"
    >
      <div class="order-2 flex-1 sm:order-none">
        <ul class="flex items-center gap-4 whitespace-nowrap">
          <li>
            <nuxt-link to="/contact">Impressum</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/privacy-policy">Privacy Policy</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/terms">Terms & Conditions</nuxt-link>
          </li>
        </ul>
      </div>
      <div
        v-if="globalData?.profile?.instagram"
        class="order-1 flex flex-1 items-center justify-center pb-4 sm:order-none sm:pb-0"
      >
        <a
          :href="globalData.profile.instagram"
          rel="noopener noreferrer"
          target="_blank"
        >
          Follow us on instagram
        </a>
      </div>
      <div class="order-2 flex flex-1 flex-col items-end sm:order-none">
        <p>
          © {{ currentYear }} {{ globalData?.profile?.company }}. All rights
          reserved.
        </p>
      </div>
    </div>
  </footer>
</template>

<script lang="ts" setup>
const { globalData } = storeToRefs(useDataStore());
const currentYear = new Date().getFullYear();
</script>
