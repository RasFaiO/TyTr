<script setup lang="ts">
import Autoplay from 'embla-carousel-autoplay';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious, } from '@/components/ui/carousel';
import { HeaderItems } from '@/types/HeaderImage';

const props = defineProps<{
  headerImages: HeaderItems;
}>();

</script>

<template>
  <Carousel :opts="{ loop: true }" class="relative w-full h-[calc(100vh-54px)]" :plugins="[Autoplay({ delay: 6000 })]">
    <CarouselContent class="h-[calc(100vh-54px)]">
      <CarouselItem v-for="image in headerImages" :key="image.id" class="relative h-full">
        <img :src="`/storage/images/header/${image.image_uri}`" :alt="`${image.caption}`"
          class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
          <component :is="image.image_uri === 'header.jpg' ? 'h1' : 'h2'"
            class="text-white text-4xl font-bold text-center px-4 break-words">
            {{ image.description }}
          </component>
        </div>
      </CarouselItem>
    </CarouselContent>

    <!-- Controles -->
    <CarouselPrevious class="absolute left-4 top-1/2 -translate-y-1/2 z-10" />
    <CarouselNext class="absolute right-4 top-1/2 -translate-y-1/2 z-10" />

    <!-- Indicadores -->
  </Carousel>
</template>
