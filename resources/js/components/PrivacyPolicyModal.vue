<script setup lang="ts">
import { ref } from 'vue'
import {
  Dialog, DialogTrigger, DialogContent, DialogHeader, DialogTitle,
  DialogDescription, DialogFooter,
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'

const open = ref(false)
</script>
<template>
  <Dialog v-model:open="open">
    <DialogTrigger as-child>
      <button type="button" class="text-blue-600 dark:text-blue-300 underline hover:text-blue-800">
        política de privacidad
      </button>
    </DialogTrigger>

    <DialogContent class="max-w-2xl">
      <DialogHeader>
        <DialogTitle>Política de Privacidad</DialogTitle>
        <DialogDescription>
          Esta política está basada en la Ley 1581 de 2012 de Protección de Datos Personales en Colombia.
        </DialogDescription>
      </DialogHeader>

      <div class="space-y-4 text-sm leading-relaxed max-h-[60vh] overflow-y-auto">
        <p>
          De acuerdo con la Ley 1581 de 2012, informamos que los datos personales recolectados serán tratados conforme a nuestra Política de Privacidad.
        </p>
        <p>
          Recopilamos y almacenamos datos como nombre, correo electrónico, número de teléfono y otros necesarios para brindarte una experiencia adecuada en nuestros servicios turísticos.
        </p>
        <p>
          Puedes ejercer tus derechos de acceso, corrección, supresión y revocatoria del consentimiento contactándonos a través de nuestro canal oficial.
        </p>
        <p>
          Nos comprometemos a no compartir tu información con terceros sin autorización previa, salvo por requerimientos legales.
        </p>
        <p>
          Para más información, puedes escribirnos o visitar nuestras oficinas.
        </p>
      </div>

      <DialogFooter class="mt-4">
        <Button @click="open = false">Cerrar</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>