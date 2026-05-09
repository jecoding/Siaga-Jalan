<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - SIAGA JALAN</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Leaflet Geoman (Drawing Tools) -->
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />  
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>  
    
    <!-- Leaflet Control Geocoder (Search) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
    <!-- Supabase Client -->
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; display: flex; height: 100vh; overflow: hidden; }
        #sidebar { width: 380px; background: #ffffff; border-right: 1px solid #e2e8f0; display: flex; flex-direction: column; z-index: 10; box-shadow: 4px 0 15px rgba(0,0,0,0.03); }
        #map { flex-grow: 1; height: 100%; z-index: 5; }
        .leaflet-container { background: #e2e8f0; } 
        
        .user-marker { background: #3b82f6; border: 2px solid white; border-radius: 50%; box-shadow: 0 0 12px rgba(59, 130, 246, 0.6); }
        .pulse { animation: pulse 1.5s infinite; }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); } 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); } }
        
        .tab-btn { border-bottom: 2px solid transparent; }
        .tab-btn.active { border-bottom: 2px solid #059669; color: #059669; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Custom Scrollbar for sidebar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Google Maps style pin */
        .gmap-pin {
            width: 30px;
            height: 42px;
            background: none;
            border: none;
        }
        .gmap-pin svg { filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4)); }
    </style>
</head>
<body>

    <div id="sidebar">
        <!-- Header -->
        <div class="p-6 pb-2 border-b border-slate-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">SIAGA <span class="bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-teal-500">JALAN</span></h2>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-md hover:bg-red-100 transition text-xs shadow-sm border border-red-100">Logout</button>
                </form>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="flex gap-6 mt-6">
                <button class="tab-btn active pb-3 text-sm font-semibold text-slate-500 hover:text-slate-800 transition" onclick="switchTab('editor')">Map Editor</button>
                <button class="tab-btn pb-3 text-sm font-semibold text-slate-500 hover:text-slate-800 transition" onclick="switchTab('tracking')">Live Tracking</button>
            </div>
        </div>

        <!-- Contents -->
        <div class="flex-grow overflow-auto p-6 bg-slate-50/50">
            
            <!-- Tab: Map Editor -->
            <div id="tab-editor" class="tab-content active space-y-6">
                
                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm mt-6">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <div class="p-1.5 bg-blue-100 rounded-md text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        Pencarian Lanjut & Penandaan
                    </h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">Ketik koordinat presisi target tanpa menyorot peta manual.</p>
                    
                    <form id="blackSpotForm" class="space-y-4">
                        <input type="hidden" id="geojson" required>
                        <input type="hidden" id="spotRadius" value="100">

                        <div class="grid grid-cols-2 gap-3 mb-2">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Latitude</label>
                                <input type="text" id="manualLat" placeholder="-6.2088" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition font-mono">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Longitude</label>
                                <input type="text" id="manualLng" placeholder="106.8456" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition font-mono">
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="button" onclick="flyToManual()" class="w-1/2 py-2 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition text-center shadow-sm">Cari Peta</button>
                            <button type="button" onclick="markManual()" class="w-1/2 py-2 text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg transition text-center shadow-sm">Tandai Titik</button>
                        </div>

                        <div class="pt-4 mt-2">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Nama / Label Titik</label>
                            <input type="text" id="spotName" placeholder="Contoh: Tikungan Kematian" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none text-slate-800 transition placeholder-slate-400 font-medium">
                        </div>
                        
                        <button type="submit" id="btnSave" class="mt-2 w-full py-3 bg-slate-800 hover:bg-slate-900 active:bg-black text-white font-semibold rounded-lg text-sm transition shadow-md opacity-50 cursor-not-allowed flex justify-center items-center gap-2" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Koordinat
                        </button>
                    </form>
                </div>

                <div class="mt-6">
                    <h3 class="font-bold text-slate-800 mb-3 text-sm flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div> Daftar Black Spots Aktif
                    </h3>
                    <ul id="blackSpotsList" class="space-y-2.5 text-sm max-h-48 overflow-y-auto pr-2">
                        <li class="text-slate-500 italic text-xs">Memuat data...</li>
                    </ul>
                </div>
            </div>

            <!-- Tab: Live Tracking -->
            <div id="tab-tracking" class="tab-content">
                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2 relative z-10">
                        <div class="p-1.5 bg-blue-100 rounded-md text-blue-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                        </div>
                        Driver Radar
                    </h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed relative z-10">Peta akan otomatis menyoroti target jika ada perangkat pengguna atau supir yang mendeteksi sinyal GPS.</p>
                    
                    <ul id="activeUsersList" class="space-y-2.5 text-sm relative z-10">
                        <li class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 italic text-xs flex items-center gap-2 justify-center shadow-inner">
                            <svg class="w-4 h-4 animate-spin text-slate-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Menunggu pantauan satelit...
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Peta Raksasa -->
    <div id="map"></div>

    <script>
        // --- UI TABS LOGIC ---
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            event.target.classList.add('active');
            document.getElementById('tab-' + tabId).classList.add('active');
            
            // Revalidate map viewport
            setTimeout(() => map.invalidateSize(), 100);
        }

        // --- MAP INITIALIZATION ---
        const map = L.map('map', {
            center: [-6.2088, 106.8456], // Jakarta
            zoom: 13,
            zoomControl: false
        });
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Peta Google Hybrid (Satelit + Nama Jalan)
        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            attribution: '&copy; <a href="https://www.google.com/maps">Google Maps</a>',
            maxZoom: 20
        }).addTo(map);

        // --- LEAFLET GEOCODER (SEARCH BOX) ---
        L.Control.geocoder({
            defaultMarkGeocode: false,
            position: 'topright'
        })
        .on('markgeocode', function(e) {
            const bbox = e.geocode.bbox;
            const poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]);
            map.fitBounds(poly.getBounds());
            L.popup().setLatLng(e.geocode.center).setContent(e.geocode.name).openOn(map);
        })
        .addTo(map);

        // --- LEAFLET GEOMAN (DRAWING TOOLS) ---
        map.pm.addControls({
            position: 'topleft',
            drawMarker: false,
            drawPolyline: false,
            drawRectangle: false,
            drawPolygon: false,
            drawCircle: false,
            drawCircleMarker: false,
            drawText: false,
            cutPolygon: false,
            rotateMode: false,
            editMode: false,
            dragMode: false,
            removalMode: false,
        });

        // Set global styles for Geoman drawing
        map.pm.setPathOptions({
            color: '#10b981',
            fillColor: '#10b981',
            fillOpacity: 0.4,
            weight: 3
        });

        let currentDrawnLayer = null;
        const geojsonInput = document.getElementById('geojson');
        const btnSave = document.getElementById('btnSave');

        map.on('pm:create', (e) => {
            // Remove previous drawing if exists
            if (currentDrawnLayer) {
                map.removeLayer(currentDrawnLayer);
            }
            
            currentDrawnLayer = e.layer;
            const geojsonStr = JSON.stringify(currentDrawnLayer.toGeoJSON().geometry);
            geojsonInput.value = geojsonStr;
            
            btnSave.disabled = false;
            btnSave.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-slate-800');
            btnSave.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'active:bg-emerald-800');

            // Optional: Listen if they edit the shape right after drawing
            currentDrawnLayer.on('pm:edit', (x) => {
                geojsonInput.value = JSON.stringify(currentDrawnLayer.toGeoJSON().geometry);
            });
        });

        map.on('pm:remove', (e) => {
            if (e.layer === currentDrawnLayer) {
                currentDrawnLayer = null;
                geojsonInput.value = '';
                btnSave.disabled = true;
                btnSave.classList.add('opacity-50', 'cursor-not-allowed', 'bg-slate-800');
                btnSave.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'active:bg-emerald-800');
            }
        });

        // --- MANUAL COORDINATE SEARCH ---
        window.flyToManual = function() {
            const lat = parseFloat(document.getElementById('manualLat').value);
            const lng = parseFloat(document.getElementById('manualLng').value);
            if(isNaN(lat) || isNaN(lng)) return alert('Koordinat tidak valid!');
            map.flyTo([lat, lng], 18);
        };

        // Google Maps Pin Icon
        const gmapPinIcon = L.divIcon({
            className: 'gmap-pin',
            html: '<svg viewBox="0 0 24 36" width="30" height="42" xmlns="http://www.w3.org/2000/svg"><path d="M12 0C5.372 0 0 5.372 0 12c0 9 12 24 12 24s12-15 12-24C24 5.372 18.628 0 12 0z" fill="#EA4335"/><circle cx="12" cy="12" r="5" fill="white"/></svg>',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
            popupAnchor: [0, -42]
        });

        let manualPinMarker = null; // terpisah dari circle agar bisa cleanup bersamaan

        window.markManual = function() {
            const lat = parseFloat(document.getElementById('manualLat').value);
            const lng = parseFloat(document.getElementById('manualLng').value);
            if(isNaN(lat) || isNaN(lng)) return alert('Koordinat tidak valid!');
            
            // Pindahkan pandangan peta target
            map.flyTo([lat, lng], 18);

            // Bersihkan jika ada tool layar sebelumnya
            if (currentDrawnLayer) map.removeLayer(currentDrawnLayer);
            if (manualPinMarker) map.removeLayer(manualPinMarker);
            
            // Buat area Lingkaran (Buffer 100m) sebagai penunjuk visual titik rawan
            currentDrawnLayer = L.circle([lat, lng], {
                radius: 100,
                color: '#ef4444', 
                fillColor: '#ef4444', 
                fillOpacity: 0.25, 
                weight: 4
            });
            currentDrawnLayer.addTo(map);

            // Tambahkan pin Google Maps style di pusat lingkaran
            manualPinMarker = L.marker([lat, lng], { icon: gmapPinIcon });
            manualPinMarker.addTo(map);
            
            // Fokuskan pandangan agar area buffer masuk ke layar penuh
            map.fitBounds(currentDrawnLayer.getBounds());

            // Ekstrak nilai string geometry POINT ke form
            const geojsonStr = JSON.stringify(currentDrawnLayer.toGeoJSON().geometry);
            geojsonInput.value = geojsonStr;
            
            // Aktifkan tombol simpan
            btnSave.disabled = false;
            btnSave.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-slate-800');
            btnSave.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'active:bg-emerald-800');
            
            alert('Titik berhasil ditandai! Silahkan isi nama dan Simpan Ke Database.');
        };

        // --- MANAGE BLACK SPOTS ---
        let blackSpotLayers = {};
        const spotsListUl = document.getElementById('blackSpotsList');

        async function loadBlackSpots() {
            spotsListUl.innerHTML = '<li class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 italic text-xs text-center border-dashed">Memuat data infrastruktur...</li>';
            const res = await fetch('/api/admin/black_spots');
            const data = await res.json();
            
            spotsListUl.innerHTML = '';
            
            if(data.length === 0) {
                spotsListUl.innerHTML = '<li class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-500 font-medium italic text-xs text-center border-dashed">Belum ada titik pantauan tersimpan.</li>';
                return;
            }

            data.forEach(spot => {
                // spot.geojson is stringified geojson geometry from PostGIS ST_AsGeoJSON
                const geometry = JSON.parse(spot.geojson);
                const layer = L.geoJSON(geometry, {
                    style: { color: '#ef4444', fillColor: '#ef4444', fillOpacity: 0.25, weight: 4 },
                    pointToLayer: function (feature, latlng) {
                        return L.circleMarker(latlng, { radius: 8, color: '#ef4444', fillColor: '#ef4444', fillOpacity: 0.5, weight: 2 });
                    }
                });
                
                layer.bindPopup(`
                    <div class="font-inter">
                        <b class="text-slate-800 text-base">${spot.name}</b>
                        <p class="text-xs text-slate-500 mt-1">Zona Buffer: <span class="font-bold text-red-500">${spot.radius}m</span></p>
                        <div class="mt-3 pt-2 border-t border-slate-100 text-right">
                            <button onclick="deleteSpot(${spot.id})" class="px-2 py-1 bg-red-50 text-red-600 font-bold hover:bg-red-100 rounded text-xs transition">Hapus Area</button>
                        </div>
                    </div>
                `);
                
                layer.addTo(map);
                blackSpotLayers[spot.id] = { geoLayer: layer, pinMarker: null };

                // Tambahkan pin Google Maps di pusat area (untuk tipe Point)
                if (geometry.type === 'Point') {
                    const pin = L.marker([geometry.coordinates[1], geometry.coordinates[0]], { icon: gmapPinIcon });
                    pin.addTo(map);
                    blackSpotLayers[spot.id].pinMarker = pin;
                }

                // Add to sidebar list
                const li = document.createElement('li');
                li.className = "bg-white border border-slate-200 p-3 text-sm rounded-lg flex justify-between items-center shadow-sm hover:border-blue-400 hover:bg-blue-50/50 transition group cursor-pointer";
                li.setAttribute('onclick', `flyToSpot(${spot.id})`);
                li.innerHTML = `
                    <div class="truncate">
                        <div class="font-bold text-slate-700 truncate max-w-[200px]">${spot.name}</div>
                        <div class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-0.5"><span class="w-1.5 h-1.5 inline-block bg-red-500 rounded-full mr-1"></span> ${spot.radius}m Radius</div>
                    </div>
                    <button onclick="event.stopPropagation(); deleteSpot(${spot.id})" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-md transition opacity-0 group-hover:opacity-100" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                `;
                spotsListUl.appendChild(li);
            });
        }
        loadBlackSpots();

        window.flyToSpot = function(id) {
            const entry = blackSpotLayers[id];
            if (!entry || !entry.geoLayer) return;
            const bounds = entry.geoLayer.getBounds();
            map.flyToBounds(bounds, { padding: [60, 60], maxZoom: 18 });
            entry.geoLayer.openPopup();
        };

        window.deleteSpot = async function(id) {
            if(!confirm("Yakin hapus area ini permanen dari radar?")) return;
            const res = await fetch(`/api/admin/black_spots/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            if(res.ok) {
                const entry = blackSpotLayers[id];
                if (entry) {
                    if (entry.geoLayer) map.removeLayer(entry.geoLayer);
                    if (entry.pinMarker) map.removeLayer(entry.pinMarker);
                }
                delete blackSpotLayers[id];
                loadBlackSpots();
                map.closePopup();
            }
        };

        // Form Submit
        const radiusInput = document.getElementById('spotRadius');

        document.getElementById('blackSpotForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            if(!geojsonInput.value) return alert('Silahkan gambar garis/area di peta terlebih dahulu!');

            // Change btn to loading state
            const originalBtnHtml = btnSave.innerHTML;
            btnSave.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...`;

            const data = {
                name: document.getElementById('spotName').value,
                geojson: geojsonInput.value,
                radius: radiusInput.value
            };

            const res = await fetch('/api/admin/black_spots', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });

            btnSave.innerHTML = originalBtnHtml;

            if(res.ok) {
                if (currentDrawnLayer) map.removeLayer(currentDrawnLayer);
                currentDrawnLayer = null;
                e.target.reset();
                geojsonInput.value = '';
                btnSave.disabled = true;
                btnSave.classList.add('opacity-50', 'cursor-not-allowed', 'bg-slate-800');
                btnSave.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'active:bg-emerald-800');
                
                // cleanup existing red spots and reload
                for(let k in blackSpotLayers) {
                    const entry = blackSpotLayers[k];
                    if (entry) {
                        if (entry.geoLayer) map.removeLayer(entry.geoLayer);
                        if (entry.pinMarker) map.removeLayer(entry.pinMarker);
                    }
                }
                if (manualPinMarker) { map.removeLayer(manualPinMarker); manualPinMarker = null; }
                await loadBlackSpots();
            } else {
                alert('Gagal menyimpan area. Pastikan format tergambar dengan benar.');
            }
        });

        // --- SUPABASE REALTIME Setup ---
        const supabaseUrl = '{{ env("SUPABASE_URL") }}';
        const supabaseKey = '{{ env("SUPABASE_KEY") }}';
        
        let userMarkers = {};
        if (supabaseUrl && supabaseKey && supabaseUrl !== 'MASUKKAN_URL_SUPABASE_DISINI') {
            const { createClient } = supabase;
            const sb = createClient(supabaseUrl, supabaseKey);
            
            const usersListUl = document.getElementById('activeUsersList');

            const channel = sb.channel('realtime_users')
            .on('postgres_changes', { event: '*', schema: 'public', table: 'user_locations' }, payload => {
                console.log('Realtime change detected:', payload);
                const row = payload.new || payload.old;
                if (!row || !row.lat || !row.lng) return;
                
                // Update Map Marker
                if (userMarkers[row.user_id]) {
                    userMarkers[row.user_id].marker.setLatLng([row.lat, row.lng]);
                    // Update metadata
                    userMarkers[row.user_id].userName = row.user_name;
                    userMarkers[row.user_id].vehicleType = row.vehicle_type;
                } else {
                    const icon = L.divIcon({ className: 'user-marker pulse', iconSize: [14, 14] });
                    const m = L.marker([row.lat, row.lng], {icon})
                               .bindTooltip(`<b class="text-blue-600">${row.user_name || 'Supir'}</b><br/><span class="text-[10px] text-slate-500">${row.vehicle_type || 'Kendaraan'}</span>`, {permanent: false});
                    m.addTo(map);
                    userMarkers[row.user_id] = { 
                        marker: m, 
                        updateTime: new Date(),
                        userName: row.user_name,
                        vehicleType: row.vehicle_type
                    };
                }

                renderUsersList();
            })
            .subscribe((status) => {
                console.log('Supabase Realtime status:', status);
            });

            window.flyToUser = function(uid) {
                const data = userMarkers[uid];
                if (data && data.marker) {
                    map.flyTo(data.marker.getLatLng(), 17, { animate: true, duration: 1.5 });
                    data.marker.openTooltip();
                }
            };

            function renderUsersList() {
                usersListUl.innerHTML = ''; // Re-render to update names
                for(let uid in userMarkers) {
                    const data = userMarkers[uid];
                    const li = document.createElement('li');
                    li.className = "bg-white p-3 rounded-lg border-l-4 border border-slate-200 border-l-blue-500 shadow-sm flex justify-between items-center transition cursor-pointer hover:bg-blue-50 hover:border-blue-300 mb-2";
                    li.setAttribute('onclick', `flyToUser('${uid}')`);
                    li.innerHTML = `
                        <div class="truncate mr-2">
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full shadow-[0_0_8px_rgba(59,130,246,0.8)] animate-pulse"></span>
                                <span class="font-bold text-slate-700 truncate">${data.userName || 'Supir'}</span>
                            </div>
                            <div class="text-[10px] text-slate-500 mt-0.5 ml-4 uppercase font-bold tracking-tight">${data.vehicleType || 'Kendaraan'}</div>
                        </div>
                        <span class="text-[9px] text-blue-600 font-bold tracking-widest bg-blue-50 px-2 py-0.5 rounded uppercase border border-blue-100 flex-shrink-0">ON RADAR</span>
                    `;
                    usersListUl.appendChild(li);
                }
            }
        }
    </script>
</body>
</html>
