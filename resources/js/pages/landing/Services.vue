<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/LandingLayout.vue';
import { PaginatedService } from '@/types/Service';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
  services: PaginatedService;
}>();

const bannerImage = 'https://images.unsplash.com/photo-1538362333531-6b503aaf6115?q=80&w=2063&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';

// const services = [
//   {
//     id: 1,
//     title: 'Viajes Nacionales',
//     description: 'Descubre los paisajes más hermosos de Colombia con nuestros paquetes completos.',
//     image: 'https://images.unsplash.com/photo-1710335514366-343c1cbf5563?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//     slug: 'viajes-nacionales',
//   },
//   {
//     id: 2,
//     title: 'Viajes Internacionales',
//     description: 'Viaja por el mundo con el respaldo y la experiencia de nuestros asesores.',
//     image: 'https://plus.unsplash.com/premium_photo-1733266864577-39492ffae2c9?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//     slug: 'viajes-internacionales',
//   },
//   {
//     id: 3,
//     title: 'Deportes Extremos',
//     description: 'Planificamos cada detalle de tu viaje para garantizar una experiencia única.',
//     image: 'https://plus.unsplash.com/premium_photo-1663089715245-d90a9df20742?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//     slug: 'deportes-extremos',
//   },
//   {
//     id: 5,
//     title: 'Caminatas',
//     description: 'Explora paisajes únicos y disfruta de la naturaleza con nuestras caminatas guiadas. Actividades ideales para todos los niveles, que combinan aventura, aire libre y momentos de desconexión.',
//     image: 'https://images.unsplash.com/photo-1649807990495-1b3b5c432384?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
//     slug: 'caminatas',
//   },
  
// ];
</script>
<template>
  <Head title="Servicios"/>
  <AppLayout>
    <section class="text-foreground bg-background">
      <!-- Banner -->
      <div class="h-[35vh] bg-cover bg-center flex items-center justify-center text-white text-4xl font-bold relative"
        :style="{ backgroundImage: `url('${bannerImage}')` }">
        <div class="absolute inset-0 bg-black/50"></div>
        <span class="z-10">Servicios</span>
      </div>
      <!-- Servicios -->
      <div class="max-w-6xl mx-auto px-4 pt-8 grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <Card v-for="service in services.data" :key="service.id" class="-py-2 flex flex-col overflow-hidden shadow-md">
          <!-- Imagen -->
          <img :src="'/storage/images/services/' + service.image_uri" :alt="service.caption_image" class="h-48 w-full object-cover rounded-t-md" />

          <!-- Contenido del Card -->
          <CardContent class="p-4 flex flex-col flex-1 justify-between">
            <div class="flex-1">
              <CardTitle class="text-xl text-primary mb-2">{{ service.name }}</CardTitle>
              <CardDescription class="text-sm text-muted-foreground mb-4">
                {{ service.excerpt }}
              </CardDescription>
            </div>

            <!-- Botón -->
            <Button as-child size="sm" class="self-start mt-auto">
              <Link :href="`/services/${service.slug}`">
                Ver más
              </Link>
            </Button>
          </CardContent>
        </Card>
      </div>
    </section>
  </AppLayout>
</template>
