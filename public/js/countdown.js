/**
 * Prayer Time Countdown Widget - Jejak Muslim Indonesia
 * Immediate fallback + Aladhan API synchronization
 */
function initPrayerCountdown() {
    const nextPrayerNameEl = document.getElementById('next-prayer-name');
    const nextPrayerTimeEl = document.getElementById('next-prayer-time');
    const countdownTimerEl = document.getElementById('countdown-timer');
    const cityLabelEl = document.getElementById('prayer-city-label');
    
    if (!countdownTimerEl) return;

    let timerInterval = null;

    const PRAYER_NAMES = {
        'Fajr': 'Subuh',
        'Dhuhr': 'Dzuhur',
        'Asr': 'Ashar',
        'Maghrib': 'Maghrib',
        'Isha': 'Isya'
    };

    // Instant realistic baseline prayer times for Indonesia (WIB)
    // Ensures timer ticks IMMEDIATELY without waiting for network or GPS prompt
    let prayerTimes = {
        'Fajr': '04:36',
        'Dhuhr': '11:55',
        'Asr': '15:11',
        'Maghrib': '17:57',
        'Isha': '19:06'
    };

    // 1. Immediately start ticking with baseline data
    startTimer();
    updateSlotsUI();

    // 2. Fetch live data with safe timeout
    initCountdown();

    function initCountdown() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    if (cityLabelEl) cityLabelEl.textContent = 'Lokasi Terdeteksi (GPS)';
                    fetchPrayerTimes(pos.coords.latitude, pos.coords.longitude);
                },
                () => {
                    // Fallback to Jakarta
                    fetchPrayerTimes(-6.2088, 106.8456);
                },
                { timeout: 3000, enableHighAccuracy: false }
            );
        } else {
            fetchPrayerTimes(-6.2088, 106.8456);
        }
    }

    async function fetchPrayerTimes(lat, lng) {
        const today = new Date();
        const dateStr = `${today.getDate()}-${today.getMonth() + 1}-${today.getFullYear()}`;
        const cacheKey = `prayer_times_${dateStr}_${lat.toFixed(2)}_${lng.toFixed(2)}`;
        
        const cached = localStorage.getItem(cacheKey);
        if (cached) {
            try {
                prayerTimes = JSON.parse(cached);
                updateTimer();
                updateSlotsUI();
                return;
            } catch (e) {
                localStorage.removeItem(cacheKey);
            }
        }

        try {
            const timestamp = Math.floor(today.getTime() / 1000);
            const url = `https://api.aladhan.com/v1/timings/${timestamp}?latitude=${lat}&longitude=${lng}&method=20`;
            
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 4000);

            const response = await fetch(url, { signal: controller.signal });
            clearTimeout(timeoutId);
            const data = await response.json();
            
            if (data && data.code === 200 && data.data && data.data.timings) {
                prayerTimes = {
                    'Fajr': data.data.timings.Fajr.substring(0, 5),
                    'Dhuhr': data.data.timings.Dhuhr.substring(0, 5),
                    'Asr': data.data.timings.Asr.substring(0, 5),
                    'Maghrib': data.data.timings.Maghrib.substring(0, 5),
                    'Isha': data.data.timings.Isha.substring(0, 5)
                };
                
                localStorage.setItem(cacheKey, JSON.stringify(prayerTimes));
                updateTimer();
                updateSlotsUI();
            }
        } catch (error) {
            // Baseline times will continue smoothly without disruption
            console.log('Using baseline prayer times.');
        }
    }

    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);
        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);
    }

    function updateTimer() {
        const now = new Date();
        const currentHours = now.getHours();
        const currentMinutes = now.getMinutes();
        const currentSeconds = now.getSeconds();
        const currentTimeInSeconds = currentHours * 3600 + currentMinutes * 60 + currentSeconds;

        // Convert prayer times to seconds from midnight
        const prayerSchedule = [
            { key: 'Fajr', name: 'Subuh', time: prayerTimes['Fajr'] },
            { key: 'Dhuhr', name: 'Dzuhur', time: prayerTimes['Dhuhr'] },
            { key: 'Asr', name: 'Ashar', time: prayerTimes['Asr'] },
            { key: 'Maghrib', name: 'Maghrib', time: prayerTimes['Maghrib'] },
            { key: 'Isha', name: 'Isya', time: prayerTimes['Isha'] }
        ].map(item => {
            const [h, m] = (item.time || '00:00').split(':').map(Number);
            return {
                ...item,
                seconds: h * 3600 + m * 60
            };
        });

        // Find upcoming prayer today
        let nextPrayer = prayerSchedule.find(p => p.seconds > currentTimeInSeconds);
        let secondsLeft = 0;

        if (nextPrayer) {
            secondsLeft = nextPrayer.seconds - currentTimeInSeconds;
        } else {
            // All prayers today have passed, target is Subuh tomorrow
            nextPrayer = prayerSchedule[0]; // Fajr
            const secondsUntilMidnight = (24 * 3600) - currentTimeInSeconds;
            secondsLeft = secondsUntilMidnight + nextPrayer.seconds;
        }

        if (nextPrayerNameEl) {
            nextPrayerNameEl.textContent = nextPrayer.name;
        }
        if (nextPrayerTimeEl) {
            nextPrayerTimeEl.textContent = nextPrayer.time;
        }

        // Format countdown H:M:S
        const hoursLeft = Math.floor(secondsLeft / 3600);
        const minutesLeft = Math.floor((secondsLeft % 3600) / 60);
        const secsLeft = secondsLeft % 60;

        countdownTimerEl.textContent = 
            `${hoursLeft.toString().padStart(2, '0')}:${minutesLeft.toString().padStart(2, '0')}:${secsLeft.toString().padStart(2, '0')}`;
            
        highlightCurrentSlot(nextPrayer.key);
    }

    function updateSlotsUI() {
        const slotMap = {
            'Fajr': 'time-fajr',
            'Dhuhr': 'time-dhuhr',
            'Asr': 'time-asr',
            'Maghrib': 'time-maghrib',
            'Isha': 'time-isha'
        };

        Object.entries(slotMap).forEach(([prayerKey, elId]) => {
            const el = document.getElementById(elId);
            if (el && prayerTimes[prayerKey]) {
                el.textContent = prayerTimes[prayerKey];
            }
        });
    }
    
    function highlightCurrentSlot(nextPrayer) {
        document.querySelectorAll('.prayer-slot').forEach(slot => {
            slot.classList.remove('bg-white/30', 'border-white/40', 'shadow-sm');
            slot.classList.add('bg-white/10');
        });
        
        const activeSlot = document.getElementById(`slot-${nextPrayer.toLowerCase()}`);
        if (activeSlot) {
            activeSlot.classList.remove('bg-white/10');
            activeSlot.classList.add('bg-white/30', 'border', 'border-white/40', 'shadow-sm');
        }
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPrayerCountdown);
} else {
    initPrayerCountdown();
}
