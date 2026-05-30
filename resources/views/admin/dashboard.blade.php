@extends('layouts.admin')

@section('title', 'Dashboard | Warkop Sky CRM')
@section('page_title', 'Dashboard Ringkasan')

@section('styles')
<style>
    /* KPI Stats Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    .kpi-card {
        background: var(--color-admin-card);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.04);
        padding: var(--spacing-md);
        border-top-left-radius: 16px;
        border-bottom-right-radius: 16px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all var(--duration-normal) var(--easing-smooth);
        text-decoration: none;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        border-color: rgba(93, 156, 236, 0.2);
        box-shadow: 0 10px 25px rgba(93, 156, 236, 0.05);
    }

    .kpi-card--highlight-blue {
        border-left: 4px solid var(--color-sky-blue);
    }

    .kpi-card--highlight-red {
        border-left: 4px solid var(--color-warkop-red);
    }

    .kpi-card--highlight-gold {
        border-left: 4px solid var(--color-warm-gold);
    }

    .kpi-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.03);
        color: var(--color-warm-cream);
        flex-shrink: 0;
    }

    .kpi-card--highlight-blue .kpi-icon-box {
        background: rgba(93, 156, 236, 0.1);
        color: var(--color-sky-blue);
    }

    .kpi-card--highlight-red .kpi-icon-box {
        background: rgba(230, 57, 70, 0.1);
        color: var(--color-warkop-red);
    }

    .kpi-card--highlight-gold .kpi-icon-box {
        background: rgba(255, 200, 87, 0.1);
        color: var(--color-warm-gold);
    }

    .kpi-details {
        display: flex;
        flex-direction: column;
    }

    .kpi-title {
        font-size: 0.82rem;
        color: var(--color-muted-text);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
    }

    .kpi-value {
        font-size: 1.8rem;
        font-family: var(--font-display);
        color: var(--color-warm-cream);
        margin: 2px 0 0 0;
        line-height: 1;
    }

    /* Dashboard Activity Section */
    .dashboard-layout-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: var(--spacing-lg);
    }

    @media (max-width: 991px) {
        .dashboard-layout-grid {
            grid-template-columns: 1fr;
        }
    }

    .panel-box {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        padding: var(--spacing-md);
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        padding-bottom: 12px;
    }

    .panel-title {
        font-family: var(--font-display);
        font-size: 1.3rem;
        margin: 0;
        color: var(--color-warm-cream);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .panel-link {
        font-size: 0.8rem;
        color: var(--color-sky-blue);
        text-decoration: none;
        font-weight: 700;
        transition: color var(--duration-fast) var(--easing-smooth);
    }

    .panel-link:hover {
        color: var(--color-warm-gold);
    }

    /* Dashboard List & Table styles */
    .dashboard-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .dashboard-list-item {
        background: rgba(7, 11, 20, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.02);
        padding: 12px 16px;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .dashboard-list-item:hover {
        background: rgba(7, 11, 20, 0.8);
        border-color: rgba(93, 156, 236, 0.1);
    }

    .item-meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .item-title {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--color-warm-cream);
    }

    .item-subtitle {
        font-size: 0.8rem;
        color: var(--color-muted-text);
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .item-badge {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .item-badge--pending {
        background: rgba(255, 200, 87, 0.1);
        color: var(--color-warm-gold);
        border: 1px solid rgba(255, 200, 87, 0.2);
    }

    .item-badge--confirmed {
        background: rgba(93, 156, 236, 0.1);
        color: var(--color-sky-blue);
        border: 1px solid rgba(93, 156, 236, 0.2);
    }

    .item-badge--cancelled {
        background: rgba(230, 57, 70, 0.1);
        color: var(--color-warkop-red);
        border: 1px solid rgba(230, 57, 70, 0.2);
    }

    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Small Interactive Buttons */
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

    .btn-action-small--whatsapp {
        background: #25D366;
        color: white;
    }

    .btn-action-small--whatsapp:hover {
        background: #128C7E;
        transform: scale(1.1);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: var(--spacing-lg) var(--spacing-md);
        color: var(--color-muted-text);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .empty-icon {
        opacity: 0.3;
        margin-bottom: 8px;
    }

    /* Stories Card Styles */
    .story-card-body {
        font-size: 0.85rem;
        color: var(--color-muted-text);
        font-style: italic;
        margin-top: 6px;
        line-height: 1.4;
        border-left: 2px solid rgba(93, 156, 236, 0.2);
        padding-left: 8px;
    }

    .stars-display {
        color: var(--color-warm-gold);
        display: flex;
        align-items: center;
        gap: 2px;
    }

    /* Dashboard Notifications Panel */
    .dashboard-notifications-container {
        margin-bottom: var(--spacing-md);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .notification-alert-bar {
        background: rgba(16, 24, 48, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-left: 4px solid var(--color-warm-gold);
        padding: 14px 20px;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        animation: notification-slide-in 0.4s var(--easing-bounce) forwards;
        position: relative;
        overflow: hidden;
    }

    .notification-alert-bar::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255, 200, 87, 0.03) 0%, transparent 70%);
        pointer-events: none;
    }

    .notification-alert-bar--info {
        border-left-color: var(--color-sky-blue);
    }
    
    .notification-alert-bar--info::before {
        background: linear-gradient(90deg, rgba(93, 156, 236, 0.03) 0%, transparent 70%);
    }

    .notification-alert-bar--success {
        border-left-color: #25D366;
    }

    .notification-alert-bar--success::before {
        background: linear-gradient(90deg, rgba(37, 211, 102, 0.03) 0%, transparent 70%);
    }

    @keyframes notification-slide-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .notification-info-side {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .notification-bell-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 200, 87, 0.1);
        color: var(--color-warm-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        animation: bell-swing 2.5s ease infinite;
    }

    .notification-alert-bar--info .notification-bell-icon {
        background: rgba(93, 156, 236, 0.1);
        color: var(--color-sky-blue);
    }

    .notification-alert-bar--success .notification-bell-icon {
        background: rgba(37, 211, 102, 0.1);
        color: #25D366;
    }

    @keyframes bell-swing {
        0%, 100% { transform: rotate(0); }
        10% { transform: rotate(15deg); }
        20% { transform: rotate(-10deg); }
        30% { transform: rotate(5deg); }
        40% { transform: rotate(-5deg); }
        50% { transform: rotate(0); }
    }

    .notification-alert-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--color-warm-cream);
        margin: 0;
    }

    .notification-alert-sub {
        font-size: 0.8rem;
        color: var(--color-muted-text);
        margin: 2px 0 0 0;
    }

    .notification-action-btn {
        padding: 0.5rem 1rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--color-warm-cream);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        transition: all var(--duration-fast) var(--easing-smooth);
        white-space: nowrap;
    }

    .notification-action-btn:hover {
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        border-color: var(--color-warm-gold);
        box-shadow: 0 4px 12px rgba(255, 200, 87, 0.2);
    }

    .notification-alert-bar--info .notification-action-btn:hover {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border-color: var(--color-sky-blue);
        box-shadow: 0 4px 12px rgba(93, 156, 236, 0.2);
    }

    /* Floating Toasts Container */
    .realtime-toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 360px;
        max-width: calc(100vw - 48px);
        pointer-events: none;
    }

    .realtime-toast {
        background: rgba(10, 15, 29, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 16px 20px;
        border-top-left-radius: 16px;
        border-bottom-right-radius: 16px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        display: flex;
        gap: 14px;
        pointer-events: auto;
        transform: translateX(120%);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .realtime-toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .realtime-toast.fade-out {
        transform: translateX(120%);
        opacity: 0;
        margin-top: -80px; /* Collapse gap nicely */
        transition: all 0.5s ease;
    }

    .realtime-toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .realtime-toast--res .realtime-toast-icon {
        background: rgba(230, 57, 70, 0.15);
        color: var(--color-warkop-red);
        border: 1px solid rgba(230, 57, 70, 0.3);
    }

    .realtime-toast--story .realtime-toast-icon {
        background: rgba(255, 200, 87, 0.15);
        color: var(--color-warm-gold);
        border: 1px solid rgba(255, 200, 87, 0.3);
    }

    .realtime-toast-content {
        flex-grow: 1;
    }

    .realtime-toast-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--color-warm-cream);
        margin: 0 0 4px 0;
    }

    .realtime-toast-body {
        font-size: 0.82rem;
        color: var(--color-muted-text);
        margin: 0;
        line-height: 1.4;
    }

    .realtime-toast-body strong {
        color: var(--color-warm-cream);
    }

    .realtime-toast-close {
        background: transparent;
        border: none;
        color: var(--color-muted-text);
        cursor: pointer;
        padding: 0;
        font-size: 1.1rem;
        line-height: 1;
        align-self: flex-start;
        transition: color var(--duration-fast);
    }

    .realtime-toast-close:hover {
        color: var(--color-warm-cream);
    }

    /* Tab Switcher Styles */
    .dashboard-tabs {
        display: flex;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 8px;
        margin-bottom: var(--spacing-lg);
    }

    .dashboard-tab-btn {
        background: transparent;
        border: none;
        color: var(--color-muted-text);
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.95rem;
        padding: 10px 20px;
        cursor: pointer;
        border-top-left-radius: 10px;
        border-bottom-right-radius: 10px;
        transition: all 0.3s var(--easing-smooth);
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    .dashboard-tab-btn:hover {
        color: var(--color-warm-cream);
        background: rgba(255, 255, 255, 0.02);
    }

    .dashboard-tab-btn.active {
        color: var(--color-warm-gold);
        background: rgba(255, 200, 87, 0.08);
        border: 1px solid rgba(255, 200, 87, 0.2);
    }

    .tab-badge {
        background: var(--color-warkop-red);
        color: white;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 1px 6px;
        border-radius: 10px;
        display: none; /* Shown dynamically when count > 0 */
        box-shadow: 0 0 10px rgba(230, 57, 70, 0.4);
    }

    /* Notification Page / Filters */
    .notif-filter-bar {
        display: flex;
        gap: 8px;
        margin-bottom: 4px;
        flex-wrap: wrap;
    }

    .notif-filter-btn {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--color-muted-text);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .notif-filter-btn:hover {
        color: var(--color-warm-cream);
        background: rgba(255, 255, 255, 0.06);
    }

    .notif-filter-btn.active {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border-color: var(--color-sky-blue);
        box-shadow: 0 4px 12px rgba(93, 156, 236, 0.25);
    }

    /* Notification Item UI */
    .notif-item {
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .notif-item.starred-item {
        border-left: 4px solid var(--color-warm-gold) !important;
        background: rgba(255, 200, 87, 0.03) !important;
    }

    .notif-item.collapsing-exit {
        opacity: 0;
        transform: translateX(-100px);
        max-height: 0;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        border-width: 0 !important;
        pointer-events: none;
    }

    .btn-action-small--star {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        color: var(--color-muted-text);
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-action-small--star:hover {
        background: rgba(255, 200, 87, 0.1);
        color: var(--color-warm-gold);
        border-color: var(--color-warm-gold);
        transform: scale(1.1);
    }

    .btn-action-small--star.active {
        background: rgba(255, 200, 87, 0.15);
        color: var(--color-warm-gold);
        border-color: rgba(255, 200, 87, 0.3);
    }

    .btn-action-small--delete {
        background: rgba(230, 57, 70, 0.05);
        border: 1px solid rgba(230, 57, 70, 0.1);
        color: var(--color-warkop-red);
        cursor: pointer;
    }

    .btn-action-small--delete:hover {
        background: var(--color-warkop-red);
        color: white;
        border-color: var(--color-warkop-red);
        transform: scale(1.1);
    }
</style>
@section('content')

    <!-- Tab Switcher -->
    <div class="dashboard-tabs">
        <button class="dashboard-tab-btn active" id="tab-btn-summary">
            📊 Ringkasan CRM
        </button>
        <button class="dashboard-tab-btn" id="tab-btn-notifications">
            🔔 Semua Notifikasi
            <span class="tab-badge" id="notif-count-badge">0</span>
        </button>
    </div>

    <!-- TAB 1: Summary -->
    <div class="tab-content" id="tab-summary">

    <!-- Dashboard Notifications Container -->
    <div class="dashboard-notifications-container">
        @php
            $hasNotification = false;
        @endphp

        <!-- 1. Pending Reservations Notification -->
        @if($kpis['pending_reservations'] > 0)
            @php $hasNotification = true; @endphp
            <div class="notification-alert-bar">
                <div class="notification-info-side">
                    <div class="notification-bell-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="notification-alert-title">Reservasi Baru Menunggu Persetujuan</h4>
                        <p class="notification-alert-sub">Ada <strong>{{ $kpis['pending_reservations'] }} reservasi</strong> baru dari pelanggan yang memerlukan konfirmasi Anda segera.</p>
                    </div>
                </div>
                <a href="{{ route('admin.reservations.index') }}" class="notification-action-btn">
                    Tinjau Reservasi &rarr;
                </a>
            </div>
        @endif

        <!-- 2. Pending Stories/Reviews Notification -->
        @if($kpis['pending_stories'] > 0)
            @php $hasNotification = true; @endphp
            <div class="notification-alert-bar notification-alert-bar--info">
                <div class="notification-info-side">
                    <div class="notification-bell-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="notification-alert-title">Ulasan Stories Baru Perlu Moderasi</h4>
                        <p class="notification-alert-sub">Ada <strong>{{ $kpis['pending_stories'] }} cerita ulasan</strong> baru dari pengunjung yang perlu dimoderasi sebelum dipublish.</p>
                    </div>
                </div>
                <a href="{{ route('admin.stories.index') }}" class="notification-action-btn">
                    Moderasi Ulasan &rarr;
                </a>
            </div>
        @endif

        <!-- 3. All Clean Success Notification (Only if no active notifications) -->
        @if(!$hasNotification)
            <div class="notification-alert-bar notification-alert-bar--success">
                <div class="notification-info-side">
                    <div class="notification-bell-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h4 class="notification-alert-title">Semua Beres! Tidak Ada Pekerjaan Tertunda</h4>
                        <p class="notification-alert-sub">Bagus! Semua ulasan stories dan reservasi pelanggan saat ini sudah diproses sepenuhnya.</p>
                    </div>
                </div>
                <span class="notification-action-btn" style="cursor: default; opacity: 0.6;">
                    System Active ✨
                </span>
            </div>
        @endif
    </div>

    <!-- KPI Stats Grid -->
    <div class="kpi-grid">
        <!-- Pending Reservations -->
        <a href="{{ route('admin.reservations.index') }}" class="kpi-card kpi-card--highlight-red">
            <div class="kpi-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="kpi-details">
                <span class="kpi-title">Reservasi Pending</span>
                <h3 class="kpi-value" id="kpi-res-value">{{ $kpis['pending_reservations'] }}</h3>
            </div>
        </a>

        <!-- Pending Stories -->
        <a href="{{ route('admin.stories.index') }}" class="kpi-card kpi-card--highlight-gold">
            <div class="kpi-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </div>
            <div class="kpi-details">
                <span class="kpi-title">Ulasan Pending</span>
                <h3 class="kpi-value" id="kpi-story-value">{{ $kpis['pending_stories'] }}</h3>
            </div>
        </a>

        <!-- Total Menus -->
        <a href="{{ route('admin.menu.index') }}" class="kpi-card kpi-card--highlight-blue">
            <div class="kpi-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="kpi-details">
                <span class="kpi-title">Total Menu</span>
                <h3 class="kpi-value">{{ $kpis['total_menus'] }}</h3>
            </div>
        </a>

        <!-- Total Gallery Photos -->
        <a href="{{ route('admin.gallery.index') }}" class="kpi-card kpi-card--highlight-blue">
            <div class="kpi-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </div>
            <div class="kpi-details">
                <span class="kpi-title">Galeri Foto</span>
                <h3 class="kpi-value">{{ $kpis['total_photos'] }}</h3>
            </div>
        </a>
    </div>

    <!-- Two Column Dashboard Layout -->
    <div class="dashboard-layout-grid">
        
        <!-- Column 1: Recent Reservations -->
        <div class="panel-box">
            <div class="panel-header">
                <h2 class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Reservasi Terbaru
                </h2>
                <a href="{{ route('admin.reservations.index') }}" class="panel-link">Lihat Semua</a>
            </div>

            <div class="dashboard-list">
                @forelse($recentReservations as $reservation)
                    <div class="dashboard-list-item" data-id="res-{{ $reservation->id }}" data-timestamp="{{ $reservation->created_at ? $reservation->created_at->toIso8601String() : now()->toIso8601String() }}">
                        <div class="item-meta">
                            <div class="item-title">
                                {{ $reservation->name }} 
                                <span class="item-badge item-badge--{{ $reservation->status }}">{{ $reservation->status }}</span>
                            </div>
                            <div class="item-subtitle">
                                <span>📞 {{ $reservation->phone }}</span>
                                <span>•</span>
                                <span>📍 {{ $reservation->branch }}</span>
                                <span>•</span>
                                <span>👥 {{ $reservation->pax }} Orang</span>
                                <span>•</span>
                                <span>📅 {{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('d M Y') }} ({{ $reservation->reservation_time }})</span>
                            </div>
                            @if($reservation->note)
                                <div class="story-card-body" style="border-left-color: var(--color-warkop-red); font-size: 0.8rem; margin-top: 4px;">
                                    Catatan: "{{ $reservation->note }}"
                                </div>
                            @endif
                        </div>

                        <div class="action-group">
                            @if($reservation->status === 'pending')
                                <!-- Approve Reservation -->
                                <form action="{{ route('admin.reservations.updateStatus', $reservation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn-action-small btn-action-small--approve" title="Setujui Reservasi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Reject/Cancel Reservation -->
                                <form action="{{ route('admin.reservations.updateStatus', $reservation->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="btn-action-small btn-action-small--reject" title="Batalkan Reservasi" onclick="return confirm('Apakah Anda yakin mau membatalkan reservasi ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            <!-- WhatsApp Contact Prefilled Link -->
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $reservation->phone);
                                if (str_starts_with($cleanPhone, '08')) {
                                    $cleanPhone = '628' . substr($cleanPhone, 2);
                                }
                                $message = urlencode("Halo Kak " . $reservation->name . ", kami dari Warkop Sky ingin mengonfirmasi reservasi Kakak untuk tanggal " . \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('d M Y') . " jam " . $reservation->reservation_time . " di cabang " . $reservation->branch . ". Apakah data sudah sesuai?");
                                $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . $message;
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="btn-action-small btn-action-small--whatsapp" title="Hubungi via WhatsApp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.907h.004c4.368 0 7.926-3.559 7.93-7.93a7.897 7.897 0 0 0-2.327-5.615zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.69-4.98c-.202-.1-1.194-.588-1.378-.654-.185-.066-.32-.1-.452.1-.132.2-.508.648-.624.782-.115.134-.233.15-.436.05-.204-.1-.859-.315-1.637-1.012-.604-.539-1.013-1.207-1.132-1.412-.119-.205-.013-.316.088-.417.09-.09.2-.21.3-.316.098-.105.13-.18.196-.299.066-.12.033-.223-.017-.323-.05-.1-452-1.09-.619-1.492-.162-.394-.34-.34-.496-.346-.129-.006-.277-.008-.425-.008-.149 0-.39.055-.595.277-.205.223-.782.764-.782 1.861 0 1.098.798 2.158.91 2.308.112.15 1.564 2.388 3.79 3.35 1.258.544 1.884.665 2.544.566.368-.055 1.194-.487 1.362-.958.168-.47.168-.874.118-.958-.05-.084-.185-.132-.387-.232z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg class="empty-icon animate-pulse" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <strong>Belum Ada Reservasi</strong>
                        <span style="font-size: 0.8rem;">Dapur sedang santai, belum ada pemesanan masuk.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Column 2: Pending Reviews / Stories -->
        <div class="panel-box">
            <div class="panel-header">
                <h2 class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Ulasan Stories Pending
                </h2>
                <a href="{{ route('admin.stories.index') }}" class="panel-link">Moderasi</a>
            </div>

            <div class="dashboard-list">
                @forelse($pendingStories as $story)
                    <div class="dashboard-list-item" data-id="story-{{ $story->id }}" data-timestamp="{{ $story->created_at ? $story->created_at->toIso8601String() : now()->toIso8601String() }}">
                        <div class="item-meta">
                            <div class="item-title" style="display: flex; align-items: center; gap: 8px;">
                                {{ $story->author }}
                                @if($story->instagram_handle)
                                    <span style="color: var(--color-sky-blue); font-size: 0.8rem; font-weight: normal;">({{ '@' . $story->instagram_handle }})</span>
                                @endif
                            </div>
                            <div class="item-subtitle">
                                <div class="stars-display">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $story->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    <span style="color: var(--color-muted-text); font-size: 0.75rem; margin-left: 4px;">({{ $story->rating }}/5)</span>
                                </div>
                                <span>•</span>
                                <span>📷 {{ $story->media_type !== 'none' ? 'Ada Media' : 'Tanpa Media' }}</span>
                            </div>
                            <div class="story-card-body">
                                "{{ \Illuminate\Support\Str::limit($story->text, 80) }}"
                            </div>
                        </div>

                        <div class="action-group">
                            <!-- Approve Story -->
                            <form action="{{ route('admin.stories.updateStatus', $story->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn-action-small btn-action-small--approve" title="Setujui Ulasan">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </button>
                            </form>

                            <!-- Reject Story -->
                            <form action="{{ route('admin.stories.updateStatus', $story->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn-action-small btn-action-small--reject" title="Tolak Ulasan" onclick="return confirm('Apakah Anda yakin mau menolak ulasan dari {{ $story->author }}?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg class="empty-icon animate-pulse" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <strong>Tidak Ada Ulasan Pending</strong>
                        <span style="font-size: 0.8rem;">Semua ulasan stories sudah selesai dimoderasi.</span>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
    </div> <!-- End of TAB 1: Summary -->

    <!-- TAB 2: Notifications List Page -->
    <div class="tab-content" id="tab-notifications" style="display: none;">
        <div class="panel-box">
            <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <h2 class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    Pusat Pemberitahuan
                </h2>
                
                <!-- Notification Filter Controls -->
                <div class="notif-filter-bar">
                    <button class="notif-filter-btn active" data-filter="all">Semua</button>
                    <button class="notif-filter-btn" data-filter="starred">⭐ Berbintang</button>
                    <button class="notif-filter-btn" data-filter="res">📅 Reservasi</button>
                    <button class="notif-filter-btn" data-filter="story">📷 Ulasan</button>
                </div>
            </div>

            <!-- Empty State for notifications -->
            <div id="notif-empty-state" class="empty-state" style="display: none;">
                <svg class="empty-icon animate-pulse" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <strong>Belum Ada Pemberitahuan</strong>
                <span style="font-size: 0.8rem;">Tidak ada notifikasi dalam filter ini.</span>
            </div>

            <!-- Notifications List -->
            <div id="notif-list-container" class="dashboard-list">
                <!-- Javascript will inject list items here -->
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching logic
        const tabBtnSummary = document.getElementById('tab-btn-summary');
        const tabBtnNotifications = document.getElementById('tab-btn-notifications');
        const tabContentSummary = document.getElementById('tab-summary');
        const tabContentNotifications = document.getElementById('tab-notifications');

        if (tabBtnSummary && tabBtnNotifications && tabContentSummary && tabContentNotifications) {
            tabBtnSummary.addEventListener('click', function() {
                tabBtnSummary.classList.add('active');
                tabBtnNotifications.classList.remove('active');
                tabContentSummary.style.display = 'block';
                tabContentNotifications.style.display = 'none';
            });

            tabBtnNotifications.addEventListener('click', function() {
                tabBtnNotifications.classList.add('active');
                tabBtnSummary.classList.remove('active');
                tabContentSummary.style.display = 'none';
                tabContentNotifications.style.display = 'block';
                renderNotifications();
            });
        }

        // Create Floating Toasts Container
        const toastContainer = document.createElement('div');
        toastContainer.className = 'realtime-toast-container';
        document.body.appendChild(toastContainer);

        // Keep track of counts
        let resCount = parseInt(document.getElementById('kpi-res-value')?.textContent || '0', 10);
        let storyCount = parseInt(document.getElementById('kpi-story-value')?.textContent || '0', 10);

        // Web Audio API Synth Play Chime
        function playChime() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                
                // First Tone: E5 (659.25 Hz)
                const osc1 = audioCtx.createOscillator();
                const gain1 = audioCtx.createGain();
                osc1.connect(gain1);
                gain1.connect(audioCtx.destination);
                
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(659.25, audioCtx.currentTime);
                gain1.gain.setValueAtTime(0, audioCtx.currentTime);
                gain1.gain.linearRampToValueAtTime(0.15, audioCtx.currentTime + 0.05);
                gain1.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.3);
                
                osc1.start(audioCtx.currentTime);
                osc1.stop(audioCtx.currentTime + 0.3);
                
                // Second Tone: A5 (880.00 Hz) starting slightly later
                const osc2 = audioCtx.createOscillator();
                const gain2 = audioCtx.createGain();
                osc2.connect(gain2);
                gain2.connect(audioCtx.destination);
                
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880.00, audioCtx.currentTime + 0.12);
                gain2.gain.setValueAtTime(0, audioCtx.currentTime + 0.12);
                gain2.gain.linearRampToValueAtTime(0.2, audioCtx.currentTime + 0.17);
                gain2.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.65);
                
                osc2.start(audioCtx.currentTime + 0.12);
                osc2.stop(audioCtx.currentTime + 0.65);
            } catch (e) {
                console.warn('Web Audio API not supported or blocked:', e);
            }
        }

        // Spawn Premium Glassmorphic Toast
        function spawnRealTimeToast(type, title, body) {
            const toast = document.createElement('div');
            toast.className = `realtime-toast realtime-toast--${type}`;
            
            // Icon selection
            let iconSvg = '';
            if (type === 'res') {
                iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>`;
            } else {
                iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>`;
            }

            toast.innerHTML = `
                <div class="realtime-toast-icon">
                    ${iconSvg}
                </div>
                <div class="realtime-toast-content">
                    <h5 class="realtime-toast-title">${title}</h5>
                    <p class="realtime-toast-body">${body}</p>
                </div>
                <button class="realtime-toast-close" aria-label="Close">&times;</button>
            `;

            // Close button listener
            toast.querySelector('.realtime-toast-close').addEventListener('click', () => {
                toast.classList.add('fade-out');
                setTimeout(() => toast.remove(), 500);
            });

            toastContainer.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => toast.classList.add('show'), 50);

            // Auto dismiss
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('fade-out');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 6000);
        }

        // ==========================================
        // LOCAL STORAGE NOTIFICATIONS PERSISTENCE
        // ==========================================
        function getStoredNotifications() {
            return JSON.parse(localStorage.getItem('warkop_crm_notifications') || '[]');
        }

        function saveNotifications(notifs) {
            localStorage.setItem('warkop_crm_notifications', JSON.stringify(notifs));
            updateUnreadBadge();
        }

        function addNotification(type, id, title, body, timestamp) {
            const notifs = getStoredNotifications();
            // Avoid duplicates
            if (notifs.some(n => n.id === id)) return;

            notifs.push({
                id: id,
                type: type,
                title: title,
                body: body,
                timestamp: timestamp || new Date().toISOString(),
                isStarred: false,
                isDeleted: false
            });
            saveNotifications(notifs);
        }

        function updateUnreadBadge() {
            const notifs = getStoredNotifications();
            const unreadCount = notifs.filter(n => !n.isDeleted && !n.isStarred).length;
            const badge = document.getElementById('notif-count-badge');
            if (badge) {
                if (unreadCount > 0) {
                    badge.textContent = unreadCount;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        // Initialize notification data from the current DOM cards on load
        function initNotificationsFromDOM(rootDoc = document) {
            // Read reservations from DOM
            const resItems = rootDoc.querySelectorAll('.dashboard-layout-grid > div:first-child .dashboard-list-item');
            resItems.forEach(item => {
                const id = item.getAttribute('data-id');
                const timestamp = item.getAttribute('data-timestamp');
                if (id && timestamp) {
                    const nameText = item.querySelector('.item-title')?.textContent || '';
                    const customerName = nameText.split('pending')[0].split('confirmed')[0].split('cancelled')[0].trim() || 'Pelanggan';
                    const subtitle = item.querySelector('.item-subtitle')?.textContent?.replace(/\s+/g, ' ').trim() || '';
                    const noteText = item.querySelector('.story-card-body')?.textContent?.trim() || '';
                    
                    const title = `Reservasi Baru: ${customerName}`;
                    const body = `${subtitle}${noteText ? '<br><strong>Catatan:</strong> ' + noteText : ''}`;
                    addNotification('res', id, title, body, timestamp);
                }
            });

            // Read stories from DOM
            const storyItems = rootDoc.querySelectorAll('.dashboard-layout-grid > div:last-child .dashboard-list-item');
            storyItems.forEach(item => {
                const id = item.getAttribute('data-id');
                const timestamp = item.getAttribute('data-timestamp');
                if (id && timestamp) {
                    const authorName = item.querySelector('.item-title')?.firstChild?.textContent?.trim() || 'Pengunjung';
                    const stars = item.querySelector('.stars-display')?.textContent?.trim() || '★';
                    const reviewText = item.querySelector('.story-card-body')?.textContent?.trim() || '';
                    
                    const title = `Ulasan Baru: ${authorName}`;
                    const body = `Rating: <strong>${stars}</strong><br>${reviewText}`;
                    addNotification('story', id, title, body, timestamp);
                }
            });
            updateUnreadBadge();
        }

        // Helpers for Date Formatting
        function getRelativeTime(timestamp) {
            const elapsed = Date.now() - new Date(timestamp).getTime();
            const msPerMinute = 60 * 1000;
            const msPerHour = msPerMinute * 60;
            const msPerDay = msPerHour * 24;

            if (elapsed < msPerMinute) {
                return 'Baru saja';
            } else if (elapsed < msPerHour) {
                const mins = Math.round(elapsed / msPerMinute);
                return `${mins} menit yang lalu`;
            } else if (elapsed < msPerHour * 2) {
                return '1 jam yang lalu';
            } else if (elapsed < msPerDay) {
                const hours = Math.round(elapsed / msPerHour);
                return `${hours} jam yang lalu`;
            } else if (elapsed < msPerDay * 2) {
                return 'Kemarin';
            } else {
                const days = Math.round(elapsed / msPerDay);
                return `${days} hari yang lalu`;
            }
        }

        function getAbsoluteTime(timestamp) {
            const date = new Date(timestamp);
            const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return date.toLocaleDateString('id-ID', options);
        }

        // ==========================================
        // NOTIFICATIONS RENDERING & FILTERS
        // ==========================================
        let currentFilter = 'all';

        function renderNotifications() {
            const container = document.getElementById('notif-list-container');
            const emptyState = document.getElementById('notif-empty-state');
            if (!container) return;

            const notifs = getStoredNotifications();
            
            // Filter notifications (not deleted)
            let filteredNotifs = notifs.filter(n => !n.isDeleted);

            if (currentFilter === 'starred') {
                filteredNotifs = filteredNotifs.filter(n => n.isStarred);
            } else if (currentFilter === 'res') {
                filteredNotifs = filteredNotifs.filter(n => n.type === 'res');
            } else if (currentFilter === 'story') {
                filteredNotifs = filteredNotifs.filter(n => n.type === 'story');
            }

            // Sort chronologically (newest first)
            filteredNotifs.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

            // Render list
            container.innerHTML = '';

            if (filteredNotifs.length === 0) {
                emptyState.style.display = 'flex';
                return;
            }
            emptyState.style.display = 'none';

            filteredNotifs.forEach(notif => {
                const item = document.createElement('div');
                item.className = `dashboard-list-item notif-item ${notif.isStarred ? 'starred-item' : ''}`;
                item.setAttribute('data-id', notif.id);

                const iconSvg = notif.type === 'res' ? `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                ` : `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                `;

                item.innerHTML = `
                    <div style="display: flex; align-items: flex-start; gap: 14px; flex-grow: 1;">
                        <div class="notification-bell-icon ${notif.type === 'res' ? 'notification-alert-bar--success' : 'notification-alert-bar--info'}" style="margin-top: 2px; width: 32px; height: 32px; font-size: 0.8rem;">
                            ${iconSvg}
                        </div>
                        <div class="item-meta" style="flex-grow: 1;">
                            <div class="item-title" style="display: flex; align-items: center; gap: 8px;">
                                ${notif.title}
                                <span class="item-badge ${notif.type === 'res' ? 'item-badge--confirmed' : 'item-badge--pending'}">${notif.type === 'res' ? 'RESERVASI' : 'ULASAN'}</span>
                            </div>
                            <div class="story-card-body" style="border-left-color: ${notif.type === 'res' ? 'var(--color-sky-blue)' : 'var(--color-warm-gold)'}; margin-top: 4px; font-size: 0.85rem;">
                                ${notif.body}
                            </div>
                            <div class="item-subtitle" style="margin-top: 6px; font-size: 0.75rem; color: var(--color-muted-text);">
                                🕒 <span class="time-relative">${getRelativeTime(notif.timestamp)}</span> &bull; 📅 <span class="time-absolute">${getAbsoluteTime(notif.timestamp)}</span>
                            </div>
                        </div>
                    </div>
                    <div class="action-group">
                        <button class="btn-action-small btn-action-small--star ${notif.isStarred ? 'active' : ''}" title="${notif.isStarred ? 'Hapus Bintang' : 'Bintangi'}">
                            ★
                        </button>
                        <button class="btn-action-small btn-action-small--delete" title="Hapus Notifikasi">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                `;

                // Star action click listener
                item.querySelector('.btn-action-small--star').addEventListener('click', function() {
                    toggleNotifStar(notif.id);
                });

                // Delete action click listener
                item.querySelector('.btn-action-small--delete').addEventListener('click', function() {
                    deleteNotification(notif.id, item);
                });

                container.appendChild(item);
            });
        }

        function toggleNotifStar(id) {
            const notifs = getStoredNotifications();
            const notif = notifs.find(n => n.id === id);
            if (notif) {
                notif.isStarred = !notif.isStarred;
                saveNotifications(notifs);
                renderNotifications();
            }
        }

        function deleteNotification(id, element) {
            const notifs = getStoredNotifications();
            const notif = notifs.find(n => n.id === id);
            if (notif) {
                notif.isDeleted = true;
                saveNotifications(notifs);
                
                // Collapse & exit animation
                element.classList.add('collapsing-exit');
                setTimeout(() => {
                    renderNotifications();
                }, 400);
            }
        }

        // Set up filters
        const filterBtns = document.querySelectorAll('.notif-filter-btn');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                renderNotifications();
            });
        });

        // Initialize list
        initNotificationsFromDOM();

        // ==========================================
        // BACKGROUND POLLING & AUTOMATIC SYNC
        // ==========================================
        setInterval(function() {
            fetch('/admin/dashboard')
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Check new KPI values
                    const newResElement = doc.getElementById('kpi-res-value');
                    const newStoryElement = doc.getElementById('kpi-story-value');

                    if (!newResElement || !newStoryElement) return;

                    const newResCount = parseInt(newResElement.textContent || '0', 10);
                    const newStoryCount = parseInt(newStoryElement.textContent || '0', 10);

                    let hasNewItems = false;
                    let soundTriggered = false;

                    // 1. Check for New Reservations
                    if (newResCount > resCount) {
                        hasNewItems = true;
                        if (!soundTriggered) { playChime(); soundTriggered = true; }
                        
                        // Extract name of newest reservation if possible
                        const firstNewResItem = doc.querySelector('.dashboard-layout-grid > div:first-child .dashboard-list-item:first-child');
                        let customerName = 'Pelanggan';
                        if (firstNewResItem) {
                            const nameText = firstNewResItem.querySelector('.item-title')?.textContent || '';
                            customerName = nameText.split('pending')[0].split('confirmed')[0].split('cancelled')[0].trim() || 'Pelanggan';
                        }
                        spawnRealTimeToast('res', '📅 Reservasi Baru Masuk!', `Reservasi pending atas nama <strong>${customerName}</strong> baru saja dikirimkan.`);
                    }

                    // 2. Check for New Stories/Reviews
                    if (newStoryCount > storyCount) {
                        hasNewItems = true;
                        if (!soundTriggered) { playChime(); soundTriggered = true; }

                        const firstNewStoryItem = doc.querySelector('.dashboard-layout-grid > div:last-child .dashboard-list-item:first-child');
                        let authorName = 'Pengunjung';
                        if (firstNewStoryItem) {
                            authorName = firstNewStoryItem.querySelector('.item-title')?.firstChild?.textContent?.trim() || 'Pengunjung';
                        }
                        spawnRealTimeToast('story', '📷 Ulasan Baru Masuk!', `Ulasan pending dari <strong>${authorName}</strong> siap dimoderasi.`);
                    }

                    // 3. UI Synchronization (Hot-swapping DOM blocks)
                    if (hasNewItems || newResCount !== resCount || newStoryCount !== storyCount) {
                        // Update values in memory
                        resCount = newResCount;
                        storyCount = newStoryCount;

                        // Hot-swap Notifications Alert Panel
                        const currentNotif = document.querySelector('.dashboard-notifications-container');
                        const fetchedNotif = doc.querySelector('.dashboard-notifications-container');
                        if (currentNotif && fetchedNotif) {
                            currentNotif.innerHTML = fetchedNotif.innerHTML;
                        }

                        // Hot-swap KPI Grid entirely (retains smooth glass style)
                        const currentKpiGrid = document.querySelector('.kpi-grid');
                        const fetchedKpiGrid = doc.querySelector('.kpi-grid');
                        if (currentKpiGrid && fetchedKpiGrid) {
                            currentKpiGrid.innerHTML = fetchedKpiGrid.innerHTML;
                        }

                        // Hot-swap Recent list grid entirely (retains dynamic actions / click listeners)
                        const currentLayoutGrid = document.querySelector('.dashboard-layout-grid');
                        const fetchedLayoutGrid = doc.querySelector('.dashboard-layout-grid');
                        if (currentLayoutGrid && fetchedLayoutGrid) {
                            currentLayoutGrid.innerHTML = fetchedLayoutGrid.innerHTML;
                        }

                        // Parse new notifications from fetched DOM and sync into localStorage
                        initNotificationsFromDOM(doc);

                        // If user is currently looking at notifications page, redraw it
                        if (tabBtnNotifications.classList.contains('active')) {
                            renderNotifications();
                        }
                    }
                })
                .catch(err => console.debug('Polling background error (ignored):', err));
        }, 8000);
    });
</script>
@endsection
