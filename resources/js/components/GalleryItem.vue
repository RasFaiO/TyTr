<script setup lang="ts">
import { GalleryItemState } from '@/types/ItemService';
import { Button } from './ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from './ui/dialog';
import { ref } from 'vue';

const props = defineProps<{
  open: boolean;
  gallery: GalleryItemState[];
}>();

const emit = defineEmits<{
  (e: 'update:open', value: boolean): void
  (e: 'remove-image', key: number | string): void
  (e: 'add-images', files: File[]): void
}>();

const fileInput = ref<HTMLInputElement | null>(null);

const triggerFile = () => {
  fileInput.value?.click();
};

const onFileSelected = (e: Event) => {
  const input = e.target as HTMLInputElement
  if (!input.files) return

  emit('add-images', Array.from(input.files));
  // limpiamos el imput
  input.value = '';
}

const path = "/storage/images/services/gallery/";

</script>

<template>
  <div class="grid auto-rows-min gap-4 md:grid-cols-8">
    <Dialog :open="open" @update:open="emit('update:open', $event)">
      <DialogContent>
        <DialogHeader>
          <DialogTitle>Galería de imágenes del subservicio</DialogTitle>
          <DialogDescription></DialogDescription>
        </DialogHeader>
        <!-- TODO el contenido de la galería -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-3">
          <div v-for="(image, index) in gallery" :key="image.id ?? `new-${index}`" :value="image.id"
            class="relative aspect-square overflow-hidden rounded-md">
            <img :src="image.isNew ? image.image_uri : `${path}${image.image_uri}`" :alt="image.caption" class="w-full h-40 object-cover rounded-md" />
            <button type="button"
              class="absolute top-1 right-1 bg-red-600 cursor-pointer text-white text-xs px-2 py-1 rounded"
              @click="emit('remove-image', image.id ?? `new-${index}`)">
              ✕
            </button>
          </div>
        </div>

        <DialogFooter>
          <Button type="button" @click="triggerFile" class="cursor-pointer">
            Agregar imagen
          </Button>
          <input ref="fileInput" id="file" type="file" accept="image/*" multiple hidden @change="onFileSelected" />
          <Button variant="secondary" class="cursor-pointer" @click="emit('update:open', false)">
            Cerrar
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </div>
</template>