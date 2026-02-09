<script setup lang="js">
import { CheckCircle, ShieldCheck, Star } from 'lucide-vue-next';

</script>
<template>
  <div class="container mx-auto px-4 sm:px-6 md:px-16">
  <div
      class="mt-4 flex flex-col md:flex-row items-center justify-between text-center divide-y md:divide-y-0 md:divide-x border-t pt-6">
      <div class="flex flex-col items-center px-6 md:w-1/3 space-y-2">
        <CheckCircle class="w-6 h-6 text-green-600" />
        <p class="font-semibold">Compromiso</p>
        <p class="text-sm mb-2">
          Nuestro compromiso con la excelencia garantiza una experiencia de viaje inigualable.
        </p>
      </div>
      <div class="flex flex-col items-center px-6 md:w-1/3 space-y-2 mt-2">
        <Star class="w-6 h-6 text-yellow-500" />
        <p class="font-semibold">Excelente servicio</p>
        <p class="text-sm mb-2">
          Nos esforzamos por superar tus expectativas brindando confort y calidad en cada destino.
        </p>
      </div>
      <div class="flex flex-col items-center px-6 md:w-1/3 space-y-2 mt-2">
        <ShieldCheck class="w-6 h-6 text-blue-600" />
        <p class="font-semibold">Calidad</p>
        <p class="text-sm">
          Ofrecemos servicios de primer nivel y atención personalizada para cada viajero.
        </p>
      </div>
    </div>
    </div>
</template>