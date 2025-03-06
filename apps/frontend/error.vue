<template>
  <main class="flex h-dvh w-full items-center justify-center text-center">
    <div v-if="error" class="flex flex-col gap-1">
      <span>{{ error.statusCode }}</span>
      <template v-if="error.statusCode === 404">
        <span>Page Not Found</span>
      </template>
      <template v-else>
        <span>
          {{ error.message || "An error occurred" }}
        </span>
      </template>
    </div>
  </main>
</template>

<script lang="ts" setup>
import type { NuxtError } from "#app";

const props = defineProps({
  error: {
    type: Object as PropType<NuxtError>,
    required: true,
  },
});

useHead({
  title: props.error.statusCode === 404 ? "Page Not Found" : "Error",
});
</script>
