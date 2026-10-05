/**
 * Map Logic for Jejak Muslim Indonesia
 * Integrated with Leaflet.js, OpenStreetMap, and /peta/markers API
 */
function initPeta() {
    const mapEl = document.getElementById('map');
    if (!mapEl) return;

    // Detect BASE_URL from meta or current path
    const baseUrl = window.BASE_URL || (window.location.origin + '/jejak-muslim-indonesia');

    // Default view: Jakarta Central
    let mapCenter = [-6.200000, 106.816666];
    let mapZoom = 12;
    let userLatLng = null;
    let userMarker = null;
    let allMosques = [];
    let activeFilter = 'all';
    let leafletMarkers = [];

    // Initialize Map
    const map = L.map('map', {
        zoomControl: false
    }).setView(mapCenter, mapZoom);

    // Invalidate size shortly after render to avoid grey box
    setTimeout(() => { map.invalidateSize(); }, 300);

    // Add OpenStreetMap Tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // Custom Emerald Mosque Icon
    const mosqueSvg = `<svg width="36" height="48" viewBox="0 0 36 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M18 0C8.05887 0 0 8.05887 0 18C0 31.5 18 48 18 48C18 48 36 31.5 36 18C36 8.05887 27.9411 0 18 0Z" fill="#059669"/>
        <path d="M18 2C9.16344 2 2 9.16344 2 18C2 30 18 44.5 18 44.5C18 44.5 34 30 34 18C34 9.16344 26.8366 2 18 2Z" fill="#047857"/>
        <path d="M18 8C15 8 13 11 13 14H23C23 11 21 8 18 8ZM11 16V26H25V16H11ZM18 18C19.6569 18 21 19.3431 21 21V26H15V21C15 19.3431 16.3431 18 18 18Z" fill="white"/>
    </svg>`;

    const customMosqueIcon = L.divIcon({
        html: mosqueSvg,
        className: 'custom-mosque-marker',
        iconSize: [36, 48],
        iconAnchor: [18, 48],
        popupAnchor: [0, -48]
    });

    // Bottom Sheet Elements
    const bottomSheet = document.getElementById('bottom-sheet');
    const sheetImg = document.getElementById('sheet-foto');
    const sheetNama = document.getElementById('sheet-nama');
    const sheetAlamat = document.getElementById('sheet-alamat');
    const sheetJarak = document.getElementById('sheet-jarak');
    const sheetFasilitas = document.getElementById('sheet-fasilitas');
    const btnArahkan = document.getElementById('btn-arahkan');
    const btnDetail = document.getElementById('btn-detail');

    // 1. Fetch Markers from backend
    fetch(baseUrl + '/peta/markers')
        .then(res => res.json())
        .then(data => {
            allMosques = data || [];
            renderMarkers(allMosques);

            // If we have mosques, fit map to markers
            if (allMosques.length > 0) {
                const group = L.featureGroup(leafletMarkers);
                map.fitBounds(group.getBounds().pad(0.2));
            }
        })
        .catch(err => console.error('Gagal mengambil data masjid:', err));

    function renderMarkers(mosques) {
        // Clear existing markers
        leafletMarkers.forEach(m => map.removeLayer(m));
        leafletMarkers = [];

        mosques.forEach(m => {
            if (!m.lat || !m.lng) return;

            const lat = parseFloat(m.lat);
            const lng = parseFloat(m.lng);

            const marker = L.marker([lat, lng], { icon: customMosqueIcon }).addTo(map);
            marker.mosqueData = m;

            marker.on('click', function() {
                showBottomSheet(m, lat, lng);
            });

            leafletMarkers.push(marker);
        });
    }

    function showBottomSheet(mosque, lat, lng) {
        if (!bottomSheet) return;

        if (sheetNama) sheetNama.textContent = mosque.nama;
        if (sheetAlamat) sheetAlamat.textContent = mosque.alamat || 'Alamat terdaftar';
        if (sheetImg) sheetImg.src = mosque.foto_utama || (baseUrl + '/public/img/placeholder.svg');

        // Distance calculation if user location available
        if (userLatLng && sheetJarak) {
            const dist = calculateDistance(userLatLng.lat, userLatLng.lng, lat, lng);
            sheetJarak.textContent = dist < 1 ? Math.round(dist * 1000) + ' meter' : dist.toFixed(1) + ' km';
            sheetJarak.parentElement.classList.remove('hidden');
        } else if (sheetJarak) {
            sheetJarak.parentElement.classList.add('hidden');
        }

        // Facilities badges
        if (sheetFasilitas) {
            sheetFasilitas.innerHTML = '';
            if (mosque.buka_24jam) {
                sheetFasilitas.innerHTML += '<span class="text-[10px] font-bold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-md">24 Jam</span>';
            }
            if (mosque.fasilitas && Array.isArray(mosque.fasilitas)) {
                mosque.fasilitas.slice(0, 3).forEach(f => {
                    sheetFasilitas.innerHTML += `<span class="text-[10px] font-medium bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md">${f}</span>`;
                });
            }
        }

        // Actions
        if (btnArahkan) {
            btnArahkan.onclick = function() {
                window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, '_blank');
            };
        }
        if (btnDetail) {
            btnDetail.onclick = function() {
                window.location.href = baseUrl + '/masjid/' + (mosque.slug || mosque.id);
            };
        }

        bottomSheet.classList.remove('translate-y-full');
        map.panTo([lat, lng]);
    }

    window.closeBottomSheet = function() {
        if (bottomSheet) {
            bottomSheet.classList.add('translate-y-full');
        }
    };

    // Auto-locate GPS Functionality
    const btnGps = document.getElementById('btn-gps');
    if (btnGps) {
        btnGps.addEventListener('click', locateUser);
    }

    function locateUser() {
        if (!navigator.geolocation) {
            alert('Geolokasi tidak didukung oleh browser Anda.');
            return;
        }

        btnGps && btnGps.classList.add('animate-spin');

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                btnGps && btnGps.classList.remove('animate-spin');
                userLatLng = {
                    lat: pos.coords.latitude,
                    lng: pos.coords.longitude
                };

                if (userMarker) {
                    userMarker.setLatLng([userLatLng.lat, userLatLng.lng]);
                } else {
                    const blueDot = L.divIcon({
                        html: '<div class="w-4 h-4 bg-blue-600 rounded-full border-2 border-white shadow-lg relative"><div class="absolute -inset-1 bg-blue-400 rounded-full animate-ping opacity-75"></div></div>',
                        className: 'user-gps-dot',
                        iconSize: [16, 16],
                        iconAnchor: [8, 8]
                    });
                    userMarker = L.marker([userLatLng.lat, userLatLng.lng], { icon: blueDot }).addTo(map);
                }

                map.flyTo([userLatLng.lat, userLatLng.lng], 14, { duration: 1.5 });
            },
            function(err) {
                btnGps && btnGps.classList.remove('animate-spin');
                alert('Tidak dapat mendeteksi lokasi GPS Anda.');
            },
            { timeout: 5000, enableHighAccuracy: true }
        );
    }

    // Try passive locate
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            userLatLng = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude
            };
        }, () => {}, { timeout: 3000 });
    }

    // Dynamic Filter Chips
    const filterButtons = document.querySelectorAll('[data-filter]');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            filterButtons.forEach(b => {
                b.classList.remove('bg-emerald-600', 'text-white');
                b.classList.add('bg-white', 'text-gray-700');
            });
            this.classList.remove('bg-white', 'text-gray-700');
            this.classList.add('bg-emerald-600', 'text-white');

            const filter = this.getAttribute('data-filter');
            applyFilter(filter);
        });
    });

    function applyFilter(filter) {
        activeFilter = filter;
        let filtered = allMosques;

        if (filter === '24jam') {
            filtered = allMosques.filter(m => m.buka_24jam == 1);
        } else if (filter === 'parkir') {
            filtered = allMosques.filter(m => m.fasilitas && m.fasilitas.some(f => f.toLowerCase().includes('parkir')));
        } else if (filter === 'ac') {
            filtered = allMosques.filter(m => m.fasilitas && m.fasilitas.some(f => f.toLowerCase().includes('ac')));
        } else if (filter === 'difabel') {
            filtered = allMosques.filter(m => m.fasilitas && m.fasilitas.some(f => f.toLowerCase().includes('difabel')));
        }

        renderMarkers(filtered);
    }

    // Search Autocomplete / Instant Filter
    const searchInput = document.getElementById('map-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            if (!query) {
                applyFilter(activeFilter);
                return;
            }

            const matched = allMosques.filter(m => 
                m.nama.toLowerCase().includes(query) || 
                (m.alamat && m.alamat.toLowerCase().includes(query))
            );

            renderMarkers(matched);

            if (matched.length === 1 && matched[0].lat && matched[0].lng) {
                map.panTo([parseFloat(matched[0].lat), parseFloat(matched[0].lng)]);
            }
        });
    }

    // Haversine formula
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPeta);
} else {
    initPeta();
}
