<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SIAGA JALAN - Traveler</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background: #0f172a; color: white; height: 100dvh; display: flex; flex-direction: column; overflow: hidden; -webkit-user-select: none; user-select: none; }
        #map { flex-grow: 1; width: 100%; z-index: 1; }
        .leaflet-container { background: #1e293b; }
        
        /* Pulse animation for danger */
        .danger-pulse { animation: dangerPulse 0.6s ease-in-out infinite alternate; }
        @keyframes dangerPulse {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            100% { box-shadow: 0 0 40px 10px rgba(239, 68, 68, 0.3); }
        }
        
        /* Status bar glow */
        .glow-safe { box-shadow: 0 -4px 20px rgba(16, 185, 129, 0.3); }
        .glow-danger { box-shadow: 0 -4px 30px rgba(239, 68, 68, 0.5); }
        .glow-idle { box-shadow: 0 -4px 15px rgba(100, 116, 139, 0.2); }
        
        /* Custom marker */
        .my-location-marker {
            width: 20px; height: 20px;
            background: #3b82f6;
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.8);
            animation: locPulse 2s infinite;
        }
        @keyframes locPulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.6); }
            50% { box-shadow: 0 0 0 14px rgba(59,130,246,0); }
        }

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

    <!-- Top Bar -->
    <div class="bg-slate-900 border-b border-slate-800 px-4 py-3 flex items-center justify-between z-10 relative">
        <div>
            <h1 class="text-lg font-extrabold tracking-tight">SIAGA <span class="text-blue-400">JALAN</span></h1>
            <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">GPS Traveler Mode</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div id="statusDot" class="w-3 h-3 rounded-full bg-slate-600 transition-all duration-500"></div>
                <span id="statusLabel" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Idle</span>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-400 bg-red-500/10 hover:bg-red-500/20 px-3 py-1.5 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Map -->
    <div id="map"></div>
    
    <!-- Bottom Control Panel -->
    <div id="bottomPanel" class="bg-slate-900 border-t border-slate-800 p-4 z-10 relative transition-all duration-500 glow-idle">
        
        <!-- Warning Banner (hidden by default) -->
        <div id="warningBanner" class="hidden mb-3 p-3 bg-red-500/20 border border-red-500/50 rounded-xl text-center danger-pulse">
            <p class="text-red-400 font-black text-sm uppercase tracking-wider">⚠️ Area Rawan Kecelakaan!</p>
            <p id="warningSpotName" class="text-white text-xs font-bold mt-1"></p>
        </div>
        
        <!-- Safe Banner (hidden by default) -->
        <div id="safeBanner" class="hidden mb-3 p-3 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-center">
            <p class="text-emerald-400 font-bold text-sm">✅ Rute Aman — Selamat Berkendara</p>
        </div>

        <!-- Controls -->
        <div class="flex items-center gap-3">
            <button id="btnTrack" onclick="toggleTracking()" class="flex-grow py-3.5 rounded-xl font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white shadow-lg shadow-blue-600/30">
                <svg id="iconPlay" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                <svg id="iconStop" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"></path></svg>
                <span id="btnLabel">Mulai Pantau GPS</span>
            </button>
            <button onclick="centerOnMe()" class="p-3.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 transition shadow-sm" title="Pusatkan Peta">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </button>
        </div>
        
        <div class="mt-3 flex justify-between text-[10px] text-slate-600 font-mono uppercase">
            <span>Lat: <span id="displayLat" class="text-slate-400">—</span></span>
            <span>Lng: <span id="displayLng" class="text-slate-400">—</span></span>
            <span>Spd: <span id="displaySpd" class="text-slate-400">—</span></span>
        </div>
    </div>

    <script>
        const USER_ID = '{{ auth()->id() }}';

        // --- MAP INIT ---
        const map = L.map('map', {
            center: [-6.2088, 106.8456],
            zoom: 15,
            zoomControl: false
        });

        L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20
        }).addTo(map);

        // Google Maps Pin Icon
        const gmapPinIcon = L.divIcon({
            className: 'gmap-pin',
            html: '<svg viewBox="0 0 24 36" width="30" height="42" xmlns="http://www.w3.org/2000/svg"><path d="M12 0C5.372 0 0 5.372 0 12c0 9 12 24 12 24s12-15 12-24C24 5.372 18.628 0 12 0z" fill="#EA4335"/><circle cx="12" cy="12" r="5" fill="white"/></svg>',
            iconSize: [30, 42],
            iconAnchor: [15, 42],
            popupAnchor: [0, -42]
        });

        // --- LOAD BLACK SPOTS ---
        let blackSpotsLayerGroup = L.layerGroup().addTo(map);

        async function loadBlackSpots() {
            try {
                const res = await fetch('/api/black_spots');
                const data = await res.json();
                
                blackSpotsLayerGroup.clearLayers();

                data.forEach(spot => {
                    const geometry = JSON.parse(spot.geojson);
                    
                    // Draw the 100m buffer circle
                    const circle = L.circle([geometry.coordinates[1], geometry.coordinates[0]], {
                        radius: 100,
                        color: '#ef4444', 
                        fillColor: '#ef4444', 
                        fillOpacity: 0.2, 
                        weight: 2
                    });
                    blackSpotsLayerGroup.addLayer(circle);

                    // Add markers for points
                    if (geometry.type === 'Point') {
                        const marker = L.marker([geometry.coordinates[1], geometry.coordinates[0]], { icon: gmapPinIcon })
                                        .bindTooltip(`<b class="text-red-600">TITIK RAWAN</b><br/>${spot.name}`, { permanent: false });
                        blackSpotsLayerGroup.addLayer(marker);
                    }
                });
            } catch (e) {
                console.error('Failed to load black spots:', e);
            }
        }

        function clearBlackSpots() {
            blackSpotsLayerGroup.clearLayers();
        }

        // My location marker
        const myIcon = L.divIcon({ className: 'my-location-marker', iconSize: [20, 20] });
        let myMarker = null;
        let myLatLng = null;

        // --- TRACKING STATE ---
        let isTracking = false;
        let watchId = null;
        let syncInterval = null;

        // DOM refs
        const btnTrack = document.getElementById('btnTrack');
        const btnLabel = document.getElementById('btnLabel');
        const iconPlay = document.getElementById('iconPlay');
        const iconStop = document.getElementById('iconStop');
        const statusDot = document.getElementById('statusDot');
        const statusLabel = document.getElementById('statusLabel');
        const bottomPanel = document.getElementById('bottomPanel');
        const warningBanner = document.getElementById('warningBanner');
        const warningSpotName = document.getElementById('warningSpotName');
        const safeBanner = document.getElementById('safeBanner');
        const displayLat = document.getElementById('displayLat');
        const displayLng = document.getElementById('displayLng');
        const displaySpd = document.getElementById('displaySpd');

        function toggleTracking() {
            if (isTracking) {
                stopTracking();
            } else {
                startTracking();
            }
        }

        function startTracking() {
            if (!navigator.geolocation) {
                alert('Browser Anda tidak mendukung Geolocation!');
                return;
            }

            isTracking = true;
            btnTrack.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'shadow-blue-600/30');
            btnTrack.classList.add('bg-red-600', 'hover:bg-red-700', 'shadow-red-600/30');
            btnLabel.textContent = 'Hentikan Pantau';
            iconPlay.classList.add('hidden');
            iconStop.classList.remove('hidden');

            statusDot.classList.remove('bg-slate-600');
            statusDot.classList.add('bg-emerald-400', 'animate-pulse');
            statusLabel.textContent = 'Memantau...';
            statusLabel.classList.remove('text-slate-500');
            statusLabel.classList.add('text-emerald-400');

            // Start watching position
            watchId = navigator.geolocation.watchPosition(
                onPositionUpdate,
                onPositionError,
                { enableHighAccuracy: true, maximumAge: 3000, timeout: 10000 }
            );

            // Fetch and show black spots
            loadBlackSpots();

            // Sync to server every 5 seconds
            syncInterval = setInterval(syncToServer, 5000);
        }

        function stopTracking() {
            isTracking = false;
            if (watchId !== null) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }
            if (syncInterval) {
                clearInterval(syncInterval);
                syncInterval = null;
            }

            btnTrack.classList.remove('bg-red-600', 'hover:bg-red-700', 'shadow-red-600/30');
            btnTrack.classList.add('bg-blue-600', 'hover:bg-blue-700', 'shadow-blue-600/30');
            btnLabel.textContent = 'Mulai Pantau GPS';
            iconPlay.classList.remove('hidden');
            iconStop.classList.add('hidden');

            statusDot.classList.remove('bg-emerald-400', 'bg-red-500', 'animate-pulse');
            statusDot.classList.add('bg-slate-600');
            statusLabel.textContent = 'Idle';
            statusLabel.classList.remove('text-emerald-400', 'text-red-400');
            statusLabel.classList.add('text-slate-500');

            bottomPanel.classList.remove('glow-safe', 'glow-danger');
            bottomPanel.classList.add('glow-idle');
            warningBanner.classList.add('hidden');
            safeBanner.classList.add('hidden');

            // Clear black spots from map
            clearBlackSpots();
        }

        function onPositionUpdate(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const spd = pos.coords.speed;
            const heading = pos.coords.heading;

            myLatLng = { lat, lng, heading };

            // Update display
            displayLat.textContent = lat.toFixed(6);
            displayLng.textContent = lng.toFixed(6);
            displaySpd.textContent = spd !== null ? (spd * 3.6).toFixed(0) + ' km/h' : '—';

            // Update marker
            if (myMarker) {
                myMarker.setLatLng([lat, lng]);
            } else {
                myMarker = L.marker([lat, lng], { icon: myIcon }).addTo(map);
                map.setView([lat, lng], 17);
            }
        }

        function onPositionError(err) {
            console.error('GPS Error:', err);
            statusLabel.textContent = 'GPS Error';
            statusLabel.classList.add('text-yellow-400');
        }

        async function syncToServer() {
            if (!myLatLng) return;

            try {
                const res = await fetch('/api/location/sync', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: myLatLng.lat,
                        longitude: myLatLng.lng,
                        heading: myLatLng.heading
                    })
                });

                const data = await res.json();

                if (data.status === 'warning') {
                    // BAHAYA!
                    const names = data.spots.map(s => s.name).join(', ');
                    warningSpotName.textContent = names;
                    warningBanner.classList.remove('hidden');
                    safeBanner.classList.add('hidden');

                    bottomPanel.classList.remove('glow-safe', 'glow-idle');
                    bottomPanel.classList.add('glow-danger');

                    statusDot.classList.remove('bg-emerald-400');
                    statusDot.classList.add('bg-red-500');
                    statusLabel.textContent = 'BAHAYA!';
                    statusLabel.classList.remove('text-emerald-400');
                    statusLabel.classList.add('text-red-400');

                    // Vibrate if supported
                    if (navigator.vibrate) navigator.vibrate([200, 100, 200, 100, 200]);
                    
                } else {
                    // Aman
                    warningBanner.classList.add('hidden');
                    safeBanner.classList.remove('hidden');

                    bottomPanel.classList.remove('glow-danger', 'glow-idle');
                    bottomPanel.classList.add('glow-safe');

                    statusDot.classList.remove('bg-red-500');
                    statusDot.classList.add('bg-emerald-400');
                    statusLabel.textContent = 'Memantau...';
                    statusLabel.classList.remove('text-red-400');
                    statusLabel.classList.add('text-emerald-400');
                }
            } catch (e) {
                console.error('Sync failed:', e);
            }
        }

        function centerOnMe() {
            if (myLatLng) {
                map.flyTo([myLatLng.lat, myLatLng.lng], 17);
            } else {
                // Try a one-shot geolocation
                navigator.geolocation.getCurrentPosition(pos => {
                    map.flyTo([pos.coords.latitude, pos.coords.longitude], 17);
                });
            }
        }
    </script>
</body>
</html>
