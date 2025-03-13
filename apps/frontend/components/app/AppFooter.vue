<template>
  <footer
    class="mb-[env(safe-area-inset-bottom)] mt-32 flex w-full flex-col gap-4 p-2 lg:p-2"
  >
    <div class="w-full py-2 text-white/10">
      <logo class="h-auto w-full" />
    </div>
    <div
      class="type-headline flex flex-col items-center justify-center gap-2 whitespace-nowrap leading-none lg:flex-row"
    >
      <span>Es werde Licht.</span>
      <span>Que la lumière soit.</span>
      <span>Let there be light.</span>
      <span>光よあれ</span>
      <span>Laat daar Lig wees.</span>
    </div>
    <div
      class="flex w-full flex-col items-center border-b border-t py-2 text-center lg:flex-row lg:justify-between lg:text-left"
    >
      <div class="flex-1">
        <ul class="flex items-center gap-4 whitespace-nowrap">
          <li>
            <nuxt-link to="/">Impressum</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/">Privacy Policy</nuxt-link>
          </li>
          <li>
            <nuxt-link to="/">Terms & Conditions</nuxt-link>
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
        <p>© {{ currentYear }} BLTV GmbH. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<script lang="ts" setup>
import Logo from "~/assets/svg/logos/logo.svg";

const { globalData } = storeToRefs(useDataStore());
const currentYear = new Date().getFullYear();
</script>
