<script setup lang="ts">
import HeaderForm from '@/components/forms/HeaderForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { HeaderImage } from '@/types/HeaderImage';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
  header: HeaderImage;
}>();

const form = useForm({
  id: props.header.id,
  description: props.header.description,
  caption: props.header.caption,
  image_uri: props.header.image_uri,
  image_file: null,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Header',
    href: '/header'
  },
  {
    title: 'Edición de header',
    href: '#'
  }
];

</script>
<template>

  <Head title="Header update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <HeaderForm :form="form" :updating="true"
        @submitForm="
        form.transform((data) => ({
          ...data,
          _method: 'put',
          })).post(route('header.update', props.header.id), {
            forceFormData: true,
            preserveScroll: true
          })
        "/>
    </div>
  </AppLayout>
</template>