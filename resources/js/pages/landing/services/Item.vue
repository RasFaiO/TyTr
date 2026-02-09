<script setup lang="ts">
import { defineProps } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import {
  DollarSign, Clock, Calendar, Users, MapPin
} from 'lucide-vue-next'
import AppLayout from '@/layouts/LandingLayout.vue';
import { Button } from '@/components/ui/button';
import { ItemServiceItem } from '@/types/ItemService';
import ImageGallery from '@/components/ImageGallery.vue';
import ReserveModal from '@/components/ReserveModal.vue';

defineProps<{
  item: ItemServiceItem;
  service: {
    name: string
    slug: string
  }
}>()
</script>

<template>

  <Head :title="item.slug" />
  <AppLayout>
    <div class="w-full">
      <!-- Banner con imagen -->
      <div class="relative w-full h-72 md:h-96 overflow-hidden">
        <img :src="`/storage/images/services/${item.image_uri}`" :alt="item.caption_image ?? item.slug"
          class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
          <h1 class="text-white text-3xl md:text-5xl font-bold text-center capitalize px-4">
            {{ item.slug.replace(/-/g, ' ') }}
          </h1>
        </div>
      </div>

      <!-- Descripción -->
      <div class="max-w-4xl mx-auto px-4 py-6 ">
        <p class="text-lg leading-relaxed" v-if="item.description">
          {{ item.description }}
        </p>
      </div>

      <!-- Detalles -->
      <div class="px-4">
        <div class="shadow-md rounded-xl max-w-4xl mx-auto px-6 py-6 mb-12">
          <h2 class="text-xl text-center font-semibold mb-4 ">Detalles del viaje</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4  text-base">
            <div class="flex items-center space-x-3" v-if="item.price">
              <DollarSign class="w-5 h-5" />
              <span><strong>Precio:</strong> ${{ Number(item.price).toLocaleString() }} Por persona </span> 
            </div>

            <div class="flex items-center space-x-3" v-if="item.duration">
              <Clock class="w-5 h-5 " />
              <span><strong>Duración:</strong> {{ item.duration }}</span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.start_date">
              <Calendar class="w-5 h-5 " />
              <span><strong>Fecha:</strong> {{ new Date(item.start_date).toLocaleDateString() }}</span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.capacity">
              <Users class="w-5 h-5 " />
              <span><strong>Cupo:</strong> {{ item.capacity }} personas</span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.location">
              <MapPin class="w-5 h-5 " />
              <span><strong>Ubicación:</strong> {{ item.location }}</span>
            </div>
          </div>

          <!-- Qué incluye -->
          <div v-if="item.included" class="mt-8">
            <h3 class="text-lg font-semibold mb-2">¿Qué incluye?</h3>
            <ul class="list-disc list-inside space-y-1 text-sm text-muted-foreground">
              <li v-for="(includedItem, index) in item.included.split('\n')" :key="index">
                {{ includedItem }}
              </li>
            </ul>
          </div>

          <div class="max-w-6xl mx-auto px-4 pb-12">
            <!-- Reserva -->
            <div class="mt-4">
              <ReserveModal :message="`${item.slug.replace(/-/g, ' ')} que se encuentra en la página web por valor de $${Number(item.price).toLocaleString()}`"/>
            </div>
            <!-- Galería de imágenes -->
            <ImageGallery :item="item.gallery ?? []" />
          </div>
        </div>

        <!-- Link de regreso -->
        <div class="max-w-6xl mx-auto px-4 mt-4 flex justify-center">
          <Button as-child size="sm" class="self-start mt-auto">
            <Link :href="`/services/${service.slug}`" class=" text-sm font-medium">
            Volver a {{ service.name }}
            </Link>
          </Button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
