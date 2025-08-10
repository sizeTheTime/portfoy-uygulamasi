<script setup lang="ts">
import { FormActions } from '@/components/ui/form';
import { ColSpan, FormGrid } from '@/components/ui/grid';
import {
    FormField,
    FormImageInput,
    FormTextareaField,
    ImageGallerySection,
    MultiSelectBox,
    ProductAttributeSection,
} from '@/components/ui/input';

import SelectBox from '@/components/ui/input/SelectBox.vue'

import { PageContainer } from '@/components/ui/layout';
import { SectionBox, SectionHeader } from '@/components/ui/section';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Image as ImageIcon, Info } from 'lucide-vue-next';
import { computed, watch } from 'vue';

// Type definitions
interface Category {
    id: number;
    name: string;
    slug: string;
}

interface Color {
    id: number;
    name: string;
    hex_code: string;
}

interface ProductImage {
    main_image: string | null; // File yerine string
    main_image_alt: string;
    hover_image: string | null; // File yerine string
    hover_image_alt: string;
}

interface CardImage {
    main_image: File | null;
    secondary_image: File | null;
    main_image_alt: string;
    secondary_image_alt: string;
    title: string;
    description: string;
}

interface ProductAttribute {
    name: string;
    value: string;
}

interface ProductFormData {
    [key: string]: any;
    name: string;
    slug: string;
    description: string;
    short_description: string;
    category_id: string | number;
    price: string | number;
    images: ProductImage[];
    card_image: CardImage;
    colors: number[];
    attributes: ProductAttribute[];
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    canonical_url: string;
}

// Form errors type
interface FormErrors {
    [key: string]: string | undefined;
    name?: string;
    slug?: string;
    description?: string;
    short_description?: string;
    category_id?: string;
    price?: string;
    colors?: string;
    meta_title?: string;
    meta_description?: string;
    meta_keywords?: string;
    canonical_url?: string;
}

interface BreadcrumbItem {
    title: string;
    href: string;
}

interface PageProps {
    categories: Category[];
    colors: Color[];
}

// Hooks must be called at the top level
const form = useForm<ProductFormData>({
    // Ürün ana bilgileri
    name: '',
    slug: '',
    description: '',
    short_description: '',
    category_id: '',
    price: '',
    // Ürün resimleri - artık string URL'ler - REACTIVE OLARAK TANIMLI
    images: [
        {
            main_image: null,
            main_image_alt: '',
            hover_image: null,
            hover_image_alt: '',
        },
    ],
    // Kart resmi (hala File olarak kalıyor)
    card_image: {
        main_image: null,
        secondary_image: null,
        main_image_alt: '',
        secondary_image_alt: '',
        title: '',
        description: '',
    },
    // Seçili renkler
    colors: [],
    // Ürün özellikleri
    attributes: [
        {
            name: '',
            value: '',
        },
    ],
    // SEO alanları
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
    canonical_url: '',
});

const page = usePage();
const categories = computed<Category[]>(() => page.props.categories as Category[]);
const colors = computed<Color[]>(() => page.props.colors as Color[]);

// Type-safe error getter
const getError = (field: string): string | undefined => {
    return form.errors[field];
};

// Type-safe nested error getter
const getNestedError = (field: string, index: number, subField: string): string | undefined => {
    const errorKey = `${field}.${index}.${subField}`;
    return (form.errors as any)[errorKey];
};

// Card image error getter
const getCardError = (subField: string): string | undefined => {
    const errorKey = `card_image.${subField}`;
    return (form.errors as any)[errorKey];
};

// Canonical URL oluşturma
const generateCanonicalUrl = () => {
    if (form.slug) {
        // Başında her zaman tek bir slash olacak
        form.canonical_url = '/' + form.slug.replace(/^\/+/, '');
    } else {
        form.canonical_url = '/';
    }
};

// Slug otomatik oluşturma
const generateSlug = (): void => {
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
        generateCanonicalUrl();
    }
};

// Eğer kullanıcı slug'ı elle değiştirirse de canonical url güncellensin
watch(() => form.slug, generateCanonicalUrl);

// Canonical URL değiştiğinde sayfa başlığını güncelle
watch(() => form.canonical_url, (newUrl) => {
    if (newUrl) {
        form.meta_title = newUrl;
    }
});

// Attribute ekleme/çıkarma
const addAttribute = (): void => {
    form.attributes.push({
        name: '',
        value: '',
    });
};

const removeAttribute = (index: number): void => {
    if (form.attributes.length > 1) {
        form.attributes.splice(index, 1);
    }
};

// Kart resmi için dosya seçme fonksiyonu (hala File olarak)
const handleFileSelect = (event: Event, type: 'card_image', field: string): void => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        console.log(`Dosya seçildi: ${file.name}, Type: ${type}, Field: ${field}`);
        if (type === 'card_image') {
            form.card_image = {
                ...form.card_image,
                [field]: file,
            };
        }
        console.log('Form data after file select:', form.data());
    }
};

// Dosya önizleme fonksiyonu
const getFilePreview = (file: File | null): string | undefined => {
    if (file && file instanceof File) {
        return URL.createObjectURL(file);
    }
    return undefined;
};

// Form gönderme
const submit = (): void => {
    console.log('Form gönderiliyor:', form.data());
    form.post('/dashboard/pages', {
        forceFormData: true,
        onSuccess: () => {
            console.log('Ürün başarıyla oluşturuldu!');
            form.reset(); // Tüm alanlar ilk değerine döner
            form.clearErrors();
        },
        onError: (errors: Record<string, string>) => {
            console.log('Validation errors:', errors);
        },
    });
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Sayfa', href: '/dashboard/pages' },
    { title: 'Sayfa Oluştur', href: '/dashboard/pages/create' },
];

// Computed properties
const isFormProcessing = computed<boolean>(() => form.processing);
const hasValidationErrors = computed<boolean>(() => Object.keys(form.errors).length > 0);

// Images array'ini güncellemek için özel fonksiyon
const updateImages = (newImages: ProductImage[]) => {
    // Inertia form'da reactive güncellemeler için doğru yöntem
    form.images = [...newImages];
    console.log('Images updated:', form.images);
};

</script>

<template>
    <Head title="Ürün Oluştur" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-8xl mx-auto p-1 md:p-8">
            <PageContainer>
                <div class="p-1 md:p-8">
                    <form @submit.prevent="submit" class="space-y-2 md:space-y-8">
                        <FormGrid>
                            <!-- Sol Kolon - Ana Bilgiler -->
                            <ColSpan>
                                <SectionBox>
                                    <SectionHeader :icon="Info" title="Ürün Bilgileri" description="Ürün hakkında temel özelliklerini belirleyin" />

                                    <!-- Ürün Adı -->
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

                                    <!-- Slug -->
                                    <FormField
                                        id="slug"
                                        label="Slug *"
                                        description="URL'de kullanılacak benzersiz tanımlayıcı (Türkçe karakter kullanmayın)"
                                        v-model="form.slug"
                                        placeholder="urun-slug"
                                        :error="getError('slug')"
                                        type="text"
                                    />

                                    <!-- Kategori -->
                                    <SelectBox
                                        id="category_id"
                                        v-model="form.category_id"
                                        :options="categories.map((cat) => ({ value: cat.id, label: cat.name }))"
                                        label="Kategori *"
                                        description="Ürünün ait olduğu kategoriyi seçin"
                                        placeholder="Kategori seçin"
                                        :error="getError('category_id')"
                                    />

                                    <!-- Fiyat -->
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

                                    <!-- Kısa Açıklama -->
                                    <FormTextareaField
                                        id="short_description"
                                        label="Kısa Açıklama *"
                                        description="Ürünün kısa ve öz açıklaması (maksimum 500 karakter)"
                                        v-model="form.short_description"
                                        :textareaProps="{ rows: 3, maxlength: 500, placeholder: 'Ürünün kısa açıklaması' }"
                                        :error="getError('short_description')"
                                    />

                                    <!-- Detaylı Açıklama -->
                                    <FormTextareaField
                                        id="description"
                                        label="Detaylı Açıklama *"
                                        description="Ürünün detaylı açıklaması ve özellikleri"
                                        v-model="form.description"
                                        :textareaProps="{ rows: 6, placeholder: 'Ürünün detaylı açıklaması' }"
                                        :error="getError('description')"
                                    />

                                    <!-- Renk Seçenekleri -->
                                    <MultiSelectBox
                                        id="product_colors"
                                        v-model="form.colors"
                                        :options="colors"
                                        label="Ürün Renkleri *"
                                        description="Bu ürün için mevcut renk seçeneklerini belirleyin"
                                        placeholder="Renk seçin"
                                        :error="getError('colors')"
                                        searchable
                                        clearable
                                        :show-colors="true"
                                        size="md"
                                    />
                                </SectionBox>

                                <!-- Ürün Resimleri - DOĞRU BAĞLAMA -->
                                <SectionBox>
                                    <ImageGallerySection :model-value="form.images" :errors="form.errors" @update:model-value="updateImages" />
                                </SectionBox>

                                <!-- Özellikler -->
                                <SectionBox>
                                    <ProductAttributeSection v-model="form.attributes" :errors="form.errors" />
                                </SectionBox>
                            </ColSpan>

                            <!-- Sağ Kolon - Kart Bilgileri -->
                            <ColSpan :span="'col-span-2 space-y-6'">
                                <SectionBox>
                                    <SectionHeader
                                        :icon="ImageIcon"
                                        title="Kart Bilgileri"
                                        description="Ürün kartında görünecek bilgileri belirleyin"
                                    />

                                    <!-- Kart Başlığı -->
                                    <FormField
                                        id="card_title"
                                        label="Kart Başlığı *"
                                        description="Ürün kartında görünecek başlık"
                                        v-model="form.card_image.title"
                                        placeholder="Kart başlığı"
                                        :error="getCardError('title')"
                                        type="text"
                                    />

                                    <!-- Kart Açıklaması -->
                                    <FormTextareaField
                                        id="card_description"
                                        label="Kart Açıklaması *"
                                        description="Ürün kartında görünecek açıklama metni"
                                        v-model="form.card_image.description"
                                        :textareaProps="{ rows: 3, placeholder: 'Kart açıklaması' }"
                                        :error="getCardError('description')"
                                    />

                                    <!-- Kart Resimleri -->
                                    <FormImageInput
                                        v-model="form.card_image.main_image"
                                        label="Ana Resim"
                                        description="Kart için ana resim seçin"
                                        :error="getCardError('main_image')"
                                        @file-select="handleFileSelect($event, 'card_image', 'main_image')"
                                    />

                                    <FormField
                                        id="card_image_main_image_alt"
                                        label="Kart Ana Resim Alt Text *"
                                        description="Ana resim için alt metin (SEO için önemli)"
                                        v-model="form.card_image.main_image_alt"
                                        placeholder="Kart ana resim alt text"
                                        :error="getCardError('main_image_alt')"
                                        type="text"
                                    />

                                    <FormImageInput
                                        v-model="form.card_image.secondary_image"
                                        label="İkinci Resim"
                                        description="Kart için ikinci resim seçin"
                                        :error="getCardError('secondary_image')"
                                        @file-select="handleFileSelect($event, 'card_image', 'secondary_image')"
                                    />

                                    <FormField
                                        id="card_image_secondary_image_alt"
                                        label="Kart İkinci Resim Alt Text *"
                                        description="İkinci resim için alt metin (SEO için önemli)"
                                        v-model="form.card_image.secondary_image_alt"
                                        placeholder="Kart ikinci resim alt text"
                                        :error="getCardError('secondary_image_alt')"
                                        type="text"
                                    />
                                </SectionBox>

                                <!-- SEO Alanları -->
                                <SectionBox>
                                    <SectionHeader title="SEO Bilgileri" description="Arama motorları için meta bilgilerini girin" />

                                    <FormField
                                        id="meta_title"
                                        label="Meta Başlık *"
                                        description="Sayfa başlığı (SEO için önemli)"
                                        v-model="form.meta_title"
                                        placeholder="Meta başlık"
                                        :error="getError('meta_title')"
                                        type="text"
                                    />

                                    <FormTextareaField
                                        id="meta_description"
                                        label="Meta Açıklama *"
                                        description="Sayfa açıklaması (SEO için önemli)"
                                        v-model="form.meta_description"
                                        :textareaProps="{ rows: 2, maxlength: 255, placeholder: 'Meta açıklama' }"
                                        :error="getError('meta_description')"
                                    />

                                    <FormField
                                        id="meta_keywords"
                                        label="Meta Anahtar Kelimeler *"
                                        description="Virgül ile ayırarak anahtar kelimeleri girin"
                                        v-model="form.meta_keywords"
                                        placeholder="ör: ayakkabı, spor, erkek"
                                        :error="getError('meta_keywords')"
                                        type="text"
                                    />

                                    <FormField
                                        id="canonical_url"
                                        label="Canonical URL *"
                                        description="Sayfanın kanonik (asıl) URL'si"
                                        v-model="form.canonical_url"
                                        placeholder="/kategori/kategori-slug/urun-slug"
                                        :error="getError('canonical_url')"
                                        type="text"
                                        :readonly="true"
                                    />
                                </SectionBox>
                            </ColSpan>
                        </FormGrid>


                        <FormActions :processing="isFormProcessing" @cancel="$inertia.visit('/dashboard/products')" />
                    </form>
                </div>
            </PageContainer>
        </div>

    </AppLayout>
</template>
