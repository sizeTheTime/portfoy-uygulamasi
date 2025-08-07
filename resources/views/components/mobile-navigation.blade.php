<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 md:hidden">
    <div class="flex justify-around items-center py-2">
        <!-- Ana Sayfa -->
        <a href="{{ route('anasayfa') }}"
            class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('anasayfa') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            <span class="text-xs font-medium">Ana Sayfa</span>
        </a>

        <!-- Kurumsal -->
        <a href="{{ route('kurumsal') }}"
            class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('kurumsal') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                <path fill-rule="evenodd"
                    d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium">Kurumsal</span>
        </a>

        <!-- Blog -->
        <a href="{{ route('blog') }}"
            class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('blog') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z"
                    clip-rule="evenodd" />
                <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V9a1 1 0 00-1-1h-1v-1z" />
            </svg>
            <span class="text-xs font-medium">Blog</span>
        </a>

        <!-- İletişim -->
        <a href="{{ route('iletisim') }}"
            class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('iletisim') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
            </svg>
            <span class="text-xs font-medium">İletişim</span>
        </a>

        <!-- Sitemap -->
        <a href="{{ route('sitemap') }}"
            class="flex flex-col items-center py-2 px-3 {{ request()->routeIs('sitemap') ? 'text-blue-600' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-xs font-medium">Sitemap</span>
        </a>
    </div>
</nav>
