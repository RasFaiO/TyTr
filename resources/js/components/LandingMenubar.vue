<script setup lang="ts">
import { NavigationMenu, NavigationMenuList, NavigationMenuItem, NavigationMenuLink } from '@/components/ui/navigation-menu';
import { Link } from '@inertiajs/vue3';
import { MenuIcon, XIcon } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import BuyModal from './BuyModal.vue';
import { useCart } from '@/composables/useCart';

const { cart } = useCart();

const cartCount = computed(() => cart.value.length);

const open = ref(false);

const productos = [
  // { title: 'Tours', href: '/viajes/tours' },
  // { title: 'Caminata Ecológica', href: '/viajes/caminata' },
  { title: 'Camisas', href: '/products/camisas' },
  { title: 'Despensa', href: '/products/food' },
];
</script>

<template>
  <header class="fixed top-0 left-0 right-0 z-50 shadow-sm bg-white dark:bg-popover">
    <div class="container mx-auto px-4 py-2 flex item-center justify-between">
      <!-- Logo -->
      <Link href="/" class="flex items-center gap-2 font-bold text-lg px-2">
      <img src="/logo.png" alt="Logo" class="h-8 w-14" />
      </Link>
      <NavigationMenu class="hidden md:block" :viewport="false">
        <NavigationMenuList class="flex items-center gap-6">

          <!-- Navigation Links -->
          <NavigationMenuItem>
            <NavigationMenuLink as-child>
              <Link href="/">Inicio</Link>
            </NavigationMenuLink>
          </NavigationMenuItem>

          <NavigationMenuItem>
            <NavigationMenuLink as-child>
              <Link href="/about">Nosotros</Link>
            </NavigationMenuLink>
          </NavigationMenuItem>

          <NavigationMenuItem>
            <NavigationMenuLink as-child>
              <Link href="/services">Servicios</Link>
            </NavigationMenuLink>
          </NavigationMenuItem>

          <NavigationMenuItem>
            <NavigationMenuLink as-child>
              <Link href="/products">Productos</Link>
            </NavigationMenuLink>
          </NavigationMenuItem>

          <NavigationMenuItem>
            <NavigationMenuLink as-child>
              <Link href="/contact">Contacto</Link>
            </NavigationMenuLink>
          </NavigationMenuItem>

          <!-- Solo si tenemos items en el carrito -->
          <NavigationMenuItem v-if="cartCount > 0">
            <BuyModal iconTrigger />
          </NavigationMenuItem>
          
        </NavigationMenuList>
      </NavigationMenu>

      <!-- Hamburger Button (mobile) -->
      <button class="md:hidden" @click="open = !open">
        <component :is="open ? XIcon : MenuIcon" class="w-6 h-6" />
      </button>
    </div>
    <!-- Mobile Menu -->
    <Transition name="fade">
      <div v-if="open"
        class="md:hidden shadow-md border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <div class="flex flex-col px-4 py-4 space-y-2">
          <Link href="/" class="block px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          Inicio
          </Link>
          <Link href="/about" class="block px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          Nosotros
          </Link>
          <Link href="/services" class="block px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          Servicios
          </Link>
          <Link href="/products" class="block px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
          Productos
          </Link>
          <Link href="/contact" class="block px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            Contacto
          </Link>
          <!-- Solo si tenemos items en el carrito -->
          <div v-if="cartCount > 0" class="px-2 py-1">
            <BuyModal iconTrigger />
          </div>
        </div>
      </div>
    </Transition>

  </header>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>