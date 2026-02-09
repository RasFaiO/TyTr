<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useSweetAlert } from '@/composables/useSweetAlert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PaginatedItemService } from '@/types/ItemService';
import { PageProps } from '@/types/Paginate';
import { cleanText } from '@/utils/cleanText';
import { formatMoney } from '@/utils/formatMoney';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CirclePlus, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  item_services: PaginatedItemService;
}>();


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Sub servicios',
    href: '/service_item',
  }
];

const page = usePage<PageProps>();
const message = computed(() => page.props.flash);

const { showFlashAlert, confirmDelete, isValidMessage } = useSweetAlert();
const msg = message.value.message ?? '';
if (isValidMessage(msg)) {
  showFlashAlert(msg);
}

const deleteService = async (id: number) => {

  const confirmed = await confirmDelete();
  if (confirmed) {
    router.delete(`/service_item/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(`/service_item`, {
          only: ['service_item'],
        });
      },
      onError: (errors) => {
        console.error('Error eliminando el registro:', errors);
      }
    });
  }
  // if (confirm('¿Estás seguro de que quieres eliminar el sub-servicio?')) {
  //   router.delete(route('service_item.destroy', id), {
  //     preserveScroll: true,
  //     onSuccess: () => {
  //       // Opcional: Mostrar un mensaje de éxito
  //       alert('Sub-servicio eliminado correctamente.');
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

  <Head title="Service Item" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size-sm>
          <Link :href="'service_item/create'">
            <CirclePlus /> Nuevo Sub-servicio
          </Link>
        </Button>

      </div>
      <div class="relative min-h-0 rounded-xl border overflow-auto">
        <Card>
          <CardHeader>
            <CardTitle>Son aquellas actividades principales que se van a publicar</CardTitle>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Nombre</TableHead>
                  <TableHead>Servicio asociado</TableHead>
                  <TableHead>Precio</TableHead>
                  <TableHead>Estado</TableHead>
                  <TableHead>Imagen</TableHead>
                  <TableHead>Destacado</TableHead>
                  <TableHead>Opciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="item_service in item_services.data">
                  <TableCell>{{ cleanText(item_service.slug) }}</TableCell>
                  <TableCell>{{ item_service.service?.name }}</TableCell>
                  <TableCell>{{ formatMoney(item_service.price) }}</TableCell>
                  <TableCell :class="item_service.state ? 'text-green-600' : 'text-red-400'">{{ item_service.state ? 'Activo' : 'Inactivo' }}</TableCell>
                  <TableCell>
                    <img :src="`storage/images/services/${item_service.image_uri}`" :alt=item_service.caption_image
                      class="h-8 w-12 rounded object-cover" />
                  </TableCell>
                  <TableCell>{{ item_service.featured ? 'si' : 'no' }}</TableCell>
                  <TableCell>
                    <Button as-child size="sm" class="xl:mx-2">
                      <Link :href="route('service_item.edit', item_service.id)">
                        <Pencil />
                      </Link>
                    </Button>
                    <Button size="sm" class="cursor-pointer" variant="destructive"
                      @click="deleteService(item_service.id!)">
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
        <Pagination :links="item_services.links.map(link => ({
          ...link,
          url: link.url?.toString() ?? null,
          label: String(link.label),
        }))" />
      </div>
    </div>
  </AppLayout>
</template>