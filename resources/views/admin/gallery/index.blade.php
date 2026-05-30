@extends('layouts.admin')

@section('title', 'Galeri Foto Kabin | Warkop Sky CRM')
@section('page_title', 'Kelola Galeri Foto')

@section('styles')
<style>
    /* Filter Bar */
    .filter-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-md);
    }

    .form-filter-input {
        padding: 0.65rem 1rem;
        background: rgba(16, 24, 48, 0.6);
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
    }

    .btn-search {
        padding: 0.65rem 1.2rem;
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border: none;
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .btn-search:hover {
        background: var(--color-warm-gold);
    }

    .btn-add-photo {
        padding: 0.65rem 1.4rem;
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        text-decoration: none;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        font-weight: 700;
        font-size: 0.88rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all var(--duration-fast) var(--easing-bounce);
        box-shadow: 0 4px 15px rgba(230, 57, 70, 0.2);
    }

    .btn-add-photo:hover {
        background: #d62828;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.35);
    }

    /* 3-Column Premium Masonry Grid */
    .gallery-masonry {
        column-count: 3;
        column-gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    @media (max-width: 991px) {
        .gallery-masonry {
            column-count: 2;
        }
    }

    @media (max-width: 576px) {
        .gallery-masonry {
            column-count: 1;
        }
    }

    .gallery-card {
        break-inside: avoid;
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: 10px;
        border-top-left-radius: 16px;
        border-bottom-right-radius: 16px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        margin-bottom: var(--spacing-md);
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        transition: all var(--duration-normal) var(--easing-smooth);
    }

    .gallery-card:hover {
        transform: translateY(-4px);
        border-color: rgba(93, 156, 236, 0.25);
        box-shadow: 0 12px 30px rgba(93, 156, 236, 0.08);
    }

    .gallery-image-wrapper {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
    }

    .gallery-img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform var(--duration-slow) var(--easing-smooth);
    }

    .gallery-card:hover .gallery-img {
        transform: scale(1.04);
    }

    /* Deletion / Action Overlay */
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(7, 11, 20, 0.85);
        backdrop-filter: blur(4px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        transition: opacity var(--duration-fast) var(--easing-smooth);
        z-index: 10;
        padding: var(--spacing-sm);
        text-align: center;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
        pointer-events: auto;
    }

    .overlay-title {
        font-family: var(--font-display);
        font-size: 1.1rem;
        margin-bottom: 4px;
        color: var(--color-warm-cream);
    }

    .overlay-desc {
        font-size: 0.75rem;
        color: var(--color-muted-text);
        margin-bottom: var(--spacing-sm);
        max-width: 220px;
    }

    .btn-overlay-delete {
        padding: 0.5rem 1.2rem;
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        border: none;
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.78rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all var(--duration-fast) var(--easing-bounce);
        box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
    }

    .btn-overlay-delete:hover {
        background: #d62828;
        transform: scale(1.05);
    }

    /* Details bottom card metadata */
    .gallery-details {
        margin-top: 10px;
        padding: 4px 6px;
    }

    .gallery-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }

    .gallery-title {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--color-warm-cream);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
    }

    .badge-category {
        background: rgba(93, 156, 236, 0.08);
        border: 1px solid rgba(93, 156, 236, 0.2);
        color: var(--color-sky-blue);
        font-weight: 700;
        padding: 2px 6px;
        font-size: 0.65rem;
        border-radius: 4px;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    /* Category CRM split column */
    .category-section-wrapper {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: var(--spacing-lg);
        margin-top: var(--spacing-md);
    }

    @media (max-width: 991px) {
        .category-section-wrapper {
            grid-template-columns: 1fr;
        }
    }

    .category-card {
        background: rgba(16, 24, 48, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.02);
        padding: 10px 14px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }

    .category-grid-box {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
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

    /* Admin Table (for Categories) */
    .admin-table-box {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .admin-table th {
        background: rgba(16, 24, 48, 0.9);
        padding: 0.9rem 1.1rem;
        font-weight: 700;
        font-size: 0.82rem;
        color: var(--color-muted-text);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .admin-table td {
        padding: 0.9rem 1.1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        font-size: 0.88rem;
        color: var(--color-warm-cream);
        vertical-align: middle;
    }
    .admin-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.01);
    }
    .btn-delete {
        background: rgba(230, 57, 70, 0.1);
        border: 1px solid rgba(230, 57, 70, 0.2);
        color: var(--color-warkop-red);
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all var(--duration-fast) var(--easing-smooth);
    }
    .btn-delete:hover {
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
    }
</style>
@section('content')

    <!-- Upper Actions Bar -->
    <div class="filter-header-bar">
        
        <!-- Filter Form -->
        <form action="{{ route('admin.gallery.index') }}" method="GET" class="search-filter-box" style="display:flex; gap:8px; flex-wrap:wrap; flex:1; max-width:600px;">
            <input 
                type="text" 
                name="search" 
                class="form-filter-input" 
                placeholder="Cari foto..." 
                value="{{ request('search') }}"
            >
            
            <select name="category" class="form-filter-input" style="cursor: pointer;">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="btn-search">Filter</button>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.gallery.index') }}" class="form-filter-input" style="text-decoration: none; background: rgba(230, 57, 70, 0.1); border-color: rgba(230, 57, 70, 0.2); color: var(--color-warkop-red);">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.gallery.create') }}" class="btn-add-photo">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Pajang Foto Baru
        </a>
    </div>

    <!-- Gallery Masonry Grid -->
    <div class="gallery-masonry">
        @forelse($items as $item)
            <div class="gallery-card">
                <div class="gallery-image-wrapper">
                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="gallery-img">
                    
                    <!-- Deletion Overlay on Hover -->
                    <div class="gallery-overlay">
                        <h4 class="overlay-title">{{ $item->title }}</h4>
                        <p class="overlay-desc">{{ $item->description ?? 'Tidak ada deskripsi.' }}</p>
                        
                        <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin mau melepas foto ini dari galeri?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-overlay-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Copot Foto
                            </button>
                        </form>
                    </div>
                </div>

                <div class="gallery-details">
                    <div class="gallery-title-row">
                        <span class="gallery-title" title="{{ $item->title }}">{{ $item->title }}</span>
                        <span class="badge-category">{{ $item->category->name ?? 'Foto' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="panel-box" style="column-span: all; text-align: center; color: var(--color-muted-text); padding: 4rem 0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="opacity: 0.3; margin-bottom: 12px;">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <div style="font-weight: 700; color: var(--color-warm-cream);">Bingkai Galeri Kosong</div>
                <div style="font-size: 0.85rem; margin-top: 4px;">Mulailah mengunggah foto suasana kabin Anda untuk memikat pengunjung.</div>
            </div>
        @endforelse
    </div>

    <!-- Paginations if pages exist -->
    @if($items->hasPages())
        <div class="custom-pagination" style="margin-bottom: var(--spacing-lg);">
            {!! $items->links() !!}
        </div>
    @endif

@endsection
