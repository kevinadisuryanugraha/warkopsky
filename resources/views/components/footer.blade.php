<footer class="footer-cabin">
    <div class="container footer-grid">
        <!-- Brand / Contact Info -->
        <div class="footer-col reveal-stagger">
            <h3 class="footer-logo-text"><span class="logo-text-red">WARKOP</span><span class="logo-text-blue">sky</span></h3>
            <p class="footer-desc">Nongkrong asik, lesehan nyaman, ditemani kehangatan es teh gentong dan sate maranggi empuk di bawah bintang malam. Buka 24 Jam penuh untuk kebersamaan tanpa batas.</p>
            <div class="footer-info-item">
                <span class="text-gold font-title">Alamat:</span>
                <p>Jl. Raya Jatiasih No. 64a, RT.001/RW.004, Jatiasih, Kota Bekasi, Jawa Barat 17423</p>
            </div>
            <div class="footer-info-item">
                <span class="text-gold font-title">Kontak & WA:</span>
                <p><a href="https://wa.me/6281385271918" target="_blank" style="color: var(--color-sky-blue); text-decoration: none; font-weight: 500;">+62 813-8527-1918</a></p>
            </div>
        </div>

        <!-- Opening Hours & Branches -->
        <div class="footer-col">
            <h3 class="footer-section-title">Waktu & Cabang</h3>
            <div class="card-cabin" style="padding: var(--spacing-sm); border-color: rgba(255, 200, 87, 0.15); margin-bottom: var(--spacing-sm);">
                <h4 class="text-gold" style="font-family: var(--font-body); font-weight: 600; font-size: 1rem; margin-bottom: 0.2rem;">OPERASIONAL:</h4>
                <p class="text-highlight" style="font-family: var(--font-display); font-size: 1.4rem;">BUKA 24 JAM</p>
                <p style="font-size: 0.85rem; color: var(--color-muted-text);">Buka setiap hari termasuk hari libur nasional.</p>
            </div>
            
            <h4 class="text-gold" style="font-family: var(--font-body); font-weight: 600; font-size: 0.95rem; margin-bottom: 0.4rem;">Cabang Aktif:</h4>
            <ul class="branch-list">
                <li>
                    <strong>Cabang Jatiasih (Bekasi):</strong>
                    <p style="font-size: 0.85rem;">Indoor & Outdoor, Smoking Area, Ruang Lesehan Luas.</p>
                </li>
            </ul>

            <!-- Social Links -->
            <div class="social-links-container" style="margin-top: var(--spacing-md);">
                <h4 class="text-gold" style="font-family: var(--font-body); font-weight: 600; font-size: 0.95rem; margin-bottom: 0.5rem;">Ikuti Sosial Kami:</h4>
                <div class="social-flex">
                    <a href="https://www.instagram.com/warkopsky.id" target="_blank" aria-label="Instagram">Instagram</a>
                    <a href="https://www.tiktok.com/@warkopsky" target="_blank" aria-label="TikTok">TikTok</a>
                </div>
            </div>
        </div>

        <!-- Google Maps Embed -->
        <div class="footer-col">
            <h3 class="footer-section-title">Peta Lokasi</h3>
            <div class="map-wrapper card-cabin" style="padding: 4px; overflow: hidden; height: 230px;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7699495994357!2d106.965473!3d-6.2939354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d367dbe3a69%3A0xdff03ed1c5ca5cdc!2sWarkop%20Sky!5e0!3m2!1sid!2sid!4v1716800000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Copyright Under-Bar -->
    <div class="footer-bottom">
        <div class="container bottom-flex">
            <p>&copy; 2026 HANSCO & Warkop Sky. All Rights Reserved. Hak Penggunaan Terbatas.</p>
            <p>Built with Laravel 11 + Livewire 3 + MySQL</p>
        </div>
    </div>
</footer>

<style>
    .footer-cabin {
        background: rgba(8, 12, 23, 0.9);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid rgba(93, 156, 236, 0.1);
        padding-top: var(--spacing-xl);
        color: var(--color-warm-cream);
        position: relative;
    }
    
    .footer-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr;
        gap: var(--spacing-xl);
        padding-bottom: var(--spacing-lg);
    }
    
    .footer-logo-text {
        font-size: 2.2rem;
        margin-bottom: var(--spacing-sm);
        display: flex;
        align-items: center;
        gap: 2px;
    }
    
    .footer-desc {
        font-size: 0.9rem;
        margin-bottom: var(--spacing-md);
    }
    
    .footer-info-item {
        margin-bottom: var(--spacing-sm);
    }
    
    .footer-info-item span {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .footer-info-item p {
        color: var(--color-warm-cream);
        font-size: 0.9rem;
    }
    
    .footer-section-title {
        font-size: 1.5rem;
        color: var(--color-sky-blue);
        margin-bottom: var(--spacing-md);
        border-bottom: 2px solid rgba(93, 156, 236, 0.15);
        padding-bottom: 0.4rem;
        display: inline-block;
    }
    
    .branch-list {
        list-style: none;
    }
    
    .branch-list li {
        margin-bottom: var(--spacing-sm);
    }
    
    .branch-list li strong {
        font-size: 0.9rem;
        color: var(--color-warm-cream);
    }
    
    .social-flex {
        display: flex;
        gap: var(--spacing-sm);
    }
    
    .social-flex a {
        color: var(--color-sky-blue);
        text-decoration: none;
        font-size: 0.9rem;
        border: 1px solid rgba(93, 156, 236, 0.3);
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        transition: all var(--duration-fast) var(--easing-smooth);
    }
    
    .social-flex a:hover {
        background: var(--color-sky-blue);
        color: var(--color-midnight-bg);
        border-color: var(--color-sky-blue);
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: var(--spacing-md) 0;
        background: #050810;
    }
    
    .bottom-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-xs);
    }
    
    .bottom-flex p {
        font-size: 0.78rem;
        color: var(--color-muted-text);
    }
    
    @media (max-width: 991px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-lg);
        }
    }
    
    @media (max-width: 767px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: var(--spacing-lg);
        }
        .bottom-flex {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
