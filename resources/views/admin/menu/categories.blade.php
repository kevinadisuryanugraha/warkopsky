@extends('layouts.admin')

@section('title', 'Kelola Kategori Menu | Warkop Sky CRM')
@section('page_title', 'Kelola Kategori Menu')

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
@endsection

@section('content')

    <!-- Upper Actions Bar -->
    <div class="action-header-bar" style="justify-content: flex-end;">
        <a href="{{ route('admin.menu.categories.create') }}" class="btn-add-menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Kategori Baru
        </a>
    </div>

    <!-- Full-Width Admin Table Box -->
    <div class="admin-table-box">
        <table class="admin-table datatable">
            <thead>
                <tr>
                    <th style="width: 100px;">Urutan</th>
                    <th>Nama Kategori</th>
                    <th>Posisi Kolom Tampil</th>
                    <th>Jumlah Item Menu</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td style="font-weight: 800; color: var(--color-sky-blue);">#{{ $category->sort_order }}</td>
                        <td style="font-weight: 700; color: var(--color-warm-cream);">{{ $category->name }}</td>
                        <td>
                            <span class="badge-category">{{ $category->column_position === 'left' ? 'Kiri (Left Column)' : 'Kanan (Right Column)' }}</span>
                        </td>
                        <td style="font-weight: 600; color: var(--color-warm-gold);">
                            {{ $category->items()->count() }} Item
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('admin.menu.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin mau menghapus kategori {{ $category->name }}?')" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-small btn-delete" style="padding: 5px 10px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;" title="Hapus Kategori">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

@endsection
