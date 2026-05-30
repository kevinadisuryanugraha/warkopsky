<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CustomerStory;
use Illuminate\Support\Str;

new class extends Component
{
    use WithFileUploads;

    public $author = '';
    public $instagram_handle = '';
    public $quote = '';
    public $text = '';
    public $rating = 5;
    public $media = null;
    
    public $successMessage = '';

    protected $rules = [
        'author' => 'required|string|min:3|max:50',
        'instagram_handle' => 'nullable|string|max:30',
        'quote' => 'required|string|min:5|max:100',
        'text' => 'required|string|min:10|max:1000',
        'rating' => 'required|integer|min:1|max:5',
        'media' => 'nullable|file|max:51200|mimes:jpg,jpeg,png,webp,mp4,mov,quicktime',
    ];

    protected $messages = [
        'author.required' => 'Nama panggilan Anda wajib diisi.',
        'author.min' => 'Nama panggilan minimal 3 karakter.',
        'quote.required' => 'Judul singkat ulasan wajib diisi.',
        'quote.min' => 'Judul singkat ulasan minimal 5 karakter.',
        'text.required' => 'Ulasan lengkap Anda wajib diisi.',
        'text.min' => 'Ulasan lengkap minimal 10 karakter.',
        'media.max' => 'Ukuran file maksimal adalah 50MB.',
        'media.mimes' => 'Format file harus berupa gambar (JPG, PNG, WebP) atau video (MP4, MOV).',
    ];

    public function submit()
    {
        $this->validate();

        $mediaPath = null;
        $mediaType = 'none';

        if ($this->media) {
            $extension = strtolower($this->media->getClientOriginalExtension());
            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
            $isVideo = in_array($extension, ['mp4', 'mov', 'quicktime']);

            // Create target directory if it doesn't exist
            $targetDir = storage_path('app/public/optimized');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $fileName = Str::random(40);

            if ($isImage) {
                $mediaType = 'image';
                $destPath = $targetDir . '/' . $fileName . '.webp';
                
                // Process image auto-conversion to WebP and max 800px width limit using GD
                $tempPath = $this->media->getRealPath();
                $image = null;

                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                        $image = @imagecreatefromjpeg($tempPath);
                        break;
                    case 'png':
                        $image = @imagecreatefrompng($tempPath);
                        break;
                    case 'webp':
                        $image = @imagecreatefromwebp($tempPath);
                        break;
                }

                if ($image) {
                    $width = imagesx($image);
                    $height = imagesy($image);
                    $maxWidth = 800;

                    if ($width > $maxWidth) {
                        $newWidth = $maxWidth;
                        $newHeight = floor($height * ($maxWidth / $width));
                        
                        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                        // Maintain transparency for PNGs
                        if ($extension === 'png') {
                            imagealphablending($resizedImage, false);
                            imagesavealpha($resizedImage, true);
                        }
                        imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagewebp($resizedImage, $destPath, 85);
                        imagedestroy($resizedImage);
                    } else {
                        imagewebp($image, $destPath, 85);
                    }
                    imagedestroy($image);
                    $mediaPath = $fileName . '.webp';
                } else {
                    // Fallback to simple upload if GD fails
                    $uploadedPath = $this->media->store('optimized', 'public');
                    $mediaPath = basename($uploadedPath);
                }
            } elseif ($isVideo) {
                $mediaType = 'video';
                $storedFile = $this->media->storeAs('optimized', $fileName . '.' . $extension, 'public');
                $mediaPath = basename($storedFile);
            }
        }

        CustomerStory::create([
            'author' => $this->author,
            'instagram_handle' => $this->instagram_handle ? ltrim($this->instagram_handle, '@') : null,
            'quote' => $this->quote,
            'text' => $this->text,
            'rating' => $this->rating,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'status' => 'pending', // Moderate first
        ]);

        $this->successMessage = 'Terima kasih banyak! Cerita Anda telah dikirim ke dapur admin dan akan segera muncul setelah disetujui.';
        $this->reset(['author', 'instagram_handle', 'quote', 'text', 'rating', 'media']);
    }
};
?>

<div class="card-cabin" style="position: relative; overflow: hidden; padding: var(--spacing-md); border: 1px solid rgba(93,156,236,0.15);">
    <!-- Glowing Edison overlay in the corner -->
    <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,200,87,0.15) 0%, transparent 70%); pointer-events: none; z-index: 1;"></div>

    <h2 style="font-family: var(--font-display); font-size: 1.6rem; color: var(--color-warm-cream); margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="var(--color-sky-blue)" viewBox="0 0 16 16">
            <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
        </svg>
        Spill Ulasan Anda
    </h2>
    <p style="font-size: 0.82rem; color: var(--color-muted-text); margin-bottom: var(--spacing-sm); line-height: 1.4;">
        Bagikan keseruan nongkrong Anda di Warkop Sky. Ulasan terbaik akan kami pajang di halaman depan!
    </p>

    @if ($successMessage)
        <!-- Beautiful Cozy Toast Alert -->
        <div style="background: rgba(93, 156, 236, 0.15); border: 1px solid var(--color-sky-blue); color: var(--color-warm-cream); padding: var(--spacing-sm); border-radius: 12px; font-size: 0.88rem; margin-bottom: var(--spacing-md); line-height: 1.5; display: flex; gap: 10px; align-items: flex-start;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--color-sky-blue)" viewBox="0 0 16 16" style="flex-shrink: 0; margin-top: 2px;">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div>
                <strong>Berhasil!</strong> {{ $successMessage }}
            </div>
        </div>
    @endif

    <form wire:submit.prevent="submit" style="display: flex; flex-direction: column; gap: var(--spacing-xs); position: relative; z-index: 2;">
        
        <!-- Row: Author & Instagram -->
        <div class="form-row-grid">
            <div class="input-group">
                <label for="author" class="form-label">Nama Panggilan <span style="color: var(--color-warkop-red);">*</span></label>
                <input type="text" id="author" wire:model="author" class="form-input-field" placeholder="Contoh: Wynne, Jefri">
                @error('author') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            
            <div class="input-group">
                <label for="instagram" class="form-label">Instagram Handle</label>
                <div style="position: relative; display: flex; align-items: center;">
                    <span style="position: absolute; left: 12px; color: var(--color-muted-text); font-size: 0.85rem;">@</span>
                    <input type="text" id="instagram" wire:model="instagram_handle" class="form-input-field" style="padding-left: 28px;" placeholder="username">
                </div>
                @error('instagram_handle') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Rating Stars Selector -->
        <div class="input-group">
            <label class="form-label">Bintang Kenyamanan <span style="color: var(--color-warkop-red);">*</span></label>
            <div class="star-rating-selector">
                @for ($i = 1; $i <= 5; $i++)
                    <button 
                        type="button" 
                        wire:click="$set('rating', {{ $i }})" 
                        class="star-btn {{ $rating >= $i ? 'active' : '' }}"
                        aria-label="Pilih {{ $i }} Bintang"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                    </button>
                @endfor
                <span style="font-size: 0.8rem; color: var(--color-warm-gold); font-weight: 700; margin-left: 8px;">
                    ({{ $rating }} / 5)
                </span>
            </div>
            @error('rating') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <!-- Quote / Short Catchy headline -->
        <div class="input-group">
            <label for="quote" class="form-label">Judul Singkat Ulasan <span style="color: var(--color-warkop-red);">*</span></label>
            <input type="text" id="quote" wire:model="quote" class="form-input-field" placeholder="Contoh: Kopi Bakar & Tahu Lada Garam-nya Juara!">
            @error('quote') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <!-- Review Text -->
        <div class="input-group">
            <label for="text" class="form-label">Ulasan Lengkap <span style="color: var(--color-warkop-red);">*</span></label>
            <textarea id="text" wire:model="text" rows="4" class="form-input-field" style="resize: none;" placeholder="Bagikan cerita seru Anda, pelayanan warkop kami, suasana lesehannya, atau rasa menunya..."></textarea>
            @error('text') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <!-- Drag & Drop Media Upload Area -->
        <div class="input-group">
            <label class="form-label">Media Keseruan (Foto/Video) <span style="font-size: 0.75rem; color: var(--color-muted-text); font-weight: normal;">- Maks 50MB (Opsional)</span></label>
            <div 
                class="drag-drop-area {{ $media ? 'has-file' : '' }}"
                onclick="document.getElementById('mediaInput').click()"
            >
                <input 
                    type="file" 
                    id="mediaInput" 
                    wire:model="media" 
                    style="display: none;" 
                    accept="image/*,video/mp4,video/quicktime"
                >
                
                @if ($media)
                    <div class="file-preview-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="var(--color-sky-blue)" viewBox="0 0 16 16">
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1v14h10V1h-10z"/>
                            <path d="M4 2h8v2H4V2zm0 3h8v1H4V5zm0 2h8v1H4V7zm0 2h8v1H4V9zm0 2h8v1H4v-1zm0 2h5v1H4v-1z"/>
                        </svg>
                        <div style="text-align: left;">
                            <p style="font-size: 0.85rem; font-weight: 700; color: var(--color-warm-cream); word-break: break-all;">
                                {{ $media->getClientOriginalName() }}
                            </p>
                            <p style="font-size: 0.72rem; color: var(--color-muted-text);">
                                {{ round($media->getSize() / 1024 / 1024, 2) }} MB • Terpilih
                            </p>
                        </div>
                    </div>
                @else
                    <div class="drag-drop-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="var(--color-muted-text)" viewBox="0 0 16 16" style="opacity: 0.5; margin-bottom: 6px;">
                            <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            <path fill-rule="evenodd" d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                        </svg>
                        <p style="font-size: 0.85rem; font-weight: 600; color: var(--color-warm-cream);">
                            Klik untuk unggah foto/video nongkrong
                        </p>
                        <p style="font-size: 0.72rem; color: var(--color-muted-text); margin-top: 2px;">
                            Mendukung JPG, PNG, WebP, MP4, MOV (Maksimal 50MB)
                        </p>
                    </div>
                @endif
                
                <!-- Livewire upload spinner shimmer pulse -->
                <div wire:loading wire:target="media" class="upload-progress-overlay">
                    <div class="pulse-shimmer" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; color: var(--color-sky-blue);">
                        Mengunggah media ulasan...
                    </div>
                </div>
            </div>
            @error('media') <span class="error-msg" style="margin-top: 4px;">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit-cozy" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Kirim Cerita Nongkrong</span>
            <span wire:loading wire:target="submit">Memproses Ulasan Anda...</span>
        </button>

    </form>
</div>

<style>
    /* Cozy Form Grid styling */
    .form-row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-sm);
    }

    @media (max-width: 576px) {
        .form-row-grid {
            grid-template-columns: 1fr;
            gap: var(--spacing-xs);
        }
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        text-align: left;
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-warm-cream);
        letter-spacing: 0.02em;
    }

    .form-input-field {
        width: 100%;
        padding: 0.65rem 0.85rem;
        background: rgba(10, 15, 29, 0.7);
        border: 1px solid rgba(93, 156, 236, 0.2);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        color: var(--color-warm-cream);
        font-family: var(--font-body);
        font-size: 0.88rem;
        outline: none;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .form-input-field:focus {
        border-color: var(--color-sky-blue);
        box-shadow: 0 0 10px rgba(93, 156, 236, 0.15);
    }

    .form-input-field::placeholder {
        color: rgba(255, 255, 255, 0.25);
    }

    /* Star Selector buttons */
    .star-rating-selector {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    .star-btn {
        background: transparent;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 0;
        color: rgba(255, 255, 255, 0.15);
        transition: color var(--duration-fast) var(--easing-smooth),
                    transform var(--duration-fast) var(--easing-bounce);
    }

    .star-btn:hover {
        transform: scale(1.18);
    }

    .star-btn.active {
        color: var(--color-warm-gold);
        filter: drop-shadow(0 0 6px rgba(255, 200, 87, 0.4));
    }

    /* Drag & Drop File Styling */
    .drag-drop-area {
        position: relative;
        width: 100%;
        min-height: 110px;
        background: rgba(10, 15, 29, 0.4);
        border: 2px dashed rgba(93, 156, 236, 0.2);
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--spacing-sm);
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-smooth);
        overflow: hidden;
    }

    .drag-drop-area:hover {
        border-color: var(--color-sky-blue);
        background: rgba(16, 24, 48, 0.4);
    }

    .drag-drop-area.has-file {
        border-color: var(--color-warm-gold);
        background: rgba(255, 200, 87, 0.05);
    }

    .drag-drop-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .file-preview-box {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        width: 100%;
        max-width: 400px;
    }

    .upload-progress-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 15, 29, 0.9);
        z-index: 5;
    }

    /* Pulse shimmer loader */
    .pulse-shimmer {
        animation: pulseBrand 1.5s ease-in-out infinite;
    }

    @keyframes pulseBrand {
        0%, 100% { opacity: 0.6; }
        50% { opacity: 1; }
    }

    /* Action submit button */
    .btn-submit-cozy {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.92rem;
        border: none;
        border-top-left-radius: 10px;
        border-bottom-right-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(93, 156, 236, 0.25);
        transition: all var(--duration-fast) var(--easing-smooth);
        margin-top: var(--spacing-xs);
    }

    .btn-submit-cozy:hover {
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        box-shadow: 0 4px 15px rgba(255, 200, 87, 0.35);
        transform: translateY(-2px);
    }

    .btn-submit-cozy:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .error-msg {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--color-warkop-red);
        text-align: left;
    }
</style>
