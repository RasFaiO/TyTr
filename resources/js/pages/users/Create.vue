<script setup lang="ts">
import ServiceItemForm from '@/components/forms/ServiceItemForm.vue';
import UserForm from '@/components/forms/UserForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  id: undefined,
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuarios',
    href: '/users',
  },
  {
    title: 'Crear usuario',
    href: '#'
  }
];

</script>
<template>

  <Head title="Service Item create" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <UserForm :form="form" @submitForm="form.post(route('users.store'), {
          forceFormData: true,
          preserveScroll: true
        })"
      />
    </div>
  </AppLayout>
</template>