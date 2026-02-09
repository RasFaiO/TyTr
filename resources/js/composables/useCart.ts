import { CartItem } from "@/types/CartItem";
import { ref, watch } from "vue";

const cart = ref<CartItem[]>(JSON.parse(localStorage.getItem('cart') || '[]'));

watch(cart, (newCart) => {
  localStorage.setItem('cart', JSON.stringify(newCart));
}, {deep: true});

export function useCart() {
  const addToCart = (item: CartItem) => {
    const existing = cart.value.find(i => i.id === item.id);
    if (existing) {
      const totalQuantity = existing.quantity + item.quantity;
    existing.quantity = totalQuantity > item.stock ? item.stock : totalQuantity;
    } else {
      const quantity = item.quantity > item.stock ? item.stock : item.quantity;
    cart.value.push({ ...item, quantity });
    }
  };

  const removeFromCart = (id: number) => {
    cart.value = cart.value.filter(i => i.id !== id);
  };

  const decreaseFromCart = (id: number) => {
  const existing = cart.value.find(i => i.id === id);
  if (existing) {
    existing.quantity--;
    if (existing.quantity <= 0) {
      removeFromCart(id);
    }
  }
};

  const clearCart = () => {
    cart.value = [];
  }

  const total = () => cart.value.reduce((sum, i) => sum + i.price * i.quantity, 0).toLocaleString();

  const getQuantityById = (id: number) => {
    return cart.value.find(i => i.id === id)?.quantity || 0;
  }

  return {
    cart,
    addToCart,
    removeFromCart,
    decreaseFromCart,
    clearCart,
    total,
    getQuantityById
  };
}