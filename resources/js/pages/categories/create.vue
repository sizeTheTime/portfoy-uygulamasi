<script setup lang="ts">
import { CancelButton, SubmitButton } from '@/components/ui/button';
import { ColSpan, FormGrid } from '@/components/ui/grid';
import { FormImageInput, FormInput, FormLabel, FormTextarea, InputError } from '@/components/ui/input';
import { PageContainer } from '@/components/ui/layout';
import { PageHeader, SectionBox, SectionHeader } from '@/components/ui/section';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Info, Star } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { AlertMessage } from '@/components/ui/alert'

// Define BreadcrumbItem type
type BreadcrumbItem = {
    title: string;
    href: string;
};

const form = useForm({
    name: '',
    slug: '',
    description: '',
    short_description: '',
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
    image_file: null,
    alt_text: '',
    title: '',
});

const message = ref('');
const messageType = ref<'success' | 'error' | ''>('');

const slugManuallyChanged = ref(false);

// Slug oluşturma fonksiyonu
function generateSlug(text: string) {
    // Türkçe karakterleri İngilizce karşılıklarına çevir
    const trMap: Record<string, string> = {
        ç: 'c',
        Ç: 'c',
        ğ: 'g',
        Ğ: 'g',
        ı: 'i',
        I: 'i',
        İ: 'i',
        ö: 'o',
        Ö: 'o',
        ş: 's',
        Ş: 's',
        ü: 'u',
        Ü: 'u',
    };
    let slug = text
        .split('')
        .map((char) => trMap[char] || char)
        .join('')
        .toLowerCase()
        .trim()
        .replace(/[\s\W-]+/g, '-') // Boşluk ve özel karakterleri tireye çevir
        .replace(/^-+|-+$/g, ''); // Baş ve sondaki tireleri kaldır
    return slug;
}

// Türkçe karakterleri İngilizce'ye çeviren fonksiyon
function replaceTurkishChars(text: string) {
    const trMap: Record<string, string> = {
        ç: 'c',
        Ç: 'c',
        ğ: 'g',
        Ğ: 'g',
        ı: 'i',
        I: 'i',
        İ: 'i',
        ö: 'o',
        Ö: 'o',
        ş: 's',
        Ş: 's',
        ü: 'u',
        Ü: 'u',
    };
    return text
        .split('')
        .map((char) => trMap[char] || char)
        .join('');
}

// Slug alanı elle değişirse otomatik güncellemeyi durdur
watch(
    () => form.slug,
    (newVal, oldVal) => {
        if (oldVal !== '' && newVal !== generateSlug(form.name)) {
            slugManuallyChanged.value = true;
        }
        // Türkçe karakter varsa otomatik düzelt
        const replaced = replaceTurkishChars(newVal);
        if (newVal !== replaced) {
            form.slug = replaced;
        }
    },
);

// Name alanı değişirse ve slug elle değiştirilmediyse otomatik güncelle
watch(
    () => form.name,
    (newVal) => {
        if (!slugManuallyChanged.value) {
            form.slug = generateSlug(newVal);
        }
    },
);

const submit = () => {
    form.post('/dashboard/categories', {
        forceFormData: true,
        onSuccess: () => {
            message.value = 'Kategori başarıyla oluşturuldu!';
            messageType.value = 'success';
            form.reset();
            form.clearErrors();
        },
        onError: (errors) => {
            // Hata nesnesi burada!
            console.log('Hata nesnesi:', errors);
            message.value = 'Bir hata oluştu. Lütfen formu kontrol edin.';
            messageType.value = 'error';
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Kategoriler',
        href: '/dashboard/categories',
    },
    {
        title: 'Kategori Oluştur',
        href: '/categories/create',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Kategori Oluştur" />
        <PageContainer>
            <div class="mx-auto max-w-7xl">
                <!-- Mesaj Kutusu -->
                <AlertMessage :message="message" :type="messageType" />
                <!-- Header -->
                <PageHeader
                    :icon="Star"
                    title="Yeni Kategori Oluştur"
                    description="Kategori bilgilerini doldurun ve yeni kategori oluşturun. Tüm alanlar SEO optimizasyonu için önemlidir."
                />
                <!-- Form -->
                <form @submit.prevent="submit" class="rounded-2xl p-1 md:p-8">
                    <FormGrid>
                        <ColSpan>
                            <SectionBox>
                                <SectionHeader :icon="Info" title="Temel Bilgiler" description="Kategorinin temel özelliklerini belirleyin" />

                                <div>
                                    <FormLabel for="name" label="Kategori Adı *" description='Kategorinin görünen adı (örn: "Teknoloji", "Spor")' />
                                    <FormInput id="name" v-model="form.name" type="text" placeholder="Kategori adını girin" />
                                    <InputError :message="form.errors.name" />
                                </div>

                                <div>
                                    <FormLabel
                                        for="slug"
                                        label="URL Kısa Adı (Slug) *"
                                        description="URL'de görünecek kısa ad (örn: 'teknoloji', 'spor')"
                                    />
                                    <FormInput id="slug" v-model="form.slug" type="text" placeholder="url-kisa-adi" />
                                    <InputError :message="form.errors.slug" />
                                </div>

                                <div>
                                    <FormLabel
                                        for="short_description"
                                        label="Kısa Açıklama"
                                        description="Kategori listelerinde görünecek kısa açıklama (50-100 karakter)"
                                    />
                                    <FormTextarea
                                        id="short_description"
                                        v-model="form.short_description"
                                        :rows="2"
                                        placeholder="Kısa açıklama yazın..."
                                    />
                                    <InputError :message="form.errors.short_description" />
                                </div>

                                <div>
                                    <FormLabel
                                        for="description"
                                        label="Detaylı Açıklama"
                                        description="Kategorinin detaylı açıklaması (200-500 karakter önerilir)"
                                    />
                                    <FormTextarea
                                        id="description"
                                        v-model="form.description"
                                        :rows="4"
                                        placeholder="Kategorinin detaylı açıklamasını yazın..."
                                    />
                                    <InputError :message="form.errors.description" />
                                </div>
                            </SectionBox>
                        </ColSpan>

                        <ColSpan :span="'col-span-2 space-y-6'">
                            <SectionBox>
                                <SectionHeader :icon="Info" title="SEO Ayarları" description="Arama motorları için optimizasyon ayarları" />

                                <div class="space-y-4">
                                    <div>
                                        <FormLabel
                                            for="meta_title"
                                            label="Meta Başlık"
                                            description="Arama sonuçlarında görünecek başlık (50-60 karakter önerilir)"
                                        />

                                        <FormInput id="meta_title" v-model="form.meta_title" type="text" placeholder="SEO başlığı girin" />
                                        <InputError :message="form.errors.meta_title" />
                                    </div>

                                    <div>
                                        <FormLabel
                                            for="meta_description"
                                            label="Meta Açıklama"
                                            description="Arama sonuçlarında görünecek açıklama (150-160 karakter önerilir)"
                                        />
                                        <FormTextarea
                                            id="meta_description"
                                            v-model="form.meta_description"
                                            :rows="3"
                                            placeholder="SEO açıklaması yazın..."
                                        />
                                        <InputError :message="form.errors.meta_description" />
                                    </div>

                                    <div>
                                        <FormLabel
                                            for="meta_keywords"
                                            label="Anahtar Kelimeler"
                                            description="Virgülle ayrılmış anahtar kelimeler (örn: teknoloji, yazılım, web)"
                                        />
                                        <FormInput
                                            id="meta_keywords"
                                            v-model="form.meta_keywords"
                                            type="text"
                                            placeholder="anahtar, kelime, listesi"
                                        />
                                        <InputError :message="form.errors.meta_keywords" />
                                    </div>
                                </div>
                            </SectionBox>
                        </ColSpan>

                        <ColSpan>
                            <SectionBox>
                                <SectionHeader :icon="Info" title="Görsel Ayarları" description="Kategori görseli ve erişilebilirlik ayarları" />

                                <div class="space-y-4">
                                    <div>
                                        <FormImageInput
                                            v-model="form.image_file"
                                            label="Görsel"
                                            description="Kategori için bir görsel seçin veya yükleyin"
                                        />
                                        <InputError :message="form.errors.image_file" />
                                    </div>

                                    <div>
                                        <FormLabel
                                            for="alt_text"
                                            label="Alt Metin"
                                            description="Görsel yüklenemediğinde gösterilecek alternatif metin"
                                        />
                                        <FormInput id="alt_text" v-model="form.alt_text" type="text" placeholder="Kategori görseli açıklaması" />
                                        <InputError :message="form.errors.alt_text" />
                                    </div>

                                    <div>
                                        <FormLabel
                                            for="title"
                                            label="Görsel Başlığı"
                                            description="Görselin üzerine gelindiğinde gösterilecek başlık"
                                        />
                                        <FormInput id="title" v-model="form.title" type="text" placeholder="Görsel başlığı" />
                                        <InputError :message="form.errors.title" />
                                    </div>
                                </div>
                            </SectionBox>
                        </ColSpan>
                    </FormGrid>

                    <!-- Submit Button -->
                    <SectionBox :class="'mt-8'">
                        <div class="flex justify-end space-x-4">
                            <CancelButton />
                            <SubmitButton :loading="form.processing" label="Kategori Oluştur" loadingLabel="Oluşturuluyor..." />
                        </div>
                    </SectionBox>
                </form>
            </div>
        </PageContainer>
    </AppLayout>
</template>
