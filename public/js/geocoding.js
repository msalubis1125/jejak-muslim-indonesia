/**
 * Geocoding for Admin Forms (Pick location on map)
 */
document.addEventListener('DOMContentLoaded', function() {
    const mapEl = document.getElementById('geocoding-map');
    if (!mapEl) return;

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    
    // Default or existing coords
    let initialLat = latInput && latInput.value ? parseFloat(latInput.value) : -6.200000;
    let initialLng = lngInput && lngInput.value ? parseFloat(lngInput.value) : 106.816666;
    let zoomLevel = latInput && latInput.value ? 16 : 11;

    const map = L.map('geocoding-map').setView([initialLat, initialLng], zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const marker = L.marker([initialLat, initialLng], {
        draggable: true
    }).addTo(map);

    function updateInputs(lat, lng) {
        if (latInput) latInput.value = lat.toFixed(6);
        if (lngInput) lngInput.value = lng.toFixed(6);
    }

    // Drag event
    marker.on('dragend', function(e) {
        const pos = marker.getLatLng();
        updateInputs(pos.lat, pos.lng);
    });

    // Click event on map
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng.lat, e.latlng.lng);
    });

    // Search Box Logic
    const searchBtn = document.getElementById('btn-search-location');
    const searchInput = document.getElementById('search-location');
    
    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            const query = searchInput.value;
            if (!query) return;
            
            searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                const data = await res.json();
                
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    updateInputs(lat, lng);
                } else {
                    alert('Lokasi tidak ditemukan');
                }
            } catch (error) {
                console.error(error);
                alert('Gagal mencari lokasi');
            } finally {
                searchBtn.innerHTML = 'Cari';
            }
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchBtn.click();
            }
        });
    }
});
