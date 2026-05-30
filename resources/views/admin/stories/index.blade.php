@extends('layouts.admin')

@section('title', 'Moderasi Cerita Ulasan | Warkop Sky CRM')
@section('page_title', 'Moderasi Cerita Ulasan')

@section('styles')
<style>
    /* Tab Controls */
    .tabs-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: var(--spacing-md);
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        padding-bottom: 12px;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 0.6rem 1.4rem;
        background: rgba(16, 24, 48, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.04);
        color: var(--color-muted-text);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        border-top-left-radius: 10px;
        border-bottom-right-radius: 10px;
        transition: all var(--duration-fast) var(--easing-smooth);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .tab-btn:hover {
        color: var(--color-warm-cream);
        border-color: rgba(93, 156, 236, 0.2);
    }

    .tab-btn.active {
        color: var(--color-midnight-bg);
        background: var(--color-sky-blue);
        border-color: var(--color-sky-blue);
    }

    .tab-btn--pending.active {
        color: var(--color-midnight-bg);
        background: var(--color-warm-gold);
        border-color: var(--color-warm-gold);
    }

    .tab-btn--rejected.active {
        color: var(--color-warm-cream);
        background: var(--color-warkop-red);
        border-color: var(--color-warkop-red);
    }

    .tab-badge {
        font-size: 0.7rem;
        background: rgba(0, 0, 0, 0.2);
        padding: 2px 6px;
        border-radius: 4px;
    }

    /* Listing Layout: Custom Asymmetric Cards */
    .story-moderation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    .story-card-item {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        padding: var(--spacing-md);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        transition: all var(--duration-normal) var(--easing-smooth);
        position: relative;
    }

    .story-card-item:hover {
        transform: translateY(-4px);
        border-color: rgba(255, 200, 87, 0.2);
        box-shadow: 0 15px 35px rgba(255, 200, 87, 0.03);
    }

    .story-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .story-author-info {
        display: flex;
        flex-direction: column;
    }

    .story-author-name {
        font-weight: 700;
        font-size: 1.05rem;
        color: var(--color-warm-cream);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .story-ig-handle {
        font-size: 0.8rem;
        color: var(--color-sky-blue);
        text-decoration: none;
    }

    .story-stars {
        color: var(--color-warm-gold);
        font-size: 0.9rem;
        display: flex;
        gap: 1px;
    }

    .story-quote-box {
        background: rgba(7, 11, 20, 0.4);
        border-left: 3px solid var(--color-warm-gold);
        padding: 10px 12px;
        border-top-left-radius: 6px;
        border-bottom-right-radius: 6px;
        font-style: italic;
        font-size: 0.85rem;
        color: var(--color-muted-text);
        line-height: 1.4;
    }

    .story-text-content {
        font-size: 0.88rem;
        color: var(--color-warm-cream);
        line-height: 1.5;
        white-space: pre-line;
    }

    /* Media Preview block */
    .story-media-box {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.05);
        cursor: pointer;
        background: rgba(0, 0, 0, 0.3);
    }

    .story-media-img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        display: block;
        transition: transform var(--duration-normal) var(--easing-smooth);
    }

    .story-media-box:hover .story-media-img {
        transform: scale(1.05);
    }

    .story-media-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(7, 11, 20, 0.8);
        backdrop-filter: blur(4px);
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--color-sky-blue);
        border: 1px solid rgba(93, 156, 236, 0.2);
    }

    /* Card Actions Bar */
    .story-card-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: var(--spacing-xs);
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        padding-top: 12px;
        margin-top: auto;
    }

    .btn-story-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.8rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        text-decoration: none;
        transition: all var(--duration-fast) var(--easing-bounce);
    }

    .btn-story-action--approve {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
    }

    .btn-story-action--approve:hover {
        background: var(--color-warm-gold);
        transform: translateY(-2px);
    }

    .btn-story-action--reject {
        background: rgba(230, 57, 70, 0.1);
        color: var(--color-warkop-red);
        border: 1px solid rgba(230, 57, 70, 0.2);
    }

    .btn-story-action--reject:hover {
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        transform: translateY(-2px);
    }

    .btn-story-action--delete {
        background: rgba(255, 255, 255, 0.02);
        color: var(--color-muted-text);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 0.5rem;
    }

    .btn-story-action--delete:hover {
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        border-color: var(--color-warkop-red);
        transform: translateY(-2px);
    }

    /* Lightbox Modal (Glassmorphic) */
    .lightbox-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(7, 11, 20, 0.95);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity var(--duration-normal) var(--easing-smooth);
    }

    .lightbox-modal.show {
        display: flex;
        opacity: 1;
    }

    .lightbox-content-box {
        position: relative;
        max-width: 90%;
        max-height: 85%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        transform: scale(0.95);
        transition: transform var(--duration-normal) var(--easing-bounce);
    }

    .lightbox-modal.show .lightbox-content-box {
        transform: scale(1);
    }

    .lightbox-media {
        max-width: 100%;
        max-height: 70vh;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .lightbox-close-btn {
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
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .lightbox-close-btn:hover {
        background: var(--color-warkop-red);
        border-color: var(--color-warkop-red);
        transform: rotate(90deg);
    }

    .lightbox-caption {
        font-family: var(--font-display);
        font-size: 1.2rem;
        color: var(--color-warm-cream);
        text-align: center;
    }

    /* Custom CSS Pagination */
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
        padding: var(--spacing-md) var(--spacing-sm);
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

    .form-filter-input {
        width: 100%;
        padding: 0.65rem 1rem;
        background: rgba(7, 11, 20, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        color: var(--color-warm-cream);
        font-family: var(--font-body);
        font-size: 0.88rem;
        outline: none;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .form-filter-input:focus {
        border-color: var(--color-sky-blue);
        background: rgba(7, 11, 20, 0.95);
        box-shadow: 0 0 10px rgba(93, 156, 236, 0.15);
    }
</style>
@section('content')

    <!-- Top Activity Bar & Search Moderation -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
        <!-- Tabs for sorting -->
        <div class="tabs-wrapper" style="margin-bottom:0; border-bottom:none; padding-bottom:0;">
            <a href="{{ route('admin.stories.index', ['status' => 'pending']) }}" class="tab-btn tab-btn--pending {{ $status === 'pending' ? 'active' : '' }}">
                Tertunda (Pending)
            </a>
            <a href="{{ route('admin.stories.index', ['status' => 'approved']) }}" class="tab-btn {{ $status === 'approved' ? 'active' : '' }}">
                Disetujui (Approved)
            </a>
            <a href="{{ route('admin.stories.index', ['status' => 'rejected']) }}" class="tab-btn tab-btn--rejected {{ $status === 'rejected' ? 'active' : '' }}">
                Ditolak (Rejected)
            </a>
        </div>

        <!-- Real-time Client-side Search Bar -->
        <div style="display:flex; gap:8px;">
            <input 
                type="text" 
                id="storiesSearchInput" 
                class="form-filter-input" 
                placeholder="Cari pengulas/kata..." 
                style="min-width: 240px;"
            >
        </div>
    </div>

    <!-- Stories Moderation Grid -->
    <div class="story-moderation-grid">
        @forelse($stories as $story)
            <div class="story-card-item">
                <div class="story-meta-row">
                    <div class="story-author-info">
                        <div class="story-author-name">
                            {{ $story->author }}
                        </div>
                        @if($story->instagram_handle)
                            <a href="https://instagram.com/{{ $story->instagram_handle }}" target="_blank" class="story-ig-handle">
                                @ {{ $story->instagram_handle }}
                            </a>
                        @endif
                    </div>
                    
                    <div class="story-stars" title="Rating: {{ $story->rating }}/5">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $story->rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                </div>

                <!-- Media Preview Section if media uploaded -->
                @if($story->media_path)
                    <div class="story-media-box" onclick="openLightbox('{{ asset('storage/optimized/' . $story->media_path) }}', '{{ $story->media_type }}', 'Ulasan dari {{ $story->author }}')">
                        @if($story->media_type === 'video')
                            <video src="{{ asset('storage/optimized/' . $story->media_path) }}" class="story-media-img" muted playsinline></video>
                            <span class="story-media-badge">▶ Video</span>
                        @else
                            <img src="{{ asset('storage/optimized/' . $story->media_path) }}" class="story-media-img" alt="Ulasan dari {{ $story->author }}">
                            <span class="story-media-badge">📷 Foto</span>
                        @endif
                    </div>
                @endif

                <!-- Quote Section -->
                <div class="story-quote-box">
                    "{{ $story->quote }}"
                </div>

                <!-- Full Text Review -->
                <div class="story-text-content">
                    {{ $story->text }}
                </div>

                <!-- Card Actions bottom bar -->
                <div class="story-card-actions">
                    
                    <!-- Permanent Delete -->
                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin mau menghapus ulasan ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-story-action btn-story-action--delete" title="Hapus Permanen">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </form>

                    @if($story->status !== 'rejected')
                        <!-- Reject/Disapprove Story -->
                        <form action="{{ route('admin.stories.updateStatus', $story->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn-story-action btn-story-action--reject">Tolak</button>
                        </form>
                    @endif

                    @if($story->status !== 'approved')
                        <!-- Approve/Accept Story -->
                        <form action="{{ route('admin.stories.updateStatus', $story->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn-story-action btn-story-action--approve">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Setujui
                            </button>
                        </form>
                    @endif

                    @if($story->status !== 'pending' && false) <!-- Optional check back to pending -->
                        <form action="{{ route('admin.stories.updateStatus', $story->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn-story-action" style="background:rgba(255,255,255,0.05); color:var(--color-warm-cream);">Pending</button>
                        </form>
                    @endif

                </div>
            </div>
        @empty
            <div class="panel-box" style="grid-column: span 3; text-align: center; color: var(--color-muted-text); padding: 4rem 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="opacity: 0.3; margin-bottom: 12px;">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <div style="font-weight: 700; color: var(--color-warm-cream);">Tidak Ada Cerita Ulasan</div>
                <div style="font-size: 0.85rem; margin-top: 4px;">Belum ada ulasan dengan status "{{ strtoupper($status) }}" saat ini.</div>
            </div>
        @endforelse
    </div>



    <!-- Fullscreen Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal" onclick="closeLightbox()">
        <div class="lightbox-content-box" onclick="event.stopPropagation()">
            <button class="lightbox-close-btn" onclick="closeLightbox()">&times;</button>
            <div id="lightboxMediaContainer"></div>
            <h3 class="lightbox-caption" id="lightboxCaption"></h3>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openLightbox(mediaUrl, mediaType, captionText) {
        const modal = document.getElementById('lightboxModal');
        const container = document.getElementById('lightboxMediaContainer');
        const caption = document.getElementById('lightboxCaption');
        
        container.innerHTML = ''; // clear previous
        
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
        
        caption.textContent = captionText;
        modal.classList.add('show');
    }

    function closeLightbox() {
        const modal = document.getElementById('lightboxModal');
        modal.classList.remove('show');
        
        // Stop any playing video
        setTimeout(() => {
            const container = document.getElementById('lightboxMediaContainer');
            container.innerHTML = '';
        }, 300); // match transition
    }

    // Close on ESC key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLightbox();
        }
    });

    // Real-time client-side search filtering for cards
    document.getElementById('storiesSearchInput')?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('.story-card-item');
        cards.forEach(card => {
            const author = card.querySelector('.story-author-name')?.textContent.toLowerCase() || '';
            const handle = card.querySelector('.story-ig-handle')?.textContent.toLowerCase() || '';
            const quote = card.querySelector('.story-quote-box')?.textContent.toLowerCase() || '';
            const text = card.querySelector('.story-text-content')?.textContent.toLowerCase() || '';
            
            if (author.includes(query) || handle.includes(query) || quote.includes(query) || text.includes(query)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
