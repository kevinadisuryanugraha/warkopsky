@extends('layouts.app')

@section('title', 'Spill Suasana & Sudut Hangat | Warkop Sky')

@section('meta_description', 'Lihat koleksi foto suasana kabin malam cozy, lesehan estetik, live akustik mingguan, dan kebersamaan hangat di Warkop Sky Jatiasih Bekasi.')

@section('content')
<div class="gallery-page-wrapper">
    
    <!-- Ambient Cabin Radial Lights -->
    <div class="glow-source glow-source--yellow"></div>
    <div class="glow-source glow-source--blue"></div>

    <!-- ==========================================
       SECTION 1: HEADER & TITLE (Matching Menu Page)
       ========================================== -->
    <div class="gallery-sticky-bar">
        <div class="container sticky-flex">
            <div class="sticky-title-col">
                <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; display: inline-block; margin-bottom: 4px;">Spill Suasana</span>
                <h1 class="gallery-title-text">Galeri Foto Kabin</h1>
                <p class="gallery-desc-text">Gemerlap Edison warm dan kabin kayu teduh peneman malam panjang Anda.</p>
            </div>
        </div>
    </div>

    <!-- ==========================================
       SECTION 2: DYNAMIC FILTER PILLS
       ========================================== -->
    <div class="container" style="margin-top: var(--spacing-lg); position: relative; z-index: 5;">
        <div class="filter-pills-row">
            <!-- "Semua Foto" default pill -->
            <button class="filter-pill active" onclick="filterGallery('all', this)">
                Semua Foto
            </button>
            
            <!-- Dynamic loop for categories -->
            @foreach($categories as $category)
                @if($category->items->count() > 0)
                    <button class="filter-pill" onclick="filterGallery('{{ $category->slug }}', this)">
                        {{ $category->name }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>

    <!-- ==========================================
       SECTION 3: ASYMMETRIC MASONRY GRID
       ========================================== -->
    <div class="container" style="margin-top: var(--spacing-lg); position: relative; z-index: 4;">
        
        <div class="gallery-masonry" id="galleryContainer">
            @php $totalPhotos = 0; @endphp
            
            @foreach($categories as $category)
                @foreach($category->items as $item)
                    @php $totalPhotos++; @endphp
                    <div class="gallery-masonry-item" data-category="{{ $category->slug }}">
                        <div class="gallery-card" onclick="openGlobalLightbox('{{ asset($item->image_path) }}', 'image', '{{ $item->title }}')">
                            
                            <!-- Lazy Loaded Image -->
                            <img 
                                src="{{ asset($item->image_path) }}" 
                                alt="{{ $item->title }}" 
                                class="gallery-img-tag"
                                loading="lazy"
                            >
                            
                            <!-- Glassmorphic Hover Overlay -->
                            <div class="gallery-hover-overlay">
                                <span class="gallery-card-badge">{{ $category->name }}</span>
                                <h3 class="gallery-card-title">{{ $item->title }}</h3>
                                @if($item->description)
                                    <p class="gallery-card-desc">{{ $item->description }}</p>
                                @endif
                                <div class="gallery-card-click-tip">
                                    <span>Klik untuk memperbesar</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>
                                    </svg>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- ==========================================
           SECTION 4: EMPTY STATE (Failsafe fallback)
           ========================================== -->
        <div class="gallery-empty-state" id="galleryEmptyState" style="{{ $totalPhotos === 0 ? 'display:flex; opacity:1;' : 'display:none;' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                <circle cx="12" cy="13" r="4"/>
            </svg>
            <h3>Foto segera hadir...</h3>
            <p>Sudut ini sedang kami persiapkan dengan detail visual terindah. Tunggu rilis galeri berikutnya ya!</p>
        </div>

    </div>

    <!-- Upgraded Gallery CTA Section -->
    <section class="gallery-cta">
        <div class="gallery-cta__inner">
            <p class="gallery-cta__text">Spot foto instagramable menanti. Kapan mampir?</p>
            <a href="{{ route('public.contact') }}" class="btn-cta-primary">
                Booking Tempat Sekarang
            </a>
        </div>
    </section>

</div>

<style>
    .gallery-page-wrapper {
        min-height: 100vh;
        background-color: var(--color-midnight-bg);
        padding-top: 0;
        padding-bottom: var(--spacing-xl);
        position: relative;
        overflow-x: hidden;
    }

    /* Ambient Bulbs Backgrounds */
    .glow-source {
        position: absolute;
        width: 450px;
        height: 450px;
        pointer-events: none;
        z-index: 1;
        filter: blur(50px);
        opacity: 0.4;
    }

    .glow-source--yellow {
        background: radial-gradient(circle, rgba(255, 200, 87, 0.03) 0%, transparent 70%);
        top: 8%;
        left: -10%;
    }

    .glow-source--blue {
        background: radial-gradient(circle, rgba(93, 156, 236, 0.025) 0%, transparent 70%);
        bottom: 20%;
        right: -10%;
    }

    /* Header Bar layout */
    .gallery-sticky-bar {
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        padding-bottom: var(--spacing-sm);
        position: relative;
        z-index: 2;
    }

    .gallery-title-text {
        font-family: var(--font-display);
        font-size: clamp(2.2rem, 5vw, 3.2rem);
        color: var(--color-warm-cream);
        margin: 4px 0 0 0;
        line-height: 1.1;
    }

    .gallery-desc-text {
        font-size: 0.9rem;
        color: var(--color-muted-text);
        margin-top: 4px;
        max-width: 600px;
    }

    /* Filter pills rows */
    .filter-pills-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-start;
        padding-bottom: 8px;
    }

    .filter-pill {
        padding: 0.6rem 1.3rem;
        background: rgba(16, 24, 48, 0.55);
        border: 1px solid rgba(255, 255, 255, 0.04);
        color: var(--color-muted-text);
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.85rem;
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-smooth);
        outline: none;
    }

    .filter-pill:hover {
        color: var(--color-warm-cream);
        border-color: rgba(93, 156, 236, 0.25);
        background: rgba(16, 24, 48, 0.85);
    }

    .filter-pill.active {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border-color: var(--color-sky-blue);
        box-shadow: 0 4px 15px rgba(93, 156, 236, 0.25);
    }

    /* Masonry CSS columns layout */
    .gallery-masonry {
        columns: 3;
        column-gap: 1.2rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    @media (max-width: 991px) {
        .gallery-masonry {
            columns: 2;
            column-gap: 1rem;
        }
    }

    @media (max-width: 576px) {
        .gallery-masonry {
            columns: 1;
            column-gap: 0;
        }
    }

    .gallery-masonry-item {
        break-inside: avoid;
        margin-bottom: 1.2rem;
        transition: opacity var(--duration-normal) var(--easing-smooth), 
                    transform var(--duration-normal) var(--easing-smooth);
        width: 100%;
        display: block;
        opacity: 1;
        transform: scale(1);
    }

    @media (max-width: 576px) {
        .gallery-masonry-item {
            margin-bottom: 1rem;
        }
    }

    /* Card styling */
    .gallery-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.04);
        background: var(--color-midnight-card);
        cursor: pointer;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        transition: transform var(--duration-normal) var(--easing-bounce),
                    border-color var(--duration-normal) var(--easing-smooth),
                    box-shadow var(--duration-normal) var(--easing-smooth);
    }

    .gallery-card:hover {
        transform: translateY(-6px);
        border-color: var(--color-warm-gold);
        box-shadow: 0 15px 40px rgba(255, 200, 87, 0.12);
    }

    .gallery-img-tag {
        width: 100%;
        height: auto;
        display: block;
        transition: transform var(--duration-slow) var(--easing-smooth);
    }

    .gallery-card:hover .gallery-img-tag {
        transform: scale(1.03);
    }

    /* Hover overlay */
    .gallery-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(7, 11, 20, 0.96) 0%, rgba(7, 11, 20, 0.4) 60%, transparent 100%);
        opacity: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: var(--spacing-md);
        transition: opacity var(--duration-normal) var(--easing-smooth);
        z-index: 2;
        text-align: left;
    }

    .gallery-card:hover .gallery-hover-overlay {
        opacity: 1;
    }

    .gallery-card-badge {
        font-size: 0.68rem;
        font-weight: 800;
        background: rgba(93, 156, 236, 0.1);
        border: 1px solid rgba(93, 156, 236, 0.25);
        color: var(--color-sky-blue);
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        width: max-content;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .gallery-card-title {
        font-family: var(--font-display);
        font-size: 1.3rem;
        color: var(--color-warm-cream);
        margin: 0;
        line-height: 1.2;
    }

    .gallery-card-desc {
        font-size: 0.8rem;
        color: var(--color-muted-text);
        margin: 4px 0 0 0;
        line-height: 1.4;
    }

    .gallery-card-click-tip {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        color: var(--color-warm-gold);
        margin-top: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    /* Empty state */
    .gallery-empty-state {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: var(--spacing-xl) var(--spacing-md);
        color: var(--color-muted-text);
        background: var(--color-midnight-card);
        border: 1px solid rgba(255, 255, 255, 0.02);
        border-radius: 20px;
        gap: 8px;
        transition: opacity 0.3s ease;
        opacity: 0;
    }

    .gallery-empty-state svg {
        opacity: 0.3;
        margin-bottom: var(--spacing-xs);
        color: var(--color-sky-blue);
        animation: pulse-glow 2s infinite ease-in-out;
    }

    .gallery-empty-state h3 {
        font-family: var(--font-display);
        font-size: 1.6rem;
        color: var(--color-warm-cream);
        margin: 0;
    }

    .gallery-empty-state p {
        font-size: 0.88rem;
        max-width: 400px;
        line-height: 1.5;
        margin: 0;
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
          "name": "Galeri",
          "item": "{{ url()->current() }}"
        }
      ]
    }
    </script>
@endsection

@push('scripts')
<script>
    function filterGallery(categorySlug, btnElement) {
        // 1. Update active pill classes
        const pills = document.querySelectorAll('.filter-pill');
        pills.forEach(pill => pill.classList.remove('active'));
        btnElement.classList.add('active');

        // 2. Animate and toggle visibility of items
        const items = document.querySelectorAll('.gallery-masonry-item');
        let visibleCount = 0;

        items.forEach(item => {
            if (categorySlug === 'all' || item.dataset.category === categorySlug) {
                visibleCount++;
                item.style.display = 'block';
                // Wait for display block to bind to DOM, then trigger transition
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'scale(1)';
                }, 10);
            } else {
                item.style.opacity = '0';
                item.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    item.style.display = 'none';
                }, 300); // Wait for scale & fade transition
            }
        });

        // 3. Update empty states if count drops to 0
        const emptyState = document.getElementById('galleryEmptyState');
        if (visibleCount === 0) {
            emptyState.style.display = 'flex';
            setTimeout(() => {
                emptyState.style.opacity = '1';
            }, 10);
        } else {
            emptyState.style.opacity = '0';
            setTimeout(() => {
                emptyState.style.display = 'none';
            }, 300);
        }
    }
</script>
@endpush
