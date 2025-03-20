<template>
  <main class="min-h-svh">
    <section class="py-32 sm:py-64">
      <div class="container max-w-2xl">
        <div class="flex w-full flex-col gap-12">
          <header class="flex flex-col gap-2 text-center">
            <h1 class="type-display">Privacy Policy</h1>
            <p>(Datenschutzerklärung)</p>
          </header>
          <section>
            <div class="flex flex-col gap-4">
              <div
                v-for="({ headline, paragraph }, index) in page?.fields
                  ?.paragraphs"
                :key="index"
                class="flex flex-col gap-3 border-b pb-4"
              >
                <h3 class="type-headline-sm">{{ headline }}</h3>
                <p v-html="paragraph" />
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </main>
</template>

<script lang="ts" setup>
useSeoMeta({
  title: "Privacy Policy",
});

const { query } = useRoute();

const { data: page } = await useApi<Page>(`/api/v1/pages/privacy-policy`, {
  query: {
    preview: query.preview,
  },
});
</script>
