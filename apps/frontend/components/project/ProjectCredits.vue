<template>
  <section v-if="credits?.length" class="project-credits py-48">
    <div class="container">
      <div class="flex flex-col items-center justify-center gap-4">
        <h2 class="type-headline">Credits</h2>
        <ul class="flex w-full max-w-[32rem] flex-col items-center border-b">
          <li
            v-for="(credit, index) in credits"
            :key="index"
            class="flex w-full justify-between gap-2 border-t py-2 text-center leading-none"
          >
            <span>
              {{ credit.role }}
            </span>
            <span>
              {{ credit.name }}
            </span>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script lang="ts" setup>
interface Props {
  credits: Credit[];
}

defineProps<Props>();
</script>
