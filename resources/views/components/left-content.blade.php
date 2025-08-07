<div
    class="col-span-12 lg:col-span-7 px-4 md:px-12 pt-8 lg:py-5 pb-10 lg:pb-32 font-outfit max-h-[calc(100vh-90px)] overflow-y-scroll custom-scroll">
    <div class="w-full min-h-screen">

        {{ $slot }}
    </div>

</div>

@once
    @push('styles')
        <style>
            .custom-scroll::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scroll::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scroll::-webkit-scrollbar-thumb {
                background-color: #FF4A3B;
                border: none;
            }

            .custom-scroll {
                scrollbar-width: thin;
                scrollbar-color: #FF4A3B transparent;
            }
        </style>
    @endpush
@endonce
