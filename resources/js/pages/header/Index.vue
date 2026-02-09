<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useSweetAlert } from '@/composables/useSweetAlert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PaginatedHeaderImage } from '@/types/HeaderImage';
import { PageProps } from '@/types/Paginate';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CirclePlus, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  headers: PaginatedHeaderImage;
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Header principal',
    href: '/header'
  }
];

const page = usePage<PageProps>();
const message = computed(() => page.props.flash);

const { showFlashAlert, confirmDelete, isValidMessage } = useSweetAlert();
const msg = message.value.message ?? '';
if (isValidMessage(msg)) {
  showFlashAlert(msg);
}

const deleteHeader = async (id: number) => {

  const confirmed = await confirmDelete();
  if (confirmed) {
    router.delete(`/header/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(`/header`, {
          only: ['header'],
        });
      },
      onError: (errors) => {
        console.error('Error eliminando el registro:', errors);
      }
    });
  }

  // if (confirm('¿Estás seguro de que quieres eliminar este header?')) {
  //   router.delete(route('header.destroy', id), {
  //     preserveScroll: true,
  //     onSuccess: () => {
  //       // Opcional: Mostrar un mensaje de éxito
  //       alert('Encabezado eliminado correctamente.');
  //     },
  //     onError: (errors) => {
  //       // Opcional: Manejar errores
  //       console.error('Error al eliminar:', errors);
  //     }
  //   });
  // }
}
</script>
<template>

  <Head title="Header" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size-sm>
          <Link :href="'header/create'">
            <CirclePlus /> Nuevo header
          </Link>
        </Button>
      </div>
      <div class="relative min-h-0 rounded-xl border overflow-auto">
        <Card>
          <CardHeader>
            <CardTitle>Son las imagenes que se muestran en la página principal junto con su descripción</CardTitle>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Descripción</TableHead>
                  <TableHead>Imágen</TableHead>
                  <TableHead>Caption</TableHead>
                  <TableHead>Opciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="(header) in headers.data">
                  <TableCell>{{ header.description }}</TableCell>
                  <TableCell>
                    <img :src="`storage/images/header/${header.image_uri}`" :alt=header.caption
                      class="h-8 w-12 rounded object-cover" />
                  </TableCell>
                  <TableCell>{{ header.caption }}</TableCell>
                  <TableCell>
                    <Button as-child size="sm" class="xl:mx-2">
                      <Link :href="route('header.edit', header.id)">
                        <Pencil />
                      </Link>
                    </Button>
                    <Button size="sm" class="cursor-pointer" variant="destructive" @click="deleteHeader(header.id!)">
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
        <Pagination :links="headers.links.map(link => ({
          ...link,
          url: link.url?.toString() ?? null,
          label: String(link.label),
        }))" />
      </div>
    </div>
  </AppLayout>
</template>