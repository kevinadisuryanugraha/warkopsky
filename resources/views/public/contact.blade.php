@extends('layouts.app')

@section('title', 'Kontak & Reservasi Tempat | Warkop Sky')

@section('meta_description', 'Hubungi kami, temukan rute lokasi cabang Warkop Sky Jatiasih, atau amankan meja lesehan nongkrong Anda secara instan menggunakan formulir reservasi online kami.')

@section('content')
<div style="min-height: 85vh; background-color: var(--color-midnight-bg); padding-bottom: var(--spacing-xl); padding-top: 0; position: relative;">
    
    <!-- Edison Lamp Glow Radial Overlays -->
    <div style="position: absolute; top: -100px; right: -100px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(255,200,87,0.04) 0%, transparent 70%); pointer-events: none; z-index: 1;"></div>
    <div style="position: absolute; bottom: 10%; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(93,156,236,0.03) 0%, transparent 70%); pointer-events: none; z-index: 1;"></div>

    <!-- Header Section -->
    <div class="container text-center" style="margin-bottom: var(--spacing-xl); position: relative; z-index: 2;">
        <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; display: inline-block; margin-bottom: 8px;">Koneksi & Booking</span>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; margin-bottom: var(--spacing-xs); font-family: var(--font-display); color: var(--color-warm-cream);">
            Kontak & <span class="text-sky" style="font-family: inherit;">Reservasi</span>
        </h1>
        <p style="max-width: 600px; margin: 0 auto; color: var(--color-muted-text); font-size: 0.95rem;">
            Ingin memesan meja lesehan untuk kumpul komunitas atau punya pertanyaan? Pintu kami terbuka lebar untuk Anda.
        </p>
    </div>

    <!-- Dual-Column Split Layout -->
    <div class="container" style="position: relative; z-index: 2;">
        <div class="contact-split-layout">
            
            <!-- Left Column: Contact details & Map embed -->
            <div class="contact-details-column">
                <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: var(--color-warm-cream); margin-bottom: var(--spacing-md); border-left: 3px solid var(--color-sky-blue); padding-left: 12px;">
                    Informasi Cabang
                </h2>

                <div class="contact-cards-container">
                    
                    <!-- Branch info card -->
                    <x-card class="contact-cozy-card" style="padding: var(--spacing-md); text-align: left;">
                        <h3 style="font-family: var(--font-display); font-size: 1.4rem; color: var(--color-warm-gold); margin-bottom: 8px;">Warkop Sky Jatiasih</h3>
                        <p style="font-size: 0.88rem; color: var(--color-muted-text); line-height: 1.5; margin-bottom: var(--spacing-md);">
                            Jl. Raya Jatiasih No. 64a, RT.001/RW.004, Jatiasih, Kec. Jatiasih, Kota Bekasi, Jawa Barat 17423.
                        </p>

                        <div class="contact-detail-items">
                            <div class="contact-item">
                                <strong>Jam Operasional:</strong> Buka 24 Jam Nonstop
                            </div>
                            <div class="contact-item">
                                <strong>WhatsApp Bisnis:</strong> 
                                <a href="https://wa.me/6281385271918" target="_blank" style="color: var(--color-sky-blue); text-decoration: none; font-weight: 700;">
                                    +62 813-8527-1918
                                </a>
                            </div>
                            <div class="contact-item">
                                <strong>Instagram Resmi:</strong> 
                                <a href="https://instagram.com/warkop.sky" target="_blank" style="color: var(--color-sky-blue); text-decoration: none; font-weight: 700;">
                                    @warkop.sky
                                </a>
                            </div>
                            <div class="contact-item">
                                <strong>Email Kantor:</strong> halo@warkopsky.id
                            </div>
                        </div>
                    </x-card>

                    <!-- Google Maps Iframe Embed -->
                    <x-card class="contact-cozy-card" style="padding: 0; height: 300px; overflow: hidden; border: 1px solid rgba(255,255,255,0.04);">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7699495994357!2d106.965473!3d-6.2939354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d367dbe3a69%3A0xdff03ed1c5ca5cdc!2sWarkop%20Sky!5e0!3m2!1sid!2sid!4v1716800000000!5m2!1sid!2sid" 
                            style="border:0; width: 100%; height: 100%;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </x-card>

                </div>
            </div>

            <!-- Right Column: Interactive Booking Form sticky box -->
            <div class="contact-form-column">
                <div class="sticky-form-container">
                    <livewire:reservation-form />
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    /* Two-Column split screen styling */
    .contact-split-layout {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: var(--spacing-lg);
        align-items: start;
    }

    @media (max-width: 992px) {
        .contact-split-layout {
            grid-template-columns: 1fr;
            gap: var(--spacing-lg);
        }
        .contact-form-column {
            order: -1; /* Place form on top for mobile reservation flows */
            margin-bottom: var(--spacing-sm);
        }
    }

    /* Sticky container for desktop layout */
    .sticky-form-container {
        position: sticky;
        top: 100px;
        z-index: 10;
    }

    /* Cozy timeline cards */
    .contact-cards-container {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .contact-cozy-card {
        background: rgba(16, 24, 48, 0.45) !important;
        border: 1px solid rgba(255,255,255,0.03) !important;
        transition: border-color var(--duration-fast) var(--easing-smooth);
    }

    .contact-cozy-card:hover {
        border-color: rgba(93, 156, 236, 0.15) !important;
    }

    /* Detail contact stats */
    .contact-detail-items {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
    }

    .contact-item {
        font-size: 0.88rem;
        color: var(--color-muted-text);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-item::before {
        content: '•';
        color: var(--color-sky-blue);
        font-weight: bold;
        font-size: 1.2rem;
    }
</style>

    <!-- JSON-LD Breadcrumb Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ config('app.url') }}"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "Kontak & Reservasi",
          "item": "{{ url()->current() }}"
        }
      ]
    }
    </script>
@endsection
