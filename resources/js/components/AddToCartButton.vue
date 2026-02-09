<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { useCart } from '@/composables/useCart';
import { CartItem } from '@/types/CartItem';
import { MinusCircle, PlusCircle } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const props = defineProps<{
  product: CartItem;
}>()

const { addToCart, decreaseFromCart, getQuantityById } = useCart();

// Valida la cantidad de productos
const quantity = computed(() => {
  return props.product.id !== undefined ? getQuantityById(props.product.id) : 0;
});

// Agrega producto
const handleAdd = () => {
  if (props.product.id === undefined) return;
  addToCart({ ...props.product, quantity: 1 });
};

// elimina producto
const handleDecrease = () => {
  if (props.product.id === undefined) return;
  decreaseFromCart(props.product.id);
};
</script>

<template>
  <div class="flex items-center gap-2">
    <template v-if="quantity > 0">
      <Button class="cursor-pointer text-red-500" size="sm" @click="handleDecrease">
        <MinusCircle />
      </Button>
      <span class="min-w-[2rem] text-center">{{ quantity }}</span>
      <Button class="cursor-pointer text-green-600" size="sm" @click="handleAdd">
        <PlusCircle />
      </Button>
    </template>

    <template v-else>
      <Button @click="handleAdd">
        Agregar al carrito
      </Button>
    </template>
  </div>
</template>
