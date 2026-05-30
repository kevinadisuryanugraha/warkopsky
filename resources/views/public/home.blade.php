@extends('layouts.app')

@section('title', 'Warkop Sky — Nongkrong di Bawah Langit Malam Bekasi')

@section('content')

    <!-- ==========================================
       SECTION 1 — HERO BANNER (Full Viewport)
       ========================================== -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content reveal-stagger">
            <!-- Pulsing Badge -->
            <div class="badge-24h">
                <span class="badge-dot"></span>
                <span>Buka 24 Jam Penuh</span>
            </div>
            
            <!-- Main Tagline -->
            <h1 style="margin-bottom: var(--spacing-sm);">Ngopi di Bawah<br><span class="text-highlight">Langit Malam Syahdu</span></h1>
            
            <!-- Sub-Tagline -->
            <p style="font-size: 1.1rem; color: var(--color-muted-text); max-width: 600px; margin: 0 auto var(--spacing-lg) auto;">
                Warung kopi terbuka bernuansa kabin kayu estetik dengan hembusan angin sejuk, tempat bersantai terbaik melepas penat di Jatiasih.
            </p>
            
            <!-- CTAs -->
            <div class="hero-cta-group">
                <!-- Primary: konversi utama -->
                <a href="{{ route('public.menu') }}" class="btn-primary-hero">
                    <span>Jelajahi Menu</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <!-- Secondary: reservasi -->
                <a href="{{ route('public.contact') }}" class="btn-secondary-hero">
                    Booking Meja
                </a>
            </div>
        </div>
    </section>

    <!-- ==========================================
       SECTION 2 — BRAND VALUE PILLARS (Asymmetric)
       ========================================== -->
    <section class="section-spacing container reveal">
        <div style="text-align: center; margin-bottom: var(--spacing-xl);">
            <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;">Keunggulan Kami</span>
            <h2>Mengapa Warkop Sky?</h2>
            <p style="max-width: 500px; margin: 0 auto;">Sentuhan kultural warung kopi merakyat yang disajikan dengan standar visual kenyamanan tingkat tinggi.</p>
        </div>

        <div class="pillars-grid">
            <!-- Pillar 1: Large Asymmetric (40% width) -->
            <x-card class="pillar-col-1" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 280px; border-color: rgba(93, 156, 236, 0.25);">
                <div>
                    <!-- Clock SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="var(--color-warm-gold)" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: var(--spacing-sm);">
                        <circle cx="12" cy="12" r="9" />
                        <polyline points="12 7 12 12 15 15" />
                    </svg>
                    <h3 style="font-size: 1.6rem; margin-bottom: var(--spacing-xs);">Terbuka 24 Jam Penuh</h3>
                    <p style="font-size: 0.95rem;">Kami mengerti bahwa ide cemerlang dan canda tawa sering kali mekar di larut malam. Datang kapan saja, pintu kami selalu terbuka menyambutmu.</p>
                </div>
                <span class="text-highlight" style="font-family: var(--font-display); font-size: 0.85rem; margin-top: var(--spacing-sm); display: inline-block;">SIAP MELAYANI 24/7 &rarr;</span>
            </x-card>

            <!-- Pillar 2: Medium (30% width) -->
            <x-card style="display: flex; flex-direction: column; justify-content: space-between; min-height: 280px;">
                <div>
                    <!-- Fire SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="var(--color-warm-gold)" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: var(--spacing-sm);">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 0 1-2.827 0l-4.244-4.243a8 8 0 1 1 11.314 0z" />
                        <path d="M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: var(--spacing-xs);">Kuliner Autentik</h3>
                    <p style="font-size: 0.88rem;">Dari hangatnya Es Teh Gentong hingga pedasnya Dimsum Chilli Oil. Rasa buatan rumah yang diolah dengan bahan segar lokal berkualitas tinggi.</p>
                </div>
                <span class="text-gold" style="font-family: var(--font-body); font-size: 0.78rem; font-weight:600; text-transform: uppercase;">100% Rasa Asli &rarr;</span>
            </x-card>

            <!-- Pillar 3: Medium (30% width) -->
            <x-card style="display: flex; flex-direction: column; justify-content: space-between; min-height: 280px;">
                <div>
                    <!-- Camera SVG Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="var(--color-warm-gold)" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom: var(--spacing-sm);">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                    <h3 style="font-size: 1.3rem; margin-bottom: var(--spacing-xs);">Spot Estetik</h3>
                    <p style="font-size: 0.88rem;">Setiap sudut didesain dengan visual asri dan pencahayaan Edison gantung yang memikat, siap menghiasi feed Instagram dan cerita TikTok-mu.</p>
                </div>
                <span class="text-sky-blue" style="font-family: var(--font-body); font-size: 0.78rem; font-weight:600; text-transform: uppercase;">INSTAGRAMABLE &rarr;</span>
            </x-card>
        </div>
    </section>

    <!-- ==========================================
       SECTION 3 — FEATURED MENU SPOTLIGHT (4 Items)
       ========================================== -->
    <section class="section-spacing container reveal">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-sm);">
            <div>
                <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;">Rekomendasi Utama</span>
                <h2>Terlaris Pekan Ini</h2>
            </div>
            <a href="/menu" style="color: var(--color-sky-blue); text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: color var(--duration-fast);">Lihat Semua Menu &rarr;</a>
        </div>

        <!-- 2x2 Grid -->
        <div class="menu-spotlight-grid">
            @foreach($featuredMenus as $menu)
                <x-card style="display: flex; gap: var(--spacing-sm); padding: var(--spacing-sm); align-items: center; min-height: 160px;">
                    <!-- Image -->
                    <div style="flex: 0 0 120px; height: 120px; border-radius: 12px; overflow: hidden; background: #131A26;">
                        @if($menu->image_path)
                            @php
                                $resolvedPath = (str_starts_with($menu->image_path, 'storage/') || str_starts_with($menu->image_path, 'uploads/')) 
                                    ? $menu->image_path 
                                    : 'storage/optimized/' . $menu->image_path;
                            @endphp
                            <img src="{{ asset($resolvedPath) }}" alt="{{ $menu->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color: var(--color-muted-text); font-size: 0.75rem; text-align:center; padding: 4px; border: 1px dashed rgba(255,255,255,0.05); border-radius: 12px;">
                                [WARKOP SKY]
                            </div>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div style="flex: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                            <span class="text-highlight" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; background: rgba(93, 156, 236, 0.1); padding: 0.2rem 0.6rem; border-radius: 30px;">
                                {{ $menu->category->name }}
                            </span>
                            <span style="font-family: var(--font-display); font-size: 1.15rem; color: var(--color-warm-gold);">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <h3 style="font-size: 1.25rem; font-family: var(--font-body); font-weight: 600; margin-bottom: 4px;">{{ $menu->name }}</h3>
                        <p style="font-size: 0.85rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $menu->description }}
                        </p>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- Closing section CTA — full width strip -->
    <section class="section-cta-strip">
        <div class="section-cta-strip__inner">
            <div class="section-cta-strip__text">
                <p class="section-cta-strip__eyebrow">Buka 24 Jam, 7 Hari Seminggu</p>
                <h3 class="section-cta-strip__headline">Mau nongkrong kapan pun? Kami selalu siap.</h3>
            </div>
            <div class="section-cta-strip__actions">
                <a href="{{ route('public.menu') }}" class="btn-cta-primary">
                    Lihat Menu Lengkap
                </a>
                <a href="https://wa.me/6281385271918?text=Halo%20Warkop%20Sky!" 
                   target="_blank" 
                   class="btn-cta-ghost">
                    WhatsApp Kami
                </a>
            </div>
        </div>
    </section>

    <!-- ==========================================
       SECTION 4 — AMBIANCE GALLERY STRIP (Scroll)
       ========================================== -->
    <section class="section-spacing reveal" style="background: rgba(16, 24, 48, 0.3); border-top: 1px solid rgba(255, 255, 255, 0.02); border-bottom: 1px solid rgba(255, 255, 255, 0.02);">
        <div class="container">
            <div style="text-align: center; margin-bottom: var(--spacing-lg);">
                <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;">Suasana Langsung</span>
                <h2>Koleksi Foto Sudut Warkop</h2>
            </div>
            
            <!-- Horizontal Snap Strip -->
            <div class="gallery-strip-container">
                <div class="gallery-strip">
                    @foreach($galleryPreviews as $item)
                        <div class="gallery-strip-item">
                            <div style="width: 100%; height: 100%; position: relative; overflow: hidden; border-radius: 12px; background: #131A26;">
                                @if($item->image_path)
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--duration-slow) var(--easing-smooth);">
                                @endif
                                <div class="gallery-strip-overlay">
                                    <h4 style="font-size: 1.05rem; margin-bottom: 2px; color: var(--color-warm-cream);">{{ $item->title }}</h4>
                                    <p style="font-size: 0.78rem; color: var(--color-muted-text); font-family: var(--font-body);">{{ $item->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div style="text-align: center; margin-top: var(--spacing-lg);">
                <a href="/galeri" style="color: var(--color-sky-blue); text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: color var(--duration-fast);">Jelajahi Galeri Kami &rarr;</a>
            </div>
        </div>
    </section>

    <!-- ==========================================
       SECTION 5 — LATEST CUSTOMER STORIES (2 Items)
       ========================================== -->
    <section class="section-spacing container reveal">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: var(--spacing-lg); flex-wrap: wrap; gap: var(--spacing-sm);">
            <div>
                <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;">Jurnal Cerita Tamu</span>
                <h2>Apa Kata Mereka?</h2>
            </div>
            <a href="/stories" style="color: var(--color-sky-blue); text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: color var(--duration-fast);">Ceritakan Pengalamanmu &rarr;</a>
        </div>

        <div class="stories-asymmetric-grid">
            @foreach($latestStories as $index => $story)
                <!-- 60/40 Asymmetric visual rendering -->
                @php
                    $isFirst = $index === 0;
                    $borderGlow = $isFirst ? 'border-color: rgba(255, 200, 87, 0.2); box-shadow: 0 10px 30px rgba(255, 200, 87, 0.05);' : '';
                @endphp
                <x-card style="display: flex; flex-direction: column; justify-content: space-between; padding: var(--spacing-md); min-height: 240px; {{ $borderGlow }}">
                    <div>
                        <!-- Quote Text -->
                        <p style="font-family: var(--font-display); font-size: 1.4rem; font-style: italic; color: var(--color-warm-cream); line-height: 1.3; margin-bottom: var(--spacing-md);">
                            "{{ $story->quote }}"
                        </p>
                        <!-- Review Text -->
                        <p style="font-size: 0.9rem; line-height: 1.5; margin-bottom: var(--spacing-md);">
                            {{ $story->text }}
                        </p>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.05); padding-top: var(--spacing-sm); margin-top: var(--spacing-sm);">
                        <div>
                            <strong style="display: block; font-size: 0.95rem; color: var(--color-warm-cream);">{{ $story->author }}</strong>
                            @if($story->instagram_handle)
                                <span style="font-size: 0.8rem; color: var(--color-sky-blue);">{{ '@' . $story->instagram_handle }}</span>
                            @endif
                        </div>
                        
                        <!-- Stars SVG -->
                        <div style="display: flex; gap: 2px;">
                            @for($i = 1; $i <= 5; $i++)
                                @php $starColor = $i <= $story->rating ? 'var(--color-warm-gold)' : 'rgba(255,255,255,0.1)'; @endphp
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="{{ $starColor }}" viewBox="0 0 16 16">
                                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- ==========================================
       SECTION 6 — LOCATION & CTA STRIP (WhatsApp)
       ========================================== -->
    <section class="section-spacing cta-location-bg reveal">
        <div class="container grid-asymmetric" style="align-items: center;">
            <!-- Address details -->
            <div class="reveal-stagger">
                <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;">Kunjungi Cabang Jatiasih</span>
                <h2 style="margin-bottom: var(--spacing-md);">Mari Nongkrong Seru!</h2>
                
                <div style="margin-bottom: var(--spacing-sm);">
                    <h4 class="text-gold" style="font-family: var(--font-body); font-weight: 600; font-size: 0.95rem; margin-bottom: 0.2rem;">Alamat:</h4>
                    <p style="font-size: 0.9rem;">Jl. Raya Jatiasih No.64a, RT.001/RW.004, Jatiasih, Kec. Jatiasih, Kota Bks, Jawa Barat 17423</p>
                </div>
                
                <div style="margin-bottom: var(--spacing-sm);">
                    <h4 class="text-gold" style="font-family: var(--font-body); font-weight: 600; font-size: 0.95rem; margin-bottom: 0.2rem;">Jam Buka:</h4>
                    <p style="font-size: 0.9rem;" class="text-highlight">Buka 24 Jam Penuh (Senin - Minggu)</p>
                </div>

                <div style="margin-bottom: var(--spacing-md);">
                    <h4 class="text-gold" style="font-family: var(--font-body); font-weight: 600; font-size: 0.95rem; margin-bottom: 0.2rem;">Layanan WhatsApp:</h4>
                    <p style="font-size: 0.9rem;">Hubungi admin untuk booking meja, acara gathering, reuni, atau reservasi besar.</p>
                </div>

                <x-button 
                    href="https://wa.me/6281385271918?text=Halo%20Warkop%20Sky%2C%20saya%20ingin%20reservasi%20meja..." 
                    target="_blank" 
                    variant="red"
                    style="box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);"
                >
                    Booking via WhatsApp &rarr;
                </x-button>
            </div>

            <!-- Map IFrame Wrapper -->
            <div>
                <div class="map-wrapper card-cabin" style="padding: 4px; overflow: hidden; height: 320px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7699495994357!2d106.965473!3d-6.2939354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d367dbe3a69%3A0xdff03ed1c5ca5cdc!2sWarkop%20Sky!5e0!3m2!1sid!2sid!4v1716800000000!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
       VANILLA SCROLL REVEAL OBSERVER SCRIPT
       ========================================== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const reveals = document.querySelectorAll('.reveal');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // Animates only once
                    }
                });
            }, {
                threshold: 0.1, // Trigger when 10% of card is in viewport
                rootMargin: "0px 0px -50px 0px" // Offset triggers slightly
            });
            
            reveals.forEach(reveal => {
                observer.observe(reveal);
            });
        });
    </script>
    <!-- JSON-LD WebSite Sitelink Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "WebSite",
      "name": "Warkop Sky",
      "url": "{{ config('app.url') }}",
      "potentialAction": {
        "@@type": "SearchAction",
        "target": {
          "@@type": "EntryPoint",
          "urlTemplate": "{{ config('app.url') }}/menu?search={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
    </script>

@endsection
