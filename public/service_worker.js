// Evento para a instalação do SW colocando os arquivos em cache
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open('v1').then(function(cache){
            return cache.addAll([
                'index.php',
                '../app/view/template/head.php',
                '../app/view/login.php',
                'assets/css/style.css',
                'assets/img/logo-preto.png',
                'assets/img/logo-kioficina.png',
            ]);
        })
    );
});

// Requisição dos arquivocs que estão em cache

self.addEventListener('fetch', function(event){
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request);
        })
    );
})