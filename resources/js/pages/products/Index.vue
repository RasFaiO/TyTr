<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useSweetAlert } from '@/composables/useSweetAlert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PageProps } from '@/types/Paginate';
import { PaginatedProduct } from '@/types/Product';
import { cleanText } from '@/utils/cleanText';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CirclePlus, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  products: PaginatedProduct;
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Productos',
    href: '/catProduct'
  }
];

const page = usePage<PageProps>();
const message = computed(() => page.props.flash);

const { showFlashAlert, confirmDelete, isValidMessage } = useSweetAlert();
const msg = message.value.message ?? '';
if (isValidMessage(msg)) {
  showFlashAlert(msg);
}

const deleteProduct = async (id: number) => {
  const confirmed = await confirmDelete();
  if (confirmed) {
    router.delete(`/catProduct/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(`/catProduct`, {
          only: ['catProduct'],
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
  <Head title="Products" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size-sm>
          <Link :href="'catProduct/create'">
            <CirclePlus /> Nuevo producto
          </Link>
        </Button>

      </div>
      <div class="relative min-h-0 rounded-xl border overflow-auto">
        <Card>
          <CardHeader>
            <CardTitle>Vienen siendo las categorías principales de los productos creados para poder incluír más adelante los ítem de producto</CardTitle>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Nombre</TableHead>
                  <TableHead>Descripción</TableHead>
                  <TableHead>Imagen</TableHead>
                  <TableHead>Estado</TableHead>
                  <TableHead>Opciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="product in products.data">
                  <TableCell>{{ cleanText(product.name) }}</TableCell>
                  <TableCell>{{ product.description.slice(0,50) }}...</TableCell>
                  <TableCell>
                    <img :src="`storage/images/products/${product.image_uri}`" :alt=product.caption_image
                      class="h-8 w-12 rounded object-cover" />
                  </TableCell>
                  <TableCell :class="product.state ? 'text-green-600' : 'text-red-400'">{{ product.state ? 'Activo' : 'Inactivo' }}</TableCell>
                  <TableCell>
                    <Button as-child size="sm" class="xl:mx-2">
                      <Link :href="route('catProduct.edit', product.id)">
                        <Pencil />
                      </Link>
                    </Button>
                    <Button size="sm" class="cursor-pointer" variant="destructive"
                      @click="deleteProduct(product.id!)">
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
        <Pagination :links="products.links.map(link => ({
          ...link,
          url: link.url?.toString() ?? null,
          label: String(link.label),
        }))" />
      </div>
    </div>
  </AppLayout>
</template>