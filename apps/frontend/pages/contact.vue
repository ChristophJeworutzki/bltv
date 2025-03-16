<template>
  <main class="min-h-svh">
    <page-hero :media="page?.fields?.hero.media">
      <app-contact />
    </page-hero>
    <section class="pb-32 pt-8">
      <div class="container">
        <div class="grid grid-cols-12 gap-y-12">
          <div
            class="col-span-12 flex flex-col gap-6 sm:col-span-8 md:col-span-6"
          >
            <p class="type-headline">
              {{ globalData?.profile?.company }}<br />
              {{ globalData?.profile?.address }}<br />
              {{ globalData?.profile?.zip }} {{ globalData?.profile?.city }},
              {{ globalData?.profile?.country }}
            </p>
            <p class="type-headline">
              <a :href="`mailto:${globalData?.profile?.email}`">
                {{ globalData?.profile?.email }}
              </a>
              <br />
              <a :href="`tel:${globalData?.profile?.phone}`">
                {{ globalData?.profile?.phone }}
              </a>
            </p>
          </div>
          <div
            v-if="page?.fields?.paragraphs"
            class="col-span-12 sm:col-span-8 md:col-span-6"
          >
            <div class="flex flex-col gap-4">
              <div
                v-for="({ headline, paragraph }, index) in page.fields
                  .paragraphs"
                :key="index"
                class="flex flex-col gap-3 border-b pb-4"
              >
                <h3 class="type-headline-sm">{{ headline }}</h3>
                <p v-html="paragraph" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script lang="ts" setup>
useSeoMeta({
  title: "Contact",
});

const { query } = useRoute();

const { globalData } = storeToRefs(useDataStore());

const { data: page } = await useApi<Page>(`/api/v1/pages/contact`, {
  query: {
    preview: query.preview,
  },
});
</script>
