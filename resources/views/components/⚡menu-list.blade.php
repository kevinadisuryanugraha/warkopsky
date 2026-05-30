<?php

use Livewire\Component;
use App\Models\MenuItem;
use App\Models\MenuCategory;

new class extends Component
{
    public $search = '';
    public $activeCategory = '';

    public function render()
    {
        // Fetch items grouped by category name, applying active category and search queries
        $groupedItems = MenuItem::with('category')
            ->when($this->activeCategory, function($q) {
                $q->whereHas('category', function($q2) {
                    $q2->where('slug', $this->activeCategory);
                });
            })
            ->when($this->search, function($q) {
                $q->where(function($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category.name');

        return view('components.⚡menu-list', [
            'groupedItems' => $groupedItems,
            'categories' => MenuCategory::orderBy('sort_order')->get(),
        ]);
    }
};
?>

<div>
    <!-- Hero Header -->
    <div class="menu-header text-center">
        <div class="container">
            <span class="text-gold" style="font-family: var(--font-body); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.1em; display: inline-block; margin-bottom: 8px;">Pilihan Lezat</span>
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.1; margin-bottom: var(--spacing-xs); font-family: var(--font-display); color: var(--color-warm-cream);">
                Daftar <span class="text-highlight" style="font-family: inherit;">Menu Kami</span>
            </h1>
            <p style="max-width: 600px; margin: 0 auto; color: var(--color-muted-text); font-size: 0.95rem;">
                Semua hidangan dibuat segar & disajikan hangat dengan cita rasa autentik penuh cinta.
            </p>
        </div>
    </div>

    <!-- Sticky Header & Search -->
    <div class="menu-sticky-bar">
        <div class="container sticky-flex">
            <!-- Header Text -->
            <div class="sticky-title-col">
                <h2 style="font-size: 1.4rem; font-family: var(--font-display); color: var(--color-warm-cream); margin: 0;">Menu Warkop Sky</h2>
            </div>
            
            <!-- Search Bar Input -->
            <div class="search-input-wrapper">
                <!-- Search Icon -->
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    class="search-input-field" 
                    placeholder="Cari es teh, sate, dimsum..."
                >
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: var(--spacing-lg);">
        <!-- Category Filter Pills -->
        <div class="filter-pills-container">
            <!-- "Semua" pill -->
            <button 
                wire:click="$set('activeCategory', '')" 
                class="filter-pill {{ $activeCategory === '' ? 'active' : '' }}"
            >
                Semua Menu
            </button>
            
            <!-- Dynamic Category loop -->
            @foreach($categories as $cat)
                <button 
                    wire:click="$set('activeCategory', '{{ $cat->slug }}')" 
                    class="filter-pill {{ $activeCategory === $cat->slug ? 'active' : '' }}"
                >
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        <!-- ==========================================
           LOADING STATE (SKELETON CARDS)
           ========================================== -->
        <div wire:loading style="width: 100%;">
            <div class="menu-grid">
                @for($s = 1; $s <= 8; $s++)
                    <div class="card-cabin" style="padding: 0; min-height: 320px; overflow: hidden; display: flex; flex-direction: column;">
                        <!-- Shimmer Image -->
                        <div style="width: 100%; height: 160px;" class="skeleton-box"></div>
                        <!-- Shimmer Content -->
                        <div style="padding: var(--spacing-sm); flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <div style="width: 50%; height: 16px; margin-bottom: 8px;" class="skeleton-box"></div>
                                <div style="width: 85%; height: 20px; margin-bottom: 6px;" class="skeleton-box"></div>
                                <div style="width: 100%; height: 14px; margin-bottom: 4px;" class="skeleton-box"></div>
                                <div style="width: 90%; height: 14px;" class="skeleton-box"></div>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--spacing-sm);">
                                <div style="width: 35%; height: 18px;" class="skeleton-box"></div>
                                <div style="width: 32px; height: 32px; border-radius: 50%;" class="skeleton-box"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <!-- ==========================================
           NORMAL GRID VIEW
           ========================================== -->
        <div wire:loading.remove>
            @if($groupedItems->isEmpty())
                <!-- Upgraded Empty State -->
                <div class="menu-empty-state">
                    <div class="menu-empty-state__icon">
                        <!-- coffee cup SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="none" stroke="var(--color-muted-text)" stroke-width="1.2" viewBox="0 0 24 24" style="opacity: 0.5;">
                            <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h14v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z" />
                            <line x1="6" y1="2" x2="6" y2="4" />
                            <line x1="10" y1="2" x2="10" y2="4" />
                            <line x1="14" y1="2" x2="14" y2="4" />
                        </svg>
                    </div>
                    <p class="menu-empty-state__title">Hmm, menu ini lagi malu-malu kali ya...</p>
                    <p class="menu-empty-state__sub">Coba kata kunci lain atau pilih kategori berbeda</p>
                    <button wire:click="$set('search', '')" wire:click="$set('activeCategory', '')" 
                            class="btn-cta-ghost btn-cta-ghost--sm"
                            style="margin-top: 1rem;">
                        Reset Pencarian
                    </button>
                </div>
            @else
                <!-- Loop over categories -->
                @foreach($groupedItems as $categoryName => $items)
                    <div style="margin-bottom: var(--spacing-xl);">
                        <!-- Category Header -->
                        <h2 class="menu-category-header">
                            {{ $categoryName }}
                        </h2>
                        
                        <!-- Items Grid -->
                        <div class="menu-grid">
                            @foreach($items as $menu)
                                @php
                                    // TODO Admin: MenuItem->is_available toggle via admin panel (Step admin build)
                                    $isSoldOut = !$menu->is_available;
                                @endphp
                                <x-card class="menu-item-card {{ $isSoldOut ? 'sold-out-card' : '' }} {{ $menu->is_favorite ? 'favorite-card' : '' }}" style="padding: 0; min-height: 320px; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                                    <div>
                                        <!-- Image Wrapper -->
                                        <div style="width: 100%; height: 160px; overflow: hidden; position: relative; background: #131A26;">
                                            @if($menu->image_path)
                                                @php
                                                    $resolvedPath = (str_starts_with($menu->image_path, 'storage/') || str_starts_with($menu->image_path, 'uploads/')) 
                                                        ? $menu->image_path 
                                                        : 'storage/optimized/' . $menu->image_path;
                                                @endphp
                                                <img src="{{ asset($resolvedPath) }}" alt="{{ $menu->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color: var(--color-muted-text); font-size: 0.8rem; letter-spacing: 0.1em;">
                                                    [WARKOP SKY]
                                                </div>
                                            @endif
                                            
                                            <!-- Category Badge -->
                                            <span class="menu-card-badge">
                                                {{ $menu->category->name }}
                                            </span>

                                            <!-- Favorite Badge -->
                                            @if($menu->is_favorite)
                                                <span class="menu-card-fav-badge" title="Rekomendasi Favorit!">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 3px;">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    FAVORIT
                                                </span>
                                            @endif

                                            <!-- Sold Out Overlay -->
                                            @if($isSoldOut)
                                                <div class="sold-out-overlay">
                                                    <span>HABIS</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Card Text -->
                                        <div style="padding: var(--spacing-sm);">
                                            <h3 style="font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 4px;">{{ $menu->name }}</h3>
                                            <p style="font-size: 0.85rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $menu->description }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Bottom Row (Price & WA Button) -->
                                    <div style="padding: var(--spacing-sm); display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.03); background: rgba(0,0,0,0.15);">
                                        <span style="font-family: var(--font-display); font-size: 1.25rem; color: var(--color-warm-gold);">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </span>
                                        
                                        <!-- Order Button -->
                                        @if(!$isSoldOut)
                                            <a href="https://wa.me/6281385271918?text=Halo%20Warkop%20Sky%2C%20saya%20mau%20pesan%20{{ urlencode($menu->name) }}..."
                                               target="_blank"
                                               class="menu-card__order-btn"
                                               aria-label="Pesan {{ $menu->name }} via WhatsApp">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                <span>Pesan</span>
                                            </a>
                                        @else
                                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--color-muted-text); text-transform: uppercase;">Habis</span>
                                        @endif
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<style>
    .menu-header {
        padding: var(--spacing-xl) 0;
        margin-top: 0;
        background: 
            linear-gradient(rgba(10,15,29,0.7), rgba(10,15,29,0.9)),
            url('/images/hero/hero_menu.webp') center/cover no-repeat;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
    }

    /* Sticky Top Bar styling */
    .menu-sticky-bar {
        position: sticky;
        top: 80px; /* Under main header */
        background: rgba(10, 15, 29, 0.9);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(93, 156, 236, 0.08);
        padding: var(--spacing-sm) 0;
        z-index: 90;
    }
    
    .sticky-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
    }
    
    .sticky-title-col {
        flex: 1;
        min-width: 250px;
    }
    
    /* Livewire interactive input fields */
    .search-input-wrapper {
        position: relative;
        width: 100%;
        max-width: 360px;
    }
    
    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-sky-blue);
        pointer-events: none;
    }
    
    .search-input-field {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.8rem;
        background: rgba(16, 24, 48, 0.8);
        border: 1px solid rgba(93, 156, 236, 0.2);
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        color: var(--color-warm-cream);
        font-family: var(--font-body);
        font-size: 0.9rem;
        outline: none;
        transition: all var(--duration-fast) var(--easing-smooth);
    }
    
    .search-input-field:focus {
        border-color: var(--color-warm-gold);
        box-shadow: 0 0 15px rgba(255, 200, 87, 0.15);
    }
    
    /* Horizontal Pill Scroller */
    .filter-pills-container {
        display: flex;
        gap: var(--spacing-xs);
        overflow-x: auto;
        padding-bottom: var(--spacing-sm);
        margin-bottom: var(--spacing-lg);
        scrollbar-width: none;
    }
    
    .filter-pills-container::-webkit-scrollbar {
        display: none;
    }
    
    .filter-pill {
        flex: 0 0 auto;
        padding: 0.45rem 1.2rem;
        background: transparent;
        border: 1px solid rgba(93, 156, 236, 0.3);
        color: var(--color-muted-text);
        font-family: var(--font-body);
        font-weight: 500;
        font-size: 0.85rem;
        border-top-left-radius: 10px;
        border-bottom-right-radius: 10px;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-smooth);
    }
    
    .filter-pill:hover,
    .filter-pill.active {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border-color: var(--color-sky-blue);
        box-shadow: 0 4px 12px rgba(93, 156, 236, 0.25);
    }
    
    /* Grid structure */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: var(--spacing-md);
    }
    
    /* Category Headers */
    .menu-category-header {
        font-size: 1.6rem;
        border-left: 3px solid var(--color-warm-gold);
        padding-left: var(--spacing-xs);
        margin-bottom: var(--spacing-md);
        margin-top: var(--spacing-md);
    }
    
    /* Badges & Overlays */
    .menu-card-badge {
        position: absolute;
        top: var(--spacing-xs);
        left: var(--spacing-xs);
        background: rgba(10, 15, 29, 0.8);
        border: 1px solid var(--color-sky-blue);
        color: var(--color-sky-blue);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.18rem 0.5rem;
        border-radius: 4px;
        z-index: 2;
    }

    .menu-card-fav-badge {
        position: absolute;
        top: var(--spacing-xs);
        right: var(--spacing-xs);
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        padding: 0.18rem 0.5rem;
        border-radius: 4px;
        z-index: 2;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(255, 200, 87, 0.4);
        border: 1px solid var(--color-warm-gold);
    }

    .favorite-card {
        border: 1px solid rgba(255, 200, 87, 0.3) !important;
        box-shadow: 0 0 15px rgba(255, 200, 87, 0.1) !important;
    }

    .favorite-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--color-warm-gold), var(--color-sky-blue));
        z-index: 10;
    }
    
    /* Sold Out States */
    .sold-out-card {
        opacity: 0.65;
    }
    
    .sold-out-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 15, 29, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }
    
    .sold-out-overlay span {
        font-family: var(--font-display);
        font-size: 1.8rem;
        letter-spacing: 0.05em;
        color: var(--color-warkop-red);
        border: 2px solid var(--color-warkop-red);
        padding: 0.3rem 0.9rem;
        border-radius: 4px;
        transform: rotate(-10deg);
        text-shadow: 0 0 10px rgba(230, 57, 70, 0.4);
    }
    
    /* WA circular button */
    .btn-menu-wa {
        width: 32px;
        height: 32px;
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(230, 57, 70, 0.3);
        transition: transform var(--duration-fast) var(--easing-bounce),
                    background var(--duration-fast) var(--easing-smooth);
    }
    
    .btn-menu-wa:hover {
        transform: scale(1.15);
        background: #d62828;
    }
    
    /* Empty State style */
    .illustrated-empty-state {
        text-align: center;
        padding: var(--spacing-xl) var(--spacing-md);
        color: var(--color-muted-text);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .illustrated-empty-state h3 {
        font-size: 1.4rem;
        font-style: italic;
        color: var(--color-warm-cream);
        margin-bottom: var(--spacing-xs);
    }
    
    @media (max-width: 768px) {
        .sticky-flex {
            flex-direction: column;
            align-items: flex-start;
        }
        .search-input-wrapper {
            max-width: 100%;
        }
        .menu-sticky-bar {
            top: 79px; /* Correct offset overlaps */
        }
    }
</style>