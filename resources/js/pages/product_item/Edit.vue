<script setup lang="ts">
import ProductItemForm from '@/components/forms/ProductItemForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ItemProductItem } from '@/types/ItemProduct';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
  product_item: ItemProductItem;
}>();

const form = useForm({
  id: props.product_item.id,
  product_id: props.product_item.product_id,
  slug: props.product_item.slug,
  description: props.product_item.description,
  excerpt: props.product_item.excerpt,
  price: props.product_item.price,
  stock: props.product_item.stock,
  image_uri: props.product_item.image_uri,
  image_file: null,
  caption_image: props.product_item.caption_image,
  size: props.product_item.size,
  weight: props.product_item.weight,
  color: props.product_item.color,
  unit: props.product_item.unit,
  state: props.product_item.state,
  featured: props.product_item.featured,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Sub productos',
    href: '/product_item',
  },
  {
    title: 'Editar Sub-producto',
    href: '#'
  }
];

</script>
<template>

  <Head title="Sub-product update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ProductItemForm :form="form" :updating="true"
        @submitForm="
        form.transform((data) => ({
          ...data,
          _method: 'put',
          })).post(route('product_item.update', props.product_item.id), {
            forceFormData: true,
            preserveScroll: true
          });
        "/>
    </div>
  </AppLayout>
</template>