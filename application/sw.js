var CACHE_NAME = 'mealplan-v1';
var urlsToCache = [
    './',
    './index.php/dashboard',
    './index.php/rencana',
    './index.php/belanja',
    './index.php/resep',
    './index.php/pengeluaran',
    './manifest.json',
    'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Bricolage+Grotesque:wght@700;800&display=swap',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'
];

// Install
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            return cache.addAll(urlsToCache).catch(function(err) {
                console.log('Cache addAll error (non-critical):', err);
            });
        })
    );
    self.skipWaiting();
});

// Activate - cleanup old caches
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(names) {
            return Promise.all(
                names.filter(function(name) { return name !== CACHE_NAME; })
                     .map(function(name) { return caches.delete(name); })
            );
        })
    );
    self.clients.claim();
});

// Fetch - network first, fallback to cache
self.addEventListener('fetch', function(event) {
    // Skip non-GET
    if (event.request.method !== 'GET') return;

    // Skip AJAX/API calls (let them always go to network)
    var url = event.request.url;
    if (url.indexOf('/jadwal/simpan') > -1 ||
        url.indexOf('/jadwal/hapus') > -1 ||
        url.indexOf('/belanja/') > -1 ||
        url.indexOf('/pengeluaran/') > -1 ||
        url.indexOf('/resep/detail') > -1 ||
        url.indexOf('/resep/favorit') > -1 ||
        url.indexOf('/resep/hapus') > -1 ||
        url.indexOf('/master-harga/') > -1) {
        return;
    }

    event.respondWith(
        fetch(event.request).then(function(response) {
            // Cache successful responses
            if (response.status === 200) {
                var responseClone = response.clone();
                caches.open(CACHE_NAME).then(function(cache) {
                    cache.put(event.request, responseClone);
                });
            }
            return response;
        }).catch(function() {
            // Offline - try cache
            return caches.match(event.request).then(function(cached) {
                if (cached) return cached;
                // Fallback offline page
                return new Response(
                    '<html><body style="font-family:sans-serif;text-align:center;padding:3rem 1rem;">' +
                    '<p style="font-size:3rem;">📡</p>' +
                    '<h2>Kamu sedang offline</h2>' +
                    '<p style="color:#888;">Koneksi internet diperlukan. Coba lagi nanti.</p>' +
                    '</body></html>',
                    { headers: { 'Content-Type': 'text/html' } }
                );
            });
        })
    );
});
