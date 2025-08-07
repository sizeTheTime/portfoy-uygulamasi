{{-- Contact Widget Component --}}

<div class="fixed bottom-28 md:bottom-4 right-4 z-50" x-data="{
    isOpen: false,
    phone: '905358757884',
    email: 'info@bimikrofonsungeri.com',
    whatsappMessage: 'Merhaba, ürünleriniz hakkında bilgi almak istiyorum.',

    toggleMenu() {
        this.isOpen = !this.isOpen;
    },

    closeMenu() {
        this.isOpen = false;
    }
}" x-init="// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (!$el.contains(e.target)) {
        isOpen = false;
    }
});

// Close menu on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        isOpen = false;
    }
});">
    <!-- Contact Options Menu -->
    <div class="absolute bottom-16 right-0 w-64 sm:w-72" x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 transform scale-90 translate-y-4" style="display: none;">

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden backdrop-blur-sm">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-sm">Bize Ulaşın</h3>
                        <p class="text-xs text-blue-100 mt-0.5">Size nasıl yardımcı olabiliriz?</p>
                    </div>
                    <button @click="isOpen = false"
                        class="p-1 hover:bg-blue-800 rounded-full transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Contact Options -->
            <div class="p-2">
                <!-- Phone Call -->
                <a href="tel:+905358757884"
                    class="flex items-center p-3 hover:bg-blue-50 rounded-xl transition-all duration-200 group border-b border-gray-50 last:border-b-0"
                    @click="isOpen = false">
                    <div
                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-blue-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 text-sm">Telefon Ara</div>
                        <div class="text-xs text-gray-500">+905358757884</div>
                    </div>
                    <div
                        class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/905358757884?text=Merhaba%2C%20%C3%BCr%C3%BCnleriniz%20hakk%C4%B1nda%20bilgi%20almak%20istiyorum."
                    target="_blank"
                    class="flex items-center p-3 hover:bg-green-50 rounded-xl transition-all duration-200 group border-b border-gray-50 last:border-b-0"
                    @click="isOpen = false">
                    <div
                        class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-green-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.63" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 text-sm">WhatsApp</div>
                        <div class="text-xs text-gray-500">Hızlı mesaj gönder</div>
                    </div>
                    <div
                        class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </div>
                </a>

                <!-- Email -->
                <a href="mailto:info@bimikrofonsungeri.com?subject=Ürün%20Bilgi%20Talebi&body=Merhaba%2C%0A%0AÜrünleriniz%20hakkında%20bilgi%20almak%20istiyorum.%0A%0ATeşekkürler."
                    class="flex items-center p-3 hover:bg-purple-50 rounded-xl transition-all duration-200 group border-b border-gray-50 last:border-b-0"
                    @click="isOpen = false">
                    <div
                        class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3 group-hover:bg-purple-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900 text-sm">E-posta Gönder</div>
                        <div class="text-xs text-gray-500">info@bimikrofonsungeri.com</div>
                    </div>
                    <div
                        class="w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-4 py-2 text-center">
                <p class="text-xs text-gray-500">7/24 müşteri desteği</p>
            </div>
        </div>
    </div>

    <!-- Main Contact Button -->
    <button @click="isOpen = !isOpen"
        class="relative w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 text-white rounded-full shadow-lg hover:shadow-2xl transition-all duration-300 flex items-center justify-center group overflow-hidden"
        :class="{ 'rotate-45 scale-110': isOpen }" aria-label="İletişim menüsünü aç/kapat">

        <!-- Animated background -->
        <div
            class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 rounded-full transform scale-0 group-hover:scale-100 transition-transform duration-500">
        </div>

        <!-- Ripple effect -->
        <div class="absolute inset-0 rounded-full bg-white opacity-0 group-active:opacity-20 group-active:scale-0 transition-all duration-300"
            :class="{ 'animate-ping': !isOpen }"></div>

        <!-- Icon container -->
        <div class="relative z-10 transition-all duration-300" :class="{ 'rotate-180': isOpen }">
            <!-- Contact icon (when closed) -->
            <svg class="w-6 h-6 sm:w-7 sm:h-7 transition-all duration-300"
                :class="{ 'opacity-0 scale-0': isOpen, 'opacity-100 scale-100': !isOpen }" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                </path>
            </svg>

            <!-- Close icon (when open) -->
            <svg class="w-6 h-6 sm:w-7 sm:h-7 absolute inset-0 transition-all duration-300"
                :class="{ 'opacity-100 scale-100': isOpen, 'opacity-0 scale-0': !isOpen }" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </div>
    </button>
</div>
