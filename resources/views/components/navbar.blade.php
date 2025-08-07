<div
    class="z-10 fixed top-0 bottom-0 left-0 w-full bg-[#121010] h-[90px] hidden lg:flex flex-row items-center justify-center gap-[35px] text-left text-sm font-outfit">
    {{-- Logo --}}
    <a href="{{ route('anasayfa') }}"
        class="bg-[#f1f1f1] w-[90px] h-[90px] flex flex-col items-center justify-center p-2 box-border hover:bg-white transition-colors duration-300">
        <div class="w-11 h-11 overflow-hidden shrink-0 flex flex-col items-center justify-center">
            <!-- SVG Logo -->
            <svg xmlns="http://www.w3.org/2000/svg" width="1604" height="1805" viewBox="0 0 1604 1805" fill="none">
                <path
                    d="M438.003 802.759C510.183 749.171 588.378 722.377 672.589 722.377C757.893 722.377 828.979 758.467 885.849 830.647C942.718 902.827 971.152 994.146 971.152 1104.6C971.152 1238.03 927.954 1342.47 841.556 1417.93C755.159 1492.3 643.06 1529.48 505.262 1529.48C421.051 1529.48 347.231 1517.45 283.8 1493.39C221.462 1469.33 172.248 1433.24 136.158 1385.12C101.162 1337 83.1167 1279.04 82.023 1211.23L78.7421 592.78C78.7421 524.975 95.1467 475.214 127.956 443.499C160.765 411.783 204.511 395.925 259.193 395.925C320.437 395.925 365.276 410.689 393.71 440.218C423.239 468.652 438.003 514.585 438.003 578.016V802.759ZM439.643 1267.01C459.329 1304.19 486.67 1322.79 521.666 1322.79C551.195 1322.79 574.161 1304.19 590.566 1267.01C606.97 1229.83 615.173 1187.17 615.173 1139.05C615.173 1112.81 612.985 1087.11 608.611 1061.95C604.236 1036.8 598.221 1014.38 590.566 994.693C582.91 973.914 573.067 957.509 561.037 945.479C549.007 932.356 535.337 925.794 520.026 925.794C486.123 925.794 459.329 946.026 439.643 986.491C439.643 1000.71 439.643 1041.72 439.643 1109.53C439.643 1176.24 439.643 1228.73 439.643 1267.01ZM1135.04 1404.81C1135.04 1361.06 1152 1329.35 1185.9 1309.66C1220.9 1289.98 1264.09 1280.13 1315.5 1280.13C1445.64 1280.13 1510.71 1321.69 1510.71 1404.81C1510.71 1445.27 1493.21 1476.44 1458.22 1498.31C1423.22 1519.09 1375.65 1529.48 1315.5 1529.48C1258.63 1529.48 1214.33 1518 1182.62 1495.03C1150.9 1470.97 1135.04 1440.9 1135.04 1404.81ZM1512.35 530.443C1512.35 586.219 1501.41 679.178 1479.54 809.321C1457.67 939.464 1446.73 1031.33 1446.73 1084.92C1446.73 1129.76 1436.34 1162.57 1415.56 1183.35C1394.78 1204.13 1360.88 1214.51 1313.85 1214.51C1267.92 1214.51 1235.66 1204.13 1217.07 1183.35C1198.48 1161.47 1189.18 1127.02 1189.18 1080C1189.18 1027.5 1178.24 938.918 1156.37 814.243C1134.5 689.568 1123.56 600.983 1123.56 548.488C1123.56 493.806 1136.69 452.794 1162.93 425.453C1190.27 398.112 1238.94 384.442 1308.93 384.442C1382.21 384.442 1434.16 395.925 1464.78 418.892C1496.49 441.858 1512.35 479.042 1512.35 530.443Z"
                    fill="#222222" />
                <path
                    d="M526.552 910.536L656.13 947.256L739.377 1053.13L744.495 1187.71L669.53 1299.6L543.116 1346.06L413.538 1309.33L330.291 1203.46L325.173 1068.88L400.138 956.992L526.552 910.536Z"
                    fill="#FE6600" />
                <path
                    d="M1326.02 1334.39L1368.59 1346.45L1395.94 1381.24L1397.62 1425.46L1372.99 1462.22L1331.46 1477.48L1288.88 1465.42L1261.53 1430.63L1259.85 1386.41L1284.48 1349.65L1326.02 1334.39Z"
                    fill="#FE6600" />
            </svg>
        </div>
    </a>

    {{-- Menü Linkleri --}}
    <div
        class="flex-1 flex flex-row items-center justify-center p-2.5 gap-[25px] uppercase font-medium tracking-widest text-[14px] text-[#e0dfdf]">
        <a href="/kurumsal" class="py-2 px-3 transition-colors duration-300 hover:text-[#FF4A3B]">Kurumsal</a>

        {{-- Kategoriler Dropdown --}}
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open"
                class="py-2 px-3 transition-colors duration-300 hover:text-[#FF4A3B] flex items-center gap-2 group"
                :class="{ 'text-[#FF4A3B]': open }">
                <span class="uppercase">Ürünlerimiz</span>

            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50 min-w-96"
                style="display: none;">

                {{-- Dropdown Header --}}
                <div class="px-4 py-3 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900 normal-case tracking-normal">Ürün Kategorileri</h3>
                    <p class="text-xs text-gray-500 normal-case tracking-normal mt-1">{{ $categories->count() }}
                        kategori mevcut</p>
                </div>

                {{-- Categories List --}}
                @if ($categories && $categories->count() > 0)
                    <div class="min-w-96 max-h-80 overflow-y-auto">
                        @foreach ($categories as $category)
                            <a href="{{ route('category.show', $category->slug) }}"
                                class="group flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-200"
                                @click="open = false">

                                {{-- Category Icon --}}
                                <div
                                    class="w-16 h-16 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                    <img src="{{ asset('storage/' . $category->image->image_path) }}"
                                        alt="{{ $category->name }} Icon" class="w-16 h-16 object-contain">
                                </div>

                                {{-- Category Info --}}
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors duration-200 normal-case tracking-normal">
                                        {{ $category->name }}
                                    </h4>
                                    @if ($category->description)
                                        <p class="text-xs text-gray-500 truncate mt-1 normal-case tracking-normal">
                                            {{ Str::limit($category->description, 50) }}
                                        </p>
                                    @endif
                                    <div class="flex items-center mt-1">
                                        <span
                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full normal-case tracking-normal">
                                            {{ $category->products_count ?? $category->products->count() }} ürün
                                        </span>
                                    </div>
                                </div>

                                {{-- Arrow --}}
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endforeach
                    </div>

                    {{-- View All Categories --}}
                    <div class="border-t border-gray-100 px-4 py-3">
                        <a href="/"
                            class="flex items-center justify-center w-full py-2 px-4 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white text-sm font-medium rounded-lg transition-all duration-200 transform hover:scale-105 normal-case tracking-normal"
                            @click="open = false">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Tüm Kategorileri Gör
                        </a>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="px-4 py-8 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4m0 0l-4-4m4 4V3">
                            </path>
                        </svg>
                        <p class="text-sm text-gray-500 normal-case tracking-normal">Henüz kategori bulunmuyor</p>
                    </div>
                @endif
            </div>
        </div>

        <a href="{{ route('sitemap') }}" class="py-2 px-3 transition-colors duration-300 hover:text-[#FF4A3B]">Site
            Haritası</a>
        <a href="{{ route('blog') }}" class="py-2 px-3 transition-colors duration-300 hover:text-[#FF4A3B]">Blog</a>
        <a href="{{ route('iletisim') }}"
            class="py-2 px-3 transition-colors duration-300 hover:text-[#FF4A3B]">İletişim</a>
    </div>

    {{-- Sağdaki ikon --}}
    <a href="/iletisim"
        class="w-[90px] h-[90px] bg-[#f7675a] hover:bg-[#e55a4d] flex flex-col items-center justify-center py-[7px] px-1 box-border transition-colors duration-300">
        <svg class="w-7" width="38" height="30" viewBox="0 0 38 30" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0.666626 29.6667V0.333374H37.3333V29.6667H0.666626ZM19 16.8334L4.33329 7.66671V26H33.6666V7.66671L19 16.8334ZM19 13.1667L33.6666 4.00004H4.33329L19 13.1667ZM4.33329 7.66671V4.00004V26V7.66671Z"
                fill="white" />
        </svg>
    </a>
</div>
