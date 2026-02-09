<script setup lang="ts">
import LandingMenubar from '@/components/LandingMenubar.vue';
import FooterLanding from '@/components/FooterLanding.vue';
</script>

<template>
    <div class="relative z-0">
        <LandingMenubar />
        <slot/>
        <FooterLanding />
    </div>
</template>
