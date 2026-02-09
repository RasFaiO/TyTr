<script setup lang="ts">
import AppLayout from '@/layouts/LandingLayout.vue';
import FooterLanding from '@/components/FooterLanding.vue';
import { Head } from '@inertiajs/vue3';

const bannerImage = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e';
</script>

<template>
  <Head title="Nosotros"/>
  <AppLayout>
    <section class="text-foreground bg-background">
      <!-- Banner -->
      <div class="h-[35vh] bg-cover bg-center flex items-center justify-center text-white text-4xl font-bold relative"
        :style="{ backgroundImage: `url('${bannerImage}')` }">
        <div class="absolute inset-0 bg-black/50"></div>
        <span class="z-10">Nosotros</span>
      </div>

      <!-- About Us Content -->
      <div class="max-w-4xl px-6 mx-auto space-y-8 pt-8 ">
        <h2 class="text-4xl font-bold text-primary">Sobre Nosotros</h2>

        <p class="text-lg leading-relaxed">
          En <strong>Tygua Travel</strong>, transformamos tus sueños de viajar en experiencias inolvidables. Somos una
          agencia de viajes comprometida con ofrecer soluciones personalizadas, cómodas y seguras para cada uno de
          nuestros clientes. Ya sea que busques aventura, descanso o cultura, estamos aquí para ayudarte a explorar el
          mundo.
        </p>

        <h3 class="text-2xl font-semibold ">Nuestra historia</h3>

        <p class="text-base leading-relaxed">
          Fundada en el año 2010, Tygua Travel nació con el propósito de acercar las maravillas del mundo a cada viajero
          colombiano. Con más de una década de experiencia, nos hemos consolidado como una de las agencias más
          confiables y dinámicas del país. Nuestra pasión por los viajes y el servicio nos ha permitido crecer junto a
          miles de clientes satisfechos.
        </p>
      </div>
    </section>
  </AppLayout>
</template>