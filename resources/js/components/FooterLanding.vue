<script setup lang="ts">
import {
  Facebook,
  Instagram,
  Phone,
  Clock,
  MessageCircle,
} from 'lucide-vue-next'
</script>

<template>
  <footer class="bg-gray-900 text-gray-200 py-8 mt-12">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
      
      <!-- Horarios -->
      <div class="flex items-start space-x-3">
        <Clock class="w-6 h-6 text-yellow-400 mt-1" />
        <div>
          <h3 class="font-semibold text-lg">Horario de atención</h3>
          <p class="text-sm">Lunes a sábado: 8:00 a.m. - 6:00 p.m.</p>
        </div>
      </div>

      <!-- Teléfono -->
      <div class="flex items-start space-x-3">
        <Phone class="w-6 h-6 text-green-400 mt-1" />
        <div>
          <h3 class="font-semibold text-lg">Contáctanos</h3>
          <p class="text-sm">+57 300 123 4567</p>
        </div>
      </div>

      <!-- Redes sociales -->
      <div>
        <h3 class="font-semibold text-lg mb-2">Síguenos</h3>
        <div class="flex space-x-4">
          <a href="https://facebook.com" target="_blank" aria-label="Facebook">
            <Facebook class="w-6 h-6 hover:text-blue-500 transition" />
          </a>
          <a href="https://instagram.com" target="_blank" aria-label="Instagram">
            <Instagram class="w-6 h-6 hover:text-pink-400 transition" />
          </a>
          <a
            href="https://wa.me/573001234567?text=Hola%2C%20estoy%20interesado%20en%20sus%20tours"
            target="_blank"
            aria-label="WhatsApp"
          >
            <MessageCircle class="w-6 h-6 hover:text-green-500 transition" />
          </a>
        </div>
      </div>
    </div>

    <!-- Línea inferior -->
    <div class="border-t border-gray-700 mt-8 pt-4 text-center text-sm text-gray-400">
      &copy; {{ new Date().getFullYear() }} FabiLanc. Todos los derechos reservados.
    </div>
  </footer>
</template>
