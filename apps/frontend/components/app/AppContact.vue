<template>
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
</template>

<script lang="ts" setup>
const { globalData } = storeToRefs(useDataStore());
</script>
