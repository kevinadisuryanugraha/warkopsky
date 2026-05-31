@extends('layouts.admin')

@section('title', isset($event) ? 'Edit Event | Warkop Sky CRM' : 'Tambah Event | Warkop Sky CRM')
@section('page_title', isset($event) ? 'Edit Event' : 'Tambah Event Baru')

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
        max-width: 800px;
        margin: 0 auto;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group-full {
        grid-column: span 2;
    }

    @media (max-width: 768px) {
        .form-group-full {
            grid-column: span 1;
        }
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
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        color: var(--color-warm-cream);
        font-family: var(--font-body);
        font-size: 0.95rem;
        transition: all var(--duration-fast) var(--easing-smooth);
        outline: none;
    }

    .form-control:focus {
        border-color: var(--color-sky-blue);
        background: rgba(7, 11, 20, 0.8);
        box-shadow: 0 0 0 3px rgba(93, 156, 236, 0.15);
    }

    .form-control option {
        background: var(--color-midnight-bg);
        color: var(--color-warm-cream);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-error {
        color: var(--color-warkop-red);
        font-size: 0.8rem;
        margin-top: 6px;
        display: block;
        font-weight: 600;
    }

    .form-hint {
        color: var(--color-muted-text);
        font-size: 0.75rem;
        margin-top: 6px;
        display: block;
    }

    /* Toggle switch for is_featured */
    .toggle-container {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 4px;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.1);
        transition: .4s;
        border-radius: 34px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 3px;
        background-color: var(--color-muted-text);
        transition: .3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        border-radius: 50%;
    }

    input:checked + .toggle-slider {
        background-color: rgba(212, 175, 55, 0.2);
        border-color: rgba(212, 175, 55, 0.4);
    }

    input:checked + .toggle-slider:before {
        transform: translateX(24px);
        background-color: var(--color-warm-gold);
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }

    .toggle-label-text {
        font-size: 0.9rem;
        color: var(--color-warm-cream);
        font-weight: 500;
    }

    /* File Upload area */
    .file-upload-area {
        border: 2px dashed rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-smooth);
        background: rgba(255, 255, 255, 0.02);
        position: relative;
    }

    .file-upload-area:hover, .file-upload-area.dragover {
        border-color: var(--color-sky-blue);
        background: rgba(93, 156, 236, 0.05);
    }

    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .preview-container {
        margin-top: 1rem;
        display: none; /* hidden by default */
        text-align: center;
    }
    .preview-container.active { display: block; }

    .preview-image {
        max-width: 160px;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .btn-cancel {
        padding: 0.75rem 1.5rem;
        background: transparent;
        color: var(--color-muted-text);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 700;
        transition: all var(--duration-fast);
    }

    .btn-cancel:hover {
        color: var(--color-warm-cream);
        background: rgba(255, 255, 255, 0.05);
    }

    .btn-save {
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, var(--color-warm-gold), #b8860b);
        color: var(--color-midnight-bg);
        border: none;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-bounce);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
    }
</style>
@endsection

@section('content')

{{-- Back link --}}
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.events.index') }}" style="color: var(--color-sky-blue); text-decoration: none; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Kembali ke Daftar Events
    </a>
</div>

<div class="form-panel">
    <form
        action="{{ isset($event) ? route('admin.events.update', $event->id) : route('admin.events.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @isset($event) @method('PUT') @endisset

        <div class="form-grid">
            {{-- Judul Event --}}
            <div class="form-group-full">
                <label class="form-label">Judul Event <span style="color:var(--color-warkop-red)">*</span></label>
                <input type="text" name="title" class="form-control"
                       placeholder="Contoh: NOBAR Final Liga Champions — PSG vs Arsenal"
                       value="{{ old('title', $event->title ?? '') }}" required>
                @error('title') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label class="form-label">Kategori <span style="color:var(--color-warkop-red)">*</span></label>
                <select name="category" class="form-control" required>
                    <option value="">— Pilih Kategori —</option>
                    @php
                        $categories = [
                            'nobar'         => '🔴 NOBAR (Nonton Bareng)',
                            'live_music'    => '🎵 Live Music',
                            'special_event' => '🔥 Special Event',
                            'promo'         => '💰 Promo / Diskon',
                            'tournament'    => '🏆 Tournament / Kompetisi',
                            'lainnya'       => '📌 Lainnya',
                        ];
                    @endphp
                    @foreach($categories as $val => $label)
                        <option value="{{ $val }}"
                            {{ old('category', $event->category ?? '') === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('category') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="form-label">Status <span style="color:var(--color-warkop-red)">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="upcoming"  {{ old('status', $event->status ?? 'upcoming') === 'upcoming'  ? 'selected' : '' }}>📅 Akan Datang</option>
                    <option value="ongoing"   {{ old('status', $event->status ?? '') === 'ongoing'   ? 'selected' : '' }}>🟢 Sedang Berlangsung</option>
                    <option value="completed" {{ old('status', $event->status ?? '') === 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="cancelled" {{ old('status', $event->status ?? '') === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
                @error('status') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Tanggal Event --}}
            <div>
                <label class="form-label">Tanggal Event <span style="color:var(--color-warkop-red)">*</span></label>
                <input type="date" name="event_date" class="form-control"
                       value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d') : '') }}" required>
                @error('event_date') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Jam Mulai --}}
            <div>
                <label class="form-label">Jam Mulai <span style="color:var(--color-warkop-red)">*</span></label>
                <input type="time" name="event_time_start" class="form-control"
                       value="{{ old('event_time_start', $event->event_time_start ?? '') }}" required>
                @error('event_time_start') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Lokasi --}}
            <div>
                <label class="form-label">Lokasi / Cabang <span style="color:var(--color-warkop-red)">*</span></label>
                <input type="text" name="location" class="form-control"
                       placeholder="Contoh: Warkop Sky Bekasi — Jatiasih"
                       value="{{ old('location', $event->location ?? 'Warkop Sky') }}" required>
                @error('location') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Jam Selesai --}}
            <div>
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="event_time_end" class="form-control"
                       value="{{ old('event_time_end', $event->event_time_end ?? '') }}">
                <span class="form-hint">Kosongkan jika acara berlangsung hingga selesai/bebas.</span>
                @error('event_time_end') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="form-group-full">
                <label class="form-label">Deskripsi Event</label>
                <textarea name="description" class="form-control"
                    placeholder="Ceritakan detail event: apa yang akan terjadi, siapa yang bisa datang, promo apa yang ada...">{{ old('description', $event->description ?? '') }}</textarea>
                @error('description') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Poster Upload --}}
            <div class="form-group-full">
                <label class="form-label">Poster / Gambar Event</label>
                <span class="form-hint" style="margin-bottom: 10px; margin-top: -4px;">Format yang didukung: JPG, PNG, WebP (Max 5MB). Gambar akan dikompres otomatis ke WebP.</span>
                
                <div class="file-upload-area" id="posterDropZone">
                    <input type="file" name="poster_image" class="file-upload-input" id="posterInput" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewPoster(this)">
                    
                    <div style="font-size: 2rem; margin-bottom: 8px; opacity: 0.5;">🖼️</div>
                    <div style="font-size: 0.95rem; color: var(--color-warm-cream); font-weight: 500;">Klik atau seret gambar ke area ini</div>
                    
                    {{-- Current Preview --}}
                    <div class="preview-container {{ isset($event) && $event->poster_image ? 'active' : '' }}" id="previewContainer">
                        @if(isset($event) && $event->poster_image)
                            <img id="posterPreview" src="{{ asset($event->poster_image) }}" alt="Poster saat ini" class="preview-image">
                            <p style="font-size:0.8rem; color:var(--color-muted-text); margin-top:8px;">Gambar yang ada saat ini</p>
                        @else
                            <img id="posterPreview" src="" alt="Preview" class="preview-image" style="display:none;">
                        @endif
                    </div>
                </div>
                @error('poster_image') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            {{-- Featured Toggle --}}
            <div class="form-group-full" style="padding: 10px 0;">
                <label class="form-label">Tampilkan di Beranda (Featured)</label>
                <div class="toggle-container">
                    <label class="toggle-switch">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label-text">Event ini akan ditampilkan dan disorot di halaman publik (Website Utama)</span>
                </div>
            </div>

        </div>{{-- end form-grid --}}

        <div class="form-actions">
            <a href="{{ route('admin.events.index') }}" class="btn-cancel">Batalkan</a>
            <button type="submit" class="btn-save">
                {{ isset($event) ? 'Simpan Perubahan' : 'Tambah Event Baru' }}
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function previewPoster(input) {
    const previewContainer = document.getElementById('previewContainer');
    const preview = document.getElementById('posterPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            previewContainer.classList.add('active');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag & drop visual
const dz = document.getElementById('posterDropZone');
if (dz) {
    dz.addEventListener('dragover', (e) => {
        e.preventDefault();
        dz.classList.add('dragover');
    });
    dz.addEventListener('dragleave', () => {
        dz.classList.remove('dragover');
    });
    dz.addEventListener('drop', (e) => {
        e.preventDefault();
        dz.classList.remove('dragover');
        
        // Manual assign files to input
        if (e.dataTransfer.files.length) {
            document.getElementById('posterInput').files = e.dataTransfer.files;
            previewPoster(document.getElementById('posterInput'));
        }
    });
}
</script>
@endsection
