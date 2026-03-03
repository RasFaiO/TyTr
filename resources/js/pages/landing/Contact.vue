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
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';

const form = useForm({
  name: "",
  email: "",
  phone: "",
  subject: "",
  message: "",
  privacy: false
});

const onSubmit = () => {
  form.post(route('contactme.send'));
};

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
                <Input id="name" v-model="form.name" />
                <InputError :message="form.errors.name" />
              </div>
              
              <div>
                <Label for="email">Correo electrónico</Label>
                <Input id="email" type="email" v-model="form.email" />
                <InputError :message="form.errors.email" />
              </div>
              
              <div>
                <Label for="phone">Teléfono (opcional)</Label>
                <Input id="phone" v-model="form.phone" />
                <InputError :message="form.errors.phone" />
              </div>
              
              <div>
                <Label>Asunto</Label>
                <Select v-model="form.subject">
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
                <InputError :message="form.errors.subject" />
              </div>
            </div>
            
            <div>
              <Label for="message">Mensaje</Label>
              <Textarea id="message" v-model="form.message" rows="5" />
              <InputError :message="form.errors.message" />
            </div>
            
            <div class="items-start gap-2">
              <Checkbox id="privacy" class="ring-1 dark:ring-white-500 mr-2" v-model="form.privacy" />
              <label for="privacy" class="text-sm leading-snug">
                   Acepto la
                <PrivacyPolicyModal />
              </label>
              <InputError :message="form.errors.privacy" />
            </div>

            <div>
              <Button type="submit" class="cursor-pointer w-full md:w-auto">
              <!-- <Button type="submit" class="cursor-pointer w-full md:w-auto" :disabled="form.processing"> -->
                <!-- <span v-if="form.processing">Enviando...</span> -->
                <!-- <span v-else>Enviar mensaje</span> -->
                <span>Enviar mensaje</span>
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
