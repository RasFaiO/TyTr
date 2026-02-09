<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from './ui/carousel';
import { ChevronLeftCircleIcon, ChevronRightCircleIcon } from 'lucide-vue-next';

const props = defineProps<{
  item: {
    image_uri: string
    caption?: string
  }[];
}>();

const selectedIndex = ref<number | null>(null);

const openZoom = (index: number) => {
  selectedIndex.value = index;
}

const closeZoom = () => {
  selectedIndex.value = null;
}

const nextImage = () => {
  if (selectedIndex.value !== null && selectedIndex.value < props.item.length - 1) {
    selectedIndex.value++;
  }
}

const prevImage = () => {
  if (selectedIndex.value !== null && selectedIndex.value > 0) {
    selectedIndex.value--;
  }
}

const selectedImage = computed(() =>
  selectedIndex.value !== null ? props.item[selectedIndex.value] : null
);

const handleKey = (e: KeyboardEvent) => {
  if (selectedIndex.value !== null) {
    if (e.key === 'ArrowRight') nextImage();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'Escape') closeZoom();
  }
}

onMounted(() => window.addEventListener('keydown', handleKey));
onUnmounted(() => window.removeEventListener('keydown', handleKey));
</script>

<template>
  <h2 class="text-2xl font-bold text-center mb-6 mt-4">Galería de imágenes</h2>
  <Carousel :opts="{ align: 'center', loop: true }" class="w-full">
    <CarouselContent class="ml-4">
      <CarouselItem v-for="(galleryItem, index) in item" :key="index"
        class="pl-1 pb-2 basis-full sm:basis-1/2 md:basis-1/3 xl:basis-1/3">
        <img :src="`/storage/images/services/gallery/${galleryItem.image_uri}`" :alt="galleryItem.caption"
          class="rounded-xl w-full h-60 object-cover cursor-zoom-in transition-transform hover:scale-105"
          @click="openZoom(index)" />
      </CarouselItem>
    </CarouselContent>
    <CarouselPrevious class="left-0" />
    <CarouselNext class="right-0" />
  </Carousel>

  <!-- Modal -->
  <div v-if="selectedImage" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4"
    @click.self="closeZoom">
    <div class="relative w-full max-w-4xl">
      <button @click="closeZoom" class="absolute top-2 right-2 text-white text-3xl font-bold z-10">
        &times;
      </button>

      <img :src="`/storage/images/services/gallery/${selectedImage.image_uri}`" :alt="selectedImage.caption"
        class="w-full rounded-lg shadow-lg object-contain max-h-[80vh] mx-auto" />

      <!-- <p v-if="selectedImage.caption" class="text-white text-center mt-4 text-lg">
        {{ selectedImage.caption }}
      </p> -->

      <button v-if="selectedIndex !== null && selectedIndex > 0" @click="prevImage"
        class="absolute top-1/2 left-4 transform -translate-y-1/2 text-white text-4xl z-10">
        <ChevronLeftCircleIcon />
      </button>

      <button v-if="selectedIndex !== null && selectedIndex < (item?.length ?? 0) - 1" @click="nextImage"
        class="absolute top-1/2 right-4 transform -translate-y-1/2 text-white text-4xl z-10">
        <ChevronRightCircleIcon/>
      </button>
    </div>
  </div>
</template>
