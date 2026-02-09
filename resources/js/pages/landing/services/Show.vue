<script setup lang="ts">
import { defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/LandingLayout.vue';
import { Button } from '@/components/ui/button';
import { ServiceItem } from '@/types/Service';
import { Calendar, Clock, MapPin } from 'lucide-vue-next';

const props = defineProps<{
  service: ServiceItem;
}>();
</script>

<template>

  <Head :title="service.name" />
  <AppLayout>
    <div class="flex flex-col">
      <!-- Banner -->
      <div class="relative w-full h-60 md:h-96 overflow-hidden">
        <img :src="`/storage/images/services/${service.image_uri}`" :alt="service.caption_image ?? service.name"
          class="object-cover w-full h-full" />

        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Texto centrado -->
        <div class="absolute inset-0 flex items-center justify-center">
          <h1 class="text-white text-2xl md:text-4xl font-bold text-center px-4">
            {{ service.name }}
          </h1>
        </div>
      </div>

      <!-- Título y descripción -->
      <div class="max-w-6xl mx-auto px-4 py-6 text-center">
        <p class=" max-w-3xl mx-auto" v-if="service.description">
          {{ service.description }}
        </p>
      </div>

      <!-- Lista de ítems -->
      <div class="max-w-6xl mx-auto py-6 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <Card v-for="item in service.items" :key="item.id"
          class="-py-2 rounded-md overflow-hidden shadow-md flex flex-col">
          <!-- Imagen -->
          <img :src="`/storage/images/services/${item.image_uri}`" :alt="item.caption_image ?? item.slug"
            class="h-48 w-full object-cover rounded-t-md" />

          <!-- Header -->
          <CardHeader>
            <CardTitle class="text-lg capitalize">{{ item.slug.replace(/-/g, ' ') }}</CardTitle>
            <CardDescription class="line-clamp-2">
              {{ item.excerpt || 'Descripción corta no disponible' }}
            </CardDescription>
          </CardHeader>

          <!-- Contenido -->
          <CardContent class="pb-4 text-sm space-y-1">
            <!-- <p><strong>Precio:</strong> ${{ Number(item.price).toLocaleString() }}</p> -->

            <p v-if="item.location" class="flex items-center gap-2">
              <MapPin class="w-4 h-4 text-muted-foreground" />
              {{ item.location }}
            </p>
            <p v-if="item.start_date" class="flex items-center gap-2">
              <Calendar class="w-4 h-4 text-muted-foreground" />
              {{ new Date(item.start_date).toLocaleDateString() }}
            </p>
            <p class="flex items-center gap-2">
              <Clock class="w-4 h-4 text-muted-foreground" />
              {{ item.duration }}
            </p>
            <!-- <p v-if="item.capacity"><strong>Cupo:</strong> {{ item.capacity }} personas</p> -->

            <!-- Botón -->
            <div class="mt-4">
              <Button as-child size="sm" class="self-start mt-auto">
                <Link :href="`/services/${service.slug}/${item.slug}`">
                Ver más
                </Link>
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
      <div class="max-w-6xl mx-auto px-4 mt-4 flex justify-center">
        <Button as-child size="sm" class="self-start mt-auto">
          <Link href="/services">
          Regresar
          </Link>
        </Button>
      </div>
    </div>
  </AppLayout>
</template>