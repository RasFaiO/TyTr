<script setup lang="ts">
import ProductForm from '@/components/forms/ProductForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  id: undefined,
  name: '',
  slug: '',
  excerpt: '',
  description: '',
  image_uri: '',
  image_file: null,
  caption_image: '',
  state: true
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Product',
    href: '/catProduct'
  },
  {
    title: 'Crear Producto',
    href: '#'
  }
];

</script>
<template>

  <Head title="Product create" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ProductForm :form="form" @submitForm="form.post(route('catProduct.store'), {
          forceFormData: true,
          preserveScroll: true
        })"
      />
    </div>
  </AppLayout>
</template>