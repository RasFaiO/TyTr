<script setup lang="ts">
// import HeaderForm from '@/components/forms/HeaderForm.vue';
import ServiceForm from '@/components/forms/ServiceForm.vue';
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
  state: true,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Servicios',
    href: '/catService'
  },
  {
    title: 'Crear servicios',
    href: '#'
  }
];

</script>
<template>

  <Head title="Service create" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ServiceForm :form="form" @submitForm="form.post(route('catService.store'), {
          forceFormData: true,
          preserveScroll: true
        })"
      />
    </div>
  </AppLayout>
</template>