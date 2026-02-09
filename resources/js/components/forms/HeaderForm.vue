<script lang="ts">
export default {
  name: 'HeaderForm'
}
</script>
<script setup lang="ts">
import { HeaderImage } from '@/types/HeaderImage';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../ui/card';
import { Label } from '../ui/label';
import { Input } from '../ui/input';
import InputError from '../InputError.vue';
import { Button } from '../ui/button';
import { Save, Undo } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
  form: HeaderImage;
  updating?: boolean;
}>();

const path = "/storage/images/header/";
let name = props.form.image_uri;
const srcImage = ref(`${path}${name}`);

if (!props.updating) {
  srcImage.value = '';
} 

const emit = defineEmits(['submitForm', 'updateForm']);

const showImg = (e: Event) => {
  const target = e.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];

    // console.log('Archivo seleccionado:', file);
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
        {{ updating ? 'Actualizar' : 'Crear' }} Header
      </CardTitle>
      <CardDescription>
        {{ updating ? 'Actualiza' : 'Crea' }}
        el header de la página principal
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="md:col-span-1">
              <Label for="description">Descripción</Label>
              <Input id="description" type="text" required v-model="form.description" />
              <InputError :message="form.errors.description" />
            </div>
            <div class="md:col-span-1">
              <Label for="image_file">Imagen</Label>
              <Input id="image_file" type="file" accept="image/*" required @change="showImg($event)" />
              <InputError :message="form.errors.image_file" />
            </div>
            <div class="md:col-span-1">
              <Label for="caption">Caption</Label>
              <Input id="caption" type="text" required v-model="form.caption" />
              <InputError :message="form.errors.caption" />
            </div>
            <div v-if="srcImage" class="md:col-span-2">
              <div>
                <Label for="image_preview">Vista previa de imagen</Label>
                <div class="mt-2">
                  <img :src="srcImage" :alt="updating ? form.caption : ''" class="w-full object-cover rounded-md" />
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
          <Link :href="route('header.index')">
          <Undo /> Cancelar
          </Link>
        </Button>
      </div>
    </CardFooter>
  </Card>
</template>