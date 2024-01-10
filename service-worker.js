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


self.addEventListener("install", (e) => {
    console.log("[Service Worker] Install");
    e.waitUntil(
      (async () => {
        const cache = await caches.open(CACHE_NAME);
        console.log("[Service Worker] Caching all: app shell and content");
        await cache.addAll(urlsToCache);
      })(),
    );
});

self.addEventListener("fetch", (e) => {
    e.respondWith(
      (async () => {
        const r = await caches.match(e.request);
        console.log(`[Service Worker] Fetching resource: ${e.request.url}`);
        if (r) {
          return r;
        }
        const response = await fetch(e.request);
        const cache = await caches.open(CACHE_NAME);
        console.log(`[Service Worker] Caching new resource: ${e.request.url}`);
        cache.put(e.request, response.clone());
        return response;
      })(),
    );
  });
  