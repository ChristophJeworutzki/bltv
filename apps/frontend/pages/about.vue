<template>
  <main class="min-h-svh">
    <base-hero :media="page?.fields?.hero.media">
      <h1
        class="type-headline [&>br]:hidden sm:[&>br]:block"
        v-html="page?.fields?.hero.headline"
      />
    </base-hero>
    <section class="py-8">
      <div class="container">
        <div class="grid grid-cols-12">
          <div
            class="col-span-12 flex flex-col gap-6 sm:col-span-8 md:col-span-6"
          >
            <p class="type-headline">
              Founded by industry pioneers Lucas Gebauer and Julian Patric
              Wagner, with over a decade of experience as gaffers and lighting
              console operators, BLTV goes beyond standard lighting design.
            </p>
            <p class="type-headline">
              From planning to execution, we provide end-to-end solutions,
              including top-tier equipment and full production support. For
              tailored, camera-ready lighting, BLTV is your go-to expert.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="py-8">
      <div class="container">
        <div class="grid gap-x-4 gap-y-8 md:grid-cols-2 lg:grid-cols-3">
          <div class="flex flex-col gap-2">
            <h2 class="type-headline">Our Services</h2>
            <div class="flex flex-col border-t">
              <base-accordion open>
                <template #summery>
                  <h3>Commercial Gaffer</h3>
                </template>
                <p>
                  Die Vermittlung von Studios, der Verleih von Filmlicht und
                  Veranstaltungstechnik oder das Bereitstellen von
                  Stromaggregaten und Hubarbeitsbühnen inkl. Strom- & Rigging
                  Planung ist ein ergänzender Service, der mit unseren anderen
                  Kompetenzen zusammenläuft. Dabei sehen wir uns nicht als
                  reinen Filmlicht Verleih, sondern als Ansprechpartner für
                  Licht bei Produktionen jeglicher Art. Durch unsere gute
                  Vernetzung in verschiedenen Kreativbranchen können wir schnell
                  und effizient handeln. Unterstützt werden wir hier durch
                  unsere langjährigen Partner.
                </p>
              </base-accordion>
              <base-accordion>
                <template #summery>
                  <h3>Lighting Design</h3>
                </template>
                <p>
                  Die Vermittlung von Studios, der Verleih von Filmlicht und
                  Veranstaltungstechnik oder das Bereitstellen von
                  Stromaggregaten und Hubarbeitsbühnen inkl. Strom- & Rigging
                  Planung ist ein ergänzender Service, der mit unseren anderen
                  Kompetenzen zusammenläuft. Dabei sehen wir uns nicht als
                  reinen Filmlicht Verleih, sondern als Ansprechpartner für
                  Licht bei Produktionen jeglicher Art. Durch unsere gute
                  Vernetzung in verschiedenen Kreativbranchen können wir schnell
                  und effizient handeln. Unterstützt werden wir hier durch
                  unsere langjährigen Partner.
                </p>
              </base-accordion>
              <base-accordion>
                <template #summery>
                  <h3>Crew and Equipment Rental</h3>
                </template>
                <p>
                  Die Vermittlung von Studios, der Verleih von Filmlicht und
                  Veranstaltungstechnik oder das Bereitstellen von
                  Stromaggregaten und Hubarbeitsbühnen inkl. Strom- & Rigging
                  Planung ist ein ergänzender Service, der mit unseren anderen
                  Kompetenzen zusammenläuft. Dabei sehen wir uns nicht als
                  reinen Filmlicht Verleih, sondern als Ansprechpartner für
                  Licht bei Produktionen jeglicher Art. Durch unsere gute
                  Vernetzung in verschiedenen Kreativbranchen können wir schnell
                  und effizient handeln. Unterstützt werden wir hier durch
                  unsere langjährigen Partner.
                </p>
              </base-accordion>
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <h2 class="type-headline">D.O.P.</h2>
            <ul class="border-b">
              <li class="border-t py-1">100BLACKDOLPHINS</li>
              <li class="border-t py-1">27KM</li>
              <li class="border-t py-1">BWGTBLD GmbH</li>
              <li class="border-t py-1">100BLACKDOLPHINS</li>
              <li class="border-t py-1">27KM</li>
              <li class="border-t py-1">BWGTBLD GmbH</li>
              <li class="border-t py-1">100BLACKDOLPHINS</li>
              <li class="border-t py-1">27KM</li>
              <li class="border-t py-1">BWGTBLD GmbH</li>
            </ul>
          </div>
          <div class="flex flex-col gap-2">
            <h2 class="type-headline">Clients and Productions</h2>
            <ul class="border-b">
              <li class="border-t py-1">100BLACKDOLPHINS</li>
              <li class="border-t py-1">27KM</li>
              <li class="border-t py-1">BWGTBLD GmbH</li>
              <li class="border-t py-1">100BLACKDOLPHINS</li>
              <li class="border-t py-1">27KM</li>
              <li class="border-t py-1">BWGTBLD GmbH</li>
              <li class="border-t py-1">100BLACKDOLPHINS</li>
              <li class="border-t py-1">27KM</li>
              <li class="border-t py-1">BWGTBLD GmbH</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script lang="ts" setup>
const { query } = useRoute();

const { data: page } = await useApi<Page>(`/api/v1/pages/about`, {
  query: {
    preview: query.preview,
  },
});

useSeoMeta({
  title: "About",
});
</script>
