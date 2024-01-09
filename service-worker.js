// service-worker.js

const CACHE_NAME = 'sniperzone-cache-v1';
const urlsToCache = [

    // Favicon
    '/',
    'assets/favicon/android-chrome-192x192.png',
    'assets/favicon/android-chrome-512x512.png',
    'assets/favicon/apple-touch-icon.png',
    'assets/favicon/browserconfig.xml',
    'assets/favicon/favicon-16x16.png',
    'assets/favicon/favicon-32x32.png',
    'assets/favicon/favicon.ico',
    'assets/favicon/mstile-150x150.png',
    'assets/favicon/safari-pinned-tab.svg',
    'assets/favicon/site.webmanifest',

    /*
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

    // Videos
    '/assets/medias/video/briefing-de.mp4',
    '/assets/medias/video/briefing-en.mp4',
    '/assets/medias/video/briefing-fr.mp4',
    '/assets/medias/video/briefing-nl.mp4',

    // Scripts & styles
    '/assets/jquery.js',
    '/assets/app.js',
    '/style.css',
    */
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                return response || fetch(event.request);
            })
    );
});
