<script setup lang="ts">
import LandingLayout from '@/layouts/landing/AppSidebarLayout.vue';

</script>

<template>
    <LandingLayout>
        <main class="pt-[54px]"> 
            <!-- contenido de la landing -->
            <slot />
        </main>
    </LandingLayout>
</template>
