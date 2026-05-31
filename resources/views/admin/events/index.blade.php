@extends('layouts.admin')

@section('title', 'Manajemen Events | Warkop Sky CRM')
@section('page_title', 'Manajemen Events')

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

    .btn-add-event {
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

    .btn-add-event:hover {
        background: #d62828;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.35);
        color: var(--color-warm-cream);
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

    /* Poster thumbnail */
    .poster-thumb {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background: rgba(7, 11, 20, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .poster-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: rgba(93, 156, 236, 0.06);
        border: 1px solid rgba(93, 156, 236, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-sky-blue);
        font-size: 1rem;
        font-weight: 800;
    }

    /* Category badges */
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

    .badge-nobar      { color: #f87171; border-color: rgba(220,38,38,0.3); background: rgba(220,38,38,0.08); }
    .badge-live       { color: #a78bfa; border-color: rgba(139,92,246,0.3); background: rgba(139,92,246,0.08); }
    .badge-special    { color: #fb923c; border-color: rgba(251,146,60,0.3); background: rgba(251,146,60,0.08); }
    .badge-promo      { color: #4ade80; border-color: rgba(34,197,94,0.3); background: rgba(34,197,94,0.08); }
    .badge-tournament { color: #facc15; border-color: rgba(234,179,8,0.3); background: rgba(234,179,8,0.08); }
    .badge-lainnya    { color: #94a3b8; border-color: rgba(148,163,184,0.3); background: rgba(148,163,184,0.08); }

    /* Status badges */
    .status-upcoming   { color: #60a5fa; }
    .status-ongoing    { color: #4ade80; }
    .status-completed  { color: #64748b; }
    .status-cancelled  { color: #f87171; }

    .bullet-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 4px;
    }
    .bullet-dot--blue  { background: #60a5fa; box-shadow: 0 0 8px #60a5fa; }
    .bullet-dot--green { background: #4ade80; box-shadow: 0 0 8px #4ade80; }
    .bullet-dot--gray  { background: #64748b; box-shadow: 0 0 8px #64748b; }
    .bullet-dot--red   { background: #f87171; box-shadow: 0 0 8px #f87171; }

    /* Featured star */
    .badge-fav {
        color: var(--color-warm-gold);
        text-shadow: 0 0 8px rgba(255, 200, 87, 0.4);
        font-size: 1rem;
    }

    /* Actions */
    .table-actions {
        display: flex;
        gap: 8px;
    }

    .btn-action-small {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-edit {
        background: rgba(93, 156, 236, 0.1);
        border: 1px solid rgba(93, 156, 236, 0.2);
        color: var(--color-sky-blue);
    }
    .btn-edit:hover { background: var(--color-sky-blue); color: var(--color-midnight-bg); }

    .btn-delete {
        background: rgba(230, 57, 70, 0.1);
        border: 1px solid rgba(230, 57, 70, 0.2);
        color: var(--color-warkop-red);
    }
    .btn-delete:hover { background: var(--color-warkop-red); color: #fff; }

    /* Premium DataTables Overrides */
    .dataTables_wrapper {
        padding: 0;
        color: var(--color-warm-cream);
        font-family: var(--font-body);
    }
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        padding: 1.25rem 1.25rem 0.5rem;
        color: var(--color-muted-text);
        font-size: 0.85rem;
    }
    .dataTables_wrapper .dataTables_length select {
        background: rgba(16, 24, 48, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--color-warm-cream);
        padding: 4px 8px;
        border-radius: 6px;
        outline: none;
    }
    .dataTables_wrapper .dataTables_filter input {
        background: rgba(16, 24, 48, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--color-warm-cream);
        padding: 6px 12px;
        border-radius: 6px;
        margin-left: 8px;
        outline: none;
        transition: border-color 0.2s;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--color-sky-blue);
    }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        padding: 1rem 1.25rem;
        color: var(--color-muted-text) !important;
        font-size: 0.85rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: var(--color-muted-text) !important;
        border: 1px solid transparent !important;
        background: transparent !important;
        border-radius: 6px;
        padding: 0.3rem 0.8rem;
        margin: 0 2px;
        cursor: pointer;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: var(--color-warm-cream) !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: var(--color-midnight-bg) !important;
        background: var(--color-warm-gold) !important;
        border: 1px solid var(--color-warm-gold) !important;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<div class="action-header-bar">
    <div>
        <p style="color: var(--color-muted-text); font-size: 0.9rem; margin: 0;">
            Kelola seluruh agenda &amp; acara Warkop Sky — NOBAR, Live Music, Special Event, Promo, dan lainnya.
        </p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="btn-add-event">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Event Baru
    </a>
</div>

<div class="admin-table-box">
    <table id="eventsTable" class="admin-table" style="width:100%">
        <thead>
            <tr>
                <th>Poster</th>
                <th>Judul Event</th>
                <th>Kategori</th>
                <th>Tanggal &amp; Jam</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Featured</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                {{-- Poster --}}
                <td>
                    @if($event->poster_image)
                        <img src="{{ asset($event->poster_image) }}" alt="{{ $event->title }}" class="poster-thumb">
                    @else
                        <div class="poster-placeholder">
                            {{ match($event->category) {
                                'nobar'         => '📺',
                                'live_music'    => '🎵',
                                'special_event' => '🔥',
                                'promo'         => '💰',
                                'tournament'    => '🏆',
                                default         => '🎉',
                            } }}
                        </div>
                    @endif
                </td>

                {{-- Judul --}}
                <td style="font-weight: 700; max-width: 200px;">
                    {{ $event->title }}
                </td>

                {{-- Kategori --}}
                <td>
                    @php
                        $catBadgeColor = match($event->category) {
                            'nobar'         => 'badge-nobar',
                            'live_music'    => 'badge-live',
                            'special_event' => 'badge-special',
                            'promo'         => 'badge-promo',
                            'tournament'    => 'badge-tournament',
                            default         => 'badge-lainnya',
                        };
                    @endphp
                    <span class="badge-category {{ $catBadgeColor }}">
                        {{ $event->category_label }}
                    </span>
                </td>

                {{-- Tanggal & Jam --}}
                <td style="white-space: nowrap; font-size: 0.82rem; color: var(--color-muted-text);">
                    <div style="color: var(--color-warm-cream); font-weight: 600;">{{ $event->event_date->translatedFormat('d M Y') }}</div>
                    <div>{{ $event->formatted_time }}</div>
                </td>

                {{-- Lokasi --}}
                <td style="font-size: 0.85rem; color: var(--color-muted-text);">
                    {{ $event->location }}
                </td>

                {{-- Status --}}
                <td>
                    @php
                        $statusClass = match($event->status) {
                            'upcoming'  => 'status-upcoming',
                            'ongoing'   => 'status-ongoing',
                            'completed' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                            default     => 'status-upcoming',
                        };
                        $bulletDot = match($event->status) {
                            'upcoming'  => 'bullet-dot--blue',
                            'ongoing'   => 'bullet-dot--green',
                            'completed' => 'bullet-dot--gray',
                            'cancelled' => 'bullet-dot--red',
                            default     => 'bullet-dot--blue',
                        };
                        $statusLabel = match($event->status) {
                            'upcoming'  => 'Akan Datang',
                            'ongoing'   => 'Berlangsung',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default     => 'Akan Datang',
                        };
                    @endphp
                    <span class="{{ $statusClass }}" style="font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center;">
                        <span class="bullet-dot {{ $bulletDot }}"></span> {{ $statusLabel }}
                    </span>
                </td>

                {{-- Featured --}}
                <td style="text-align: center;">
                    @if($event->is_featured)
                        <span class="badge-fav" title="Ditampilkan di beranda">★</span>
                    @else
                        <span style="color: var(--color-muted-text); font-size: 0.8rem;">-</span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td style="text-align: center;">
                    <div class="table-actions" style="justify-content: center;">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn-action-small btn-edit" title="Edit Event">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                              onsubmit="return confirm('Hapus event \"{{ addslashes($event->title) }}\"? Poster juga akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-small btn-delete" title="Hapus Event">
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
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: var(--color-muted-text);">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;">📅</div>
                    <div style="font-weight: 700;">Belum Ada Event</div>
                    <div style="font-size: 0.85rem;">Klik "Tambah Event Baru" untuk mulai.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('eventsTable')) {
        $('#eventsTable').DataTable({
            order: [[3, 'desc']], // Urutkan berdasarkan Tanggal & Jam
            pageLength: 10,
            language: {
                search: 'Cari Event:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ event',
                infoEmpty: 'Belum ada event yang dijadwalkan',
                zeroRecords: 'Tidak ada event yang cocok dengan pencarian.',
                paginate: { 
                    previous: 'Sebelumnya', 
                    next: 'Selanjutnya' 
                },
                emptyTable: 'Belum ada event. Klik "Tambah Event Baru" untuk mulai menambahkan agenda!',
            },
            columnDefs: [
                { orderable: false, targets: [0, 6, 7] }, // Disable sorting untuk Poster, Featured, Aksi
            ],
            // Hapus border bawah ganda dari DataTables bawaan
            drawCallback: function() {
                $('.dataTables_wrapper .admin-table').css('border-bottom', 'none');
            }
        });
    }
});
</script>
@endsection
