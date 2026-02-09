<script setup lang="ts">
import HeaderForm from '@/components/forms/HeaderForm.vue';
import ServiceForm from '@/components/forms/ServiceForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ServiceItem } from '@/types/Service';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
  service: ServiceItem;
}>();

const form = useForm({
  id: props.service.id,
  name: props.service.name,
  slug: props.service.slug,
  excerpt: props.service.excerpt,
  description: props.service.description,
  image_uri: props.service.image_uri,
  image_file: null,
  caption_image: props.service.caption_image,
  state: props.service.state,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Servicios',
    href: '/catService'
  },
  {
    title: 'Edición de servicios',
    href: '#'
  }
];

</script>
<template>

  <Head title="Service update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <ServiceForm :form="form" :updating="true"
        @submitForm="
        form.transform((data) => ({
          ...data,
          _method: 'put',
          })).post(route('catService.update', props.service.id), {
            forceFormData: true,
            preserveScroll: true
          })
        "/>
    </div>
  </AppLayout>
</template>