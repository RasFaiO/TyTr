<script setup lang="ts">
import { ref, computed, watch, DefineProps } from 'vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger, } from './ui/dialog';
import { useCart } from '@/composables/useCart';
import { MinusCircle, PlusCircle, ShoppingCart } from 'lucide-vue-next';

const { cart, total, clearCart, decreaseFromCart, addToCart } = useCart();

// carrito de compras en LandingMenubar
const props = defineProps<{ iconTrigger?: boolean }>();

const open = ref(false);

watch(cart, (newCart) => {
  if (newCart.length === 0) {
    open.value = false;
  }
});

const phone = '573209962319'; 

const hasItems = computed(() => cart.value.length > 0);

const generateMessage = () => {
  let message = 'Hola, quiero solicitar los siguientes productos:\n\n';

  cart.value.forEach((item, index) => {
    message += `${index + 1}. ${item.name} (x${item.quantity}) - $${item.price * item.quantity}\n`;
  });

  message += `\nTotal: $${total()}`;

  return encodeURIComponent(message);
};

const handleSendWhatsApp = () => {
  if (!hasItems.value) return;

  const url = `https://wa.me/${phone}?text=${generateMessage()}`;
  window.open(url, '_blank');
  clearCart(); // Limpia el carrito luego de enviar
};
</script>

<template>
  <Dialog v-model:open="open">
    <template v-if="hasItems">
      <DialogTrigger as-child>
        <template v-if="props.iconTrigger">
          <button class="relative">
            <ShoppingCart class="w-5 h-5" />
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] leading-tight font-medium
                 rounded-full h-5 min-w-[1.25rem] flex items-center justify-center">
              {{ cart.length }}
            </span>
          </button>
        </template>

        <template v-else>
          <Button size="sm" class="self-start cursor-pointer">
            Solicitar Pedido
          </Button>
        </template>
      </DialogTrigger>
    </template>

    <DialogContent class="sm:max-w-xl">
      <DialogHeader>
        <DialogTitle class="text-lg font-bold">Resumen del Pedido</DialogTitle>
        <DialogDescription class="space-y-3 mt-2 text-sm text-muted-foreground">
          <div v-if="hasItems">
            <ul class="space-y-1">
              <li v-for="(item, index) in cart" :key="item.id" class="flex justify-between items-center border-b pb-1">
                <div>
                  <span class="block">{{ index + 1 }}. {{ item.name }}</span>
                  <span class="text-sm text-muted-foreground">(x{{ item.quantity }})</span>
                </div>
                <div class="flex items-center gap-2">
                  <Button v-if="item.id !== undefined" size="icon" variant="ghost" class="cursor-pointer text-red-500"
                    @click="decreaseFromCart(item.id)">
                    <MinusCircle />
                  </Button>
                  <span>${{ Number(item.price * item.quantity).toLocaleString() }}</span>
                  <Button size="icon" variant="ghost" class="cursor-pointer text-green-600"
                    @click="addToCart({ ...item, quantity: 1 })">
                    <PlusCircle />
                  </Button>

                </div>
              </li>
            </ul>
            <div class="mt-4 font-bold text-right">
              Total: ${{ total() }}
            </div>
          </div>
          <p v-else class="text-red-500">No hay productos en el carrito.</p>

          <div class="mt-6 text-sm text-muted-foreground">
            <p class="font-bold">Nota:</p>
            <p>
              Puedes <span class="font-semibold underline">separar realizando pagos a cuotas</span> hasta una semana
              antes
              de la fecha de viaje.
            </p>
            <p class="mt-2">
              Una vez realizado <span class="font-bold underline">cualquier pago o abono</span>,
              <span class="font-bold underline">no habrá devolución</span>.
            </p>
            <p class="mt-2"><span class="font-bold">Nequi / Daviplata:</span> 3209962319</p>
          </div>
        </DialogDescription>
      </DialogHeader>

      <DialogFooter class="mt-4 flex justify-between">
        <Button class="cursor-pointer" :disabled="!hasItems" @click="handleSendWhatsApp">
          Enviar por WhatsApp
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>