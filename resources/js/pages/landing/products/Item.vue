<script setup lang="ts">
import { defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { DollarSign, Package, Ruler, Droplet, Weight } from 'lucide-vue-next';
import AppLayout from '@/layouts/LandingLayout.vue';
import { Button } from '@/components/ui/button';
import { ItemProductItem } from '@/types/ItemProduct';
import BuyModal from '@/components/BuyModal.vue';
import AddToCartButton from '@/components/AddToCartButton.vue';

defineProps<{
  item: ItemProductItem;
  product: {
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
        <img :src="`/storage/images/products/${item.image_uri}`" :alt="item.caption_image ?? item.slug"
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
          <h2 class="text-xl text-center font-semibold mb-4 ">Detalles del producto</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4  text-base">
            <div class="flex items-center space-x-3" v-if="item.price">
              <DollarSign class="w-5 h-5" />
              <span><strong>Precio:</strong> ${{ Number(item.price).toLocaleString() }} </span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.stock">
              <Package class="w-5 h-5 " />
              <span><strong>Existencias:</strong> {{ item.stock }}</span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.size">
              <Ruler class="w-5 h-5 " />
              <span><strong>Talla:</strong> {{ item.size }}</span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.weight">
              <Weight class="w-5 h-5 " />
              <span><strong>Peso aprox:</strong> {{ item.weight }}</span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.color">
              <Droplet class="w-5 h-5 " />
              <span><strong>Color:</strong> {{ item.color }} </span>
            </div>

            <div class="flex items-center space-x-3" v-if="item.unit">
              <Droplet class="w-5 h-5 " />
              <span><strong>Presentación:</strong> {{ item.unit }} </span>
            </div>
            <!-- Botón Agregar al carrito -->
            <div class="col-span-1 sm:col-span-2 mt-4">
              <div class="flex flex-col sm:flex-row justify-center items-center gap-6 ">
                <div class="flex flex-col sm:flex-row justify-center items-center sm:gap-48 gap-y-4">
                  <AddToCartButton
                    :product="{ id: item.id, name: item.slug.replace(/-/g, ' '), price: item.price, quantity: 1, stock: item.stock }" />
                  <BuyModal />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Link de regreso -->
        <div class="max-w-6xl mx-auto px-4 mt-4 flex justify-center">
          <Button as-child size="sm" class="self-start mt-auto">
            <Link :href="`/products/${product.slug}`" class=" text-sm font-medium">
            Volver a {{ product.name }}
            </Link>
          </Button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
