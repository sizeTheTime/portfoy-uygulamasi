@props(['image', 'alt'])

<img src="{{ asset('storage/' . $image) }}" alt="{{ $alt }}"
    class="w-full h-auto sm:w-64 object-contain rounded-r-md" loading="lazy" width="300" height="350">
