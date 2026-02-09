<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger, } from './ui/dialog';

const props = defineProps<{
  message: string;
}>();

const open = ref(false);
const whatsappUrl = ref('');
const phone = '573209962319';

// Función para generar el mensaje según tipo
const handleWhatsAppClick = (type: 'separar' | 'pago_total') => {
  let finalMessage = '';
  if (type === 'separar') {
    finalMessage = `Hola, quiero separar realizando un abono al viaje ${props.message}. ¿Podrías brindarme más información?`;
  } else {
    finalMessage = `Hola, quiero realizar el pago total del viaje ${props.message}. ¿Podrías brindarme más información?`;
  }

  whatsappUrl.value = `https://wa.me/${phone}?text=${encodeURIComponent(finalMessage)}`;

  window.open(whatsappUrl.value, '_blank');
};
</script>

<template>
  <Dialog v-model:open="open">
    <!-- Botón que abre el modal -->
    <DialogTrigger as-child>
      <Button size="sm" class="self-start mt-4 cursor-pointer">
        Reservar
      </Button>
    </DialogTrigger>

    <!-- Contenido del modal -->
    <DialogContent class="sm:max-w-xl">
      <DialogHeader>
        <DialogTitle class="text-lg font-bold">¡Importante!</DialogTitle>
        <DialogDescription class="space-y-3 mt-2 text-sm text-muted-foreground">
          <p>
            Puedes <span class="font-semibold underline">separar realizando pagos a cuotas</span>
            hasta una semana antes de la fecha de viaje.
          </p>

          <p class="text-lg font-bold ">Nota:</p>
          <p class="-mt-4">
            Una vez realizado <span class="font-bold underline">cualquier pago o abono</span>,
            <span class="font-bold underline">no habrá devolución</span> por ninguna causa o
            incumplimiento del cliente, ni cambios de fecha. <br />
            Eso quiere decir que el <span class="font-semibold underline">cupo es personal e intransferible</span> y no
            se puede usar para otra actividad.
          </p>

          <p class="text-lg font-bold">Medios de pago:</p>
          <p class="-mt-4">
            <span class="font-bold">Nequi:</span> 3209962319 <br />
            <span class="font-bold">Daviplata:</span> 3209962319
          </p>
          <p class="font-bold">Cupos limitados, aparta el tuyo.</p>
        </DialogDescription>
      </DialogHeader>

      <DialogFooter class="mt-4 flex justify-between">
        <Button class="cursor-pointer" @click="handleWhatsAppClick('separar')">Separar</Button>
        <Button class="cursor-pointer" @click="handleWhatsAppClick('pago_total')">Pago Total</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
