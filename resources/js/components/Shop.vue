<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle, CardDescription, } from '@/components/ui/card';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious, } from '@/components/ui/carousel';
import { Button } from './ui/button';
import { Link } from '@inertiajs/vue3';
// import { CheckCircle, ShieldCheck, Star } from 'lucide-vue-next'
import { FeaturedProductItems } from '@/types/FeaturedProductItems';

const props = defineProps<{
  featuredProductItems: FeaturedProductItems;
}>();

// const items = [
//   {
//     title: 'Camisas estampadas',
//     description: 'Luce genial con nuestros diseños únicos.',
//     image: 'https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Chaquetas urbanas',
//     description: 'Perfectas para climas fríos y estilos callejeros.',
//     image: 'https://images.unsplash.com/photo-1649768722421-bb3e728fb83d?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Sudaderas cómodas',
//     description: 'Ideales para descansar o explorar la ciudad.',
//     image: 'https://images.unsplash.com/photo-1616150638538-ffb0679a3fc4?q=80&w=1979&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
//   {
//     title: 'Gorras viajeras',
//     description: 'Protege tu rostro del sol con estilo.',
//     image: 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=1200&auto=format&fit=crop',
//   },
//   {
//     title: 'Camisetas aventura',
//     description: 'Inspiradas en los destinos que amamos.',
//     image: 'https://images.unsplash.com/photo-1527272918532-326a1f4d1c10?q=80&w=1962&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//   },
// ]
</script>

<template>
  <div class="relative mx-auto max-w-6xl px-4">
    <Carousel class="w-full" :opts="{ align: 'center', loop: true }">
      <CarouselContent class="-ml-1 -py-4">
        <CarouselItem v-for="item in featuredProductItems" :key="item.id"
          class="pl-1 -py-2 basis-full sm:basis-1/2 md:basis-1/3 xl:basis-1/4">
          <div class="p-2">
            <Card class="-py-2 rounded-md overflow-hidden shadow-md">
              <img :src="`/storage/images/products/${item.image_uri}`" :alt="item.slug" class="h-48 w-full object-cover" />
              <CardHeader>
                <CardTitle>{{ item.slug.replace(/-/g, ' ').toUpperCase() }}</CardTitle>
                <CardDescription>{{ item.excerpt }}</CardDescription>
              </CardHeader>
              <CardContent class="pb-4">
                <Button as-child size="sm" class="self-start mt-auto">
                  <Link :href="`/products/${item.product.slug}/${item.slug}`">
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
        <Link href="/products">Ver tienda</Link>
      </Button>
    </div>
    
  </div>
</template>
