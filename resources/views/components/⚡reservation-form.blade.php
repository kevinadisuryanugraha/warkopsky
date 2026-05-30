<?php

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

new class extends Component
{
    public $name = '';
    public $phone = '';
    public $branch = 'Jatiasih';
    public $pax = 2;
    public $reservation_date = '';
    public $reservation_time = '19:00';
    public $purpose = 'Makan Biasa / Dine In';
    public $note = '';
    
    public $successMessage = '';
    public $whatsappUrl = '';

    public function mount()
    {
        // Default to today's date
        $this->reservation_date = Carbon::today()->format('Y-m-d');
    }

    protected $rules = [
        'name' => 'required|string|min:3|max:50',
        'phone' => 'required|string|min:10|max:15',
        'branch' => 'required|string|in:Jatiasih',
        'pax' => 'required|integer|min:1|max:50',
        'reservation_date' => 'required|date|after_or_equal:today',
        'reservation_time' => 'required|string',
        'purpose' => 'required|string',
        'note' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'name.required' => 'Nama lengkap Anda wajib diisi.',
        'name.min' => 'Nama minimal 3 karakter.',
        'phone.required' => 'Nomor HP/WhatsApp aktif wajib diisi.',
        'phone.min' => 'Nomor HP minimal 10 digit.',
        'phone.max' => 'Nomor HP maksimal 15 digit.',
        'reservation_date.required' => 'Tanggal booking tempat wajib diisi.',
        'reservation_date.after_or_equal' => 'Tanggal booking tidak boleh hari kemarin.',
        'pax.min' => 'Minimal booking untuk 1 orang.',
    ];

    public function reserve()
    {
        $this->validate();

        // Standardize note content: prepend reservation purpose
        $finalNote = "Kebutuhan: " . $this->purpose;
        if ($this->note) {
            $finalNote .= " | Catatan: " . $this->note;
        }

        // 1. Save to MySQL database
        $res = Reservation::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'branch' => $this->branch,
            'pax' => $this->pax,
            'reservation_date' => $this->reservation_date,
            'reservation_time' => $this->reservation_time,
            'note' => $finalNote,
            'status' => 'pending',
        ]);

        // 2. Build Cozy WhatsApp prefills string
        $formattedDate = Carbon::parse($this->reservation_date)->translatedFormat('l, d F Y');
        $message = "Halo Warkop Sky,\n\nSaya mau booking tempat untuk nongkrong:\n"
                 . "- *Nama:* {$this->name}\n"
                 . "- *WhatsApp:* {$this->phone}\n"
                 . "- *Cabang:* Warkop Sky {$this->branch}\n"
                 . "- *Jumlah:* {$this->pax} Orang\n"
                 . "- *Kebutuhan:* {$this->purpose}\n"
                 . "- *Tanggal:* {$formattedDate}\n"
                 . "- *Jam:* {$this->reservation_time} WIB\n";

        if ($this->note) {
            $message .= "- *Catatan:* {$this->note}\n";
        }
        
        $message .= "\nMohon konfirmasi ketersediaan meja ya min. Terima kasih!";

        // Encode to strict wa.me business redirect URL
        $this->whatsappUrl = "https://wa.me/6281385271918?text=" . urlencode($message);
        
        $this->successMessage = 'Booking meja Anda sukses tercatat di buku tamu! Silakan klik tombol kirim WhatsApp di bawah ini untuk mengirimkan detail booking instan ke admin kami.';
        
        // Reset inputs
        $this->reset(['name', 'phone', 'pax', 'note', 'purpose']);
        $this->reservation_date = Carbon::today()->format('Y-m-d');
        $this->reservation_time = '19:00';
        $this->purpose = 'Makan Biasa / Dine In';
    }
};
?>

<div class="card-cabin" style="position: relative; overflow: hidden; padding: var(--spacing-md); border: 1px solid rgba(255, 200, 87, 0.2);">
    <!-- Glowing Edison Lamp Radial Overlay -->
    <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(93,156,236,0.1) 0%, transparent 70%); pointer-events: none; z-index: 1;"></div>

    <h2 style="font-family: var(--font-display); font-size: 1.6rem; color: var(--color-warm-cream); margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="var(--color-warm-gold)" viewBox="0 0 16 16">
            <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
        </svg>
        Amankan Meja Anda
    </h2>
    <p style="font-size: 0.82rem; color: var(--color-muted-text); margin-bottom: var(--spacing-sm); line-height: 1.4;">
        Rencanakan kumpul bareng pacar, teman nongkrong, atau keluarga agar tidak kehabisan meja lesehan favorit Anda.
    </p>

    @if ($successMessage)
        <!-- Upgraded success state -->
        <div class="reservation-success">
            <div class="reservation-success__icon">✓</div>
            <h3 class="reservation-success__title">Reservasi Tercatat!</h3>
            <p class="reservation-success__sub">
                Konfirmasi via WhatsApp agar meja kamu terjamin.
                Tim kami membalas dalam <strong>30 menit</strong>.
            </p>
            <a href="{{ $whatsappUrl }}" 
               target="_blank" 
               class="btn-cta-primary btn-cta-primary--wa"
               style="width: 100%; justify-content: center; box-sizing: border-box;">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 6px; display: inline-block; vertical-align: middle;">
                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.907h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.69-4.86c-.202-.101-1.202-.594-1.387-.662-.185-.069-.32-.103-.454.101-.135.202-.52.662-.637.793-.118.131-.235.148-.437.047a5.535 5.535 0 0 1-1.62-1.002 5.09 5.09 0 0 1-1.12-1.395c-.118-.202-.013-.31.088-.41.09-.09.202-.236.303-.353.101-.118.135-.202.202-.336.069-.135.034-.253-.017-.354-.052-.101-.454-1.1-.623-1.503-.164-.397-.33-.342-.454-.349-.117-.007-.253-.007-.389-.007a.774.774 0 0 0-.559.258c-.185.202-.708.692-.708 1.689 0 .997.724 1.96 1.025 2.366.302.406 1.425 2.176 3.452 3.053.483.208.858.332 1.151.426.486.154.928.132 1.278.08.39-.058 1.202-.492 1.372-.966.17-.474.17-.881.118-.966-.052-.085-.185-.136-.387-.237z"/>
                </svg>
                Konfirmasi via WhatsApp Sekarang
            </a>
            <p class="reservation-success__note">
                Reservasi belum terkonfirmasi tanpa balasan WhatsApp
            </p>
        </div>
    @else

    <form wire:submit.prevent="reserve" style="display: flex; flex-direction: column; gap: var(--spacing-xs); position: relative; z-index: 2;">
        
        <!-- Input: Name -->
        <div class="input-group">
            <label for="name" class="form-label">Nama Lengkap <span style="color: var(--color-warkop-red);">*</span></label>
            <input type="text" id="name" wire:model="name" class="form-input-field" placeholder="Masukkan nama panggilan Anda">
            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <!-- Row: WhatsApp & Pax -->
        <div class="form-row-grid">
            <div class="input-group">
                <label for="phone" class="form-label">No WhatsApp <span style="color: var(--color-warkop-red);">*</span></label>
                <input type="text" id="phone" wire:model="phone" class="form-input-field" placeholder="Contoh: 081385271918">
                @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="pax" class="form-label">Jumlah Pax <span style="color: var(--color-warkop-red);">*</span></label>
                <input type="number" id="pax" wire:model="pax" class="form-input-field" min="1" max="50">
                @error('pax') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Row: Date & Time -->
        <div class="form-row-grid">
            <div class="input-group">
                <label for="res_date" class="form-label">Tanggal Booking <span style="color: var(--color-warkop-red);">*</span></label>
                <input type="date" id="res_date" wire:model="reservation_date" class="form-input-field">
                @error('reservation_date') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="res_time" class="form-label">Jam Booking <span style="color: var(--color-warkop-red);">*</span></label>
                <input type="time" id="res_time" wire:model="reservation_time" class="form-input-field">
                @error('reservation_time') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Input: Purpose / Kebutuhan Reservasi -->
        <div class="input-group">
            <label for="purpose" class="form-label">Kebutuhan Reservasi <span style="color: var(--color-warkop-red);">*</span></label>
            <select id="purpose" wire:model="purpose" class="form-input-field" style="height: 38px; cursor: pointer;">
                <option value="Makan Biasa / Dine In">Makan Biasa / Dine In</option>
                <option value="Ulang Tahun">Ulang Tahun (Birthday Party)</option>
                <option value="Family Gathering">Family Gathering / Arisan</option>
                <option value="Kumpul Komunitas / Kerja">Kumpul Komunitas / Kerja</option>
                <option value="Lainnya">Lainnya (Tulis detail di Catatan)</option>
            </select>
            @error('purpose') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <!-- Input: Note -->
        <div class="input-group">
            <label for="note" class="form-label">Catatan Tambahan <span style="font-size: 0.75rem; color: var(--color-muted-text); font-weight: normal;">(Opsional)</span></label>
            <textarea id="note" wire:model="note" rows="3" class="form-input-field" style="resize: none;" placeholder="Contoh: Tolong pilih lesehan outdoor di sudut dekat pohon ya min..."></textarea>
            @error('note') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Form Button -->
        <button type="submit" class="btn-submit-reserve" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="reserve">Booking Tempat Sekarang</span>
            <span wire:loading wire:target="reserve">Mencatat Reservasi Anda...</span>
        </button>

    </form>
    @endif
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
        border-color: var(--color-warm-gold);
        box-shadow: 0 0 10px rgba(255, 200, 87, 0.15);
    }

    .form-input-field::placeholder {
        color: rgba(255, 255, 255, 0.25);
    }

    /* Premium direct WA CTA button */
    .btn-wa-reserve-direct {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        background: #25d366;
        color: #fff;
        text-decoration: none;
        font-family: var(--font-body);
        font-weight: 800;
        font-size: 0.9rem;
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transition: all var(--duration-fast) var(--easing-smooth);
        text-align: center;
    }

    .btn-wa-reserve-direct:hover {
        background: #20ba5a;
        box-shadow: 0 4px 12px rgba(32, 186, 90, 0.45);
        transform: translateY(-2px);
    }

    /* Action submit button */
    .btn-submit-reserve {
        width: 100%;
        padding: 0.75rem 1rem;
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.92rem;
        border: none;
        border-top-left-radius: 10px;
        border-bottom-right-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 200, 87, 0.25);
        transition: all var(--duration-fast) var(--easing-smooth);
        margin-top: var(--spacing-xs);
    }

    .btn-submit-reserve:hover {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        box-shadow: 0 4px 15px rgba(93, 156, 236, 0.35);
        transform: translateY(-2px);
    }

    .btn-submit-reserve:disabled {
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
