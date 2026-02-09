<script lang="ts">
export default {
  name: 'ServiceItemForm'
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
import { GalleryItemState, ItemServiceItem } from '@/types/ItemService';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '../ui/select';
import api from '@/api/axios';
import GalleryItem from '../GalleryItem.vue';

const props = defineProps<{
  form: ItemServiceItem;
  updating?: boolean;
}>();

// Servicios
const services = ref<{ id: number; name: string }[]>([]);
// Selector de servicio
const selectedService = ref<number | null>(props.form.service_id ?? null);
// Cargar los servicios
const loadServices = async () => {
  const { data } = await api.get('/services');
  services.value = data;
}
// Manejo de estado del modal de galería
const openGallery = ref(false);

const gallery = ref<GalleryItemState[]>(
  (props.form.gallery ?? []).map(img => ({
    id: img.id,
    item_id: img.item_id,
    image_uri: img.image_uri,
    caption: img.caption,
    isNew: false,
    removed: false
  }))
);

const galleryPreview = computed(() =>
  gallery.value.filter(img => !img.removed)
)

watch(galleryPreview, (value)=> {
  props.form.gallery = value
})


const onRemoveImage = (key: number | string | undefined) => {
  const img = gallery.value.find(
    i => i.id === key || i.id === key
  )
  if (!img) return

  if (img.isNew) {
    gallery.value = gallery.value.filter(i => i !== img)
  } else {
    img.removed = true
  }
}

const getCaptionFromFile = (file: File) => {
  return file.name.replace(/\.[^/.]+$/, '')
}

const onAddImages = (files: File[]) => {
  files.forEach(file => {
    gallery.value.push({
      id: null,
      item_id: props.form.id,
      file,
      image_uri: URL.createObjectURL(file),
      caption: getCaptionFromFile(file),
      isNew: true,
      removed: false
    })
  })
}

// Escuchar cambios en el selector de servicios
watch(selectedService, (value) => {
  props.form.service_id = value;
});

const nowDateTime = () => {
  const d = new Date();

  const yyyy = d.getFullYear();
  const mm = String(d.getMonth() + 1).padStart(2, '0');
  const dd = String(d.getDate()).padStart(2, '0');

  const hh = String(d.getHours()).padStart(2, '0');
  const mi = String(d.getMinutes()).padStart(2, '0');
  const ss = String(d.getSeconds()).padStart(2, '0');

  return {
    date: `${yyyy}-${mm}-${dd}`,
    datetime: `${yyyy}-${mm}-${dd} ${hh}:${mi}:${ss}`,
  }
};

const start_date = ref<string | undefined>(undefined);
//   const start_date = ref<string | undefined>(undefined);

const { date, datetime } = nowDateTime();
if (props.form.start_date) {
  start_date.value = props.form.start_date.slice(0, 10);
} else {
  props.form.start_date = `${datetime}`;
  start_date.value = props.form.start_date.slice(0, 10);
}


watch(start_date, (value) => {
  if (!value) return;
  const time = nowDateTime().datetime.slice(11);
  props.form.start_date = `${value} ${time}`;

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
  loadServices();
  if (props.updating) {
    // loadGallery();
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

const path = "/storage/images/services/";
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

  // const formData = new FormData()

  // // datos normales
  // Object.entries(props.form).forEach(([k, v]) => {
  //   if (v !== null && v !== undefined) {
  //     formData.append(k, v as any)
  //   }
  // })

  // // nuevas
  // gallery.value
  //   .filter(i => i.isNew && !i.removed)
  //   .forEach((img, i) => {
  //     formData.append(`gallery_new[${i}]`, img.file!)
  //   })

  // // eliminadas
  // gallery.value
  //   .filter(i => !i.isNew && i.removed)
  //   .forEach((img, i) => {
  //     formData.append(`gallery_removed[${i}]`, String(img.id))
  //   })

  e.preventDefault();
  emit('submitForm');
}

</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>
        {{ updating ? 'Actualizar' : 'Crear' }} Sub-servicio
      </CardTitle>
      <CardDescription>
        {{ updating ? 'Actualiza' : 'Crea' }}
        el subservicio que dependerá del servicio principal, por ejemplo, viajes nacionales, deportes extremos...
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="md:col-span-1">
              <Label for="service_id">Servicio</Label>
              <Select id="service_id" v-model="selectedService" :disabled="updating">
                <SelectTrigger>
                  <SelectValue placeholder="Seleccione un servicio" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectItem v-for="service in services" :key="service.id" :value="service.id">
                      {{ service.name }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
              <InputError :message="form.errors.service_id" />
            </div>
            <div class="md:col-span-1">
              <Label for="slug">Titulo de sub-servicio</Label>
              <Input id="slug" type="text" required v-model="title" />
              <InputError :message="form.errors.slug" />
            </div>
            <div class="md:col-span-1">
              <Label for="price">Precio</Label>
              <Input id="price" type="number" required v-model="form.price" />
              <InputError :message="form.errors.price" />
            </div>
            <div class="md:col-span-1">
              <Label for="start_date">Fecha de salida</Label>
              <Input id="start_date" type="date" :required="!updating" v-model="start_date" />
              <InputError :message="form.errors.start_date" />
            </div>
            <div class="md:col-span-2">
              <Label for="included">Qué incluye el plan?</Label>
              <Textarea id="included" required v-model="form.included"> </Textarea>
              <InputError :message="form.errors.included" />
            </div>
            <div class="md:col-span-2">
              <Label for="description">Descripción completa</Label>
              <Textarea id="description" required v-model="form.description"> </Textarea>
              <InputError :message="form.errors.description" />
            </div>
            <div class="md:col-span-2">
              <Label for="excerpt">Descripción corta "info en tarjeta del home"</Label>
              <Input id="excerpt" type="text" required v-model="form.excerpt" />
              <InputError :message="form.errors.excerpt" />
            </div>
            <div class="md:col-span-1">
              <Label for="duration">Duración</Label>
              <Input id="duration" type="text" required v-model="form.duration" />
              <InputError :message="form.errors.duration" />
            </div>
            <div class="md:col-span-1">
              <Label for="location">Lugar</Label>
              <Input id="location" type="text" required v-model="form.location" />
              <InputError :message="form.errors.location" />
            </div>
            <div class="md:col-span-1">
              <Label for="capacity">Cupo en # personas</Label>
              <Input id="capacity" type="text" required v-model="form.capacity" />
              <InputError :message="form.errors.capacity" />
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
            <div class="md:col-span-1">
              <Label for="position">Posición en el home</Label>
              <Input id="position" type="number" required v-model="form.position" />
              <InputError :message="form.errors.position" />
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
            <!-- {{ galleryPreview }} -->
            <div class="md:col-span-1 mt-2">
              <Button type="button" class="cursor-pointer" @click="openGallery = true">
                {{ form.gallery && form.gallery.length > 0 ? "Ver" : "Agregar" }}
                Galeria
              </Button>
              <!-- Modal Galeria -->
              <GalleryItem v-model:open="openGallery" :gallery="galleryPreview" @remove-image="onRemoveImage"
              @add-images="onAddImages" />
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
          <!-- {{ galleryPreview }} -->
          <!-- {{ form.gallery }} -->
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
          <Link :href="route('service_item.index')">
            <Undo /> Cancelar
          </Link>
        </Button>
      </div>
    </CardFooter>
  </Card>
</template>