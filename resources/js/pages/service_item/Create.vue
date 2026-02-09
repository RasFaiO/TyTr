<script setup lang="ts">
import ServiceItemForm from '@/components/forms/ServiceItemForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  id: undefined,
  service_id: null,
  slug: '',
  description: '',
  excerpt: '',
  price: 0,
  included: '',
  duration: '',
  state: true,
  image_uri: '',
  image_file: null,
  caption_image: '',
  location: '',
  capacity: 0,
  start_date: '',
  featured: false,
  position: 0,
  gallery: []
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Sub servicios',
    href: '/service_item',
  },
  {
    title: 'Crear Sub-servicio',
    href: '#'
  }
];

</script>
<template>

  <Head title="Service Item create" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ServiceItemForm :form="form" @submitForm="form.post(route('service_item.store'), {
          forceFormData: true,
          preserveScroll: true
        })"
      />
    </div>
  </AppLayout>
</template>