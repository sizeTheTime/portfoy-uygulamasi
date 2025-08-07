@props(['colors'])

@if ($colors && count($colors) > 0)
    <div class="bg-white/90 backdrop-blur-sm rounded-lg p-3 sm:p-4 border border-gray-200">
        <h6 class="text-black text-base sm:text-lg font-semibold mb-3 flex items-center">
            Renk Seçenekleri
        </h6>
        <div class="mx-auto max-w-md grid grid-cols-4 sm:grid-cols-5 gap-2 mb-3">
            @foreach ($colors as $color)
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg border-2 border-gray-300 shadow-md"
                    style="background-color: {{ $color->hex_code }}" title="{{ $color->name }}">
                </div>
            @endforeach
        </div>
    </div>
@endif
