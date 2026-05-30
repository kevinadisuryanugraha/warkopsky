@extends('layouts.admin')

@section('title', 'CRM Reservasi Tamu | Warkop Sky CRM')
@section('page_title', 'CRM Reservasi Tamu')

@section('styles')
<style>
    /* Filter Bar Box */
    .filter-panel-box {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        padding: var(--spacing-md);
        margin-bottom: var(--spacing-md);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .filter-form {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .form-group-filter {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
        min-width: 160px;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--color-muted-text);
        text-transform: uppercase;
        letter-spacing: 0.05em;
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
    }

    .filter-btn-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-filter-submit {
        padding: 0.68rem 1.4rem;
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

    .btn-filter-submit:hover {
        background: var(--color-warm-gold);
    }

    .btn-export-csv {
        padding: 0.68rem 1.4rem;
        background: rgba(255, 200, 87, 0.1);
        border: 1px solid rgba(255, 200, 87, 0.25);
        color: var(--color-warm-gold);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .btn-export-csv:hover {
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        box-shadow: 0 4px 15px rgba(255, 200, 87, 0.15);
    }

    /* Table styles */
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

    .guest-name {
        font-weight: 700;
        font-size: 0.95rem;
    }

    .guest-note {
        font-size: 0.82rem;
        color: var(--color-muted-text);
        margin-top: 8px;
        margin-left: 8px;
        font-style: italic;
        border-left: 2px solid var(--color-warkop-red);
        padding-left: 8px;
        max-width: 250px;
        line-height: 1.45;
    }

    /* Badges */
    .badge-pax {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 0.85rem;
        color: var(--color-warm-cream);
    }

    .badge-status {
        font-size: 0.75rem;
        font-weight: 800;
        padding: 4px 10px;
        border-top-left-radius: 6px;
        border-bottom-right-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    .badge-status--pending {
        background: rgba(255, 200, 87, 0.1);
        color: var(--color-warm-gold);
        border: 1px solid rgba(255, 200, 87, 0.2);
    }

    .badge-status--confirmed {
        background: rgba(93, 156, 236, 0.1);
        color: var(--color-sky-blue);
        border: 1px solid rgba(93, 156, 236, 0.2);
    }

    .badge-status--cancelled {
        background: rgba(230, 57, 70, 0.15);
        color: var(--color-warkop-red);
        border: 1px solid rgba(230, 57, 70, 0.2);
    }

    /* Small Actions Button group */
    .table-actions {
        display: flex;
        gap: 6px;
    }

    .btn-action-small {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-bounce);
        color: var(--color-midnight-bg);
        text-decoration: none;
    }

    .btn-action-small--approve {
        background: var(--color-sky-blue);
    }

    .btn-action-small--approve:hover {
        background: var(--color-warm-gold);
        transform: scale(1.1);
    }

    .btn-action-small--reject {
        background: rgba(230, 57, 70, 0.15);
        color: var(--color-warkop-red);
        border: 1px solid rgba(230, 57, 70, 0.2);
    }

    .btn-action-small--reject:hover {
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        transform: scale(1.1);
    }

    .btn-action-small--delete {
        background: rgba(255, 255, 255, 0.02);
        color: var(--color-muted-text);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .btn-action-small--delete:hover {
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        border-color: var(--color-warkop-red);
        transform: scale(1.1);
    }

    .btn-action-small--whatsapp {
        background: #25D366;
        color: white;
    }

    .btn-action-small--whatsapp:hover {
        background: #128C7E;
        transform: scale(1.1);
    }

    /* Custom CSS Pagination */
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
</style>
@section('content')

    <!-- Search and filter dynamic panel -->
    <div class="filter-panel-box">
        <form action="{{ route('admin.reservations.index') }}" method="GET" class="filter-form">
            
            <!-- Status filter -->
            <div class="form-group-filter">
                <label class="filter-label">Status Moderasi</label>
                <select name="status" class="form-filter-input" style="cursor: pointer;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Tertunda (Pending)</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Disetujui (Confirmed)</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="form-group-filter">
                <label class="filter-label">Dari Tanggal</label>
                <input 
                    type="date" 
                    name="start_date" 
                    class="form-filter-input" 
                    value="{{ request('start_date') }}"
                >
            </div>

            <!-- End Date -->
            <div class="form-group-filter">
                <label class="filter-label">Sampai Tanggal</label>
                <input 
                    type="date" 
                    name="end_date" 
                    class="form-filter-input" 
                    value="{{ request('end_date') }}"
                >
            </div>

            <!-- Actions buttons group -->
            <div class="filter-btn-group">
                <button type="submit" class="btn-filter-submit">Filter</button>
                
                @if(request('status') || request('start_date') || request('end_date'))
                    <a href="{{ route('admin.reservations.index') }}" class="form-filter-input" style="text-decoration: none; background: rgba(230, 57, 70, 0.1); border-color: rgba(230, 57, 70, 0.2); color: var(--color-warkop-red); text-align: center;">
                        Reset
                    </a>
                @endif
                
                <!-- CSV export passing the exact filtered params -->
                @php
                    $csvParams = request()->all();
                    $csvParams['export'] = 'csv';
                    $csvUrl = route('admin.reservations.index', $csvParams);
                @endphp
                <a href="{{ $csvUrl }}" class="btn-export-csv" title="Ekspor data CSV ke Excel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Unduh CSV
                </a>
            </div>

        </form>
    </div>

    <!-- Reservations Listing Table -->
    <div class="admin-table-box">
        <table class="admin-table datatable">
            <thead>
                <tr>
                    <th>Tamu</th>
                    <th>Cabang</th>
                    <th style="width: 80px; text-align: center;">Pax</th>
                    <th>Jadwal Reservasi</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $res)
                    <tr>
                        <td>
                            <div class="guest-name">{{ $res->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--color-sky-blue); font-family: var(--font-body); margin-top: 2px;">
                                📞 {{ $res->phone }}
                            </div>
                            @if($res->note)
                                <div class="guest-note" title="Catatan Tambahan">
                                    "{{ $res->note }}"
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge-category">{{ $res->branch }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-pax">{{ $res->pax }}</span>
                        </td>
                        <td>
                            <div style="font-weight: 700;">
                                📅 {{ \Carbon\Carbon::parse($res->reservation_date)->translatedFormat('d F Y') }}
                            </div>
                            <div style="font-size: 0.8rem; color: var(--color-muted-text); margin-top: 2px;">
                                ⏰ Jam {{ $res->reservation_time }} WIB
                            </div>
                        </td>
                        <td>
                            <span class="badge-status badge-status--{{ $res->status }}">{{ $res->status }}</span>
                        </td>
                        <td style="font-size: 0.78rem; color: var(--color-muted-text);">
                            {{ $res->created_at->translatedFormat('d M H:i') }}
                        </td>
                        <td style="text-align: center;">
                            <div class="table-actions">
                                
                                @if($res->status === 'pending')
                                    <!-- Approve booking -->
                                    <form action="{{ route('admin.reservations.updateStatus', $res->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn-action-small btn-action-small--approve" title="Setujui Reservasi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </button>
                                    </form>
 
                                    <!-- Reject/Cancel booking -->
                                    <form action="{{ route('admin.reservations.updateStatus', $res->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn-action-small btn-action-small--reject" title="Batalkan Reservasi" onclick="return confirm('Apakah Anda yakin mau membatalkan reservasi Kak {{ $res->name }}?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
 
                                <!-- WhatsApp Redirection URL Helper with country code WA API format -->
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $res->phone);
                                    if (str_starts_with($cleanPhone, '08')) {
                                        $cleanPhone = '628' . substr($cleanPhone, 2);
                                    }
                                    
                                    $indonesianDate = \Carbon\Carbon::parse($res->reservation_date)->translatedFormat('d F Y');
                                    
                                    $message = "Halo Kak " . $res->name . ", kami dari pengelola Warkop Sky ingin mengonfirmasi reservasi meja Kakak untuk jadwal:\n\n";
                                    $message .= "📅 Tanggal: " . $indonesianDate . "\n";
                                    $message .= "⏰ Jam: " . $res->reservation_time . " WIB\n";
                                    $message .= "👥 Jumlah Tamu: " . $res->pax . " Orang\n";
                                    $message .= "📍 Cabang: " . $res->branch . "\n\n";
                                    
                                    if ($res->status === 'confirmed') {
                                        $message .= "Status booking Kakak sudah KAMI SETUJUI (CONFIRMED) dan meja telah dipersiapkan. Ditunggu kedatangannya ya Kak! ☕🌟";
                                    } else {
                                        $message .= "Apakah data jadwal di atas sudah sesuai dan benar Kak? Mohon konfirmasinya ya. Terima kasih! 🙏☕";
                                    }
                                    
                                    $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($message);
                                @endphp
                                <a href="{{ $waUrl }}" target="_blank" class="btn-action-small btn-action-small--whatsapp" title="Hubungi via WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.907h.004c4.368 0 7.926-3.559 7.93-7.93a7.897 7.897 0 0 0-2.327-5.615zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.69-4.98c-.202-.1-1.194-.588-1.378-.654-.185-.066-.32-.1-.452.1-.132.2-.508.648-.624.782-.115.134-.233.15-.436.05-.204-.1-.859-.315-1.637-1.012-.604-.539-1.013-1.207-1.132-1.412-.119-.205-.013-.316.088-.417.09-.09.2-.21.3-.316.098-.105.13-.18.196-.299.066-.12.033-.223-.017-.323-.05-.1-452-1.09-.619-1.492-.162-.394-.34-.34-.496-.346-.129-.006-.277-.008-.425-.008-.149 0-.39.055-.595.277-.205.223-.782.764-.782 1.861 0 1.098.798 2.158.91 2.308.112.15 1.564 2.388 3.79 3.35 1.258.544 1.884.665 2.544.566.368-.055 1.194-.487 1.362-.958.168-.47.168-.874.118-.958-.05-.084-.185-.132-.387-.232z"/>
                                    </svg>
                                </a>
 
                                <!-- Delete reservation record -->
                                <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin mau menghapus data reservasi ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-small btn-action-small--delete" title="Hapus Permanen">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
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
