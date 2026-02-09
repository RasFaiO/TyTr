<script lang="ts">
export default {
  name: 'ProductForm'
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
import { computed, ref } from 'vue';
import { Textarea } from '../ui/textarea';
import { Switch } from '../ui/switch';
import { ProductItem } from '@/types/Product';

const props = defineProps<{
  form: ProductItem;
  updating?: boolean;
}>();

const stateComputed = computed({
  get: () => Boolean(props.form.state),
  set: (val: boolean) => {
    props.form.state = val;
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
  <!-- {{ form }} -->
  <Card>
    <CardHeader>
      <CardTitle>
        {{ updating ? 'Actualizar' : 'Crear' }} Producto
      </CardTitle>
      <CardDescription>
        {{ updating ? 'Actualiza' : 'Crea' }}
        el producto de la página principal
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="md:col-span-1">
              <Label for="name">Titulo de producto</Label>
              <Input id="name" type="text" required v-model="form.name" />
              <InputError :message="form.errors.name" />
            </div>
            <div class="md:col-span-1">
              <Label for="image_file">Imagen</Label>
              <Input id="image_file" type="file" accept="image/*" required @change="showImg($event)" />
              <InputError :message="form.errors.image_file" />
            </div>
            <div class="md:col-span-1">
              <Label for="caption_image">Pie de imagen</Label>
              <Input id="caption_image" type="text" required v-model="form.caption_image" />
              <InputError :message="form.errors.caption_image" />
            </div>
            <div class="md:col-span-1">
              <Label for="excerpt">Descripción corta de tarjeta</Label>
              <Input id="excerpt" type="text" required v-model="form.excerpt" />
              <InputError :message="form.errors.excerpt" />
            </div>
            <div class="md:col-span-2">
              <Label for="description">Descripción en página</Label>
              <Textarea id="description" required v-model="form.description"> </Textarea>
              <InputError :message="form.errors.description" />
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
                  <img :src="srcImage" :alt="updating ? form.caption_image : ''" class="w-full object-cover rounded-md" />
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
          <Link :href="route('catProduct.index')">
          <Undo /> Cancelar
          </Link>
        </Button>
      </div>
    </CardFooter>
  </Card>
</template>