<div class="relative w-full h-[calc(100vh-8rem)] -mx-3 sm:-mx-6 lg:-mx-8 -my-4 sm:-my-6 overflow-hidden rounded-2xl shadow-sm border border-gray-100">
    <!-- Map Container -->
    <div id="map" class="w-full h-full min-h-[500px] z-0 bg-gray-100"></div>

    <!-- Top Overlay: Search Bar & Dynamic Filter Chips -->
    <div class="absolute top-4 left-0 right-0 px-4 sm:px-6 z-10 pointer-events-none max-w-xl mx-auto space-y-2.5">
        <!-- Search Input -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-lg border border-gray-100 p-2 flex items-center pointer-events-auto transition hover:shadow-xl">
            <svg class="w-5 h-5 text-gray-400 ml-2.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="map-search-input" placeholder="Cari nama atau lokasi masjid..." class="w-full px-3 py-1.5 bg-transparent outline-none text-sm text-gray-800 placeholder-gray-400">
        </div>
        
        <!-- Filter Chips -->
        <div class="flex overflow-x-auto gap-2 pb-2 hide-scrollbar pointer-events-auto">
            <button data-filter="all" class="px-4 py-1.5 bg-emerald-600 text-white rounded-full text-xs font-semibold shadow-md whitespace-nowrap transition">
                Semua
            </button>
            <button data-filter="24jam" class="px-4 py-1.5 bg-white text-gray-700 hover:bg-gray-50 rounded-full text-xs font-semibold shadow-md border border-gray-100 whitespace-nowrap transition">
                Buka 24 Jam
            </button>
            <button data-filter="parkir" class="px-4 py-1.5 bg-white text-gray-700 hover:bg-gray-50 rounded-full text-xs font-semibold shadow-md border border-gray-100 whitespace-nowrap transition">
                Parkir Luas
            </button>
            <button data-filter="ac" class="px-4 py-1.5 bg-white text-gray-700 hover:bg-gray-50 rounded-full text-xs font-semibold shadow-md border border-gray-100 whitespace-nowrap transition">
                Ruang AC
            </button>
            <button data-filter="difabel" class="px-4 py-1.5 bg-white text-gray-700 hover:bg-gray-50 rounded-full text-xs font-semibold shadow-md border border-gray-100 whitespace-nowrap transition">
                Ramah Difabel
            </button>
        </div>
    </div>

    <!-- Floating GPS Auto-Locate Button -->
    <button id="btn-gps" class="absolute bottom-24 md:bottom-8 right-5 z-10 bg-white hover:bg-emerald-50 text-gray-700 hover:text-emerald-600 p-3.5 rounded-2xl shadow-xl border border-gray-100 focus:outline-none transition group" title="Deteksi Lokasi Saya">
        <svg class="w-6 h-6 text-emerald-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
        </svg>
    </button>

    <!-- Interactive Bottom Sheet Card -->
    <div id="bottom-sheet" class="absolute bottom-0 left-0 right-0 max-w-lg mx-auto bg-white rounded-t-3xl shadow-2xl border border-gray-100 z-30 transform translate-y-full transition-transform duration-300 ease-out">
        <!-- Drag Handle & Close -->
        <div class="relative pt-3 pb-1 cursor-pointer" onclick="closeBottomSheet()">
            <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto"></div>
            <button onclick="closeBottomSheet()" class="absolute top-2 right-4 text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="px-6 pb-6 pt-2">
            <div class="flex gap-4 items-center">
                <img id="sheet-foto" src="<?= BASE_URL ?>/public/img/placeholder.svg" class="w-20 h-20 rounded-2xl object-cover border border-gray-100 flex-shrink-0 shadow-sm">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1.5 mb-1 hidden" id="sheet-jarak-wrapper">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span id="sheet-jarak" class="text-xs font-bold text-emerald-700">1.2 km dari Anda</span>
                    </div>
                    <h3 id="sheet-nama" class="font-heading font-bold text-lg text-gray-900 leading-tight truncate">Nama Masjid</h3>
                    <p id="sheet-alamat" class="text-xs text-gray-500 mt-1 line-clamp-2">Alamat lengkap masjid...</p>
                    <div id="sheet-fasilitas" class="flex flex-wrap gap-1.5 mt-2"></div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-3 mt-5">
                <button id="btn-arahkan" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Arahkan (Maps)
                </button>
                <button id="btn-detail" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-4 rounded-xl text-sm transition">
                    Lihat Profil
                </button>
            </div>
        </div>
    </div>
</div>
