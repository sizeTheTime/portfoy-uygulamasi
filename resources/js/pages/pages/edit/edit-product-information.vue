<template>
    <Head title="Ürün Bilgilerini Düzenle" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageContainer>
            <div v-if="message" class="mb-6">
                <div
                    class="rounded px-4 py-3"
                    :class="{
                        'border border-green-300 bg-green-100 text-green-800': messageType === 'success',
                        'border border-red-300 bg-red-100 text-red-800': messageType === 'error',
                    }"
                >
                    {{ message }}
                </div>
            </div>
            <form @submit.prevent="submit" class="mx-auto w-7xl space-y-6 p-6">
                <FormGrid>
                    <ColSpan>
                        <SectionBox>
                            <SectionHeader :icon="Info" title="Ürün Bilgileri" description="Ürün hakkında temel özelliklerini belirleyin" />
                            <FormField
                                id="name"
                                label="Ürün Adı *"
                                description="Ürünün görüntülenecek adını girin"
                                v-model="form.name"
                                placeholder="Ürün adını girin"
                                :error="getError('name')"
                                type="text"
                                @input="generateSlug"
                            />

                            <FormField
                                id="slug"
                                label="Slug *"
                                description="URL'de kullanılacak benzersiz tanımlayıcı (Türkçe karakter kullanmayın)"
                                v-model="form.slug"
                                placeholder="urun-slug"
                                :error="getError('slug')"
                                type="text"
                            />

                            <SelectBox
                                id="category_id"
                                v-model="form.category_id"
                                :options="categories.map((cat) => ({ value: cat.id, label: cat.name }))"
                                label="Kategori *"
                                description="Ürünün ait olduğu kategoriyi seçin"
                                placeholder="Kategori seçin"
                                :error="getError('category_id')"
                            />

                            <FormField
                                id="price"
                                label="Fiyat *"
                                description="Ürünün satış fiyatını girin (TL)"
                                v-model="form.price"
                                placeholder="0.00"
                                :error="getError('price')"
                                type="number"
                                :inputProps="{ step: '0.01', min: '0' }"
                            />

                            <FormTextareaField
                                id="description"
                                label="Detaylı Açıklama"
                                description="Ürünün detaylı açıklaması ve özellikleri"
                                v-model="form.description"
                                :textareaProps="{ rows: 6, placeholder: 'Ürünün detaylı açıklaması' }"
                                :error="getError('description')"
                            />
                        </SectionBox>
                    </ColSpan>

                    <ColSpan :span="'col-span-2 space-y-6'">
                        <SectionBox>
                            <SectionHeader :icon="Info" title="Ürün Bilgileri" description="Ürün hakkında temel özelliklerini belirleyin" />
                            <FormField
                                id="meta_title"
                                label="Meta Başlık"
                                description="Sayfa başlığı (SEO için önemli)"
                                v-model="form.meta_title"
                                placeholder="Meta başlık"
                                :error="getError('meta_title')"
                                type="text"
                            />

                            <FormTextareaField
                                id="meta_description"
                                label="Meta Açıklama"
                                description="Sayfa açıklaması (SEO için önemli)"
                                v-model="form.meta_description"
                                :textareaProps="{ rows: 2, maxlength: 255, placeholder: 'Meta açıklama' }"
                                :error="getError('meta_description')"
                            />

                            <FormField
                                id="meta_keywords"
                                label="Meta Anahtar Kelimeler"
                                description="Virgül ile ayırarak anahtar kelimeleri girin"
                                v-model="form.meta_keywords"
                                placeholder="ör: ayakkabı, spor, erkek"
                                :error="getError('meta_keywords')"
                                type="text"
                            />

                            <FormField
                                id="canonical_url"
                                label="Canonical URL"
                                description="Sayfanın kanonik (asıl) URL'si"
                                v-model="form.canonical_url"
                                placeholder="ör: https://site.com/urun-slug"
                                :error="getError('canonical_url')"
                                type="text"
                            />
                        </SectionBox>
                    </ColSpan>
                </FormGrid>
                <FormActions :processing="form.processing" @cancel="$inertia.visit(`/dashboard/pages/${product.id}`)" />
            </form>
        </PageContainer>
    </AppLayout>
</template>

<script setup lang="ts">
import { FormActions } from '@/components/ui/form';
import { ColSpan, FormGrid } from '@/components/ui/grid';
import { FormField, FormTextareaField } from '@/components/ui/input';
import SelectBox from '@/components/ui/input/SelectBox.vue';
import { PageContainer } from '@/components/ui/layout';
import { SectionBox, SectionHeader } from '@/components/ui/section';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Info } from 'lucide-vue-next';
import { computed, ref } from 'vue';

// Breadcrumbs
const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Ürünler', href: '/dashboard/pages' },
    { title: 'Bilgileri Düzenle', href: '#' },
];

// Props from controller
const page = usePage();
const product = page.props.product;
const categories = computed(() => page.props.categories ?? []);

// Mesajlar
const message = ref('');
const messageType = ref<'success' | 'error' | ''>('');

// Form
const form = useForm({
    name: product.name || '',
    slug: product.slug || '',
    category_id: product.category_id || '',
    price: product.price || '',
    description: product.description || '',
    meta_title: product.meta_title || '',
    meta_description: product.meta_description || '',
    meta_keywords: product.meta_keywords || '',
    canonical_url: product.canonical_url || '',
});

// Error getter
const getError = (field: string) => form.errors[field];

// Slug otomatik oluşturma
const generateSlug = () => {
    if (form.name) {
        form.slug = form.name
            .toLowerCase()
            .replace(/ğ/g, 'g')
            .replace(/ü/g, 'u')
            .replace(/ş/g, 's')
            .replace(/ı/g, 'i')
            .replace(/ö/g, 'o')
            .replace(/ç/g, 'c')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
};

const submit = () => {
    form.post(`/dashboard/pages/${product.id}/edit/information`, {
        preserveScroll: true,
        onSuccess: () => {
            message.value = 'Ürün bilgileri başarıyla güncellendi!';
            messageType.value = 'success';
        },
        onError: () => {
            message.value = 'Bir hata oluştu. Lütfen formu kontrol edin.';
            messageType.value = 'error';
        },
    });
};
</script>
