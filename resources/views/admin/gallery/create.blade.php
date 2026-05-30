@extends('layouts.admin')

@section('title', 'Pajang Foto Baru | Warkop Sky CRM')
@section('page_title', 'Pajang Foto Baru')

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
        max-width: 700px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: var(--spacing-md);
    }

    /* Premium inputs and fields */
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
    }

    .form-control:focus {
        border-color: var(--color-sky-blue);
        background: rgba(7, 11, 20, 0.9);
        box-shadow: 0 0 12px rgba(93, 156, 236, 0.12);
    }

    /* File upload wrapper */
    .file-upload-wrapper {
        border: 1.5px dashed rgba(93, 156, 236, 0.25);
        background: rgba(93, 156, 236, 0.02);
        padding: var(--spacing-md);
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .file-upload-wrapper:hover {
        border-color: var(--color-warm-gold);
        background: rgba(255, 200, 87, 0.02);
    }

    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        color: var(--color-muted-text);
        font-size: 0.85rem;
    }

    .file-upload-label svg {
        color: var(--color-sky-blue);
    }

    /* Actions buttons */
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

    /* Preview box */
    .image-preview-box {
        margin-top: 12px;
        display: none;
        justify-content: center;
    }

    .image-preview {
        max-width: 100%;
        max-height: 240px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 6px 20px rgba(0,0,0,0.4);
    }
</style>
@section('content')

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

        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            
            <!-- Category Select -->
            <div class="form-group">
                <label for="category_id" class="form-label">Kategori Foto *</label>
                <select name="category_id" id="category_id" class="form-control" style="cursor: pointer;" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Title Field -->
            <div class="form-group">
                <label for="title" class="form-label">Judul / Keterangan Singkat Foto *</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="form-control" 
                    placeholder="Contoh: Sudut Hangat Dekat Jendela" 
                    value="{{ old('title') }}" 
                    required
                >
            </div>

            <!-- Description Field -->
            <div class="form-group">
                <label for="description" class="form-label">Deskripsi Tambahan (Opsional)</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="form-control" 
                    rows="3" 
                    placeholder="Ceritakan kisah di balik foto suasana warkop ini..."
                >{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload Field -->
            <div class="form-group">
                <label class="form-label">Pilih Foto Utama *</label>
                <div class="file-upload-wrapper">
                    <input type="file" name="image" id="imageInput" class="file-upload-input" accept="image/*" required>
                    <div class="file-upload-label" id="uploadLabel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <span id="fileName">Klik atau seret file gambar ke sini (Maksimal 5MB)</span>
                    </div>
                </div>
                
                <div class="image-preview-box" id="previewBox">
                    <img src="" id="imgPreview" class="image-preview" alt="Pratinjau gambar">
                </div>
            </div>

            <!-- Action buttons -->
            <div class="form-actions">
                <a href="{{ route('admin.gallery.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Pajang Foto
                </button>
            </div>
            
        </form>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imageInput');
        const fileName = document.getElementById('fileName');
        const previewBox = document.getElementById('previewBox');
        const imgPreview = document.getElementById('imgPreview');

        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Update label text
                    fileName.textContent = file.name + ' (' + (file.size/1024/1024).toFixed(2) + ' MB)';
                    
                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        imgPreview.src = event.target.result;
                        previewBox.style.display = 'flex';
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileName.textContent = 'Klik atau seret file gambar ke sini (Maksimal 5MB)';
                    previewBox.style.display = 'none';
                    imgPreview.src = '';
                }
            });
        }
    });
</script>
@endsection
