<script setup lang="ts">
import ServiceItemForm from '@/components/forms/ServiceItemForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ItemServiceItem } from '@/types/ItemService';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
  service_item: ItemServiceItem;
}>();

const form = useForm({
  id: props.service_item.id,
  service_id: props.service_item.service_id,
  slug: props.service_item.slug,
  description: props.service_item.description,
  excerpt: props.service_item.excerpt,
  price: props.service_item.price,
  included: props.service_item.included,
  duration: props.service_item.duration,
  state: props.service_item.state,
  image_uri: props.service_item.image_uri,
  image_file: null,
  caption_image: props.service_item.caption_image,
  location: props.service_item.location,
  capacity: props.service_item.capacity,
  start_date: props.service_item.start_date,
  featured: props.service_item.featured,
  position: props.service_item.position,
  gallery: props.service_item.gallery,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Sub servicios',
    href: '/service_item',
  },
  {
    title: 'Editar Sub-servicio',
    href: '#'
  }
];

</script>
<template>

  <Head title="Sub-service update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ServiceItemForm :form="form" :updating="true"
        @submitForm="
        form.transform((data) => ({
          ...data,
          _method: 'put',
          })).post(route('service_item.update', props.service_item.id), {
            forceFormData: true,
            preserveScroll: true
          });
        "/>
    </div>
  </AppLayout>
</template>