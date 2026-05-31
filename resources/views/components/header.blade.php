<header class="header-nav">
    <div class="container header-container">
        <!-- Logo -->
        <a href="/" class="header-logo">
            <span class="logo-text-red">WARKOP</span><span class="logo-text-blue">sky</span>
        </a>
        
        <!-- Desktop Nav Links -->
        <nav class="desktop-menu">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
            <a href="/menu" class="{{ request()->is('menu') ? 'active' : '' }}">Menu</a>
            <a href="/galeri" class="{{ request()->is('galeri') ? 'active' : '' }}">Galeri</a>
            <a href="/stories" class="{{ request()->is('stories') ? 'active' : '' }}">Stories</a>
            <a href="/events" class="{{ request()->is('events') ? 'active' : '' }}">Events</a>
            <a href="/tentang" class="{{ request()->is('tentang') ? 'active' : '' }}">Tentang</a>
            <a href="/kontak" class="{{ request()->is('kontak') ? 'active' : '' }}">Kontak</a>
        </nav>
        
        <!-- Hamburger Button -->
        <button class="menu-toggle" id="menuToggleBtn" aria-label="Toggle Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <!-- Mobile Nav Slide Panel -->
    <div class="mobile-menu" id="mobileMenuPanel">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a>
        <a href="/menu" class="{{ request()->is('menu') ? 'active' : '' }}">Menu</a>
        <a href="/galeri" class="{{ request()->is('galeri') ? 'active' : '' }}">Galeri</a>
        <a href="/stories" class="{{ request()->is('stories') ? 'active' : '' }}">Stories</a>
        <a href="/events" class="{{ request()->is('events') ? 'active' : '' }}">Events</a>
        <a href="/tentang" class="{{ request()->is('tentang') ? 'active' : '' }}">Tentang</a>
        <a href="/kontak" class="{{ request()->is('kontak') ? 'active' : '' }}">Kontak</a>
    </div>
</header>

<style>
    .header-nav {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 80px;
        background: rgba(10, 15, 29, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(93, 156, 236, 0.12);
        z-index: 1000;
        display: flex;
        align-items: center;
        transition: background var(--duration-fast) var(--easing-smooth);
    }
    
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    
    .header-logo {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 2px;
        font-family: var(--font-display);
        font-size: 1.8rem;
    }
    
    .logo-text-red {
        color: var(--color-warkop-red);
        font-weight: bold;
        text-shadow: 0 0 10px rgba(230, 57, 70, 0.2);
    }
    
    .logo-text-blue {
        color: var(--color-sky-blue);
        font-style: italic;
        font-weight: 300;
        text-shadow: 0 0 10px rgba(93, 156, 236, 0.2);
    }
    
    .desktop-menu {
        display: flex;
        gap: var(--spacing-md);
    }
    
    .desktop-menu a {
        color: var(--color-muted-text);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: color var(--duration-fast) var(--easing-smooth);
        position: relative;
        padding: 0.3rem 0;
    }
    
    .desktop-menu a:hover, 
    .desktop-menu a.active {
        color: var(--color-sky-blue);
    }
    
    .desktop-menu a::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--color-warkop-red);
        transition: width var(--duration-normal) var(--easing-smooth);
    }
    
    .desktop-menu a:hover::after,
    .desktop-menu a.active::after {
        width: 100%;
    }
    
    /* Hamburger Menu */
    .menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 24px;
        height: 18px;
        background: transparent;
        border: none;
        cursor: pointer;
        z-index: 1100;
    }
    
    .menu-toggle span {
        width: 100%;
        height: 2.5px;
        background: var(--color-warm-cream);
        border-radius: 2px;
        transition: all var(--duration-fast) var(--easing-smooth);
    }
    
    /* Mobile Slide Drawer */
    .mobile-menu {
        display: none;
        position: fixed;
        top: 80px;
        left: 0;
        width: 100%;
        background: rgba(10, 15, 29, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(93, 156, 236, 0.15);
        padding: var(--spacing-md) var(--spacing-sm);
        flex-direction: column;
        gap: var(--spacing-sm);
        z-index: 999;
        transform: translateY(-100%);
        opacity: 0;
        transition: transform var(--duration-normal) var(--easing-smooth),
                    opacity var(--duration-normal) var(--easing-smooth);
        pointer-events: none;
    }
    
    .mobile-menu.open {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }
    
    .mobile-menu a {
        color: var(--color-muted-text);
        text-decoration: none;
        font-size: 1.2rem;
        font-family: var(--font-display);
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: color var(--duration-fast) var(--easing-smooth);
    }
    
    .mobile-menu a:hover,
    .mobile-menu a.active {
        color: var(--color-sky-blue);
        border-bottom-color: var(--color-sky-blue);
    }

    @media (max-width: 768px) {
        .desktop-menu {
            display: none;
        }
        .menu-toggle {
            display: flex;
        }
        .mobile-menu {
            display: flex;
        }
        
        .menu-toggle.open span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }
        .menu-toggle.open span:nth-child(2) {
            opacity: 0;
        }
        .menu-toggle.open span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('menuToggleBtn');
        const mobilePanel = document.getElementById('mobileMenuPanel');
        
        if(toggleBtn && mobilePanel) {
            toggleBtn.addEventListener('click', function() {
                toggleBtn.classList.toggle('open');
                mobilePanel.classList.toggle('open');
            });
            
            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if(!toggleBtn.contains(e.target) && !mobilePanel.contains(e.target)) {
                    toggleBtn.classList.remove('open');
                    mobilePanel.classList.remove('open');
                }
            });
        }
    });
</script>
