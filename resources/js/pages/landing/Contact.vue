<script setup lang="ts">
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectItem, SelectContent, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/LandingLayout.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import PrivacyPolicyModal from '@/components/PrivacyPolicyModal.vue';
import { Head } from '@inertiajs/vue3';

const name = ref('');
const email = ref('');
const phone = ref('');
const subject = ref('');
const message = ref('');
const privacy = ref(false);

const onSubmit = () => {
  const data = {
    name: name.value,
    email: email.value,
    phone: phone.value,
    subject: subject.value,
    message: message.value,
    privacy: privacy.value
  };

  console.log('Formulario enviado:', data);
}
const bannerImage = 'https://plus.unsplash.com/premium_photo-1681488379875-ab3ec6a4e7a3?q=80&w=1857&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
</script>

<template>
  <Head title="Contacto" />
  <AppLayout>
    <!-- Banner -->
      <div class="h-[35vh] bg-cover bg-center flex items-center justify-center text-white text-4xl font-bold relative"
        :style="{ backgroundImage: `url('${bannerImage}')` }">
        <div class="absolute inset-0 bg-black/50"></div>
        <span class="z-10">Contacto</span>
      </div>
    <div class="container mx-auto px-8 my-8">
      <Card class="mx-auto max-w-5xl w-full">
        <CardHeader>
          <CardTitle class="text-center">
            Estaremos atentos a tus inquietudes
          </CardTitle>
        </CardHeader>
        <CardContent>
          <h3>Diligencia el formulario para contactarte lo antes posible.</h3>
          <form @submit.prevent="onSubmit" class="px-4 py-10 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <Label for="name">Nombre completo</Label>
                <Input id="name" v-model="name" />
              </div>

              <div>
                <Label for="email">Correo electrónico</Label>
                <Input id="email" type="email" v-model="email" />
              </div>

              <div>
                <Label for="phone">Teléfono (opcional)</Label>
                <Input id="phone" v-model="phone" />
              </div>

              <div>
                <Label>Asunto</Label>
                <Select v-model="subject">
                  <SelectTrigger class="w-full">
                    <SelectValue placeholder="Selecciona un asunto" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="tours">Tours</SelectItem>
                    <SelectItem value="caminatas">Caminatas</SelectItem>
                    <SelectItem value="ropa">Ropa</SelectItem>
                    <SelectItem value="otro">Otro</SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>

            <div>
              <Label for="message">Mensaje</Label>
              <Textarea id="message" v-model="message" rows="5" />
            </div>

            <div class="flex items-start gap-2">
              <Checkbox id="privacy" v-model="privacy" />
              <label for="privacy" class="text-sm leading-snug">
                Acepto la
                <PrivacyPolicyModal />
              </label>
            </div>

            <div>
              <Button type="submit" class="w-full md:w-auto">Enviar mensaje</Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
