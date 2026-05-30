@extends('layouts.admin')

@section('title', 'Kelola Menu Utama | Warkop Sky CRM')
@section('page_title', 'Kelola Menu Utama')

@section('styles')
<style>
    /* Upper Actions Bar */
    .action-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-sm);
        margin-bottom: var(--spacing-md);
    }

    .search-filter-box {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        flex-wrap: wrap;
        flex: 1;
        max-width: 600px;
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

    .btn-add-menu {
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

    .btn-add-menu:hover {
        background: #d62828;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.35);
    }

    /* Asymmetric Cards Table Layout */
    .admin-table-box {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        overflow: hidden;
        margin-bottom: var(--spacing-lg);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .admin-table th {
        background: rgba(16, 24, 48, 0.9);
        padding: 1rem 1.25rem;
        font-weight: 700;
        font-size: 0.82rem;
        color: var(--color-muted-text);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .admin-table td {
        padding: 1.1rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        font-size: 0.88rem;
        color: var(--color-warm-cream);
        vertical-align: middle;
    }

    .admin-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.01);
    }

    /* Menu Item Meta */
    .menu-item-meta {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .menu-item-img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background: rgba(7, 11, 20, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .menu-item-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: rgba(93, 156, 236, 0.06);
        border: 1px solid rgba(93, 156, 236, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-sky-blue);
        font-size: 0.72rem;
        font-weight: 800;
    }

    .menu-item-name {
        font-weight: 700;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .menu-item-desc {
        font-size: 0.78rem;
        color: var(--color-muted-text);
        margin-top: 2px;
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Badges & Flags */
    .badge-category {
        background: rgba(93, 156, 236, 0.08);
        border: 1px solid rgba(93, 156, 236, 0.2);
        color: var(--color-sky-blue);
        font-weight: 700;
        padding: 4px 8px;
        font-size: 0.75rem;
        border-top-left-radius: 6px;
        border-bottom-right-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .badge-fav {
        color: var(--color-warm-gold);
        text-shadow: 0 0 8px rgba(255, 200, 87, 0.4);
        font-size: 1rem;
    }

    .badge-avail--yes {
        color: #25D366;
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-avail--no {
        color: var(--color-warkop-red);
        font-weight: 700;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .bullet-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .bullet-dot--green {
        background: #25D366;
        box-shadow: 0 0 8px #25D366;
    }

    .bullet-dot--red {
        background: var(--color-warkop-red);
        box-shadow: 0 0 8px var(--color-warkop-red);
    }

    /* Actions */
    .table-actions {
        display: flex;
        gap: 8px;
    }

    .btn-edit {
        background: rgba(93, 156, 236, 0.1);
        border: 1px solid rgba(93, 156, 236, 0.2);
        color: var(--color-sky-blue);
    }

    .btn-edit:hover {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
    }

    .btn-delete {
        background: rgba(230, 57, 70, 0.1);
        border: 1px solid rgba(230, 57, 70, 0.2);
        color: var(--color-warkop-red);
    }

    .btn-delete:hover {
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
    }

    /* Category Management Section */
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

    /* Custom CSS styled Pagination */
    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
        padding: var(--spacing-md) var(--spacing-sm);
        border-top: 1px solid rgba(255, 255, 255, 0.03);
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

    .custom-pagination .disabled span {
        opacity: 0.3;
        cursor: not-allowed;
    }
</style>
@section('content')

    <!-- Upper Actions Bar -->
    <div class="action-header-bar" style="justify-content: flex-end;">
        <a href="{{ route('admin.menu.create') }}" class="btn-add-menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Menu Baru
        </a>
    </div>

    <!-- Menu Table Listing -->
    <div class="admin-table-box">
        <table class="admin-table datatable">
            <thead>
                <tr>
                    <th style="width: 80px;">Urutan</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th style="width: 140px;">Ketersediaan</th>
                    <th style="width: 140px;">Rekomendasi</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td style="font-weight: 800; color: var(--color-sky-blue);">#{{ $item->sort_order }}</td>
                        <td>
                            <div class="menu-item-meta">
                                @if($item->image_path)
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="menu-item-img">
                                @else
                                    <div class="menu-item-placeholder">No Pic</div>
                                @endif
                                <div>
                                    <div class="menu-item-name">{{ $item->name }}</div>
                                    <div class="menu-item-desc">{{ $item->description ?? 'Tidak ada deskripsi.' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-category">{{ $item->category->name ?? 'Tanpa Kategori' }}</span>
                        </td>
                        <td style="font-family: var(--font-body); font-weight: 700;">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($item->is_available)
                                <span class="badge-avail--yes">
                                    <span class="bullet-dot bullet-dot--green"></span> Tersedia
                                </span>
                            @else
                                <span class="badge-avail--no">
                                    <span class="bullet-dot bullet-dot--red"></span> Habis
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_favorite)
                                <span class="badge-fav" title="Favorit Rekomendasi">★ Favorit</span>
                            @else
                                <span style="color: var(--color-muted-text); font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div class="table-actions">
                                <a href="{{ route('admin.menu.edit', $item->id) }}" class="btn-action-small btn-edit" title="Edit Menu">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin mau menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-small btn-delete" title="Hapus Menu">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

@endsection
