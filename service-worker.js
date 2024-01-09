// service-worker.js
self.addEventListener('install', function(event) {
    event.waitUntil(

      caches.open('my-cache').then(function(cache) {
        return cache.addAll([

          '/style.css',

          '/assets/medias/images/bg.jpg',

          '/assets/medias/video/briefing-de.mp4',
          '/assets/medias/video/briefing-fr.mp4',
          '/assets/medias/video/briefing-nl.mp4',
          '/assets/medias/video/briefing-en.mp4'
        ]);
      })
    );
  });
  
self.addEventListener('fetch', function(event) {
    event.respondWith(
      caches.match(event.request).then(function(response) {
        return response || fetch(event.request);
      })
    );
});
