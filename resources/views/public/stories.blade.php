@extends('layouts.app')

@section('title', 'Cerita Nongkrong Pengunjung | Warkop Sky')

@section('meta_description', 'Baca cerita, ulasan, dan keseruan dari pengunjung setia Warkop Sky Jatiasih. Kirimkan cerita Anda dan bagikan kenikmatan nongkrong di bawah langit malam!')

@section('content')
<div style="min-height: 85vh; background-color: var(--color-midnight-bg); padding-bottom: var(--spacing-xl);">
    
    <!-- Hero Header -->
    <div class="stories-header text-center">
        <div class="container">
            <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; display: inline-block; margin-bottom: 8px;">Keluarga Warkop Sky</span>
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; margin-bottom: var(--spacing-xs); font-family: var(--font-display); color: var(--color-warm-cream);">
                Cerita <span class="text-sky" style="font-family: inherit;">Nongkrong</span>
            </h1>
            <p style="max-width: 600px; margin: 0 auto; color: var(--color-muted-text); font-size: 0.95rem;">
                Apa kata mereka tentang nikmatnya kopi susu warsky, gurihnya tahu lada garam, dan hangatnya suasana malam di Jatiasih?
            </p>
        </div>
    </div>

    <!-- Dual-Column Split Layout -->
    <div class="container">
        <div class="stories-split-layout">
            
            <!-- Left Column: Reviews Timeline -->
            <div class="stories-timeline-column">
                <h2 style="font-family: var(--font-display); font-size: 1.8rem; color: var(--color-warm-cream); margin-bottom: var(--spacing-md); border-left: 3px solid var(--color-sky-blue); padding-left: 12px; display: flex; align-items: center; justify-content: space-between;">
                    Ulasan Pengunjung
                    <span style="font-size: 0.8rem; font-family: var(--font-body); color: var(--color-muted-text); font-weight: normal;">
                        ({{ $stories->count() }} Ulasan)
                    </span>
                </h2>

                @if($stories->isEmpty())
                    <div class="illustrated-empty-state" style="background: rgba(16, 24, 48, 0.3); border-radius: 16px; border: 1px dashed rgba(255,255,255,0.05); padding: var(--spacing-xl) var(--spacing-md);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="var(--color-muted-text)" stroke-width="1.2" viewBox="0 0 24 24" style="margin-bottom: var(--spacing-sm); opacity: 0.5;">
                            <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3>Belum ada cerita terpajang...</h3>
                        <p>Jadilah yang pertama untuk membagikan cerita Anda di sebelah kanan!</p>
                    </div>
                @else
                    <div class="stories-timeline-grid">
                        @foreach($stories as $story)
                            <x-card class="story-cozy-card">
                                <!-- Top Row: Header & Stars -->
                                <div class="story-header-row">
                                    <div>
                                        <h3 class="story-author-name">{{ $story->author }}</h3>
                                        @if($story->instagram_handle)
                                            <a href="https://instagram.com/{{ $story->instagram_handle }}" target="_blank" class="story-ig-link">
                                                @<span>{{ $story->instagram_handle }}</span>
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <!-- Stars Display -->
                                    <div class="story-stars-display">
                                        @for($s = 1; $s <= 5; $s++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="{{ $story->rating >= $s ? 'var(--color-warm-gold)' : 'rgba(255,255,255,0.1)' }}" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Polaroid Style Media Content -->
                                @if($story->media_path)
                                    @if($story->media_type === 'image')
                                        <div class="story-media-wrapper" onclick="openGlobalLightbox('{{ asset('storage/optimized/' . $story->media_path) }}', 'image', 'Ulasan Keseruan Tamu: {{ $story->author }}')" style="cursor: pointer;" title="Klik untuk memperbesar">
                                            <img src="{{ asset('storage/optimized/' . $story->media_path) }}" alt="Foto keseruan {{ $story->author }}" loading="lazy">
                                        </div>
                                    @elseif($story->media_type === 'video')
                                        <div class="story-media-wrapper" onclick="openGlobalLightbox('{{ asset('storage/optimized/' . $story->media_path) }}', 'video', 'Ulasan Keseruan Tamu: {{ $story->author }}')" style="cursor: pointer; position: relative;" title="Klik untuk memutar video">
                                            <video src="{{ asset('storage/optimized/' . $story->media_path) }}" style="width: 100%; height: 100%; object-fit: cover;" preload="metadata"></video>
                                            <div class="video-play-indicator-overlay">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="var(--color-warm-gold)" viewBox="0 0 16 16" style="filter: drop-shadow(0 4px 10px rgba(0,0,0,0.5));">
                                                    <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Story Quote & Text -->
                                <h4 class="story-quote-text">“{{ $story->quote }}”</h4>
                                <p class="story-body-text">{{ $story->text }}</p>

                                <div class="story-footer-info">
                                    <span>Dikirim {{ $story->created_at->diffForHumans() }}</span>
                                    <span style="color: var(--color-sky-blue); font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 4px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.412 14.571a.75.75 0 0 0-.546-.215H4.134a.75.75 0 0 0-.546.215 9.03 9.03 0 0 0-1.89 2.467.75.75 0 0 0 .61 1.022h11.378a.75.75 0 0 0 .61-1.022 9.03 9.03 0 0 0-1.89-2.467z"/>
                                            <path d="M8 0a5 5 0 1 0 0 10A5 5 0 0 0 8 0z"/>
                                        </svg>
                                        Terverifikasi
                                    </span>
                                </div>
                            </x-card>
                        @endforeach
                    </div>
                    
                    <!-- Dynamic Pagination (AJAX Load More) -->
                    @if($stories->hasPages())
                        <div class="load-more-container text-center" style="margin-top: var(--spacing-md); display: flex; justify-content: center; width: 100%;">
                            <button id="loadMoreBtn" class="btn-cta-ghost" data-next-url="{{ $stories->nextPageUrl() }}" style="padding: 0.8rem 2.2rem; font-weight: 700; width: auto; display: inline-flex; align-items: center; gap: 10px; cursor: pointer; border-radius: 8px;">
                                <span>Muat Lebih Banyak Ulasan</span>
                                <span class="spinner-loader" style="display: none; width: 14px; height: 14px; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: spin-loader 0.8s linear infinite;"></span>
                            </button>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Right Column: Submission Form Sticky Box -->
            <div class="stories-form-column">
                <div class="sticky-form-container">
                    <!-- Upgraded Stories CTA Banner -->
                    <div class="stories-cta-banner">
                        <div class="stories-cta-banner__content">
                            <h3>Punya cerita seru di Warkop Sky?</h3>
                            <p>Bagikan momenmu — siapa tahu jadi inspirasi tamu berikutnya ☕</p>
                        </div>
                        <div class="stories-cta-banner__arrow">↓</div>
                    </div>
                    <livewire:submit-story />
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    .stories-header {
        padding: var(--spacing-xl) 0;
        margin-top: 0;
        background: 
            linear-gradient(rgba(10,15,29,0.7), rgba(10,15,29,0.9)),
            url('/images/hero/hero_stories.webp') center/cover no-repeat;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        margin-bottom: var(--spacing-lg);
    }

    /* Two-Column split screen styling */
    .stories-split-layout {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: var(--spacing-lg);
        align-items: start;
    }

    @media (max-width: 992px) {
        .stories-split-layout {
            grid-template-columns: 1fr;
            gap: var(--spacing-lg);
        }
        .stories-form-column {
            order: -1; /* Place form on top for mobile review triggers */
            margin-bottom: var(--spacing-sm);
        }
    }

    /* Sticky container for desktop layout */
    .sticky-form-container {
        position: sticky;
        top: 100px;
        z-index: 10;
    }

    /* Cozy Timeline grid (2-Column Masonry Wall) */
    .stories-timeline-grid {
        display: block;
        columns: 2;
        column-gap: var(--spacing-md);
    }

    @media (max-width: 768px) {
        .stories-timeline-grid {
            columns: 1;
        }
    }

    .story-cozy-card {
        display: inline-block;
        width: 100%;
        break-inside: avoid;
        margin-bottom: var(--spacing-md);
        padding: var(--spacing-md) !important;
        border: 1px solid rgba(255,255,255,0.03) !important;
        background: rgba(16, 24, 48, 0.45) !important;
        transition: transform var(--duration-fast) var(--easing-smooth),
                    border-color var(--duration-fast) var(--easing-smooth);
    }

    .story-cozy-card:hover {
        transform: translateY(-3px);
        border-color: rgba(93, 156, 236, 0.15) !important;
    }

    /* Card inner structures */
    .story-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--spacing-sm);
    }

    .story-author-name {
        font-family: var(--font-body);
        font-weight: 700;
        color: var(--color-warm-cream);
        font-size: 1.1rem;
        line-height: 1.2;
    }

    .story-ig-link {
        font-size: 0.8rem;
        color: var(--color-sky-blue);
        text-decoration: none;
        display: inline-block;
        margin-top: 2px;
        font-weight: 500;
        transition: opacity var(--duration-instant) var(--easing-smooth);
    }

    .story-ig-link:hover {
        opacity: 0.8;
    }

    .story-stars-display {
        display: flex;
        gap: 3px;
        color: var(--color-warm-gold);
    }

    /* Polaroid photo styles - Restored to original majestic size */
    .story-media-wrapper {
        width: 100%;
        max-height: 380px;
        overflow: hidden;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.05);
        background: #060913;
        margin-bottom: var(--spacing-sm);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .story-media-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .story-quote-text {
        font-family: var(--font-display);
        font-size: 1.4rem;
        line-height: 1.3;
        color: var(--color-warm-cream);
        margin-bottom: var(--spacing-xs);
        font-style: italic;
        text-align: left;
    }

    .story-body-text {
        font-size: 0.88rem;
        color: var(--color-muted-text);
        line-height: 1.5;
        margin-bottom: var(--spacing-sm);
        white-space: pre-line;
        text-align: left;
    }

    .story-footer-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255,255,255,0.03);
        padding-top: var(--spacing-xs);
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.3);
    }

    /* Video Overlay & Play button */
    .video-play-indicator-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(7, 11, 20, 0.3);
        transition: background var(--duration-fast) var(--easing-smooth);
    }
    
    .story-media-wrapper:hover .video-play-indicator-overlay {
        background: rgba(7, 11, 20, 0.5);
    }

    /* Loading Spinner Keyframes */
    @keyframes spin-loader {
        to { transform: rotate(360deg); }
    }

    /* Custom CSS Pagination */
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
        padding: var(--spacing-md) 0;
    }

    .custom-pagination nav {
        display: flex;
        gap: 6px;
    }

    .custom-pagination a, .custom-pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 6px;
        background: rgba(7, 11, 20, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 6px;
        color: var(--color-warm-cream);
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .custom-pagination a:hover {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border-color: var(--color-sky-blue);
    }

    .custom-pagination .active span {
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        border-color: var(--color-warm-gold);
    }
</style>

    <!-- JSON-LD FoodEstablishment AggregateRating & Breadcrumb Schemas -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "FoodEstablishment",
      "@@id": "{{ config('app.url') }}/#restaurant",
      "name": "Warkop Sky",
      "url": "{{ config('app.url') }}",
      "telephone": "+6281385271918",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Jl. Raya Jatiasih No. 64a, RT.001/RW.004",
        "addressLocality": "Jatiasih",
        "addressRegion": "Bekasi",
        "addressCountry": "ID",
        "postalCode": "17423"
      },
      "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "{{ number_format($avgRating, 1) }}",
        "reviewCount": "{{ $totalReviews }}",
        "bestRating": "5",
        "worstRating": "1"
      }
    }
    </script>
    
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
          "name": "Cerita Pelanggan",
          "item": "{{ url()->current() }}"
        }
      ]
    }
    </script>

    <!-- AJAX Load More Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            const timelineGrid = document.querySelector('.stories-timeline-grid');
            const loader = document.querySelector('.spinner-loader');
            
            if (loadMoreBtn && timelineGrid) {
                loadMoreBtn.addEventListener('click', function() {
                    let nextUrl = loadMoreBtn.getAttribute('data-next-url');
                    if (!nextUrl) return;

                    // Show loading state
                    loadMoreBtn.disabled = true;
                    if (loader) loader.style.display = 'inline-block';
                    loadMoreBtn.querySelector('span').textContent = 'Memuat Ulasan...';

                    fetch(nextUrl)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.text();
                        })
                        .then(html => {
                            // Parse response HTML
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            // Extract new reviews
                            const newReviews = doc.querySelectorAll('.story-cozy-card');
                            
                            // Append new reviews to timeline grid
                            newReviews.forEach(card => {
                                timelineGrid.appendChild(card);
                            });

                            // Check if there is another next page in the fetched page's load more button
                            const fetchedBtn = doc.getElementById('loadMoreBtn');
                            if (fetchedBtn && fetchedBtn.getAttribute('data-next-url')) {
                                const newNextUrl = fetchedBtn.getAttribute('data-next-url');
                                loadMoreBtn.setAttribute('data-next-url', newNextUrl);
                                loadMoreBtn.disabled = false;
                                if (loader) loader.style.display = 'none';
                                loadMoreBtn.querySelector('span').textContent = 'Muat Lebih Banyak Ulasan';
                            } else {
                                // No more pages, hide the load more container
                                const container = document.querySelector('.load-more-container');
                                if (container) {
                                    container.innerHTML = '<p style="color: var(--color-muted-text); font-size: 0.88rem; font-style: italic; margin-top: var(--spacing-md); text-align: center; width: 100%;">Semua cerita ulasan telah dimuat ✨</p>';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error loading more stories:', error);
                            loadMoreBtn.disabled = false;
                            if (loader) loader.style.display = 'none';
                            loadMoreBtn.querySelector('span').textContent = 'Gagal memuat. Coba Lagi';
                        });
                });
            }
        });
    </script>
@endsection
