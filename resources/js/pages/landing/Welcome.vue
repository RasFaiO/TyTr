<script lang="ts">
export default {
  name: 'WelcomeLanding'
}
</script>
<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import NextTours from '@/components/NextTours.vue';
import Header from '@/components/Header.vue';
import AppLayout from '@/layouts/LandingLayout.vue';
import Shop from '@/components/Shop.vue';
import QualityVar from '@/components/QualityVar.vue';
import { FeatureItems } from '@/types/FeaturedItems';
import { HeaderItems } from '@/types/HeaderImage';
import { FeaturedProductItems } from '@/types/FeaturedProductItems';
import { computed } from 'vue';
import { PageProps } from '@/types/Paginate';
import { useSweetAlert } from '@/composables/useSweetAlert';

const props = defineProps<{
  featuredItems: FeatureItems;
  headerImages: HeaderItems;
  featuredProductItems: FeaturedProductItems;
}>();

const page = usePage<PageProps>();
const message = computed(() => page.props.flash);

const { showFlashAlert, isValidMessage } = useSweetAlert();
const msg = message.value.message ?? '';
if (isValidMessage(msg)) {
  showFlashAlert(msg);
}

</script>
<template>
  
  <Head title="Inicio" />
  <AppLayout>
    <Header :headerImages="headerImages"/>
    <QualityVar />
    <div class="container mx-auto px-4 sm:px-8 md:px-16 my-8">
      <div class="flex items-center gap-4">
        <div class="flex-1 border-t border-gray-300 dark:border-gray-600"></div>
        <h2 class="text-center text-4xl font-semibold">
          Nuestros próximos tours
        </h2>
        <div class="flex-1 border-t border-gray-300 dark:border-gray-600"></div>
      </div>
    </div>
    <NextTours :featured-items="featuredItems"/>
    <!-- Banner -->
    <section class="relative mt-6">
      <div class="mx-auto max-w-6xl px-4">
        <div class="relative h-[35vh] w-full overflow-hidden rounded-md shadow-md">
          <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e" alt="Banner"
            class="h-full w-full object-cover" />
          <div
            class="absolute inset-0 flex flex-col items-center justify-center bg-black/40 text-white text-center px-4">
            <h2 class="text-xl md:text-3xl font-semibold mb-2">
              ¿Estás listo para nuevas aventuras?
            </h2>
            <div class="flex flex-col md:flex-row items-center gap-2">
              <p class="text-sm md:text-base break-words">Pregunta por nuestros tours y reserva ahora!</p>
            </div>
            <a href="https://wa.me/573209962319?text=Hola%2C%20estoy%20interesado%20en%20los%20tours%20que%20ofrecen"
              target="_blank"
              class="inline-block rounded bg-green-500 px-4 py-2 text-sm font-medium text-black hover:bg-green-600 transition">
              Escríbenos
            </a>
          </div>
        </div>
      </div>
    </section>

    <div class="container mx-auto px-8 my-8">
      <div class="flex items-center gap-4">
        <div class="flex-1 border-t border-gray-300 dark:border-gray-600"></div>
        <h2 class="text-center text-4xl font-semibold">
          Productos Tygua
        </h2>
        <div class="flex-1 border-t border-gray-300 dark:border-gray-600"></div>
      </div>
    </div>
    <Shop :featured-product-items="featuredProductItems" />
    <!-- {{ featuredProductItems }} -->
  </AppLayout>
</template>