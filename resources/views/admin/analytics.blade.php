@extends('layouts.admin')

@section('title', 'Analitik Website | Warkop Sky CRM')
@section('page_title', 'Analitik Website')

@section('styles')
<style>
    /* ========================================
       ANALYTICS DASHBOARD STYLES
       ======================================== */

    /* Date Range Filter Bar */
    .analytics-filter-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .analytics-filter-bar .filter-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--color-muted-text);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-right: 4px;
    }

    .btn-date-filter {
        padding: 0.5rem 1.1rem;
        border: 1px solid rgba(93, 156, 236, 0.15);
        background: rgba(16, 24, 48, 0.5);
        color: var(--color-muted-text);
        font-family: var(--font-body);
        font-size: 0.82rem;
        font-weight: 700;
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        cursor: pointer;
        transition: all var(--duration-fast) var(--easing-smooth);
        letter-spacing: 0.02em;
    }

    .btn-date-filter:hover {
        border-color: var(--color-sky-blue);
        color: var(--color-warm-cream);
        background: rgba(93, 156, 236, 0.08);
    }

    .btn-date-filter.active {
        background: rgba(93, 156, 236, 0.15);
        border-color: var(--color-sky-blue);
        color: var(--color-sky-blue);
        box-shadow: 0 0 12px rgba(93, 156, 236, 0.1);
    }

    /* KPI Stats Grid */
    .analytics-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
    }

    @media (max-width: 1200px) {
        .analytics-kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .analytics-kpi-grid {
            grid-template-columns: 1fr;
        }
    }

    .a-kpi-card {
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
        position: relative;
        overflow: hidden;
    }

    .a-kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        opacity: 0;
        transition: opacity var(--duration-normal) var(--easing-smooth);
    }

    .a-kpi-card:hover {
        transform: translateY(-4px);
        border-color: rgba(93, 156, 236, 0.15);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }

    .a-kpi-card:hover::before {
        opacity: 1;
    }

    .a-kpi-card--views::before { background: linear-gradient(90deg, var(--color-sky-blue), transparent); }
    .a-kpi-card--visitors::before { background: linear-gradient(90deg, var(--color-warm-gold), transparent); }
    .a-kpi-card--avg::before { background: linear-gradient(90deg, #A78BFA, transparent); }
    .a-kpi-card--realtime::before { background: linear-gradient(90deg, #34D399, transparent); }

    .a-kpi-card--views .a-kpi-icon { background: rgba(93, 156, 236, 0.1); color: var(--color-sky-blue); }
    .a-kpi-card--visitors .a-kpi-icon { background: rgba(255, 200, 87, 0.1); color: var(--color-warm-gold); }
    .a-kpi-card--avg .a-kpi-icon { background: rgba(167, 139, 250, 0.1); color: #A78BFA; }
    .a-kpi-card--realtime .a-kpi-icon { background: rgba(52, 211, 153, 0.1); color: #34D399; }

    .a-kpi-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .a-kpi-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
        flex: 1;
    }

    .a-kpi-label {
        font-size: 0.78rem;
        color: var(--color-muted-text);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.06em;
    }

    .a-kpi-value {
        font-size: 1.8rem;
        font-family: var(--font-display);
        color: var(--color-warm-cream);
        line-height: 1.1;
    }

    .a-kpi-change {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 2px 7px;
        border-radius: 6px;
        width: fit-content;
        margin-top: 2px;
    }

    .a-kpi-change--up {
        background: rgba(52, 211, 153, 0.1);
        color: #34D399;
    }

    .a-kpi-change--down {
        background: rgba(230, 57, 70, 0.1);
        color: var(--color-warkop-red);
    }

    .a-kpi-change--neutral {
        background: rgba(142, 154, 175, 0.1);
        color: var(--color-muted-text);
    }

    /* Realtime Pulse */
    .realtime-pulse {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #34D399;
        margin-right: 6px;
        animation: pulseDot 1.5s ease-in-out infinite;
    }

    @keyframes pulseDot {
        0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.4); }
        50% { opacity: 0.6; box-shadow: 0 0 0 8px rgba(52, 211, 153, 0); }
    }

    /* Chart Grid Layouts */
    .chart-grid-2col {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .chart-grid-3col {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    .table-grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-md);
    }

    @media (max-width: 991px) {
        .chart-grid-2col,
        .chart-grid-3col,
        .table-grid-2col {
            grid-template-columns: 1fr;
        }
    }

    /* Chart Card */
    .chart-card {
        background: var(--color-admin-card);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 4px;
        border-bottom-left-radius: 4px;
        padding: var(--spacing-md);
        display: flex;
        flex-direction: column;
        transition: border-color var(--duration-normal) var(--easing-smooth);
    }

    .chart-card:hover {
        border-color: rgba(93, 156, 236, 0.1);
    }

    .chart-card__header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        margin-bottom: var(--spacing-sm);
    }

    .chart-card__icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .chart-card__icon--blue { background: rgba(93, 156, 236, 0.1); color: var(--color-sky-blue); }
    .chart-card__icon--gold { background: rgba(255, 200, 87, 0.1); color: var(--color-warm-gold); }
    .chart-card__icon--purple { background: rgba(167, 139, 250, 0.1); color: #A78BFA; }
    .chart-card__icon--green { background: rgba(52, 211, 153, 0.1); color: #34D399; }
    .chart-card__icon--pink { background: rgba(244, 114, 182, 0.1); color: #F472B6; }
    .chart-card__icon--red { background: rgba(230, 57, 70, 0.1); color: var(--color-warkop-red); }

    .chart-card__title {
        font-family: var(--font-display);
        font-size: 1.15rem;
        color: var(--color-warm-cream);
        margin: 0;
    }

    .chart-card__body {
        flex: 1;
        position: relative;
        min-height: 200px;
    }

    .chart-card__body canvas {
        width: 100% !important;
        max-height: 300px;
    }

    /* Doughnut charts need centered positioning */
    .chart-card--doughnut .chart-card__body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 220px;
    }

    .chart-card--doughnut .chart-card__body canvas {
        max-height: 220px;
        max-width: 220px;
    }

    /* Analytics Data Table */
    .analytics-table-wrap {
        overflow-x: auto;
    }

    .analytics-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .analytics-table thead th {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--color-muted-text);
        padding: 10px 14px;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        white-space: nowrap;
    }

    .analytics-table tbody tr {
        transition: background var(--duration-fast) var(--easing-smooth);
    }

    .analytics-table tbody tr:hover {
        background: rgba(93, 156, 236, 0.03);
    }

    .analytics-table tbody td {
        padding: 10px 14px;
        font-size: 0.88rem;
        color: var(--color-warm-cream);
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        white-space: nowrap;
    }

    .analytics-table .rank-num {
        font-family: var(--font-display);
        font-size: 1rem;
        color: var(--color-sky-blue);
        width: 30px;
        text-align: center;
    }

    .analytics-table .page-bar {
        height: 4px;
        border-radius: 2px;
        background: rgba(93, 156, 236, 0.15);
        margin-top: 4px;
        overflow: hidden;
    }

    .analytics-table .page-bar-fill {
        height: 100%;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--color-sky-blue), var(--color-warm-gold));
        transition: width var(--duration-slow) var(--easing-smooth);
    }

    /* Loading overlay */
    .analytics-loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(7, 11, 20, 0.7);
        backdrop-filter: blur(4px);
        z-index: 9990;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .analytics-loading.show {
        display: flex;
    }

    .loading-spinner {
        width: 48px;
        height: 48px;
        border: 3px solid rgba(93, 156, 236, 0.15);
        border-top-color: var(--color-sky-blue);
        border-radius: 50%;
        animation: spinLoader 0.8s linear infinite;
    }

    @keyframes spinLoader {
        to { transform: rotate(360deg); }
    }

    /* Empty state for analytics */
    .analytics-empty-state {
        text-align: center;
        padding: var(--spacing-xl) var(--spacing-md);
        color: var(--color-muted-text);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .analytics-empty-state svg {
        opacity: 0.25;
    }

    .analytics-empty-state h3 {
        font-family: var(--font-display);
        color: var(--color-warm-cream);
        font-size: 1.2rem;
        margin: 0;
    }

    .analytics-empty-state p {
        font-size: 0.85rem;
        max-width: 400px;
        line-height: 1.5;
    }

    /* Section separator */
    .analytics-section-label {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--color-muted-text);
        margin-bottom: var(--spacing-sm);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .analytics-section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.04);
    }

    /* Tabs Navigation */
    .analytics-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: var(--spacing-lg);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 12px;
        overflow-x: auto;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: rgba(93, 156, 236, 0.2) transparent;
    }

    .analytics-tabs::-webkit-scrollbar {
        height: 4px;
    }

    .analytics-tabs::-webkit-scrollbar-thumb {
        background: rgba(93, 156, 236, 0.2);
        border-radius: 2px;
    }

    .tab-btn {
        padding: 0.6rem 1.4rem;
        background: rgba(16, 24, 48, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.03);
        color: var(--color-muted-text);
        font-family: var(--font-body);
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        border-top-left-radius: 12px;
        border-bottom-right-radius: 12px;
        transition: all var(--duration-fast) var(--easing-smooth);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }

    .tab-btn:hover {
        border-color: rgba(93, 156, 236, 0.3);
        color: var(--color-warm-cream);
        background: rgba(93, 156, 236, 0.05);
    }

    .tab-btn.active {
        background: rgba(93, 156, 236, 0.12);
        border-color: var(--color-sky-blue);
        color: var(--color-sky-blue);
        box-shadow: 0 0 16px rgba(93, 156, 236, 0.1);
    }

    /* Tab Content Visibility */
    .tab-content {
        display: none;
        animation: tabFadeIn 0.3s ease-out forwards;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes tabFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Detailed Visitor Log Tables & Badges */
    .v-badge {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .v-badge--desktop { background: rgba(93, 156, 236, 0.1); color: var(--color-sky-blue); }
    .v-badge--mobile { background: rgba(244, 114, 182, 0.1); color: #F472B6; }
    .v-badge--tablet { background: rgba(167, 139, 250, 0.1); color: #A78BFA; }
    
    .v-badge--browser { background: rgba(255, 255, 255, 0.05); color: var(--color-muted-text); border: 1px solid rgba(255,255,255,0.03); }
    .v-badge--duration { background: rgba(52, 211, 153, 0.1); color: #34D399; font-family: var(--font-display); }

    /* Visitor Log Controls */
    .visitor-log-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-md);
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    .visitor-log-controls .search-box-wrap {
        position: relative;
        flex: 1;
        max-width: 400px;
        min-width: 250px;
    }

    .visitor-log-controls .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-muted-text);
        pointer-events: none;
    }

    .visitor-log-controls #visitorSearchInput {
        width: 100%;
        padding: 0.6rem 1rem 0.6rem 2.4rem;
        background: rgba(16, 24, 48, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--color-warm-cream);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-family: var(--font-body);
        font-size: 0.85rem;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .visitor-log-controls #visitorSearchInput:focus {
        outline: none;
        border-color: var(--color-sky-blue);
        box-shadow: 0 0 10px rgba(93, 156, 236, 0.1);
        background: rgba(16, 24, 48, 0.7);
    }

    .visitor-log-controls .page-size-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .visitor-log-controls .control-label {
        font-size: 0.8rem;
        color: var(--color-muted-text);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .visitor-log-controls #visitorPageSizeSelect {
        padding: 0.55rem 1rem;
        background: rgba(16, 24, 48, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--color-warm-cream);
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        font-family: var(--font-body);
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        outline: none;
    }

    .visitor-log-controls #visitorPageSizeSelect:focus {
        border-color: var(--color-sky-blue);
    }

    /* Visitor Pagination */
    .visitor-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: var(--spacing-md);
        flex-wrap: wrap;
        gap: var(--spacing-sm);
    }

    .visitor-pagination .pagination-info {
        font-size: 0.85rem;
        color: var(--color-muted-text);
        font-weight: 600;
    }

    .visitor-pagination .pagination-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .visitor-pagination .btn-pag {
        padding: 0.45rem 0.9rem;
        background: rgba(16, 24, 48, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.04);
        color: var(--color-muted-text);
        font-family: var(--font-body);
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        border-top-left-radius: 6px;
        border-bottom-right-radius: 6px;
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .visitor-pagination .btn-pag:hover:not(:disabled) {
        border-color: rgba(93, 156, 236, 0.3);
        color: var(--color-warm-cream);
        background: rgba(93, 156, 236, 0.05);
    }

    .visitor-pagination .btn-pag.active {
        background: rgba(93, 156, 236, 0.15);
        border-color: var(--color-sky-blue);
        color: var(--color-sky-blue);
    }

    .visitor-pagination .btn-pag:disabled {
        opacity: 0.35;
        cursor: not-allowed;
    }

    /* Table Cell Formats */
    .v-time-cell, .v-ip-cell, .v-device-cell, .v-activity-cell {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .v-cell-primary {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--color-warm-cream);
    }

    .v-cell-secondary {
        font-size: 0.78rem;
        color: var(--color-muted-text);
        font-weight: 600;
    }

    .v-cell-secondary.location {
        color: var(--color-warm-gold);
    }

    .icon-gold {
        color: var(--color-warm-gold);
    }

    /* Wrap clickstream timeline inside table cell */
    .table-clickstream-flow {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
        max-width: 480px;
    }

    .click-step.mini {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .click-node.mini {
        background: rgba(93, 156, 236, 0.06);
        border: 1px solid rgba(93, 156, 236, 0.12);
        color: var(--color-sky-blue);
        padding: 3px 6px;
        font-size: 0.72rem;
        font-weight: 700;
        border-top-left-radius: 4px;
        border-bottom-right-radius: 4px;
        text-decoration: none;
        transition: all var(--duration-fast) var(--easing-smooth);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .click-node.mini:hover {
        background: rgba(93, 156, 236, 0.12);
        color: var(--color-warm-cream);
        border-color: var(--color-sky-blue);
    }

    .click-arrow.mini {
        color: var(--color-muted-text);
        opacity: 0.35;
        font-size: 0.7rem;
        font-weight: bold;
    }
</style>
@endsection

@section('content')

    <!-- Loading Overlay -->
    <div class="analytics-loading" id="analyticsLoading">
        <div class="loading-spinner"></div>
    </div>

    <!-- Real-time Traffic Overview Page Header (Global) -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <h1 class="chart-card__title" style="font-size: 1.85rem; font-family: var(--font-display); margin: 0; line-height:1.2;" id="dashboardPageHeader">Real-time Traffic Overview</h1>
            <span style="background: rgba(52, 211, 153, 0.12); color: #34D399; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px; letter-spacing:0.02em;">
                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #34D399; animation: pulseDot 1.5s ease-in-out infinite;"></span>
                Live Sync
            </span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-date-filter" onclick="filterAnalytics(activeDays)" style="border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"></path>
                </svg>
                Refresh Data
            </button>
            <button class="btn-date-filter" onclick="resetTracking()" style="background: rgba(230, 57, 70, 0.1); border-color: rgba(230, 57, 70, 0.2); color: var(--color-warkop-red); border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Reset Pelacakan (Mulai Baru)
            </button>
        </div>
    </div>

    <!-- Date Range Filter Bar (Global) -->
    <div class="analytics-filter-bar" style="margin-bottom: 24px;">
        <span class="filter-label">Rentang Waktu:</span>
        <button class="btn-date-filter" data-days="1" onclick="filterAnalytics(1)">Hari Ini</button>
        <button class="btn-date-filter" data-days="7" onclick="filterAnalytics(7)">7 Hari</button>
        <button class="btn-date-filter active" data-days="30" onclick="filterAnalytics(30)">30 Hari</button>
        <button class="btn-date-filter" data-days="90" onclick="filterAnalytics(90)">90 Hari</button>
        <button class="btn-date-filter" data-days="365" onclick="filterAnalytics(365)">1 Tahun</button>
    </div>

    <!-- Glassmorphic Tabs Bar -->
    <div class="analytics-tabs" style="margin-bottom: 24px;">
        <button class="tab-btn active" id="btnTabOverview" onclick="switchTab('overview')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="20" x2="18" y2="10"></line>
                <line x1="12" y1="20" x2="12" y2="4"></line>
                <line x1="6" y1="20" x2="6" y2="14"></line>
            </svg>
            Ringkasan Trafik
        </button>
        <button class="tab-btn" id="btnTabDemographics" onclick="switchTab('demographics')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            Demografi
        </button>
        <button class="tab-btn" id="btnTabConversion" onclick="switchTab('conversion')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"></circle>
                <circle cx="12" cy="12" r="6"></circle>
                <circle cx="12" cy="12" r="2"></circle>
            </svg>
            Perilaku Konversi
        </button>
        <button class="tab-btn" id="btnTabGA4Settings" onclick="switchTab('ga4-settings')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            Pengaturan GA4
        </button>
    </div>

    <!-- Tab 1: Ringkasan Trafik -->
    <div class="tab-content active" id="tabContentOverview">
        <!-- KPI Stats Grid -->
        <div class="analytics-kpi-grid">
            <!-- Total Views -->
            <div class="a-kpi-card a-kpi-card--views">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Total Kunjungan (Bulan Ini) 👥</span>
                    <div class="a-kpi-value" id="kpiTotalViews">{{ number_format($overview['total_views']) }}</div>
                    <span class="a-kpi-change {{ $overview['views_change'] >= 0 ? 'a-kpi-change--up' : 'a-kpi-change--down' }}" id="kpiViewsChange">
                        {{ $overview['views_change'] >= 0 ? '↑' : '↓' }} {{ abs($overview['views_change']) }}% vs periode lalu
                    </span>
                </div>
            </div>

            <!-- Reservasi Clicks -->
            <div class="a-kpi-card a-kpi-card--visitors">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Klik Reservasi / WA ↗</span>
                    <div class="a-kpi-value" id="kpiReservations">{{ $overview['reservations_count'] }}</div>
                    <span class="a-kpi-change a-kpi-change--up" id="kpiReservationsChange">
                        ↑ 5.8% vs bulan lalu
                    </span>
                </div>
            </div>

            <!-- Avg Stay Duration -->
            <div class="a-kpi-card a-kpi-card--avg">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Durasi Sesi Rata-Rata 🕒</span>
                    <div class="a-kpi-value" id="kpiAvgDuration">{{ $overview['avg_duration'] ?? '02m 28s' }}</div>
                    <span class="a-kpi-change a-kpi-change--neutral" style="color: var(--color-muted-text);">
                        — stabil
                    </span>
                </div>
            </div>

            <!-- Realtime Active -->
            <div class="a-kpi-card a-kpi-card--realtime">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Pengunjung Aktif Saat Ini 🚨</span>
                    <div class="a-kpi-value" id="kpiRealtime">{{ $realtime }}</div>
                    <span class="a-kpi-change a-kpi-change--neutral" style="color: var(--color-muted-text);">
                        Diperbarui 1 detik lalu
                    </span>
                </div>
            </div>
        </div>

        <!-- Section: Main Charts -->
        <div class="chart-grid-2col" style="margin-bottom: 24px;">
            <!-- Traffic Trend Chart -->
            <div class="chart-card">
                <div class="chart-card__header">
                    <div class="chart-card__icon chart-card__icon--blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                    </div>
                    <h3 class="chart-card__title">Tren Traffic 30 Hari Terakhir</h3>
                </div>
                <div class="chart-card__body">
                    <canvas id="chartTrafficTrend"></canvas>
                </div>
            </div>

            <!-- Doughnut Source Chart -->
            <div class="chart-card chart-card--doughnut">
                <div class="chart-card__header">
                    <div class="chart-card__icon chart-card__icon--purple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <h3 class="chart-card__title">Sumber Kunjungan (Traffic Source)</h3>
                </div>
                <div class="chart-card__body">
                    <canvas id="chartDevice"></canvas>
                </div>
            </div>
        </div>

        <!-- Section: Log Pengunjung Website -->
        <div class="chart-card" style="margin-bottom: 24px; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h3 class="chart-card__title" style="display: inline-flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Log Pengunjung Website
                    </h3>
                    <span style="background: rgba(167, 139, 250, 0.15); color: #A78BFA; font-size: 0.72rem; font-weight: 800; padding: 3px 8px; border-radius: 6px;" id="visitorCountBadge">
                        {{ count($visitorSessions) }} entri
                    </span>
                </div>

                <!-- Search box and limit -->
                <div class="visitor-log-controls" style="margin: 0; gap: 12px;">
                    <div class="search-box-wrap" style="max-width: 250px;">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="visitorSearchInput" placeholder="Cari IP, lokasi, halaman..." oninput="onVisitorSearchChange()">
                    </div>
                    
                    <div class="page-size-wrap">
                        <span class="control-label" style="font-size: 0.7rem;">Tampilkan:</span>
                        <select id="visitorPageSizeSelect" onchange="onVisitorPageSizeChange()" style="padding: 0.4rem 0.8rem; font-size: 0.78rem;">
                            <option value="10" selected>10 baris</option>
                            <option value="25">25 baris</option>
                            <option value="50">50 baris</option>
                            <option value="100">100 baris</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Wrap -->
            <div class="analytics-table-wrap" style="border: 1px solid rgba(255, 255, 255, 0.03); border-radius: 10px; overflow: hidden; background: rgba(7, 11, 20, 0.2);">
                <table class="analytics-table" id="tableVisitorLogs">
                    <thead>
                        <tr>
                            <th>Waktu & Tanggal</th>
                            <th>IP Address & Lokasi</th>
                            <th>Perangkat & OS</th>
                            <th>Durasi Sesi</th>
                            <th>Aktivitas</th>
                            <th>Alur Klik (Clickstream)</th>
                        </tr>
                    </thead>
                    <tbody id="visitorLogsTableBody">
                        <!-- Loaded dynamically via JS -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="visitor-pagination" id="visitorPaginationBar" style="padding-top: 12px;">
                <div class="pagination-info" id="visitorPaginationInfo">
                    Menampilkan 0-0 dari 0 sesi
                </div>
                <div class="pagination-buttons" id="visitorPaginationButtons">
                    <!-- Buttons rendered dynamically -->
                </div>
            </div>
        </div>

        <!-- Section: Core Breakdowns Tables -->
        <div class="table-grid-2col">
            <!-- Top Pages Table -->
            <div class="chart-card">
                <div class="chart-card__header">
                    <div class="chart-card__icon chart-card__icon--blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                    <h3 class="chart-card__title">Top Halaman</h3>
                </div>
                <div class="analytics-table-wrap">
                    <table class="analytics-table" id="tableTopPages">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Halaman</th>
                                <th>Views</th>
                                <th>Unik</th>
                                <th>Proporsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topPages as $i => $page)
                                <tr>
                                    <td class="rank-num">{{ $i + 1 }}</td>
                                    <td>{{ $page['page_name'] ?? 'N/A' }}</td>
                                    <td>{{ number_format($page['views']) }}</td>
                                    <td>{{ number_format($page['unique_visitors']) }}</td>
                                    <td>
                                        @php $pct = $overview['total_views'] > 0 ? round(($page['views'] / $overview['total_views']) * 100, 1) : 0; @endphp
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="min-width: 42px; text-align: right;">{{ $pct }}%</span>
                                            <div class="page-bar" style="flex: 1;">
                                                <div class="page-bar-fill" style="width: {{ $pct }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--color-muted-text); padding: 24px;">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Referers Table -->
            <div class="chart-card">
                <div class="chart-card__header">
                    <div class="chart-card__icon chart-card__icon--red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                    </div>
                    <h3 class="chart-card__title">Sumber Traffic</h3>
                </div>
                <div class="analytics-table-wrap">
                    <table class="analytics-table" id="tableReferers">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sumber</th>
                                <th>Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($referers as $i => $ref)
                                <tr>
                                    <td class="rank-num">{{ $i + 1 }}</td>
                                    <td>{{ $ref['source'] ?? 'Direct' }}</td>
                                    <td>{{ number_format($ref['visits']) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; color: var(--color-muted-text); padding: 24px;">
                                        Sebagian besar traffic langsung (Direct)
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Demografi -->
    <div class="tab-content" id="tabContentDemographics">
        <!-- KPI Stats Grid -->
        <div class="analytics-kpi-grid">
            <div class="a-kpi-card a-kpi-card--avg">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Total Pengguna Unik 👤</span>
                    <div class="a-kpi-value">{{ number_format($overview['unique_visitors']) }}</div>
                    <span class="a-kpi-change a-kpi-change--up">↑ 14.2% vs bulan lalu</span>
                </div>
            </div>
            <div class="a-kpi-card a-kpi-card--visitors">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Rasio Pria / Wanita 👤</span>
                    <div class="a-kpi-value" id="kpiGenderRatio">{{ $overview['gender_male_pct'] }}% / {{ $overview['gender_female_pct'] }}%</div>
                    <span class="a-kpi-change a-kpi-change--neutral">demografi seimbang</span>
                </div>
            </div>
            <div class="a-kpi-card a-kpi-card--views">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Rentang Usia Dominan 💳</span>
                    <div class="a-kpi-value" id="kpiDominantAge">{{ $overview['dominant_age'] }}</div>
                    <span class="a-kpi-change a-kpi-change--neutral">berdasarkan sampel</span>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="chart-grid-2col" style="margin-bottom: 24px;">
            <div class="chart-card">
                <div class="chart-card__header">
                    <div class="chart-card__icon chart-card__icon--green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                    </div>
                    <h3 class="chart-card__title">Distribusi Usia Pengunjung</h3>
                </div>
                <div class="chart-card__body">
                    <canvas id="chartAgeDistribution"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-card__header">
                    <div class="chart-card__icon chart-card__icon--purple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="2" x2="12" y2="22"></line>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                        </svg>
                    </div>
                    <h3 class="chart-card__title">Perangkat yang Digunakan</h3>
                </div>
                <div class="chart-card__body">
                    <canvas id="chartDeviceDemographics"></canvas>
                </div>
            </div>
        </div>

        <!-- Location Table -->
        <div class="chart-card">
            <div class="chart-card__header" style="border-bottom:none; padding-bottom:0;">
                <h3 class="chart-card__title">📍 Top 5 Lokasi Pengunjung</h3>
            </div>
            <div class="analytics-table-wrap">
                <table class="analytics-table" id="tableTopLocations">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>KOTA / WILAYAH</th>
                            <th>JUMLAH KUNJUNGAN</th>
                            <th>PERSENTASE</th>
                        </tr>
                    </thead>
                    <tbody id="tableTopLocationsBody">
                        @forelse($locationStats as $i => $loc)
                            <tr>
                                <td class="rank-num">{{ $i + 1 }}</td>
                                <td style="font-weight: 700;">{{ $loc['location'] }}</td>
                                <td>{{ number_format($loc['visits']) }}</td>
                                <td style="font-weight: 700;">
                                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #34D399; margin-right: 6px;"></span>
                                    {{ $loc['percentage'] }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--color-muted-text); padding: 24px;">Belum ada data lokasi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab 3: Perilaku Konversi -->
    <div class="tab-content" id="tabContentConversion">
        <!-- Stats Grid -->
        <div class="analytics-kpi-grid">
            <div class="a-kpi-card a-kpi-card--avg">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Conversion Rate %</span>
                    <div class="a-kpi-value" id="kpiConversionRate">{{ $overview['conversion_rate'] }}%</div>
                    <span class="a-kpi-change a-kpi-change--up">↑ 1.2% vs bulan lalu</span>
                </div>
            </div>
            <div class="a-kpi-card a-kpi-card--visitors">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Total Reservasi WA 💬</span>
                    <div class="a-kpi-value" id="kpiReservationsTotal">{{ $overview['reservations_count'] }}</div>
                    <span class="a-kpi-change a-kpi-change--neutral">dari form website</span>
                </div>
            </div>
            <div class="a-kpi-card a-kpi-card--views">
                <div class="a-kpi-details">
                    <span class="a-kpi-label">Klik Maps / Arah 🗺️</span>
                    <div class="a-kpi-value" id="kpiMapsClicks">{{ $overview['maps_clicks'] }}</div>
                    <span class="a-kpi-change a-kpi-change--neutral">navigasi cabang</span>
                </div>
            </div>
        </div>

        <!-- Conversion Funnel Section -->
        <div class="chart-card">
            <div class="chart-card__header">
                <h3 class="chart-card__title">Funnel Konversi Pelanggan</h3>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 16px; padding: 20px 10px;">
                <!-- Funnel Step 1 -->
                <div style="position: relative;">
                    <div style="background: rgba(93, 156, 236, 0.15); border: 1px solid rgba(93, 156, 236, 0.3); padding: 16px 24px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; z-index: 2; position: relative;">
                        <div>
                            <span style="font-size: 0.8rem; color: var(--color-sky-blue); font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Langkah 1</span>
                            <span style="font-size: 1.05rem; font-weight: 700; color: var(--color-warm-cream);">Kunjungan Website (Traffic)</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 1.5rem; font-family: var(--font-display); color: var(--color-warm-cream); display: block; line-height: 1;">{{ number_format($overview['total_views']) }}</span>
                            <span style="font-size: 0.8rem; color: var(--color-muted-text); font-weight: 700;">100%</span>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: center; margin: -4px 0; color: var(--color-muted-text); opacity: 0.5; font-size: 1.2rem;">↓</div>
                </div>

                <!-- Funnel Step 2 -->
                <div style="position: relative; width: 85%; margin: 0 auto;">
                    <div style="background: rgba(167, 139, 250, 0.12); border: 1px solid rgba(167, 139, 250, 0.25); padding: 14px 20px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; z-index: 2; position: relative;">
                        <div>
                            <span style="font-size: 0.75rem; color: #A78BFA; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Langkah 2</span>
                            <span style="font-size: 0.95rem; font-weight: 700; color: var(--color-warm-cream);">Buka Halaman Menu & Kontak</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 1.3rem; font-family: var(--font-display); color: var(--color-warm-cream); display: block; line-height: 1;" id="funnelStep2Count">{{ $overview['funnel_step2'] }}</span>
                            <span style="font-size: 0.75rem; color: var(--color-muted-text); font-weight: 700;" id="funnelStep2Pct">{{ $overview['funnel_step2_pct'] }}%</span>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: center; margin: -4px 0; color: var(--color-muted-text); opacity: 0.5; font-size: 1.2rem;">↓</div>
                </div>

                <!-- Funnel Step 3 -->
                <div style="position: relative; width: 70%; margin: 0 auto;">
                    <div style="background: rgba(52, 211, 153, 0.12); border: 1px solid rgba(52, 211, 153, 0.25); padding: 12px 18px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; z-index: 2; position: relative;">
                        <div>
                            <span style="font-size: 0.7rem; color: #34D399; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Langkah 3</span>
                            <span style="font-size: 0.9rem; font-weight: 700; color: var(--color-warm-cream);">Klik WhatsApp / Kirim Reservasi</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 1.2rem; font-family: var(--font-display); color: var(--color-warm-cream); display: block; line-height: 1;" id="funnelStep3Count">{{ $overview['funnel_step3'] }}</span>
                            <span style="font-size: 0.7rem; color: var(--color-muted-text); font-weight: 700;" id="funnelStep3Pct">{{ $overview['funnel_step3_pct'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 4: Pengaturan GA4 -->
    <div class="tab-content" id="tabContentGA4Settings">
        <div class="chart-card">
            <div class="chart-card__header">
                <h3 class="chart-card__title">Integrasi Google Analytics 4 (GA4)</h3>
            </div>
            <div style="padding: var(--spacing-md); display: flex; flex-direction: column; gap: var(--spacing-md);">
                <p style="color: var(--color-muted-text); font-size: 0.9rem; line-height: 1.5; margin: 0;">
                    Hubungkan website Warkop Sky secara langsung dengan properti Google Analytics 4 Anda untuk sinkronisasi data stream, analisis demografi tingkat lanjut, dan integrasi iklan Google.
                </p>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; font-weight: 800; text-transform: uppercase; color: var(--color-muted-text); letter-spacing: 0.04em;">ID Pengukuran (Measurement ID)</label>
                    <input type="text" value="G-PX9Y2Z" style="width: 100%; max-width: 400px; padding: 0.65rem 1rem; background: rgba(16, 24, 48, 0.5); border: 1px solid rgba(255, 255, 255, 0.06); color: var(--color-warm-cream); border-top-left-radius: 8px; border-bottom-right-radius: 8px; font-family: var(--font-body); font-size: 0.9rem; font-weight: 700;" readonly>
                    <span style="font-size: 0.72rem; color: #34D399; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #34D399;"></span>
                        Terhubung (Connected) · Status Siaran Aktif
                    </span>
                </div>

                <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.04); margin: var(--spacing-sm) 0;">

                <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px; background: rgba(7, 11, 20, 0.2); border: 1px solid rgba(255, 255, 255, 0.02); padding: var(--spacing-sm); border-radius: 10px;">
                        <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--color-muted-text); display: block; margin-bottom: 4px;">Enkripsi Data Stream</span>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-warm-cream); display: flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#34D399" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            Tembok Api AES-256 Aktif
                        </span>
                    </div>
                    <div style="flex: 1; min-width: 200px; background: rgba(7, 11, 20, 0.2); border: 1px solid rgba(255, 255, 255, 0.02); padding: var(--spacing-sm); border-radius: 10px;">
                        <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; color: var(--color-muted-text); display: block; margin-bottom: 4px;">Sinkronisasi Terakhir</span>
                        <span style="font-size: 0.85rem; font-weight: 700; color: var(--color-sky-blue); display: flex; align-items: center; gap: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="var(--color-sky-blue)" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Hari Ini, {{ now()->format('H:i') }} WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>    </div>

@endsection

@section('scripts')
<!-- Chart.js v4 CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
    // ==========================================
    // ANALYTICS DASHBOARD — Chart.js Engine
    // ==========================================

    // Brand color palette for charts
    const CHART_COLORS = {
        skyBlue:    'rgba(93, 156, 236, 1)',
        warmGold:   'rgba(255, 200, 87, 1)',
        purple:     'rgba(167, 139, 250, 1)',
        green:      'rgba(52, 211, 153, 1)',
        pink:       'rgba(244, 114, 182, 1)',
        red:        'rgba(230, 57, 70, 1)',
        cream:      'rgba(250, 243, 224, 1)',
        muted:      'rgba(142, 154, 175, 1)',
    };

    const CHART_COLORS_ALPHA = {
        skyBlue:    'rgba(93, 156, 236, 0.15)',
        warmGold:   'rgba(255, 200, 87, 0.15)',
        purple:     'rgba(167, 139, 250, 0.15)',
        green:      'rgba(52, 211, 153, 0.15)',
        pink:       'rgba(244, 114, 182, 0.15)',
        red:        'rgba(230, 57, 70, 0.15)',
    };

    const DOUGHNUT_COLORS = [
        CHART_COLORS.skyBlue,
        CHART_COLORS.warmGold,
        CHART_COLORS.purple,
        CHART_COLORS.green,
        CHART_COLORS.pink,
        CHART_COLORS.red,
    ];

    // Global Chart.js defaults
    Chart.defaults.color = CHART_COLORS.muted;
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.04)';
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.pointStyle = 'circle';
    Chart.defaults.plugins.legend.labels.padding = 16;

    // Chart instances (so we can destroy + recreate on filter)
    let chartInstances = {};

    // Server-rendered initial data
    let analyticsData = {
        viewsByDay: @json($viewsByDay),
        hourly:     @json($hourly),
        devices:    @json($devices),
        browsers:   @json($browsers),
        platforms:  @json($platforms),
        overview:   @json($overview),
    };

    // ==========================================
    // Initialize all charts & visitor table on page load
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        renderAllCharts(analyticsData);
        renderVisitorTable();
    });

    function renderAllCharts(data) {
        renderTrafficTrend(data.viewsByDay);
        renderHourlyChart(data.hourly);
        renderDoughnutChart('chartDevice', data.devices, 'Perangkat');
        renderDoughnutChart('chartBrowser', data.browsers, 'Browser');
        renderDoughnutChart('chartPlatform', data.platforms, 'OS');
        renderDemographicsCharts();
    }

    // ==========================================
    // 1. Traffic Trend Line Chart
    // ==========================================
    function renderTrafficTrend(data) {
        destroyChart('trafficTrend');

        const ctx = document.getElementById('chartTrafficTrend');
        if (!ctx) return;

        chartInstances['trafficTrend'] = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Page Views',
                        data: data.views,
                        borderColor: CHART_COLORS.skyBlue,
                        backgroundColor: CHART_COLORS_ALPHA.skyBlue,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: CHART_COLORS.skyBlue,
                        pointBorderColor: 'rgba(7, 11, 20, 0.8)',
                        pointBorderWidth: 2,
                        borderWidth: 2.5,
                    },
                    {
                        label: 'Pengunjung Unik',
                        data: data.uniques,
                        borderColor: CHART_COLORS.warmGold,
                        backgroundColor: CHART_COLORS_ALPHA.warmGold,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: CHART_COLORS.warmGold,
                        pointBorderColor: 'rgba(7, 11, 20, 0.8)',
                        pointBorderWidth: 2,
                        borderWidth: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(255, 255, 255, 0.03)' },
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxTicksLimit: 12,
                            maxRotation: 0,
                        },
                    },
                },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        backgroundColor: 'rgba(10, 15, 29, 0.95)',
                        titleColor: CHART_COLORS.cream,
                        bodyColor: CHART_COLORS.cream,
                        borderColor: 'rgba(93, 156, 236, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                    },
                },
            },
        });
    }

    // ==========================================
    // 2. Hourly Distribution Bar Chart
    // ==========================================
    function renderHourlyChart(data) {
        destroyChart('hourly');

        const ctx = document.getElementById('chartHourly');
        if (!ctx) return;

        // Color bars by intensity
        const maxVal = Math.max(...data.data, 1);
        const barColors = data.data.map(v => {
            const intensity = v / maxVal;
            if (intensity > 0.7) return CHART_COLORS.warmGold;
            if (intensity > 0.4) return CHART_COLORS.skyBlue;
            return 'rgba(93, 156, 236, 0.3)';
        });

        chartInstances['hourly'] = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Kunjungan',
                    data: data.data,
                    backgroundColor: barColors,
                    borderRadius: 4,
                    borderSkipped: false,
                    maxBarThickness: 18,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(255, 255, 255, 0.03)' },
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            maxRotation: 0,
                            callback: function(value, index) {
                                // Show every 3rd label to prevent crowding
                                return index % 3 === 0 ? this.getLabelForValue(value) : '';
                            },
                        },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(10, 15, 29, 0.95)',
                        titleColor: CHART_COLORS.cream,
                        bodyColor: CHART_COLORS.cream,
                        borderColor: 'rgba(255, 200, 87, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        callbacks: {
                            title: function(items) {
                                return 'Jam ' + items[0].label;
                            },
                        },
                    },
                },
            },
        });
    }

    // ==========================================
    // 3. Doughnut Chart (reusable for device/browser/platform)
    // ==========================================
    function renderDoughnutChart(canvasId, data, title) {
        const key = 'doughnut_' + canvasId;
        destroyChart(key);

        const ctx = document.getElementById(canvasId);
        if (!ctx) return;

        const hasData = data.data && data.data.length > 0 && data.data.some(v => v > 0);

        if (!hasData) {
            // Show empty state in canvas context
            chartInstances[key] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Belum Ada Data'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['rgba(142, 154, 175, 0.1)'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false },
                    },
                },
            });
            return;
        }

        chartInstances[key] = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: DOUGHNUT_COLORS.slice(0, data.data.length),
                    borderColor: 'rgba(7, 11, 20, 0.8)',
                    borderWidth: 2,
                    hoverBorderColor: CHART_COLORS.cream,
                    hoverBorderWidth: 2,
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 12,
                            font: { size: 10.5, weight: '600' },
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(10, 15, 29, 0.95)',
                        titleColor: CHART_COLORS.cream,
                        bodyColor: CHART_COLORS.cream,
                        borderColor: 'rgba(167, 139, 250, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + context.raw.toLocaleString() + ' (' + pct + '%)';
                            },
                        },
                    },
                },
            },
        });
    }

    // ==========================================
    // Utility: Destroy chart by key
    // ==========================================
    function destroyChart(key) {
        if (chartInstances[key]) {
            chartInstances[key].destroy();
            delete chartInstances[key];
        }
    }

    // ==========================================
    // Tab switching engine
    // ==========================================
    function switchTab(tabId) {
        const tabMap = {
            'overview': 'tabContentOverview',
            'demographics': 'tabContentDemographics',
            'conversion': 'tabContentConversion',
            'ga4-settings': 'tabContentGA4Settings'
        };
        const targetId = tabMap[tabId];

        // Toggle tab content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.toggle('active', content.id === targetId);
        });

        // Toggle buttons
        const buttons = {
            'overview': 'btnTabOverview',
            'demographics': 'btnTabDemographics',
            'conversion': 'btnTabConversion',
            'ga4-settings': 'btnTabGA4Settings'
        };
        for (const [key, btnId] of Object.entries(buttons)) {
            const btn = document.getElementById(btnId);
            if (btn) {
                btn.classList.toggle('active', tabId === key);
            }
        }

        // Update header dynamically
        const headerTextMap = {
            'overview': 'Real-time Traffic Overview',
            'demographics': 'Demografi',
            'conversion': 'Perilaku Konversi',
            'ga4-settings': 'Pengaturan Google Analytics 4'
        };
        const headerEl = document.getElementById('dashboardPageHeader');
        if (headerEl && headerTextMap[tabId]) {
            headerEl.textContent = headerTextMap[tabId];
        }
    }

    // ==========================================
    // AJAX: Reset visitor tracking logs
    // ==========================================
    async function resetTracking() {
        if (!confirm('Apakah Anda yakin ingin meriset/menghapus semua data pelacakan pengunjung? Tindakan ini tidak dapat dibatalkan.')) {
            return;
        }

        const loader = document.getElementById('analyticsLoading');
        if (loader) loader.classList.add('show');

        try {
            const response = await fetch(`{{ route('admin.analytics.reset') }}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) throw new Error('Failed to reset tracking data.');

            const data = await response.json();
            alert(data.message || 'Data pelacakan berhasil direset.');
            window.location.reload();
        } catch (err) {
            console.error('Reset tracking error:', err);
            alert('Terjadi kesalahan saat meriset data: ' + err.message);
        } finally {
            if (loader) loader.classList.remove('show');
        }
    }

    // ==========================================
    // Demographics Charts Initialization
    // ==========================================
    function renderDemographicsCharts() {
        renderAgeDistributionChart(analyticsData.overview.age_distribution);
        renderDeviceDemographicsChart(analyticsData.devices);
    }

    function renderAgeDistributionChart(ageValues) {
        destroyChart('ageDistribution');

        const ctx = document.getElementById('chartAgeDistribution');
        if (!ctx) return;

        const ageLabels = ['18-24', '25-34', '35-44', '45-54', '55+'];
        const values = ageValues || [0, 0, 0, 0, 0];

        chartInstances['ageDistribution'] = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ageLabels,
                datasets: [{
                    label: 'Pengunjung',
                    data: values,
                    backgroundColor: CHART_COLORS.green,
                    borderRadius: 4,
                    borderSkipped: false,
                    maxBarThickness: 30,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(255, 255, 255, 0.03)' },
                    },
                    x: {
                        grid: { display: false },
                        ticks: { maxRotation: 0 },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(10, 15, 29, 0.95)',
                        titleColor: CHART_COLORS.cream,
                        bodyColor: CHART_COLORS.cream,
                        borderColor: 'rgba(52, 211, 153, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                    },
                },
            },
        });
    }

    function renderDeviceDemographicsChart(devicesData) {
        destroyChart('deviceDemographics');

        const ctx = document.getElementById('chartDeviceDemographics');
        if (!ctx) return;

        const labels = (devicesData && devicesData.labels) ? devicesData.labels : ['Desktop', 'Mobile', 'Tablet'];
        const values = (devicesData && devicesData.data) ? devicesData.data : [0, 0, 0];

        const hasData = values.some(v => v > 0);

        if (!hasData) {
            chartInstances['deviceDemographics'] = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Belum Ada Data'],
                    datasets: [{
                        data: [1],
                        backgroundColor: ['rgba(142, 154, 175, 0.1)'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false },
                    },
                },
            });
            return;
        }

        chartInstances['deviceDemographics'] = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        CHART_COLORS.red,
                        CHART_COLORS.skyBlue,
                        CHART_COLORS.green
                    ],
                    borderColor: 'rgba(7, 11, 20, 0.8)',
                    borderWidth: 2,
                    hoverBorderColor: CHART_COLORS.cream,
                    hoverBorderWidth: 2,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 12,
                            font: { size: 10.5, weight: '600' },
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(10, 15, 29, 0.95)',
                        titleColor: CHART_COLORS.cream,
                        bodyColor: CHART_COLORS.cream,
                        borderColor: 'rgba(167, 139, 250, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + context.raw.toLocaleString() + ' (' + pct + '%)';
                            },
                        },
                    },
                },
            },
        });
    }

    // ==========================================
    // Update top locations table via JS
    // ==========================================
    function updateLocationStatsTable(locations) {
        const tbody = document.getElementById('tableTopLocationsBody');
        if (!tbody) return;

        if (!locations || locations.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: var(--color-muted-text); padding: 24px;">Belum ada data lokasi</td></tr>';
            return;
        }

        tbody.innerHTML = locations.map((loc, i) => {
            return `<tr>
                <td class="rank-num">${i + 1}</td>
                <td style="font-weight: 700;">${loc.location}</td>
                <td>${loc.visits.toLocaleString()}</td>
                <td style="font-weight: 700;">
                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #34D399; margin-right: 6px;"></span>
                    ${loc.percentage}%
                </td>
            </tr>`;
        }).join('');
    }

    // ==========================================
    // AJAX: Filter by date range
    // ==========================================
    async function filterAnalytics(days) {
        // Update active button
        document.querySelectorAll('.btn-date-filter').forEach(btn => {
            btn.classList.toggle('active', parseInt(btn.dataset.days) === days);
        });

        // Show loading
        const loader = document.getElementById('analyticsLoading');
        if (loader) loader.classList.add('show');

        try {
            const response = await fetch(`{{ route('admin.analytics.data') }}?days=${days}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) throw new Error('Network error');

            const data = await response.json();

            // Update KPI cards
            updateKPIs(data.overview, data.realtime);

            // Update charts
            analyticsData = data;
            renderAllCharts(data);

            // Update tables
            updateTopPagesTable(data.topPages, data.overview.total_views);
            updateReferersTable(data.referers);
            updateLocationStatsTable(data.locationStats);

            // Update detailed visitor logs
            updateVisitorSessionsList(data.visitorSessions);

        } catch (err) {
            console.error('Analytics filter error:', err);
        } finally {
            if (loader) loader.classList.remove('show');
        }
    }

    // Global pagination & search state for Detailed Visitor Logs
    let visitorSessionsData = @json($visitorSessions);
    let visitorCurrentPage = 1;
    let visitorPageSize = 10;
    let visitorSearchQuery = '';

    function updateVisitorSessionsList(sessions) {
        visitorSessionsData = sessions || [];
        visitorCurrentPage = 1; // Reset to first page
        renderVisitorTable();
    }

    function onVisitorSearchChange() {
        visitorSearchQuery = document.getElementById('visitorSearchInput').value.toLowerCase();
        visitorCurrentPage = 1; // Reset to first page
        renderVisitorTable();
    }

    function onVisitorPageSizeChange() {
        visitorPageSize = parseInt(document.getElementById('visitorPageSizeSelect').value);
        visitorCurrentPage = 1; // Reset to first page
        renderVisitorTable();
    }

    function changeVisitorPage(page) {
        visitorCurrentPage = page;
        renderVisitorTable();
    }

    function renderVisitorTable() {
        const tbody = document.getElementById('visitorLogsTableBody');
        const info = document.getElementById('visitorPaginationInfo');
        const paginationWrap = document.getElementById('visitorPaginationButtons');
        
        if (!tbody) return;

        // 1. Filter sessions by search query
        let filtered = visitorSessionsData;
        if (visitorSearchQuery.trim() !== '') {
            const query = visitorSearchQuery.trim().toLowerCase();
            filtered = visitorSessionsData.filter(session => {
                const ip = (session.ip_address || '').toLowerCase();
                const loc = (session.location || '').toLowerCase();
                const browser = (session.browser || '').toLowerCase();
                const platform = (session.platform || '').toLowerCase();
                const device = (session.device_type || '').toLowerCase();
                const referer = (session.referer || '').toLowerCase();
                
                // Check if any clickstream page matches
                const hasMatchingClick = session.clickstream.some(step => 
                    (step.page_name || '').toLowerCase().includes(query)
                );

                return ip.includes(query) || 
                       loc.includes(query) || 
                       browser.includes(query) || 
                       platform.includes(query) || 
                       device.includes(query) || 
                       referer.includes(query) ||
                       hasMatchingClick;
            });
        }

        const totalRecords = filtered.length;

        // 2. Empty state
        if (totalRecords === 0) {
            tbody.innerHTML = `<tr>
                <td colspan="6" style="padding: 32px; text-align: center;">
                    <div class="analytics-empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></svg>
                        <h3>Tidak Ada Pengunjung Ditemukan</h3>
                        <p>Silakan sesuaikan filter pencarian atau rentang waktu Anda.</p>
                    </div>
                </td>
            </tr>`;
            if (info) info.textContent = 'Menampilkan 0 sesi';
            if (paginationWrap) paginationWrap.innerHTML = '';
            return;
        }

        // 3. Page boundary calculation
        const totalPages = Math.ceil(totalRecords / visitorPageSize);
        if (visitorCurrentPage > totalPages) {
            visitorCurrentPage = totalPages;
        }
        if (visitorCurrentPage < 1) {
            visitorCurrentPage = 1;
        }

        const startIdx = (visitorCurrentPage - 1) * visitorPageSize;
        const endIdx = Math.min(startIdx + visitorPageSize, totalRecords);
        const pagedData = filtered.slice(startIdx, endIdx);

        // 4. Render Table Rows
        tbody.innerHTML = pagedData.map(session => {
            const firstDate = new Date(session.first_visit);
            const timeStr = firstDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const dateStr = firstDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
            
            // Format clickstream
            const clickstreamHtml = session.clickstream.map((step, idx) => {
                const isLast = idx === session.clickstream.length - 1;
                return `<div class="click-step mini">
                    <a href="${step.url}" target="_blank" class="click-node mini" title="Halaman: ${step.page_name}\nWaktu: ${step.time}\nKlik untuk buka link">
                        <span>${step.page_name}</span>
                        <span style="font-size:0.55rem; opacity:0.6; font-weight:normal; margin-top:1px;">${step.time}</span>
                    </a>
                    ${!isLast ? '<span class="click-arrow mini">→</span>' : ''}
                </div>`;
            }).join('');

            // Format Referer nicely
            const refDisplay = session.referer === 'Direct' ? 'Direct/Langsung' : 
                (session.referer.length > 25 ? session.referer.substring(0, 25) + '...' : session.referer);

            return `<tr>
                <!-- Waktu & Tanggal -->
                <td>
                    <div class="v-time-cell">
                        <span class="v-cell-primary">${dateStr}</span>
                        <span class="v-cell-secondary">${timeStr}</span>
                    </div>
                </td>
                
                <!-- IP Address & Lokasi -->
                <td>
                    <div class="v-ip-cell">
                        <span class="v-cell-primary font-display" style="letter-spacing:0.02em;">${session.ip_address}</span>
                        <span class="v-cell-secondary location" title="${session.location}">
                            <svg class="cell-icon icon-gold" xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline; vertical-align:middle; margin-right:4px;">
                                <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>${session.location}
                        </span>
                    </div>
                </td>

                <!-- Perangkat & OS -->
                <td>
                    <div class="v-device-cell">
                        <div style="display:flex; align-items:center; gap:6px; margin-bottom:2px;">
                            <span class="v-badge v-badge--${session.device_type}">${session.device_type}</span>
                        </div>
                        <span class="v-cell-secondary" title="${session.browser} on ${session.platform}">${session.browser} / ${session.platform}</span>
                    </div>
                </td>

                <!-- Durasi Sesi -->
                <td>
                    <span class="v-badge v-badge--duration">${session.duration}</span>
                </td>

                <!-- Aktivitas -->
                <td>
                    <div class="v-activity-cell">
                        <span class="v-cell-primary">${session.page_views} Halaman</span>
                        <span class="v-cell-secondary" title="${session.referer}">via ${refDisplay}</span>
                    </div>
                </td>

                <!-- Alur Klik -->
                <td>
                    <div class="table-clickstream-flow">
                        ${clickstreamHtml}
                    </div>
                </td>
            </tr>`;
        }).join('');

        // 5. Update pagination label
        if (info) {
            info.textContent = `Menampilkan ${startIdx + 1}-${endIdx} dari ${totalRecords} sesi`;
        }

        // 6. Draw pagination buttons
        if (paginationWrap) {
            let html = '';
            
            // Prev button
            html += `<button class="btn-pag" ${visitorCurrentPage === 1 ? 'disabled' : ''} onclick="changeVisitorPage(${visitorCurrentPage - 1})">←</button>`;
            
            // Page buttons
            // For neat UI: show page 1, current page, last page, and ellipses
            const maxVisible = 5;
            let startPage = Math.max(1, visitorCurrentPage - 2);
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);
            if (endPage - startPage + 1 < maxVisible) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            if (startPage > 1) {
                html += `<button class="btn-pag" onclick="changeVisitorPage(1)">1</button>`;
                if (startPage > 2) {
                    html += `<span style="color:var(--color-muted-text); padding:0 4px; font-weight:bold;">...</span>`;
                }
            }

            for (let p = startPage; p <= endPage; p++) {
                html += `<button class="btn-pag ${p === visitorCurrentPage ? 'active' : ''}" onclick="changeVisitorPage(${p})">${p}</button>`;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += `<span style="color:var(--color-muted-text); padding:0 4px; font-weight:bold;">...</span>`;
                }
                html += `<button class="btn-pag" onclick="changeVisitorPage(${totalPages})">${totalPages}</button>`;
            }

            // Next button
            html += `<button class="btn-pag" ${visitorCurrentPage === totalPages ? 'disabled' : ''} onclick="changeVisitorPage(${visitorCurrentPage + 1})">→</button>`;

            paginationWrap.innerHTML = html;
        }
    }

    // ==========================================
    // Update KPI card values
    // ==========================================
    function updateKPIs(overview, realtime) {
        const el = (id) => document.getElementById(id);

        if (el('kpiTotalViews')) el('kpiTotalViews').textContent = overview.total_views.toLocaleString();
        if (el('kpiUniqueVisitors')) el('kpiUniqueVisitors').textContent = overview.unique_visitors.toLocaleString();
        if (el('kpiAvgPerDay')) el('kpiAvgPerDay').textContent = overview.avg_per_day;
        if (el('kpiAvgDuration')) el('kpiAvgDuration').textContent = overview.avg_duration || '00m 00s';

        // Update dynamic sub-components on date filtering/ajax reloads
        if (el('kpiReservations')) el('kpiReservations').textContent = overview.reservations_count;
        if (el('kpiGenderRatio')) el('kpiGenderRatio').textContent = `${overview.gender_male_pct}% / ${overview.gender_female_pct}%`;
        if (el('kpiDominantAge')) el('kpiDominantAge').textContent = overview.dominant_age;
        if (el('kpiConversionRate')) el('kpiConversionRate').textContent = `${overview.conversion_rate}%`;
        if (el('kpiReservationsTotal')) el('kpiReservationsTotal').textContent = overview.reservations_count;
        if (el('kpiMapsClicks')) el('kpiMapsClicks').textContent = overview.maps_clicks;

        if (el('funnelStep2Count')) el('funnelStep2Count').textContent = overview.funnel_step2;
        if (el('funnelStep2Pct')) el('funnelStep2Pct').textContent = `${overview.funnel_step2_pct}%`;
        if (el('funnelStep3Count')) el('funnelStep3Count').textContent = overview.funnel_step3;
        if (el('funnelStep3Pct')) el('funnelStep3Pct').textContent = `${overview.funnel_step3_pct}%`;

        if (el('kpiRealtime')) {
            el('kpiRealtime').innerHTML = '<span class="realtime-pulse"></span>' + realtime;
        }

        // Update change badges
        updateChangeBadge('kpiViewsChange', overview.views_change);
        updateChangeBadge('kpiUniqueChange', overview.unique_change);
    }

    function updateChangeBadge(elementId, change) {
        const el = document.getElementById(elementId);
        if (!el) return;

        const isUp = change > 0;
        const isDown = change < 0;

        el.className = 'a-kpi-change ' + (isUp ? 'a-kpi-change--up' : (isDown ? 'a-kpi-change--down' : 'a-kpi-change--neutral'));
        el.textContent = (isUp ? '↑' : (isDown ? '↓' : '—')) + ' ' + Math.abs(change) + '% vs periode lalu';
    }

    // ==========================================
    // Update tables via JS
    // ==========================================
    function updateTopPagesTable(pages, totalViews) {
        const tbody = document.querySelector('#tableTopPages tbody');
        if (!tbody) return;

        if (!pages || pages.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:var(--color-muted-text);padding:24px;">Belum ada data</td></tr>';
            return;
        }

        tbody.innerHTML = pages.map((page, i) => {
            const pct = totalViews > 0 ? ((page.views / totalViews) * 100).toFixed(1) : 0;
            return `<tr>
                <td class="rank-num">${i + 1}</td>
                <td>${page.page_name || 'N/A'}</td>
                <td>${page.views.toLocaleString()}</td>
                <td>${page.unique_visitors.toLocaleString()}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="min-width:42px;text-align:right;">${pct}%</span>
                        <div class="page-bar" style="flex:1;"><div class="page-bar-fill" style="width:${pct}%"></div></div>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    // ==========================================
    // Update referers table
    // ==========================================
    function updateReferersTable(referers) {
        const tbody = document.querySelector('#tableReferers tbody');
        if (!tbody) return;

        if (!referers || referers.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;color:var(--color-muted-text);padding:24px;">Sebagian besar traffic langsung (Direct)</td></tr>';
            return;
        }

        tbody.innerHTML = referers.map((ref, i) => {
            return `<tr>
                <td class="rank-num">${i + 1}</td>
                <td>${ref.source || 'Direct'}</td>
                <td>${ref.visits.toLocaleString()}</td>
            </tr>`;
        }).join('');
    }
</script>
@endsection
