{{-- filepath: resources/views/components/category-section.blade.php --}}
@props(['category'])

<section class="grid grid-cols-1 md:grid-cols-3 ">
    <div class="col-span-2 space-y-7 p-3 w-full flex flex-col">
        <h2 class="text-black text-2xl font-semibold pt-3">
            {{ $category->short_description ?? $category->name }}
        </h2>

        <p class="text-black text-base font-normal max-w-xl leading-6">
            {{ $category->description }}
        </p>

        <x-contact-buttons />
    </div>
    <div class="flex items-center justify-center">
        @if ($category->image)
            <img src="{{ asset('storage/' . $category->image->image_path) }}" alt="{{ $category->image->alt_text }}"
                class="w-auto h-44 md:h-full md:w-64 object-cover rounded-r-md" loading="lazy" width="300"
                height="350" title="{{ $category->image->title }}">
        @endif
    </div>
</section>
