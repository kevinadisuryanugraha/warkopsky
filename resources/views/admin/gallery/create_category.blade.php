@extends('layouts.admin')

@section('title', 'Tambah Kategori Galeri Baru | Warkop Sky CRM')
@section('page_title', 'Tambah Kategori Galeri Baru')

@section('styles')
<style>
    .form-panel {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-top-left-radius: 24px;
        border-bottom-right-radius: 24px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        padding: var(--spacing-lg) var(--spacing-md);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-grid {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .form-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--color-muted-text);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-control {
        width: 100%;
        padding: 0.85rem 1rem;
        background: rgba(7, 11, 20, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        color: var(--color-warm-cream);
        font-family: var(--font-body);
        font-size: 0.92rem;
        outline: none;
        transition: all var(--duration-fast) var(--easing-smooth);
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: var(--color-sky-blue);
        background: rgba(7, 11, 20, 0.9);
        box-shadow: 0 0 12px rgba(93, 156, 236, 0.12);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: var(--spacing-sm);
        margin-top: var(--spacing-lg);
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        padding-top: var(--spacing-md);
    }

    .btn-cancel {
        padding: 0.8rem 1.6rem;
        background: rgba(7, 11, 20, 0.5);
        color: var(--color-muted-text);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top-left-radius: 10px;
        border-bottom-right-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .btn-cancel:hover {
        background: rgba(7, 11, 20, 0.9);
        color: var(--color-warm-cream);
    }

    .btn-submit {
        padding: 0.8rem 2rem;
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        border: none;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all var(--duration-fast) var(--easing-bounce);
        box-shadow: 0 4px 15px rgba(230, 57, 70, 0.25);
    }

    .btn-submit:hover {
        background: #d62828;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.4);
    }
</style>
@endsection

@section('content')

    <!-- Form container -->
    <div class="form-panel">
        
        <!-- Error Block -->
        @if ($errors->any())
            <div style="background: rgba(230, 57, 70, 0.12); border: 1px solid var(--color-warkop-red); color: var(--color-warm-cream); padding: 1rem; border-radius: 10px; margin-bottom: 20px; font-size: 0.85rem; line-height: 1.4;">
                <strong style="color: var(--color-warkop-red); display: block; margin-bottom: 6px;">Periksa kembali inputan Anda:</strong>
                <ul style="margin: 0; padding-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.gallery.category.store') }}" method="POST" autocomplete="off">
            @csrf
            
            <div class="form-grid">
                
                <!-- Category Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Kategori Baru *</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Contoh: Suasana Kabin" 
                        value="{{ old('name') }}" 
                        required
                    >
                </div>

                <!-- Sort Order -->
                <div class="form-group">
                    <label for="sort_order" class="form-label">Urutan Tampil (Order) *</label>
                    <input 
                        type="number" 
                        name="sort_order" 
                        id="sort_order" 
                        class="form-control" 
                        placeholder="Contoh: 1" 
                        value="{{ old('sort_order', $categories->count() + 1) }}" 
                        min="0"
                        required
                    >
                </div>

            </div>

            <!-- Action buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.gallery.categories.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Simpan Kategori Baru
                </button>
            </div>
            
        </form>
    </div>

@endsection
