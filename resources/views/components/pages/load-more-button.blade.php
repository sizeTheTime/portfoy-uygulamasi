@props(['hasMoreImages' => false, 'isLoadingMore' => false])

<div class="text-center mt-6" x-show="{{ $hasMoreImages }}">
    <button x-on:click="loadMoreImages()" :disabled="isLoadingMore"
        class="group relative inline-flex items-center justify-center px-5 py-2.5 bg-white hover:bg-gray-50 disabled:bg-green-50 border border-gray-300 hover:border-gray-400 disabled:border-green-200 text-gray-700 hover:text-gray-900 disabled:text-green-600 text-sm font-medium rounded-lg transition-all duration-200 disabled:cursor-not-allowed shadow-sm hover:shadow-md"
        :class="{
            'animate-pulse': isLoadingMore,
            'cursor-wait': isLoadingMore
        }"
        x-data="{ ripples: [] }"
        x-on:click="
                if (!isLoadingMore) {
                    let rect = $el.getBoundingClientRect();
                    let x = $event.clientX - rect.left;
                    let y = $event.clientY - rect.top;
                    ripples.push({ x, y, id: Date.now() });
                    setTimeout(() => ripples.shift(), 600);
                }
            ">

        <!-- Ripple Effects -->
        <template x-for="ripple in ripples" :key="ripple.id">
            <span class="absolute rounded-full bg-white/30 pointer-events-none animate-ping"
                :style="`left: ${ripple.x}px; top: ${ripple.y}px; width: 0px; height: 0px; transform: translate(-50%, -50%);`"
                x-init="$el.style.width = '100px';
                $el.style.height = '100px';
                setTimeout(() => $el.remove(), 600);">
            </span>
        </template>

        <!-- Button Content -->
        <div class="relative z-10 flex items-center space-x-3">
            <template x-if="!isLoadingMore">
                <div class="flex items-center gap-3">
                    <!-- Icon -->
                    <span>Daha fazla yükle</span>
                </div>
            </template>

            <template x-if="isLoadingMore">
                <div class="flex items-center gap-2">
                    <!-- Animated Loading Spinner -->
                    <div class="relative">
                        <div class="w-4 h-4 border-2 border-green-200 border-t-green-600 rounded-full animate-spin">
                        </div>
                    </div>

                    <!-- Loading Text -->
                    <span>Yükleniyor...</span>
                </div>
            </template>
        </div>

        <!-- Bottom Glow Effect -->
        <div
            class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-3/4 h-4 bg-gradient-to-r from-transparent via-blue-400/50 to-transparent blur-lg group-hover:via-blue-300/70 transition-all duration-500">
        </div>
    </button>

    <!-- Progress Indicator (Optional) -->
    <div class="mt-4 flex justify-center" x-show="isLoadingMore" x-transition>
        <div class="flex space-x-2">
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 0ms;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 200ms;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 400ms;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 600ms;"></div>
            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse" style="animation-delay: 800ms;"></div>
        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .border-2 {
        border-width: 2px;
    }

    /* Custom bounce animation for dots */
    @keyframes bounce-dot {

        0%,
        80%,
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        40% {
            transform: scale(1.2);
            opacity: 1;
        }
    }

    .animate-bounce-dot {
        animation: bounce-dot 1.4s infinite ease-in-out;
    }
</style>
