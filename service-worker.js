// service-worker.js
self.addEventListener('install', function(event) {
    event.waitUntil(

      caches.open('my-cache').then(function(cache) {
        return cache.addAll([

          '/style.css',
          '/assets/app.js',

          '/assets/medias/images/bg.jpg',

          '/assets/medias/videos/briefing-de.mp4',
          '/assets/medias/videos/briefing-fr.mp4',
          '/assets/medias/videos/briefing-nl.mp4',
          '/assets/medias/videos/briefing-en.mp4'
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
