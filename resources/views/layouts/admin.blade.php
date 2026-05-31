<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin CRM | Warkop Sky')</title>
    
    <!-- Google Fonts: DM Serif Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    
    <!-- Main Style Link (Statically linking our app.css) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Admin specific variables override */
        :root {
            --admin-sidebar-width: 240px;
            --color-admin-bg: #070B14;
            --color-admin-sidebar: #0A0F1D;
            --color-admin-card: rgba(16, 24, 48, 0.7);
        }

        body {
            background-color: var(--color-admin-bg);
            color: var(--color-warm-cream);
            font-family: var(--font-body);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--color-admin-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-sky-blue);
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-warm-gold);
        }

        /* Admin Page Container */
        .admin-layout-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background-color: var(--color-admin-sidebar);
            border-right: 1px solid rgba(93, 156, 236, 0.08);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 100;
            transition: transform var(--duration-normal) var(--easing-smooth);
        }

        .sidebar-top {
            display: flex;
            flex-direction: column;
        }

        /* Logo Area */
        .sidebar-logo-box {
            padding: var(--spacing-md);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-text {
            font-family: var(--font-display);
            font-size: 1.6rem;
            color: var(--color-warm-cream);
            letter-spacing: 0.02em;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-logo-text span {
            color: var(--color-sky-blue);
            font-size: 0.8rem;
            font-family: var(--font-body);
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-top: -2px;
        }

        /* Nav List */
        .sidebar-nav-list {
            list-style: none;
            padding: var(--spacing-sm) 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-nav-item > a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem var(--spacing-md);
            color: var(--color-muted-text);
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 600;
            transition: all var(--duration-fast) var(--easing-smooth);
            border-left: 3px solid transparent;
        }

        .sidebar-nav-item > a:hover {
            color: var(--color-warm-cream);
            background: rgba(255, 255, 255, 0.02);
        }

        .sidebar-nav-item.active > a {
            color: var(--color-warm-gold);
            background: rgba(255, 200, 87, 0.08);
            border-left: 3px solid var(--color-warm-gold);
        }

        /* Sidebar Submenu Styles */
        .sidebar-submenu {
            list-style: none;
            padding: 0 0 0 40px !important;
            margin: 4px 0 8px 0;
        }
        
        .sidebar-submenu .submenu-item a {
            padding: 0.5rem 0 !important;
            font-size: 0.85rem !important;
            font-weight: 600;
            border-left: none !important;
            background: transparent !important;
            color: var(--color-muted-text);
            display: block;
            text-decoration: none;
            transition: color var(--duration-fast) var(--easing-smooth);
        }
        
        .sidebar-submenu .submenu-item.active a {
            color: var(--color-warm-gold) !important;
            font-weight: 700;
        }
        
        .sidebar-submenu .submenu-item a:hover {
            color: var(--color-warm-cream) !important;
        }
        
        .sidebar-nav-item.has-dropdown.open .dropdown-chevron {
            transform: rotate(180deg);
        }

        /* Sidebar bottom actions */
        .sidebar-bottom {
            padding: var(--spacing-md);
            border-top: 1px solid rgba(255, 255, 255, 0.03);
        }

        .btn-sidebar-logout {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0.7rem;
            background: rgba(230, 57, 70, 0.1);
            color: var(--color-warkop-red);
            border: 1px solid rgba(230, 57, 70, 0.2);
            border-top-left-radius: 8px;
            border-bottom-right-radius: 8px;
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all var(--duration-fast) var(--easing-smooth);
        }

        .btn-sidebar-logout:hover {
            background: var(--color-warkop-red);
            color: var(--color-warm-cream);
            box-shadow: 0 4px 12px rgba(230, 57, 70, 0.3);
        }

        /* Main Content Styling */
        .admin-main-content {
            flex: 1;
            min-width: 0;
            width: calc(100% - var(--admin-sidebar-width));
            margin-left: var(--admin-sidebar-width);
            padding: var(--spacing-md) var(--spacing-lg);
            min-height: 100vh;
            background-color: var(--color-admin-bg);
            transition: margin-left var(--duration-normal) var(--easing-smooth);
            box-sizing: border-box;
        }

        /* Top Bar Header */
        .admin-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            padding-bottom: var(--spacing-xs);
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            position: relative;
            z-index: 10;
        }

        .page-header-title {
            font-family: var(--font-display);
            font-size: 1.8rem;
            color: var(--color-warm-cream);
            margin: 0;
        }

        .admin-user-profile {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--color-sky-blue);
            color: var(--color-midnight-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.9rem;
            border: 2px solid rgba(93, 156, 236, 0.3);
            box-shadow: 0 0 10px rgba(93, 156, 236, 0.2);
        }

        .admin-profile-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--color-warm-cream);
        }

        /* Mobile Header controls */
        .mobile-header {
            display: none;
            width: 100%;
            background-color: var(--color-admin-sidebar);
            border-bottom: 1px solid rgba(93, 156, 236, 0.08);
            padding: var(--spacing-sm) var(--spacing-md);
            position: sticky;
            top: 0;
            z-index: 150;
            align-items: center;
            justify-content: space-between;
        }

        .btn-hamburger {
            background: transparent;
            border: none;
            outline: none;
            color: var(--color-warm-cream);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Flash alert system */
        .flash-alerts-container {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            max-width: 450px;
            padding: 0 var(--spacing-md);
            pointer-events: none;
        }

        .flash {
            width: 100%;
            padding: 1rem 1.25rem;
            border-top-left-radius: 12px;
            border-bottom-right-radius: 12px;
            font-size: 0.88rem;
            font-weight: 600;
            line-height: 1.5;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            gap: 12px;
            pointer-events: auto;
            transform: translateY(-50px);
            opacity: 0;
            animation: slideDown var(--duration-normal) var(--easing-bounce) forwards;
            transition: opacity var(--duration-normal) var(--easing-smooth),
                        transform var(--duration-normal) var(--easing-smooth);
        }

        @keyframes slideDown {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .flash--success {
            background: rgba(93, 156, 236, 0.15);
            border: 1px solid var(--color-sky-blue);
            color: var(--color-warm-cream);
        }

        .flash--error {
            background: rgba(230, 57, 70, 0.15);
            border: 1px solid var(--color-warkop-red);
            color: var(--color-warm-cream);
        }

        .flash-icon {
            flex-shrink: 0;
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .mobile-header {
                display: flex;
            }

            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main-content {
                margin-left: 0;
                width: 100%;
                padding: var(--spacing-md);
            }

            .admin-profile-name {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .page-header-title {
                font-size: 1.4rem !important;
            }
            .admin-top-bar {
                margin-bottom: var(--spacing-md);
            }
        }

            .admin-sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(4px);
                z-index: 95;
            }

            .admin-sidebar-overlay.show {
                display: block;
            }
        }

        /* Global Responsive Table Swipe fixes */
        @media (max-width: 768px) {
            .admin-table-box {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
            }
            .admin-table {
                min-width: 750px !important;
            }
        }

        /* Fix Laravel's Tailwind Paginator in Vanilla CSS */
        .custom-pagination nav {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        /* Hide the mobile-only pagination wrapper */
        .custom-pagination nav > div:first-child {
            display: none !important;
        }

        /* Style the desktop-style wrapper to be responsive */
        .custom-pagination nav > div:last-child {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        @media (min-width: 640px) {
            .custom-pagination nav {
                flex-direction: row !important;
                justify-content: space-between !important;
            }
            .custom-pagination nav > div:last-child {
                flex-direction: row !important;
                justify-content: space-between !important;
                width: 100% !important;
            }
        }

        /* Style the text results "Showing..." */
        .custom-pagination nav p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--color-muted-text);
        }

        /* Style the page number buttons wrapper */
        .custom-pagination nav span.relative.z-0 {
            display: inline-flex;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(7, 11, 20, 0.3);
        }

        .custom-pagination nav span.relative.z-0 a,
        .custom-pagination nav span.relative.z-0 span {
            min-width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: var(--color-warm-cream);
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }

        .custom-pagination nav span.relative.z-0 a:hover {
            background: var(--color-sky-blue);
            color: var(--color-midnight-bg);
        }

        .custom-pagination nav span.relative.z-0 [aria-current="page"] span {
            background: var(--color-warm-gold) !important;
            color: var(--color-midnight-bg) !important;
        }

        .custom-pagination nav span.relative.z-0 [aria-disabled="true"] span {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* jQuery DataTables Dark & Premium Glassmorphic Styling Overrides */
        .dataTables_wrapper {
            padding: 1.25rem;
            color: var(--color-warm-cream) !important;
            background: transparent !important;
        }

        .dataTables_wrapper .dataTables_length {
            color: var(--color-muted-text) !important;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 0.5rem 2rem 0.5rem 0.75rem;
            background: rgba(16, 24, 48, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-top-left-radius: 6px;
            border-bottom-right-radius: 6px;
            color: var(--color-warm-cream) !important;
            font-family: var(--font-body);
            font-size: 0.85rem;
            outline: none;
            transition: all 0.2s;
            cursor: pointer;
            margin: 0 6px;
        }

        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--color-sky-blue) !important;
            background: rgba(7, 11, 20, 0.95) !important;
        }

        .dataTables_wrapper .dataTables_filter {
            color: var(--color-muted-text) !important;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }

        .dataTables_wrapper .dataTables_filter input {
            padding: 0.6rem 1rem;
            background: rgba(16, 24, 48, 0.6) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-top-left-radius: 8px;
            border-bottom-right-radius: 8px;
            color: var(--color-warm-cream) !important;
            font-family: var(--font-body);
            font-size: 0.88rem;
            outline: none;
            transition: all 0.2s;
            margin-left: 10px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--color-sky-blue) !important;
            background: rgba(7, 11, 20, 0.95) !important;
            box-shadow: 0 0 10px rgba(93, 156, 236, 0.15);
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--color-muted-text) !important;
            font-size: 0.85rem;
            font-weight: 600;
            padding-top: 1.25rem !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1.25rem !important;
            color: var(--color-warm-cream) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.85rem !important;
            margin-left: 4px !important;
            border-top-left-radius: 6px !important;
            border-bottom-right-radius: 6px !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            background: rgba(16, 24, 48, 0.4) !important;
            color: var(--color-muted-text) !important;
            font-weight: 700 !important;
            transition: all 0.2s !important;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--color-sky-blue) !important;
            color: var(--color-midnight-bg) !important;
            border-color: var(--color-sky-blue) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--color-warm-gold) !important;
            color: var(--color-midnight-bg) !important;
            border-color: var(--color-warm-gold) !important;
            box-shadow: 0 0 10px rgba(255, 200, 87, 0.3) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            background: rgba(16, 24, 48, 0.2) !important;
            color: rgba(255, 255, 255, 0.2) !important;
            border-color: rgba(255, 255, 255, 0.02) !important;
            cursor: not-allowed !important;
            opacity: 0.5 !important;
        }

        /* Clean up jquery datatable default styling conflicts */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            margin: 1rem 0 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 1rem 1.25rem !important;
        }

        /* Sort styling alignment */
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            background-image: none !important;
            position: relative;
            cursor: pointer;
        }

        table.dataTable thead .sorting::after,
        table.dataTable thead .sorting_asc::after,
        table.dataTable thead .sorting_desc::after {
            position: absolute;
            right: 12px;
            font-family: monospace;
            opacity: 0.3;
        }

        table.dataTable thead .sorting::after {
            content: " ↕";
        }

        table.dataTable thead .sorting_asc::after {
            content: " ▴";
            opacity: 0.8;
            color: var(--color-warm-gold);
        }

        table.dataTable thead .sorting_desc::after {
            content: " ▾";
            opacity: 0.8;
            color: var(--color-warm-gold);
        }

        /* Custom alignment for tables inside glass card container */
        .admin-table-box .dataTables_wrapper {
            padding: 1.25rem 1.5rem !important;
        }

        /* Make sure horizontal scrolling is smooth and premium on mobile */
        .dataTables_wrapper .dataTables_scrollBody {
            border: none !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .dataTables_wrapper .dataTables_scrollBody::-webkit-scrollbar {
            height: 4px;
        }
        
        .dataTables_wrapper .dataTables_scrollBody::-webkit-scrollbar-thumb {
            background: var(--color-sky-blue);
            border-radius: 2px;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Flash Alerts Container -->
    <div class="flash-alerts-container">
        @if(session('success'))
            <div class="flash flash--success" id="successFlash">
                <svg class="flash-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--color-sky-blue)" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="flash flash--error" id="errorFlash">
                <svg class="flash-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--color-warkop-red)" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Mobile Header Navigation -->
    <div class="mobile-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-text" style="font-size: 1.3rem;">
            Warkop Sky <span>CRM</span>
        </a>
        <button class="btn-hamburger" id="hamburgerBtn" aria-label="Toggle Sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="4" y1="12" x2="20" y2="12"></line>
                <line x1="4" y1="6" x2="20" y2="6"></line>
                <line x1="4" y1="18" x2="20" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Sidebar Mobile Overlay -->
    <div class="admin-sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-layout-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-logo-box">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-text">
                        WARKOP <span>SKY CRM</span>
                    </a>
                </div>
                
                <nav>
                    <ul class="sidebar-nav-list">
                        <!-- Dashboard -->
                        <li class="sidebar-nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="7" height="9" rx="1"></rect>
                                    <rect x="14" y="3" width="7" height="5" rx="1"></rect>
                                    <rect x="14" y="12" width="7" height="9" rx="1"></rect>
                                    <rect x="3" y="16" width="7" height="5" rx="1"></rect>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        
                        <!-- Analytics -->
                        <li class="sidebar-nav-item {{ Route::is('admin.analytics.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.analytics.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M18 20V10M12 20V4M6 20v-6"></path>
                                </svg>
                                Analitik Website
                            </a>
                        </li>
                        
                        <!-- Menu CRUD -->
                        <li class="sidebar-nav-item has-dropdown {{ Route::is('admin.menu.*') || Route::is('admin.menu.categories.*') || Route::is('admin.menu-categories.*') || Route::is('admin.menu.categories.index') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="dropdown-toggle" style="justify-content: flex-start;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Manajemen Menu</span>
                                <svg class="dropdown-chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left: auto; transition: transform 0.2s; {{ Route::is('admin.menu.*') || Route::is('admin.menu.categories.*') || Route::is('admin.menu-categories.*') || Route::is('admin.menu.categories.index') ? 'transform: rotate(180deg);' : '' }}">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <ul class="sidebar-submenu" style="display: {{ Route::is('admin.menu.*') || Route::is('admin.menu.categories.*') || Route::is('admin.menu-categories.*') || Route::is('admin.menu.categories.index') ? 'block' : 'none' }};">
                                <li class="submenu-item {{ Route::is('admin.menu.index') || Route::is('admin.menu.create') || Route::is('admin.menu.edit') ? 'active' : '' }}">
                                    <a href="{{ route('admin.menu.index') }}">Daftar Menu</a>
                                </li>
                                <li class="submenu-item {{ Route::is('admin.menu.categories.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.menu.categories.index') }}">Kategori Menu</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Gallery CRUD -->
                        <li class="sidebar-nav-item has-dropdown {{ Route::is('admin.gallery.*') || Route::is('admin.gallery.categories.*') || Route::is('admin.gallery-categories.*') || Route::is('admin.gallery.categories.index') ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="dropdown-toggle" style="justify-content: flex-start;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <span>Manajemen Galeri</span>
                                <svg class="dropdown-chevron" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="margin-left: auto; transition: transform 0.2s; {{ Route::is('admin.gallery.*') || Route::is('admin.gallery.categories.*') || Route::is('admin.gallery-categories.*') || Route::is('admin.gallery.categories.index') ? 'transform: rotate(180deg);' : '' }}">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <ul class="sidebar-submenu" style="display: {{ Route::is('admin.gallery.*') || Route::is('admin.gallery.categories.*') || Route::is('admin.gallery-categories.*') || Route::is('admin.gallery.categories.index') ? 'block' : 'none' }};">
                                <li class="submenu-item {{ Route::is('admin.gallery.index') || Route::is('admin.gallery.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery.index') }}">Daftar Galeri</a>
                                </li>
                                <li class="submenu-item {{ Route::is('admin.gallery.categories.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery.categories.index') }}">Kategori Galeri</a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Stories Approval -->
                        <li class="sidebar-nav-item {{ Route::is('admin.stories.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.stories.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Cerita Ulasan
                            </a>
                        </li>
                        
                        <!-- Reservations CRM -->
                        <li class="sidebar-nav-item {{ Route::is('admin.reservations.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.reservations.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Reservasi Meja
                            </a>
                        </li>

                        <!-- Events Management -->
                        <li class="sidebar-nav-item {{ Route::is('admin.events.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.events.index') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                Manajemen Events
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <div class="sidebar-bottom">
                <!-- Secure Logout Form -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-sidebar-logout" onclick="return confirm('Apakah Anda yakin mau keluar dari sistem CRM?')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main-content">
            <!-- Top Bar Header -->
            <header class="admin-top-bar">
                <h1 class="page-header-title">@yield('page_title', 'Dashboard')</h1>
                
                <div class="admin-user-profile">
                    <div class="admin-avatar">
                        A
                    </div>
                    <div class="admin-profile-name">
                        {{ Auth::user()->name ?? 'Pengelola' }}
                    </div>
                </div>
            </header>

            <!-- Dynamic Child Content -->
            @yield('content')
        </main>
    </div>

    <!-- Vanilla Javascript Alerts & Mobile Menu Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Flash alert auto-dismiss timeout (4 seconds)
            const flashes = document.querySelectorAll('.flash');
            flashes.forEach(flash => {
                setTimeout(() => {
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        flash.remove();
                    }, 400); // match fade transition
                }, 4000);
            });

            // 2. Mobile Sidebar hamburger toggle
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (hamburgerBtn && sidebar && overlay) {
                function toggleSidebar() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }

                hamburgerBtn.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);
            }

            // 3. Dropdown sidebar menu toggle
            const dropdownToggles = document.querySelectorAll('.sidebar-nav-item.has-dropdown .dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.parentElement;
                    const submenu = parent.querySelector('.sidebar-submenu');
                    const chevron = this.querySelector('.dropdown-chevron');
                    
                    const isOpen = parent.classList.contains('open');
                    
                    if (isOpen) {
                        parent.classList.remove('open');
                        submenu.style.display = 'none';
                        if (chevron) {
                            chevron.style.transform = 'rotate(0deg)';
                        }
                    } else {
                        parent.classList.add('open');
                        submenu.style.display = 'block';
                        if (chevron) {
                            chevron.style.transform = 'rotate(180deg)';
                        }
                    }
                });
            });
        });
    </script>
    <!-- jQuery & DataTables JS CDNs -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <!-- Global DataTables Initializer -->
    <script>
        $(document).ready(function() {
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    },
                    "scrollX": true,
                    "pageLength": 10,
                    "lengthMenu": [10, 25, 50, 100]
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
