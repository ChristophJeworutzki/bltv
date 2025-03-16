<template>
  <footer
    class="mb-[env(safe-area-inset-bottom)] flex w-full flex-col gap-4 p-2 lg:p-2"
  >
    <div class="flex flex-col-reverse gap-4 lg:flex-col">
      <app-footer-logo />
      <div
        class="type-headline flex flex-col items-center justify-center gap-2 whitespace-nowrap leading-none lg:flex-row"
      >
        <span>Es werde Licht.</span>
        <span>Que la lumière soit.</span>
        <span>Let there be light.</span>
        <span>光よあれ</span>
        <span>Laat daar Lig wees.</span>
      </div>
    </div>
    <div
      class="flex w-full flex-col items-center border-b border-t py-2 text-center lg:flex-row lg:justify-between lg:text-left"
    >
      <div class="flex-1">
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
        class="flex flex-1 items-center justify-center"
      >
        <a
          :href="globalData.profile.instagram"
          rel="noopener noreferrer"
          target="_blank"
        >
          Follow us on instagram
        </a>
      </div>
      <div class="flex flex-1 flex-col items-end">
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
