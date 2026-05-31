@extends('layouts.app')

@section('title', $seoData['title'])
@section('meta_description', $seoData['description'])

@section('content')
<style>
    /* ═══════════════════════════════════════════
       EVENTS PUBLIC PAGE
    ═══════════════════════════════════════════ */

    /* Hero */
    .events-hero {
        position: relative;
        padding: 5rem 0 3.5rem;
        text-align: center;
        background: linear-gradient(180deg, rgba(5,10,20,0) 0%, rgba(5,10,20,0.6) 100%);
        overflow: hidden;
    }
    .events-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 50% at 50% 30%, rgba(93,156,236,0.08), transparent);
        pointer-events: none;
    }
    .events-hero-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--color-warm-gold);
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .events-hero-title {
        font-family: var(--font-display);
        font-size: clamp(2rem, 5vw, 3.2rem);
        color: var(--color-warm-cream);
        line-height: 1.15;
        margin-bottom: 1rem;
    }
    .events-hero-title span { color: var(--color-warm-gold); }
    .events-hero-sub {
        font-size: 1rem;
        color: rgba(255,255,255,0.55);
        max-width: 520px;
        margin: 0 auto 2rem;
        line-height: 1.75;
    }

    /* Filter bar */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        margin-bottom: 2.5rem;
    }
    .filter-btn {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.55);
        padding: 7px 18px;
        border-radius: 24px;
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        letter-spacing: 0.3px;
    }
    .filter-btn:hover,
    .filter-btn.active {
        background: var(--color-warm-gold);
        border-color: var(--color-warm-gold);
        color: var(--color-midnight-bg);
    }

    /* Events grid */
    .events-section { padding: 0 0 5rem; }
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    /* Event card */
    .event-card {
        background: rgba(16,24,48,0.6);
        border: 1px solid rgba(93,156,236,0.1);
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
        cursor: default;
        position: relative;
    }
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.4);
        border-color: rgba(93,156,236,0.25);
    }

    /* Poster */
    .event-poster-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: rgba(10,15,30,0.8);
    }
    .event-poster {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }
    .event-card:hover .event-poster { transform: scale(1.04); }
    .poster-placeholder-pub {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        background: linear-gradient(135deg, rgba(16,24,48,0.9), rgba(8,14,32,0.9));
        color: rgba(255,255,255,0.15);
    }

    /* Category badge overlay */
    .event-cat-overlay {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }
    .cat-nobar      { background: rgba(220,38,38,0.85); color: #fff; }
    .cat-live_music { background: rgba(139,92,246,0.85); color: #fff; }
    .cat-special_event { background: rgba(251,146,60,0.85); color: #fff; }
    .cat-promo      { background: rgba(34,197,94,0.85); color: #fff; }
    .cat-tournament { background: rgba(234,179,8,0.85); color: #0a0f1d; }
    .cat-lainnya    { background: rgba(100,116,139,0.85); color: #fff; }

    /* Status badges */
    .event-status-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }
    .st-ongoing  { background: rgba(34,197,94,0.9); color: #fff; animation: pulse-green 2s infinite; }
    .st-upcoming { background: rgba(59,130,246,0.85); color: #fff; }
    .st-completed { background: rgba(100,116,139,0.7); color: rgba(255,255,255,0.7); }
    @keyframes pulse-green {
        0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.4); }
        50%       { box-shadow: 0 0 0 6px rgba(34,197,94,0); }
    }

    /* Card body */
    .event-body {
        padding: 1.1rem 1.25rem 1.25rem;
    }
    .event-title {
        font-family: var(--font-display);
        font-size: 1.05rem;
        color: var(--color-warm-cream);
        margin-bottom: 0.6rem;
        line-height: 1.3;
    }
    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 0.75rem;
    }
    .event-meta-row {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.82rem;
        color: rgba(255,255,255,0.5);
    }
    .event-meta-row .mi { font-size: 0.85rem; flex-shrink: 0; }
    .event-desc {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.4);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Featured star */
    .event-featured-badge {
        position: absolute;
        bottom: calc(100% - (4/3 * 100%) - 12px);
        right: 12px;
        font-size: 0.75rem;
        background: rgba(212,175,55,0.9);
        color: #000;
        padding: 2px 9px;
        border-radius: 12px;
        font-weight: 800;
        letter-spacing: 0.5px;
        display: none;
    }

    /* Empty state */
    .events-empty {
        text-align: center;
        padding: 4rem 1rem;
    }
    .events-empty-icon { font-size: 3.5rem; margin-bottom: 1rem; opacity: 0.5; }
    .events-empty-title { font-family: var(--font-display); font-size: 1.4rem; color: rgba(255,255,255,0.4); margin-bottom: 0.5rem; }
    .events-empty-sub { font-size: 0.9rem; color: rgba(255,255,255,0.25); }

    @media (max-width: 640px) {
        .events-grid { grid-template-columns: 1fr; }
        .events-hero { padding: 3.5rem 0 2.5rem; }
    }
</style>

{{-- ─── HERO ─── --}}
<section class="events-hero container">
    <div class="events-hero-eyebrow">Agenda & Acara</div>
    <h1 class="events-hero-title">Events <span>Warkop Sky</span></h1>
    <p class="events-hero-sub">
        NOBAR seru, Live Music setiap Sabtu & Minggu, Bakar-Bakaran, dan banyak kejutan spesial lainnya. Jangan sampai ketinggalan!
    </p>

    {{-- Filter Buttons --}}
    <div class="filter-bar">
        <button class="filter-btn active" data-filter="all">🎉 Semua</button>
        <button class="filter-btn" data-filter="nobar">🔴 NOBAR</button>
        <button class="filter-btn" data-filter="live_music">🎵 Live Music</button>
        <button class="filter-btn" data-filter="special_event">🔥 Special Event</button>
        <button class="filter-btn" data-filter="promo">💰 Promo</button>
        <button class="filter-btn" data-filter="tournament">🏆 Tournament</button>
        <button class="filter-btn" data-filter="lainnya">📌 Lainnya</button>
    </div>
</section>

{{-- ─── EVENTS GRID ─── --}}
<section class="events-section">
    <div class="container">

        @if($allEvents->isEmpty())
            <div class="events-empty">
                <div class="events-empty-icon">📅</div>
                <div class="events-empty-title">Belum Ada Event Terjadwal</div>
                <div class="events-empty-sub">Nantikan agenda seru Warkop Sky! Ikuti kami di Instagram @warkopsky.id</div>
            </div>
        @else
            <div class="events-grid" id="eventsGrid">
                @foreach($allEvents as $event)
                @php
                    $catClass = match($event->category) {
                        'nobar'         => 'cat-nobar',
                        'live_music'    => 'cat-live_music',
                        'special_event' => 'cat-special_event',
                        'promo'         => 'cat-promo',
                        'tournament'    => 'cat-tournament',
                        default         => 'cat-lainnya',
                    };
                    $catLabel = match($event->category) {
                        'nobar'         => '🔴 NOBAR',
                        'live_music'    => '🎵 Live Music',
                        'special_event' => '🔥 Special Event',
                        'promo'         => '💰 Promo',
                        'tournament'    => '🏆 Tournament',
                        default         => '📌 Lainnya',
                    };
                    $stClass = match($event->status) {
                        'ongoing'   => 'st-ongoing',
                        'upcoming'  => 'st-upcoming',
                        'completed' => 'st-completed',
                        default     => '',
                    };
                    $stLabel = match($event->status) {
                        'ongoing'   => '🟢 Live Sekarang',
                        'upcoming'  => '📅 Akan Datang',
                        'completed' => '✅ Selesai',
                        'cancelled' => '❌ Dibatalkan',
                        default     => '',
                    };
                @endphp
                <div class="event-card" data-category="{{ $event->category }}">
                    {{-- Poster --}}
                    <div class="event-poster-wrap">
                        @if($event->poster_image)
                            <img src="{{ asset($event->poster_image) }}"
                                 alt="{{ $event->title }}"
                                 class="event-poster"
                                 loading="lazy">
                        @else
                            <div class="poster-placeholder-pub">
                                {{ match($event->category) {
                                    'nobar'         => '📺',
                                    'live_music'    => '🎵',
                                    'special_event' => '🔥',
                                    'promo'         => '💰',
                                    'tournament'    => '🏆',
                                    default         => '🎉',
                                } }}
                            </div>
                        @endif

                        {{-- Category badge --}}
                        <span class="event-cat-overlay {{ $catClass }}">{{ $catLabel }}</span>

                        {{-- Status badge --}}
                        @if($event->status !== 'cancelled')
                            <span class="event-status-overlay {{ $stClass }}">{{ $stLabel }}</span>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="event-body">
                        <div class="event-title">{{ $event->title }}</div>
                        <div class="event-meta">
                            <div class="event-meta-row">
                                <span class="mi">📅</span>
                                <span>{{ $event->event_date->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="event-meta-row">
                                <span class="mi">⏰</span>
                                <span>{{ $event->formatted_time }}</span>
                            </div>
                            <div class="event-meta-row">
                                <span class="mi">📍</span>
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>
                        @if($event->description)
                            <div class="event-desc">{{ $event->description }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- No results after filter --}}
            <div class="events-empty" id="eventsEmpty" style="display:none;">
                <div class="events-empty-icon">🔍</div>
                <div class="events-empty-title">Tidak Ada Event di Kategori Ini</div>
                <div class="events-empty-sub">Coba filter lainnya atau nantikan agenda berikutnya!</div>
            </div>
        @endif

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.event-card');
    const emptyMsg = document.getElementById('eventsEmpty');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            let visible = 0;

            cards.forEach(card => {
                const cat = card.dataset.category;
                if (filter === 'all' || cat === filter) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (emptyMsg) emptyMsg.style.display = visible === 0 ? 'block' : 'none';
        });
    });
});
</script>
@endsection
