// service-worker.js
self.addEventListener('install', function(event) {
    event.waitUntil(
      caches.open('my-cache').then(function(cache) {
        return cache.addAll([
          '../',
          '../style.css',
          '../assets/app.js',
          '../medias/images/bg.jpg',
          '../videos/briefing-de.mp4',
          '../videos/briefing-fr.mp4',
          '../videos/briefing-nl.mp4',
          '../videos/briefing-en.mp4'
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
