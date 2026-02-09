<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle, CardDescription, } from '@/components/ui/card';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious, } from '@/components/ui/carousel';
import { Button } from './ui/button';
import { Link } from '@inertiajs/vue3';
import { FeatureItems } from '@/types/FeaturedItems';
import { Calendar, Clock, MapPin } from 'lucide-vue-next';

const props = defineProps<{
  featuredItems: FeatureItems;
}>();

// const items = [
//   {
//     title: 'Explora destinos',
//     description: 'Descubre lugares increíbles con nuestros paquetes turísticos.',
//     image: 'https://images.unsplash.com/photo-1746950862855-ccd90286a57c?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Aventura extrema',
//     description: 'Vive experiencias únicas llenas de adrenalina y naturaleza.',
//     image: 'https://images.unsplash.com/photo-1747607176057-175b357ef4ab?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Cultura y tradición',
//     description: 'Conecta con comunidades locales y su riqueza cultural.',
//     image: 'https://images.unsplash.com/photo-1747372236557-6a201063ab35?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Viajes ecológicos',
//     description: 'Explora sin dejar huella con nuestras caminatas sostenibles.',
//     image: 'https://images.unsplash.com/photo-1746950862786-c13d07b85bff?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Ropa temática',
//     description: 'Encuentra camisetas y souvenirs únicos de cada viaje.',
//     image: 'https://images.unsplash.com/photo-1746121813274-50f7f8d4bad4?q=80&w=1803&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
// ];
</script>

<template>
  <div class="relative mx-auto max-w-6xl px-4">
    <Carousel class="w-full" :opts="{ align: 'center', loop: true }">
      <CarouselContent class="-ml-1 -py-4">
        <CarouselItem v-for="item in featuredItems" :key="item.id"
          class="-py-2 pl-1 sm:basis-1/2 md:basis-1/3 lg:basis-1/3">
          <div class="p-2">
            <Card class="-py-2 rounded-md overflow-hidden shadow-md">
              <img :src="`/storage/images/services/${item.image_uri}`" :alt="item.slug"
                class="h-48 w-full object-cover rounded-t-md" />
              <CardHeader>
                <CardTitle>{{ item.slug.replace(/-/g, ' ').toUpperCase() }}</CardTitle>
                <CardDescription class="line-clamp-2 mt-2">{{ item.excerpt }}</CardDescription>
              </CardHeader>
              <CardContent class="pb-4">
                <p v-if="item.location" class="flex items-center gap-2">
                  <MapPin class="w-4 h-4 text-muted-foreground" />
                  {{ item.location }}
                </p>
                <p v-if="item.start_date" class="flex items-center gap-2">
                  <Calendar class="w-4 h-4 text-muted-foreground" />
                  {{ new Date(item.start_date).toLocaleDateString() }}
                </p>
                <p class="flex items-center gap-2 mb-4">
                  <Clock class="w-4 h-4 text-muted-foreground" />
                  {{ item.duration }}
                </p>
                <Button as-child size="sm" class="self-start mt-auto">
                  <Link :href="`/services/${item.service.slug}/${item.slug}`">
                  Más información
                  </Link>
                </Button>
              </CardContent>
            </Card>
          </div>
        </CarouselItem>
      </CarouselContent>
      <CarouselPrevious class="left-0" />
      <CarouselNext class="right-0" />
    </Carousel>
    <div class="flex justify-end mt-4">
      <Button as-child size="sm">
        <Link :href="'/services'">
        Ver Tours
        </Link>
      </Button>
    </div>
  </div>
</template>
