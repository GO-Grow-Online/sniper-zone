// service-worker.js

const CACHE_NAME = 'sniperzone-cache-v1';
const urlsToCache = [

    // Videos
    // '/assets/medias/video/briefing-de.mp4',
    // '/assets/medias/video/briefing-en.mp4',
    // '/assets/medias/video/briefing-fr.mp4',
    // '/assets/medias/video/briefing-nl.mp4',

    // Favicon
    '/',
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

/*
self.addEventListener('activate', (event) => {
  event.waitUntil(
      caches.keys().then((cacheNames) => {
          return Promise.all(
              cacheNames.filter((name) => {
                  return name !== CACHE_NAME;
              }).map((name) => {
                  return caches.delete(name);
              })
          );
      })
  );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        if (response) {
          return response;
        }
  
        if (!navigator.onLine) {
          return new Response('You are offline. Please check your internet connection.');
        }
  
        return fetch(event.request)
          .then((networkResponse) => {
            if (!networkResponse || networkResponse.status !== 200 || event.request.method !== 'GET') {
              return networkResponse;
            }
  
            return caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, networkResponse.clone());
              return networkResponse;
            });
          })
          .catch((error) => {
            console.error('Fetch error:', error);
          });
      })
    );
  });
  */


const VIDEOS_CACHE_NAME = 'sniperzone-video-cache-v1';
const VIDEOS_TO_CACHE = [
    '/assets/medias/video/briefing-de.mp4',
    '/assets/medias/video/briefing-en.mp4',
    '/assets/medias/video/briefing-fr.mp4',
    '/assets/medias/video/briefing-nl.mp4',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(VIDEOS_CACHE_NAME).then((cache) => {
            return cache.addAll(VIDEOS_TO_CACHE).catch((error) => {
              console.error('Cache.addAll error:', error);
            });
        })
    );
});

  
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.open(VIDEOS_CACHE_NAME).then((cache) => {
            return Promise.all(
                VIDEOS_TO_CACHE.map((videoUrl) => {
                    return fetch(videoUrl).then((response) => {
                        return cache.put(videoUrl, response);
                    });
                })
            );
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((response) => {
        if (response) {
          return response;
        }
  
        if (!navigator.onLine) {
          // Gérer la réponse hors ligne ici si nécessaire
          return new Response('You are offline. Please check your internet connection.');
        }
  
        return fetch(event.request)
          .then((networkResponse) => {
            if (!networkResponse || networkResponse.status !== 200 || event.request.method !== 'GET') {
              return networkResponse;
            }
  
            return caches.open(VIDEOS_CACHE_NAME).then((cache) => {
              cache.put(event.request, networkResponse.clone());
              return networkResponse;
            });
          })
          .catch((error) => {
            console.error('Fetch error:', error);
          });
      })
    );
});
  