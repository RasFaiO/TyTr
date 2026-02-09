<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/LandingLayout.vue';
import { PaginatedProduct } from '@/types/Product';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps<{
  products: PaginatedProduct;
}>();

const bannerImage = 'https://images.unsplash.com/photo-1577538928305-3807c3993047?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
</script>
<template>

  <Head title="Productos" />
  <AppLayout>
    <section class="text-foreground bg-background">
      <!-- Banner -->
      <div class="h-[35vh] bg-cover bg-center flex items-center justify-center text-white text-4xl font-bold relative"
        :style="{ backgroundImage: `url('${bannerImage}')` }">
        <div class="absolute inset-0 bg-black/50"></div>
        <span class="z-10">Productos</span>
      </div>
      <!-- Servicios -->
      <div class="max-w-6xl mx-auto px-4 pt-8 grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <Card v-for="product in products.data" :key="product.id" class="-py-2 flex flex-col overflow-hidden shadow-md">
          <!-- Imagen -->
          <img :src="'/storage/images/products/' + product.image_uri" :alt="product.caption_image"
            class="h-48 w-full object-cover rounded-t-md" />

          <!-- Contenido del Card -->
          <CardContent class="p-4 flex flex-col flex-1 justify-between">
            <div class="flex-1">
              <CardTitle class="text-xl text-primary mb-2">{{ product.name }}</CardTitle>
              <CardDescription class="text-sm text-muted-foreground mb-4">
                {{ product.excerpt }}
              </CardDescription>
            </div>

            <!-- Botón -->
            <Button as-child size="sm" class="self-start mt-auto">
              <Link :href="`/products/${product.slug}`">
              Ver más
              </Link>
            </Button>
          </CardContent>
        </Card>
      </div>
    </section>
  </AppLayout>
</template>