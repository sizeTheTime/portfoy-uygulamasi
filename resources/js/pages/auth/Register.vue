<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Hesap Oluştur" description="Hesabınızı oluşturmak için aşağıdaki bilgileri girin">
        <Head title="Kayıt Ol" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Ad Soyad</Label>
                    <Input id="name" type="text" autofocus :tabindex="1" autocomplete="name" v-model="form.name" placeholder="Ad Soyad" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">E-posta adresi</Label>
                    <Input id="email" type="email" :tabindex="2" autocomplete="email" v-model="form.email" placeholder="eposta@ornek.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Şifre</Label>
                    <Input id="password" type="password" :tabindex="3" autocomplete="new-password" v-model="form.password" placeholder="Şifre" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Şifre (Tekrar)</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Şifreyi tekrar girin"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Hesap Oluştur
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Zaten bir hesabınız var mı?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Giriş Yap</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
