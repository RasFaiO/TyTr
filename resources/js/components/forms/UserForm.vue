<script lang="ts">
export default {
  name: 'UsersForm'
}
</script>
<script setup lang="ts">
import { Save, Undo } from 'lucide-vue-next';
import InputError from '../InputError.vue';
import { Button } from '../ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../ui/card';
import { Input } from '../ui/input';
import { Label } from '../ui/label';
import { Link } from '@inertiajs/vue3';
import { User } from '@/types/User';

const props = defineProps<{
  form: User;
  updating?: boolean;
}>();

const emit = defineEmits(['submitForm', 'updateForm']);

const submitForm = () => {
  emit('submitForm');
}
</script>
<template>
  <Card>
    <CardHeader>
      <CardTitle>
        {{ updating ? '' : 'Crear' }} Usuario
      </CardTitle>
      <CardDescription>
        {{ updating ? '' : 'Crea' }}
        el usuario para que pueda ingresar a gestionar procesos en el sistema
      </CardDescription>
    </CardHeader>
    <CardContent>
      <form>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
          <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div class="md:col-span-2">
              <Label for="name">Nombres</Label>
              <Input id="name" type="text" :disabled="updating" required autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Tu nombre" />
              <InputError :message="form.errors.name" />
            </div>
            <div class="md:col-span-2">
              <Label for="email">Dirección Email</Label>
              <Input id="email" type="email" :disabled="updating" required :tabindex="2" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
              <InputError :message="form.errors.email" />
            </div>
            <div class="md:col-span-2" v-if="!updating">
              <Label for="password">Contraseña</Label>
              <Input id="password" type="password" required :tabindex="3" autocomplete="new-password" v-model="form.password" placeholder="Tu contraseña"/>
              <InputError :message="form.errors.password" />
            </div>
            <div class="md:col-span-2" v-if="!updating">
              <Label for="password_confirmation">Confirme contraseña</Label>
              <Input id="password_confirmation" type="password" required :tabindex="4" autocomplete="new-password" v-model="form.password_confirmation" placeholder="Confirma tu contraseña" />
              <InputError :message="form.errors.password_confirmation" />
            </div>
          </div>
        </div>
      </form>
    </CardContent>
    <CardFooter>
      <div class="w-full flex justify-end gap-4 p-4">
        <Button type="submit" v-if="!updating" class="cursor-pointer" size-sm  @click="submitForm">
          <Save/>
          {{ updating ? 'Actualizar' : 'Crear' }}
        </Button>
        <Button as-child size-sm variant="destructive">
          <Link :href="route('users.index')">
            <Undo /> {{ updating ? 'Volver' : 'Cancelar' }}
          </Link>
        </Button>
      </div>
    </CardFooter>
  </Card>
</template>