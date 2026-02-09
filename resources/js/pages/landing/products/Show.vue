<script setup lang="ts">
import { defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/LandingLayout.vue';
import { Button } from '@/components/ui/button';
import { Droplet, Package, Ruler, Scale, Weight } from 'lucide-vue-next';
import { ProductItem } from '@/types/Product';

const props = defineProps<{
  product: ProductItem;
}>();
</script>

<template>

  <Head :title="product.name" />
  <AppLayout>
    <div class="flex flex-col">
      <!-- Banner -->
      <div class="relative w-full h-60 md:h-96 overflow-hidden">
        <img :src="`/storage/images/products/${product.image_uri}`" :alt="product.caption_image ?? product.name"
          class="object-cover w-full h-full" />

        <!-- Overlay oscuro -->
        <div class="absolute inset-0 bg-black/30"></div>

        <!-- Texto centrado -->
        <div class="absolute inset-0 flex items-center justify-center">
          <h1 class="text-white text-2xl md:text-4xl font-bold text-center px-4">
            {{ product.name }}
          </h1>
        </div>
      </div>

      <!-- Título y descripción -->
      <div class="max-w-6xl mx-auto px-4 py-6 text-center">
        <p class=" max-w-3xl mx-auto" v-if="product.description">
          {{ product.description }}
        </p>
      </div>

      <!-- Lista de ítems -->
      <div class="max-w-6xl mx-auto py-6 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <Card v-for="item in product.items" :key="item.id"
          class="-py-2 rounded-md overflow-hidden shadow-md flex flex-col">
          <!-- Imagen -->
          <img :src="`/storage/images/products/${item.image_uri}`" :alt="item.caption_image ?? item.slug"
            class="h-48 w-full object-cover rounded-t-md" />

          <!-- Header -->
          <CardHeader>
            <CardTitle class="text-lg capitalize">{{ item.slug.replace(/-/g, ' ') }}</CardTitle>
            <CardDescription class="line-clamp-2">
              {{ item.excerpt || 'Sin descripción corta disponible' }}
            </CardDescription>
          </CardHeader>

          <!-- Contenido -->
          <CardContent class="pb-4 text-sm space-y-1">

            <p v-if="item.stock" class="flex items-center gap-2">
              <Package class="w-4 h-4 text-muted-foreground" />
              Existencias: {{ item.stock }}
            </p>
            <p v-if="item.size" class="flex items-center gap-2">
              <Ruler class="w-4 h-4 text-muted-foreground" />
              Talla: {{ item.size }}
            </p>
            <p v-if="item.weight" class="flex items-center gap-2">
              <Weight class="w-4 h-4 text-muted-foreground" />
              Peso aprox: {{ item.weight }}
            </p>
            <p v-if="item.color" class="flex items-center gap-2">
              <Droplet class="w-4 h-4 text-muted-foreground" />
              Color: {{ item.color }}
            </p>
            <p v-if="item.unit" class="flex items-center gap-2">
              <Scale class="w-4 h-4 text-muted-foreground" />
              Presentación: {{ item.unit }}
            </p>

            <!-- Botón -->
            <div class="mt-4">
              <Button as-child size="sm" class="self-start mt-auto">
                <Link :href="`/products/${product.slug}/${item.slug}`">
                Ver más
                </Link>
              </Button>
            </div>
          </CardContent>
        </Card>
      </div>
      <div class="max-w-6xl mx-auto px-4 mt-4 flex justify-center">
        <Button as-child size="sm" class="self-start mt-auto">
          <Link href="/products">
          Regresar
          </Link>
        </Button>
      </div>
    </div>
  </AppLayout>
</template>