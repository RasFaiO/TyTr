<script lang="ts">
export default {
  name: 'ProductItemForm'
}
</script>
<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../ui/card';
import { Label } from '../ui/label';
import { Input } from '../ui/input';
import InputError from '../InputError.vue';
import { Button } from '../ui/button';
import { Save, Undo } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { computed, ref, watch, watchEffect } from 'vue';
import { Textarea } from '../ui/textarea';
import { Switch } from '../ui/switch';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '../ui/select';
import api from '@/api/axios';
import { ItemProductItem, unitsData } from '@/types/ItemProduct';

const props = defineProps<{
  form: ItemProductItem;
  updating?: boolean;
}>();

// Productos
const products = ref<{ id: number; name: string; slug: string; }[]>([]);
// Selector de producto
const selectedProduct = ref<number | null>(props.form.product_id ?? null);
const selectedProductData = computed<{ id: number; name: string; slug: string; } | null>(() => {
  if (!selectedProduct.value) return null;
  return (
    products.value.find(p => p.id === selectedProduct.value) ?? null
  );
});
const selectedUnit = ref<unitsData>(props.form.unit ?? null);
// Cargar los productos
const loadProducts = async () => {
  const { data } = await api.get('/products');
  products.value = data;
}

const isClothes = computed<boolean>(() => {
  if (!selectedProductData.value) return true;
  return selectedProductData.value.slug
    .toLowerCase()
    .includes('clothes');
});

const units = ['UNIDAD', 'DOCENA', 'GRAMOS', 'LITROS'];

// Escuchar cambios en el selector de servicios
watch(selectedProduct, (value) => {
  props.form.product_id = value;
});

watch(selectedUnit, (value) => {
  props.form.unit = value;
});

const title = ref<string>('');
const fromSlug = (slug: string) => {
  return slug.replace(/-/g, ' ').trim();
};

const toSlug = (text: string) => {
  return text
    .toLowerCase()
    .trim()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9\s-]/g, '')
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-')
};

watch(title, (value) => {
  props.form.slug = toSlug(value)
});

watchEffect(() => {
  loadProducts();
  if (props.updating) {
    title.value = fromSlug(props.form.slug);
  }
});

const stateComputed = computed({
  get: () => Boolean(props.form.state),
  set: (val: boolean) => {
    props.form.state = val;
  }
});

const featuredComputed = computed({
  get: () => Boolean(props.form.featured),
  set: (val: boolean) => {
    props.form.featured = val;
  }
});

const path = "/storage/images/products/";
const path_name = props.form.image_uri;
const srcImage = ref(`${path}${path_name}`);

if (!props.updating) {
  srcImage.value = '';
}

const emit = defineEmits(['submitForm', 'updateForm']);

const showImg = (e: Event) => {
  const target = e.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];
    srcImage.value = URL.createObjectURL(file);
    props.form.image_file = file;
  }
};

const submitForm = (e: Event) => {
  e.preventDefault();
  emit('submitForm');
}
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>
        {{ updating ? 'Actualizar' : 'Crear' }} Sub-producto
      </CardTitle>
      <CardDescription>
        {{ updating ? 'Actualiza' : 'Crea' }}
        el subproducto o item que dependerá del producto principal, por ejemplo, ropa, despensa...
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="md:col-span-1">
              <Label for="product_id">Producto</Label>
              <Select id="product_id" v-model="selectedProduct" :disabled="updating">
                <SelectTrigger>
                  <SelectValue placeholder="Seleccione un producto" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectItem v-for="product in products" :key="product.id" :value="product.id">
                      {{ product.name }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <InputError :message="form.errors.product_id" />
            </div>
            <div class="md:col-span-1">
              <Label for="slug">Titulo de sub-producto</Label>
              <Input id="slug" type="text" required v-model="title" />
              <InputError :message="form.errors.slug" />
            </div>
            <div class="md:col-span-1">
              <Label for="price">Precio</Label>
              <Input id="price" type="number" required v-model="form.price" />
              <InputError :message="form.errors.price" />
            </div>
            <div class="md:col-span-1">
              <Label for="stock">Stock disponible</Label>
              <Input id="stock" type="number" required v-model="form.stock" />
              <InputError :message="form.errors.stock" />
            </div>
            <div class="md:col-span-1">
              <Label for="image_file">Imagen principal</Label>
              <Input id="image_file" type="file" accept="image/*" :required="!updating" @change="showImg($event)" />
              <InputError :message="form.errors.image_file" />
            </div>
            <div class="md:col-span-1">
              <Label for="caption_image">Pie de imagen</Label>
              <Input id="caption_image" type="text" required v-model="form.caption_image" />
              <InputError :message="form.errors.caption_image" />
            </div>
            <div v-if="isClothes" class="grid md:grid-cols-2 md:col-span-2 gap-4">
              <div class="md:col-span-1">
                <Label for="size">Talla</Label>
                <Input id="size" type="text" required v-model="form.size" />
                <InputError :message="form.errors.size" />
              </div>
              <div class="md:col-span-1">
                <Label for="color">Color</Label>
                <Input id="color" type="text" required v-model="form.color" />
                <InputError :message="form.errors.color" />
              </div>
            </div>
            <div v-if="!isClothes" class="grid md:grid-cols-2 md:col-span-2 gap-4">
              <div class="md:col-span-1">
                <Label for="unit">Unidad de medida</Label>
                <Select id="unit" v-model="selectedUnit">
                  <SelectTrigger>
                    <SelectValue placeholder="Seleccione uno" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectGroup>
                      <SelectItem v-for="unit in units" :key="unit" :value="unit">
                        {{ unit }}
                      </SelectItem>
                    </SelectGroup>
                  </SelectContent>
                </Select>
                <InputError :message="form.errors.unit" />
              </div>
              <div class="md:col-span-1">
                <Label for="weight">Peso</Label>
                <Input id="weight" type="text" required v-model="form.weight" />
                <InputError :message="form.errors.weight" />
              </div>
            </div>
            <div class="md:col-span-2">
              <Label for="description">Descripción completa</Label>
              <Textarea id="description" required v-model="form.description"> </Textarea>
              <InputError :message="form.errors.description" />
            </div>
            <div class="md:col-span-2 pb-4">
              <Label for="excerpt">Descripción corta "info en tarjeta del home"</Label>
              <Input class="h-full" id="excerpt" type="text" required v-model="form.excerpt" />
              <InputError :message="form.errors.excerpt" />
            </div>
            <div class="md:col-span-1">
              <Label for="featured">Ver en Inicio</Label>
              <Switch class="mt-2" v-model="featuredComputed" />
              <InputError :message="form.errors.state" />
            </div>
            <div class="md:col-span-1">
              <Label for="state">Estado</Label>
              <Switch class="mt-2" v-model="stateComputed" />
              <InputError :message="form.errors.state" />
            </div>
            <div v-if="srcImage" class="md:col-span-1">
              <div>
                <Label for="image_preview">Vista previa de imagen</Label>
                <div class="mt-2">
                  <img :src="srcImage" :alt="updating ? form.caption_image : ''"
                    class="w-full object-cover rounded-md" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </CardContent>
    <CardFooter>
      <div class="w-full flex justify-end gap-4 p-4">
        <Button type="submit" class="cursor-pointer" size-sm @click="submitForm">
          <Save />
          {{ updating ? 'Actualizar' : 'Crear' }}
        </Button>
        <Button as-child size-sm variant="destructive">
          <Link :href="route('product_item.index')">
            <Undo /> Cancelar
          </Link>
        </Button>
      </div>
    </CardFooter>
  </Card>
</template>