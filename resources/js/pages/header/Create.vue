<script setup lang="ts">
import HeaderForm from '@/components/forms/HeaderForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

// const props = defineProps<{
//   header: HeaderImage;
// }>();

const form = useForm({
  id: undefined,
  description: '',
  caption: '',
  image_uri: '',
  image_file: null,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Header',
    href: '/header'
  },
  {
    title: 'Crear header',
    href: '#'
  }
];

</script>
<template>

  <Head title="Header update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <HeaderForm :form="form" @submitForm="form.post(route('header.store'), {
          forceFormData: true,
          preserveScroll: true
        })"
      />
    </div>
  </AppLayout>
</template>