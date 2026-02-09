<script setup lang="ts">
import ServiceItemForm from '@/components/forms/ServiceItemForm.vue';
import UserForm from '@/components/forms/UserForm.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ItemServiceItem } from '@/types/ItemService';
import { User } from '@/types/User';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
  user: User;
}>();

const form = useForm({
  id: props.user.id,
  name: props.user.name,
  email: props.user.email,
  password: '',
  password_confirmation: '',
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuarios',
    href: '/users',
  },
  {
    title: 'Editar Usuario',
    href: '#'
  }
];

</script>
<template>

  <Head title="User update" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <UserForm :form="form" :updating="true"
        @submitForm="
        form.transform((data) => ({
          ...data,
          _method: 'put',
          })).post(route('users.update', props.user.id), {
            forceFormData: true,
            preserveScroll: true
          });
        "/>
    </div>
  </AppLayout>
</template>