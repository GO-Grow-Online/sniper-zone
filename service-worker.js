// service-worker.js

const CACHE_NAME = 'sniperzone-cache-v1';
const urlsToCache = [

    // Videos
    '/assets/medias/video/briefing-de.mp4',
    '/assets/medias/video/briefing-en.mp4',
    '/assets/medias/video/briefing-fr.mp4',
    '/assets/medias/video/briefing-nl.mp4',

    // Favicon
    '/assets/favicon/android-chrome-192x192.png',
    '/assets/favicon/android-chrome-512x512.png',
    '/assets/favicon/apple-touch-icon.png',
    '/assets/favicon/browserconfig.xml',
    '/assets/favicon/favicon-16x16.png',
    '/assets/favicon/favicon-32x32.png',
    '/assets/favicon/favicon.ico',
    '/assets/favicon/mstile-150x150.png',
    '/assets/favicon/safari-pinned-tab.svg',
    '/assets/favicon/site.webmanifest',

    // Fonts
    '/assets/fonts/urbanist-black-italic.ttf',
    '/assets/fonts/urbanist-black.ttf',
    '/assets/fonts/urbanist-bold-italic.ttf',
    '/assets/fonts/urbanist-bold.ttf',
    '/assets/fonts/urbanist-italic.ttf',
    '/assets/fonts/urbanist-regular.ttf',

    // Images
    '/assets/medias/image/bg.jpg',
    '/assets/medias/image/de_flag.svg',
    '/assets/medias/image/en_flag.svg',
    '/assets/medias/image/fr_flag.svg',
    '/assets/medias/image/logo.png',
    '/assets/medias/image/nl_flag.svg',

    // Scripts & styles
    '/assets/jquery.js',
    '/assets/app.js',
    '/style.css',
];


self.addEventListener('activate', (event) => {
    event.waitUntil(

        // Delete old cache
        caches.keys().then((cacheNames) => {

            return cache.addAll(urlsToCache);

            //return Promise.all(
            //    cacheNames.filter((name) => {
            //        return name !== CACHE_NAME;
            //    }).map((name) => {
            //        return caches.delete(name);
            //    })
            //);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                // If in cache, use it
                if (response) {
                    return response;
                }

                // If not in cache, download it and add to cache
                return fetch(event.request)
                    .then((networkResponse) => {
                        // Check if ressource download is successful and if it is GET
                        if (networkResponse && networkResponse.status === 200 && event.request.method === 'GET') {
                            // Exclude chrome extention
                            if (event.request.url.indexOf('chrome-extension') === -1) {
                                caches.open(CACHE_NAME)
                                    .then((cache) => {
                                        cache.put(event.request, networkResponse.clone());
                                    });
                            }
                        }
                        return networkResponse;
                    })
                    .catch(() => {
                        // Add fallback if necessary
                        console.log('Network unavailable');
                    });
            })
    );
});
