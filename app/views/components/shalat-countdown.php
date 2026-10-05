<div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-white shadow-xl relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-2xl"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-400/20 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-between mb-2">
            <span class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs font-medium text-emerald-100 bg-white/10 px-2.5 sm:px-3 py-1 rounded-full backdrop-blur-sm truncate max-w-[200px] sm:max-w-none">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse shrink-0"></span>
                <span id="prayer-city-label" class="truncate">DKI Jakarta & Sekitarnya</span>
            </span>
            <span id="next-prayer-time" class="text-xs sm:text-sm font-semibold text-emerald-200">11:50</span>
        </div>

        <p class="text-[11px] sm:text-xs text-emerald-100 font-medium">Menuju Waktu Shalat</p>
        <h2 id="next-prayer-name" class="font-['Poppins'] text-2xl sm:text-4xl font-bold tracking-tight text-white mb-1 sm:mb-2">Dzuhur</h2>
        
        <div class="flex items-baseline gap-2 mb-4 sm:mb-6">
            <span id="countdown-timer" class="font-mono text-2xl sm:text-4xl font-bold tracking-wider text-emerald-50">-:-:-</span>
            <span class="text-xs text-emerald-200 font-medium">lagi</span>
        </div>
        
        <!-- 5 Prayer Slots -->
        <div class="grid grid-cols-5 gap-1 sm:gap-2 pt-2 border-t border-white/15">
            <div id="slot-fajr" class="prayer-slot flex flex-col items-center py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-lg sm:rounded-xl bg-white/10 backdrop-blur-sm transition-all duration-300">
                <span class="text-[10px] sm:text-[11px] text-emerald-100">Subuh</span>
                <span id="time-fajr" class="font-semibold text-[11px] sm:text-sm mt-0.5">04:30</span>
            </div>
            <div id="slot-dhuhr" class="prayer-slot flex flex-col items-center py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-lg sm:rounded-xl bg-white/25 border border-white/30 backdrop-blur-sm transition-all duration-300">
                <span class="text-[10px] sm:text-[11px] text-emerald-100">Dzuhur</span>
                <span id="time-dhuhr" class="font-semibold text-[11px] sm:text-sm mt-0.5">11:50</span>
            </div>
            <div id="slot-asr" class="prayer-slot flex flex-col items-center py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-lg sm:rounded-xl bg-white/10 backdrop-blur-sm transition-all duration-300">
                <span class="text-[10px] sm:text-[11px] text-emerald-100">Ashar</span>
                <span id="time-asr" class="font-semibold text-[11px] sm:text-sm mt-0.5">15:10</span>
            </div>
            <div id="slot-maghrib" class="prayer-slot flex flex-col items-center py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-lg sm:rounded-xl bg-white/10 backdrop-blur-sm transition-all duration-300">
                <span class="text-[10px] sm:text-[11px] text-emerald-100">Maghrib</span>
                <span id="time-maghrib" class="font-semibold text-[11px] sm:text-sm mt-0.5">18:00</span>
            </div>
            <div id="slot-isha" class="prayer-slot flex flex-col items-center py-1.5 sm:py-2 px-0.5 sm:px-1 rounded-lg sm:rounded-xl bg-white/10 backdrop-blur-sm transition-all duration-300">
                <span class="text-[10px] sm:text-[11px] text-emerald-100">Isya</span>
                <span id="time-isha" class="font-semibold text-[11px] sm:text-sm mt-0.5">19:15</span>
            </div>
        </div>
    </div>
</div>
