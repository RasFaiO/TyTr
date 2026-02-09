<script setup lang="ts">
import ProductForm from '@/components/forms/ProductForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ProductItem } from '@/types/Product';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
  product: ProductItem;
}>();

const form = useForm({
  id: props.product.id,
  name: props.product.name,
  slug: props.product.slug,
  excerpt: props.product.excerpt,
  description: props.product.description,
  image_uri: props.product.image_uri,
  image_file: null,
  caption_image: props.product.caption_image,
  state: props.product.state,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Productos',
    href: '/catProduct'
  },
  {
    title: 'Edición de productos',
    href: '#'
  }
];

</script>
<template>

  <Head title="Product update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ProductForm :form="form" :updating="true"
        @submitForm="
        form.transform((data) => ({
          ...data,
          _method: 'put',
          })).post(route('catProduct.update', props.product.id), {
            forceFormData: true,
            preserveScroll: true
          })
        "/>
    </div>
  </AppLayout>
</template>