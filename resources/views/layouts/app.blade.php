<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic SEO & Performance Meta Tags -->
    <x-seo :seo="$seoData ?? []" />
    <meta name="keywords" content="warkop sky, warkop bekasi, sate maranggi, es teh gentong, nongkrong 24 jam, cafe outdoor, dimsum chilli oil, jatiasih">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0A0F1D">
    <link rel="icon" type="image/webp" href="/images/logo_192.webp">

    <!-- CSS System Link -->
    <link rel="stylesheet" href="/css/app.css">
    
    <!-- JSON-LD FoodEstablishment Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FoodEstablishment",
      "@@id": "{{ config('app.url') }}/#restaurant",
      "name": "Warkop Sky",
      "alternateName": "Warkop Sky Jatiasih",
      "url": "{{ config('app.url') }}",
      "telephone": "+6281385271918",
      "image": [
        "{{ asset('images/og-default.jpg') }}"
      ],
      "description": "Warung kopi dan kuliner autentik di Jatiasih Bekasi, buka 24 jam.",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Jl. Raya Jatiasih No. 64a, RT.001/RW.004",
        "addressLocality": "Jatiasih",
        "addressRegion": "Bekasi",
        "addressCountry": "ID",
        "postalCode": "17423"
      },
      "geo": {
        "@@type": "GeoCoordinates",
        "latitude": -6.3297,
        "longitude": 106.9951
      },
      "openingHoursSpecification": {
        "@@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
        "opens": "00:00",
        "closes": "23:59"
      },
      "servesCuisine": ["Indonesian", "Coffee", "Local Food"],
      "priceRange": "Rp 10.000 – Rp 50.000",
      "hasMap": "https://maps.google.com/?q=Warkop+Sky+Jatiasih",
      "sameAs": [
        "https://instagram.com/warkopsky.id",
        "https://wa.me/6281385271918"
      ]
    }
    </script>
    
    @livewireStyles
    @stack('styles')
</head>
<body class="glow-bulb">

    <!-- Global Header -->
    <x-header />

    <!-- Main Content Area -->
    <main style="min-height: 80vh; padding-top: 100px; padding-bottom: 80px;">
        @yield('content')
        @isset($slot)
            {{ $slot }}
        @endisset
    </main>

    <!-- Floating WhatsApp Booking CTA -->
    <div class="floating-cta" id="floatingCta">
        <a href="https://wa.me/6281385271918?text=Halo%20Warkop%20Sky!%20Saya%20ingin%20bertanya%20tentang..." 
           target="_blank" 
           class="floating-cta__btn"
           aria-label="Chat WhatsApp Warkop Sky">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="display:inline-block; vertical-align:middle;">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span class="floating-cta__label">Chat Sekarang</span>
        </a>
        <div class="floating-cta__pulse"></div>
    </div>

    <!-- Global Footer -->
    <x-footer />

    <!-- Global Fullscreen Lightbox Modal (Shared between Gallery, Stories, etc.) -->
    <div class="global-lightbox-modal" id="globalLightbox" onclick="closeGlobalLightbox()">
        <div class="lightbox-content-box" onclick="event.stopPropagation()">
            <button class="lightbox-close-btn" onclick="closeGlobalLightbox()">&times;</button>
            <div id="globalLightboxMedia"></div>
            <h3 class="lightbox-caption" id="globalLightboxCaption"></h3>
        </div>
    </div>

    <style>
        /* Global Lightbox Modal Styles */
        .global-lightbox-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(7, 11, 20, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .global-lightbox-modal.show {
            display: flex;
            opacity: 1;
        }

        .global-lightbox-modal .lightbox-content-box {
            position: relative;
            max-width: 90%;
            max-height: 85%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            transform: scale(0.95);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .global-lightbox-modal.show .lightbox-content-box {
            transform: scale(1);
        }

        .global-lightbox-modal .lightbox-media {
            max-width: 100%;
            max-height: 70vh;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: block;
        }

        .global-lightbox-modal .lightbox-close-btn {
            position: absolute;
            top: -48px;
            right: 0;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--color-warm-cream);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.5rem;
            line-height: 1;
            transition: all 0.2s ease;
        }

        .global-lightbox-modal .lightbox-close-btn:hover {
            background: var(--color-warkop-red);
            border-color: var(--color-warkop-red);
            transform: rotate(90deg);
        }

        .global-lightbox-modal .lightbox-caption {
            font-family: var(--font-display);
            font-size: 1.25rem;
            color: var(--color-warm-cream);
            text-align: center;
            margin: 0;
        }
    </style>

    <script>
        function openGlobalLightbox(mediaUrl, mediaType, captionText) {
            const modal = document.getElementById('globalLightbox');
            const container = document.getElementById('globalLightboxMedia');
            const caption = document.getElementById('globalLightboxCaption');
            
            if (!modal || !container || !caption) return;
            
            container.innerHTML = ''; // Clear previous contents
            
            if (mediaType === 'video') {
                const video = document.createElement('video');
                video.src = mediaUrl;
                video.className = 'lightbox-media';
                video.controls = true;
                video.autoplay = true;
                container.appendChild(video);
            } else {
                const img = document.createElement('img');
                img.src = mediaUrl;
                img.className = 'lightbox-media';
                container.appendChild(img);
            }
            
            caption.textContent = captionText || '';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Lock scrolling
        }

        function closeGlobalLightbox() {
            const modal = document.getElementById('globalLightbox');
            if (!modal) return;
            
            modal.classList.remove('show');
            document.body.style.overflow = ''; // Unlock scrolling
            
            // Wait for transition before purging media
            setTimeout(() => {
                const container = document.getElementById('globalLightboxMedia');
                if (container) container.innerHTML = '';
            }, 350);
        }

        // Floating CTA hide/show on scroll
        const floatingCta = document.getElementById('floatingCta');
        if (floatingCta) {
            window.addEventListener('scroll', () => {
                floatingCta.style.opacity = window.scrollY > 300 ? '1' : '0';
                floatingCta.style.pointerEvents = window.scrollY > 300 ? 'auto' : 'none';
            }, { passive: true });
            floatingCta.style.opacity = '0';
            floatingCta.style.transition = 'opacity 0.3s ease';
        }

        // Global key listeners
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeGlobalLightbox();
            }
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
