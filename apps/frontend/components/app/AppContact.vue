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
      v-if="!compact && globalData?.profile?.instagram"
      class="w-full border-t p-2 text-center leading-none"
    >
      <nuxt-link :href="globalData.profile.instagram" target="_blank">
        Follow us on Instagram
      </nuxt-link>
    </div>
  </div>
</template>

<script lang="ts" setup>
interface Props {
  compact?: boolean;
}

const { globalData } = storeToRefs(useDataStore());

defineProps<Props>();
</script>
