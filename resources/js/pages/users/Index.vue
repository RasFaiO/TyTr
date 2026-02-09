<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useSweetAlert } from '@/composables/useSweetAlert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PageProps } from '@/types/Paginate';
import { PaginatedUser } from '@/types/User';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CirclePlus, Eye, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  users: PaginatedUser;
}>();


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuarios',
    href: '/users',
  }
];

const page = usePage<PageProps>();
const authUserId = computed(() => page.props.auth?.user?.id);
const message = computed(() => page.props.flash);

const { showFlashAlert, confirmDelete, isValidMessage } = useSweetAlert();
const msg = message.value.message ?? '';
if (isValidMessage(msg)) {
  showFlashAlert(msg);
}

const deleteUser = async (id: number) => {
  const confirmed = await confirmDelete();
  if (confirmed) {
    router.delete(`/users/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(`/users`, {
          only: ['users'],
        });
      },
      onError: (errors) => {
        console.error('Error eliminando el registro:', errors);
      }
    });
  }
}
</script>
<template>

  <Head title="Users" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size-sm>
          <Link :href="'users/create'">
            <CirclePlus /> Nuevo Usuario
          </Link>
        </Button>
      </div>
      <div class="relative min-h-0 rounded-xl border overflow-auto">
        <Card>
          <CardHeader>
            <CardTitle>Gestión de usuarios</CardTitle>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Nombre</TableHead>
                  <TableHead>Email</TableHead>
                  <TableHead>Opciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="user in users.data">
                  <TableCell>{{ user.name }}</TableCell>
                  <TableCell>{{ user.email }}</TableCell>
                  <TableCell>
                    <Button as-child size="sm" class="xl:mx-2">
                      <Link :href="route('users.show', user.id)">
                        <Eye />
                      </Link>
                    </Button>
                    <Button :disabled="user.id === authUserId" size="sm" class="cursor-pointer" variant="destructive" @click="deleteUser(user.id!)">
                      <Trash />
                    </Button>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </CardContent>
        </Card>
      </div>
      <div class="flex justify-center mt-2">
        <Pagination :links="users.links.map(link => ({
          ...link,
          url: link.url?.toString() ?? null,
          label: String(link.label),
        }))" />
      </div>
    </div>
  </AppLayout>
</template>