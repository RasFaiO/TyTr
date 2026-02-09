<script setup lang="ts">
import ProductItemForm from '@/components/forms/ProductItemForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { unitsData } from '@/types/ItemProduct';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  id: undefined,
  product_id: null,
  slug: '',
  description: '',
  excerpt: '',
  price: 0,
  stock: 0,
  image_uri: '',
  image_file: null,
  caption_image: '',
  size: '',
  weight: '',
  color: '',
  unit: '' as unitsData,
  state: true,
  featured: false,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Sub productos',
    href: '/product_item',
  },
  {
    title: 'Crear Sub-producto',
    href: '#'
  }
];
</script>
<template>
  <Head title="Product Item create" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ProductItemForm :form="form" @submitForm="form.post(route('product_item.store'), {
          forceFormData: true,
          preserveScroll: true
        })"
      />
    </div>
  </AppLayout>
</template>