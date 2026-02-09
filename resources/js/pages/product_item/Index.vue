<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useSweetAlert } from '@/composables/useSweetAlert';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PaginatedItemProduct } from '@/types/ItemProduct';
import { PageProps } from '@/types/Paginate';
import { cleanText } from '@/utils/cleanText';
import { formatMoney } from '@/utils/formatMoney';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CirclePlus, Pencil, Trash } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
  item_products: PaginatedItemProduct;
}>();


const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Sub producto',
    href: '/product_item',
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
    router.delete(`/product_item/${id}`, {
      preserveScroll: true,
      onSuccess: () => {
        router.visit(`/product_item`, {
          only: ['product_item'],
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

  <Head title="Product Item" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex">
        <Button as-child size-sm>
          <Link :href="'product_item/create'">
            <CirclePlus /> Nuevo Sub-producto
          </Link>
        </Button>

      </div>
      <div class="relative min-h-0 rounded-xl border overflow-auto">
        <Card>
          <CardHeader>
            <CardTitle>Son los productos o artículos principales que se van a publicar</CardTitle>
          </CardHeader>
          <CardContent>
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Nombre</TableHead>
                  <TableHead>Producto asociado</TableHead>
                  <TableHead>Precio</TableHead>
                  <TableHead>Stock</TableHead>
                  <TableHead>Destacado</TableHead>
                  <TableHead>Imagen</TableHead>
                  <TableHead>Estado</TableHead>
                  <TableHead>Opciones</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="item_product in item_products.data">
                  <TableCell>{{ cleanText(item_product.slug) }}</TableCell>
                  <TableCell>{{ item_product.product?.name }}</TableCell>
                  <TableCell>{{ formatMoney(item_product.price) }}</TableCell>
                  <TableCell>{{ item_product.stock }}</TableCell>
                  <TableCell>{{ item_product.featured ? 'si' : 'no' }}</TableCell>
                  <TableCell>
                    <img :src="`storage/images/products/${item_product.image_uri}`" :alt=item_product.caption_image
                      class="h-8 w-12 rounded object-cover" />
                  </TableCell>
                  <TableCell :class="item_product.state ? 'text-green-600' : 'text-red-400'">{{ item_product.state ? 'Activo' : 'Inactivo' }}</TableCell>
                  
                  <TableCell>
                    <Button as-child size="sm" class="xl:mx-2">
                      <Link :href="route('product_item.edit', item_product.id)">
                        <Pencil />
                      </Link>
                    </Button>
                    <Button size="sm" class="cursor-pointer" variant="destructive"
                      @click="deleteProduct(item_product.id!)">
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
        <Pagination :links="item_products.links.map(link => ({
          ...link,
          url: link.url?.toString() ?? null,
          label: String(link.label),
        }))" />
      </div>
    </div>
  </AppLayout>
</template>