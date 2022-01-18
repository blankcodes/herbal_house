const herbalHousePh = "herbal-house-ph-v1"
const assets = [
  "/",
  "assets/css/icons.min.css",
  "assets/css/app-dark.min.css",
  "assets/css/default.css",
  "assets/css/product.css",
  "assets/js/auth/cart.js",
  "assets/js/auth/_csrf.js",
  "assets/js/auth/_products.js",
  "assets/js/auth/_contact.js",
  "assets/js/auth/app.js",
]

self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(herbalHousePh).then(cache => {
      cache.addAll(assets)
    })
  )
})

self.addEventListener("fetch", fetchEvent => {
  fetchEvent.respondWith(
    caches.match(fetchEvent.request).then(res => {
      return res || fetch(fetchEvent.request)
    })
  )
})