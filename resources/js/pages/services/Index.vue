<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useSweetAlert } from '@/composables/useSweetAlert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PageProps } from '@/types/Paginate';
import { PaginatedService, ServicesIt } from '@/types/Service';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CirclePlus, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  services: PaginatedService;
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Servicios',
    href: '/catService',
  }
];

const page = usePage<PageProps>();
const message = computed(() => page.props.flash);

const { showFlashAlert, confirmDelete, isValidMessage } = useSweetAlert();
const msg = message.value.message ?? '';
if (isValidMessage(msg)) {
  showFlashAlert(msg);
}

const deleteService = async(id: number) => {
  const confirmed = await confirmDelete();
  if (confirmed){
    router.delete(`/catService/${id}`, {
      preserveScroll:true,
      onSuccess: () => {
        router.visit(`/catService`, {
          only: ['catService'],
        });
      },
      onError: (errors) => {
        console.error('Error eliminando el registro:', errors);
      }
    });

  // if (confirm('¿Estás seguro de que quieres eliminar el servicio?')) {
  //   router.delete(route('service.destroy', id), {
  //     preserveScroll: true,
  //     onSuccess: () => {
  //       // Opcional: Mostrar un mensaje de éxito
  //       alert('Servicio eliminado correctamente.');
  //     },
  //     onError: (errors) => {
  //       // Opcional: Manejar errores
  //       console.error('Error al eliminar:', errors);
  //     }
  //   });
  }
}
</script>
<template>

  <Head title="Services" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size-sm>
          <Link :href="'catService/create'">
          <CirclePlus /> Nuevo Servicio
          </Link>
        </Button>

      </div>
      <div class="relative min-h-0 rounded-xl border overflow-auto">
        <Card>
          <CardHeader>
            <CardTitle>Son aquellos servicios principales que categorizan cada una de las actividades que se van a realizar</CardTitle>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Nombre</TableHead>
                  <TableHead>Descripción Corta</TableHead>
                  <TableHead>Imagen</TableHead>
                  <TableHead>Estado</TableHead>
                  <TableHead>Opciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="(service) in services.data">
                  <TableCell>{{ service.name }}</TableCell>
                  <!-- <TableCell>{{ service.slug }}</TableCell> -->
                  <TableCell>{{ service.excerpt }}</TableCell>
                  <!-- <TableCell>{{ service.description }}</TableCell> -->
                  <TableCell>
                    <img :src="`storage/images/services/${service.image_uri}`" :alt=service.caption_image
                      class="h-8 w-12 rounded object-cover" />
                  </TableCell>
                  <TableCell :class="service.state ? 'text-green-600': 'text-red-400'">{{ service.state ? 'Activo' : 'Inactivo' }}</TableCell>
                  <TableCell>
                    <Button as-child size="sm" class="xl:mx-2">
                      <Link :href="route('catService.edit', service.id)">
                      <Pencil />
                      </Link>
                    </Button>
                    <Button size="sm" class="cursor-pointer" variant="destructive" @click="deleteService(service.id!)">
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
        <Pagination :links="services.links.map(link => ({
          ...link,
          url: link.url?.toString() ?? null,
          label: String(link.label),
        }))" />
      </div>
    </div>
  </AppLayout>
</template>