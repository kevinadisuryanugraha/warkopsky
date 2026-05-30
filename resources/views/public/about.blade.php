@extends('layouts.app')

@section('title', 'Tentang Kami - Kehangatan di Bawah Langit Malam | Warkop Sky')

@section('meta_description', 'Pelajari kisah perjalanan Warkop Sky, pilar nilai kenyamanan 24 jam kami, fasilitas lengkap Jatiasih, dan bagaimana kami membangun cangkir persaudaraan.')

@section('content')
<div class="about-page-wrapper">
    
    <!-- Ambient Cabin Lighting Glows -->
    <div class="bulb-glow bulb-glow--yellow"></div>
    <div class="bulb-glow bulb-glow--blue"></div>

    <!-- ==========================================
       SECTION 1: OPENING STATEMENT (Cozy Intro)
       ========================================== -->
    <section class="about-hero text-center reveal-stagger">
        <div class="container">
            <!-- Decorative hanging Edison bulb -->
            <div class="hanging-bulb-art">
                <div class="wire"></div>
                <div class="bulb"></div>
                <div class="glow"></div>
            </div>
            
            <span class="badge-accent">KISAH & FILOSOFI</span>
            <h1 class="about-main-title">Di Balik Kehangatan <br><span class="text-highlight">Warkop Sky</span></h1>
            <p class="about-subtitle">
                Bukan sekadar tempat singgah untuk menyesap kopi susu. Kami adalah ruang ketiga Anda—sebuah rumah singgah ramah 24 jam di mana ide mengalir, tawa mengangkasa, dan persaudaraan diseduh hangat.
            </p>
        </div>
    </section>

    <!-- ==========================================
       SECTION 2: ORIGIN STORY (Zigzag Layout)
       ========================================== -->
    <section class="about-section container">
        <h2 class="section-title text-center">Menyusuri Jejak Langkah Kami</h2>
        <p class="section-desc text-center">Bagaimana secangkir obrolan santai tumbuh menjadi markas kabin tengah malam terhangat di Jatiasih.</p>
        
        <div class="zigzag-timeline">
            <!-- Timeline Row 1: Left Text / Right Visual -->
            <div class="zigzag-row">
                <div class="zigzag-content card-cabin">
                    <span class="timeline-year">2023</span>
                    <h3 class="timeline-title">Mimpi di Bawah Bintang Jatiasih</h3>
                    <p class="timeline-text">
                        Semua dimulai ketika sekelompok sahabat seringkali kesulitan mencari tempat nongkrong yang representatif di tengah malam Bekasi. Kebanyakan warkop terlalu bising atau tidak nyaman untuk produktivitas, sementara kafe modern lekas tutup di jam 10 malam. 
                    </p>
                    <p class="timeline-text">
                        Kami bermimpi menciptakan sebuah kabin malam yang hangat, teduh, dengan harga merakyat namun dibekali fasilitas modern. Dari situ lahir nama <strong>Warkop Sky</strong>—warkop berkonsep kabin kayu nyaman di bawah naungan langit malam yang ramah bagi para pencari inspirasi malam.
                    </p>
                    <!-- EDIT: Tambahkan foto dokumentasi pendirian warkop pertama kali di sini -->
                </div>
                
                <div class="zigzag-visual card-cabin glow-bulb">
                    <img src="/images/about/about_exterior.webp" 
                         alt="Exterior Warkop Sky Jatiasih" 
                         loading="lazy"
                         class="about-zigzag-img">
                </div>
            </div>

            <!-- Timeline Row 2: Right Text / Left Visual (Zigzag) -->
            <div class="zigzag-row zigzag-row--reverse">
                <div class="zigzag-content card-cabin">
                    <span class="timeline-year">2024</span>
                    <h3 class="timeline-title">Membangun Rumah Kedua yang Komplit</h3>
                    <p class="timeline-text">
                        Mimpi itu terwujud di Jatiasih. Kami menyadari bahwa pengunjung kami bukan sekadar butuh kopi susu warkop, melainkan ruang produktivitas yang mumpuni. Kami berinvestasi penuh untuk menghadirkan WiFi berkecepatan tinggi, ratusan titik colokan listrik di setiap meja lesehan, mushola luas, dan toilet yang selalu bersih terjaga.
                    </p>
                    <p class="timeline-text">
                        Konsep kabin kayu midnight dengan sentuhan Edison warm hias yang asri terbukti dicintai. Warkop Sky bertransformasi menjadi oase bagi para mahasiswa yang mengerjakan skripsi larut malam, komunitas yang berdiskusi kreatif, hingga keluarga yang bersantap santai di sore hari.
                    </p>
                    <!-- EDIT: Tambahkan foto interior area lesehan modern Warkop Sky di sini -->
                </div>
                
                <div class="zigzag-visual card-cabin" style="border-color: rgba(93, 156, 236, 0.2);">
                    <img src="/images/about/about_rooftop.webp" 
                         alt="Suasana Kabin Warkop Sky" 
                         loading="lazy"
                         class="about-zigzag-img">
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
       SECTION 3: CORE VALUES (Horizontal Scroll Strip)
       ========================================== -->
    <section class="about-section" style="background: #060a14; border-top: 1px solid rgba(93, 156, 236, 0.05); border-bottom: 1px solid rgba(93, 156, 236, 0.05); padding: var(--spacing-xl) 0;">
        <div class="container">
            <h2 class="section-title text-center">Pilar Kenyamanan Kabin</h2>
            <p class="section-desc text-center" style="margin-bottom: var(--spacing-md);">4 Pilar kenyamanan utama yang kami jaga ketat demi kepuasan nongkrong Anda.</p>
            
            <!-- Horizontal scroll strip wrapper -->
            <div class="horizontal-scroll-container">
                <div class="values-scroll-strip">
                    
                    <!-- Card 1 -->
                    <div class="value-scroll-card card-cabin">
                        <div class="scroll-icon-box" style="color: var(--color-warm-gold); background: rgba(255, 200, 87, 0.08);">
                            ★
                        </div>
                        <h3 class="scroll-card-title">Vibe Kabin Estetik</h3>
                        <p class="scroll-card-text">
                            Perpaduan desain kayu kabin yang hangat, area lesehan karpet tebal, dan gemerlap lampu bohlam gantung Edison yang cozy menenangkan pikiran.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="value-scroll-card card-cabin">
                        <div class="scroll-icon-box" style="color: var(--color-warkop-red); background: rgba(230, 57, 70, 0.08);">
                            ♥
                        </div>
                        <h3 class="scroll-card-title">Harga Jujur & Merakyat</h3>
                        <p class="scroll-card-text">
                            Semua menu dirancang ekonomis bersahabat layaknya warkop tradisional sejati. Nongkrong berjam-jam tanpa perlu khawatir menguras isi dompet.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="value-scroll-card card-cabin">
                        <div class="scroll-icon-box" style="color: var(--color-sky-blue); background: rgba(93, 156, 236, 0.08);">
                            ⚡
                        </div>
                        <h3 class="scroll-card-title">Fasilitas Paripurna</h3>
                        <p class="scroll-card-text">
                            Koneksi WiFi serat optik super stabil, steker listrik melimpah di setiap sudut duduk, mushola ber-AC, serta toilet higienis yang harum terjaga.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="value-scroll-card card-cabin">
                        <div class="scroll-icon-box" style="color: #25D366; background: rgba(37, 211, 102, 0.08);">
                            🕒
                        </div>
                        <h3 class="scroll-card-title">Pintu Selalu Terbuka</h3>
                        <p class="scroll-card-text">
                            Buka 24 Jam Non-Stop. Tim kru kami ramah menyambut Anda kapan pun ide malam Anda menyala atau saat perut berbisik mencari kehangatan mie instan.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
       SECTION 4: STATS COUNT-UP (KPI Display)
       ========================================== -->
    <section class="about-section container text-center">
        <div class="stats-counter-grid">
            
            <div class="stat-counter-item">
                <h3 class="stat-number">50.000+</h3>
                <span class="stat-label">Cangkir Kopi Terjual</span>
            </div>

            <div class="stat-counter-item">
                <h3 class="stat-number">120+</h3>
                <span class="stat-label">Kapasitas Tempat Duduk</span>
            </div>

            <div class="stat-counter-item">
                <h3 class="stat-number">24/7</h3>
                <span class="stat-label">Jam Pelayanan Tanpa Libur</span>
            </div>

            <div class="stat-counter-item">
                <h3 class="stat-number">4.9★</h3>
                <span class="stat-label">Rating Ulasan Pelanggan</span>
            </div>

        </div>
    </section>

    <!-- ==========================================
       SECTION 5: BRANCH CARD (Aesthetic Seating Box)
       ========================================== -->
    <section class="about-section container">
        <h2 class="section-title text-center">Cabang Utama Jatiasih</h2>
        <p class="section-desc text-center">Nikmati suasana ramah dan sejuk di markas utama kami di bawah asuhan rimbun pohon kota Bekasi.</p>
        
        <x-card class="branch-card" style="padding: 0; overflow: hidden; border: 1px solid rgba(255,255,255,0.04);">
            <div class="branch-flex-layout">
                <!-- Branch Information -->
                <div class="branch-stats-info">
                    <span class="branch-sub">Cabang Pusat</span>
                    <h3 class="branch-title">Warkop Sky - Jatiasih</h3>
                    <p class="branch-address">
                        Jl. Raya Jatiasih No. 64a, RT.001/RW.004, Jatiasih, Kec. Jatiasih, Kota Bekasi, Jawa Barat 17423.
                    </p>

                    <!-- Amenities Grid -->
                    <div class="amenities-grid-list">
                        <div class="amenity-item">
                            <strong>Lesehan:</strong> Karpet Tebal & Meja Kayu
                        </div>
                        <div class="amenity-item">
                            <strong>Outdoor:</strong> Kursi Santai Rindang Adem
                        </div>
                        <div class="amenity-item">
                            <strong>Hiburan:</strong> Akustik & Nobar Bola
                        </div>
                        <div class="amenity-item">
                            <strong>Keamanan:</strong> Parkir Lebar + CCTV 24H
                        </div>
                    </div>

                    <!-- Call To Action Direct Reservasi -->
                    <div style="margin-top: var(--spacing-sm);">
                        <a href="{{ route('public.contact') }}" class="btn-branch-cta">
                            Reservasi Lesehan Terfavorit
                        </a>
                    </div>
                </div>

                <!-- Google Maps Frame -->
                <div class="branch-map-embed">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7699495994357!2d106.965473!3d-6.2939354!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d367dbe3a69%3A0xdff03ed1c5ca5cdc!2sWarkop%20Sky!5e0!3m2!1sid!2sid!4v1716800000000!5m2!1sid!2sid" 
                        style="border:0; width: 100%; height: 100%; min-height: 320px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </x-card>
    </section>

    <!-- ==========================================
       SECTION 6: CLOSING CTA (Dynamic Conversion Upgraded)
       ========================================== -->
    <section class="about-closing-cta">
        <div class="about-closing-cta__inner">
            <blockquote class="about-closing-cta__quote">
                "Langit malam selalu punya ruang untuk kamu."
            </blockquote>
            <p class="about-closing-cta__sub">
                Tidak perlu reservasi untuk datang — tapi kalau mau tempat duduk terjamin, kami siapkan.
            </p>
            <div class="about-closing-cta__btns">
                <a href="{{ route('public.contact') }}" class="btn-cta-primary">
                    Reservasi Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('public.menu') }}" class="btn-cta-ghost">
                    Lihat Menu Dulu
                </a>
            </div>
            <p class="about-closing-cta__reassurance">
                ✓ Buka 24 jam &nbsp;·&nbsp; ✓ Tanpa DP &nbsp;·&nbsp; ✓ Konfirmasi via WhatsApp
            </p>
        </div>
    </section>

</div>

<style>
    .about-page-wrapper {
        min-height: 100vh;
        background-color: var(--color-midnight-bg);
        padding-top: 0;
        position: relative;
        overflow-x: hidden;
    }

    /* Ambient bulb lights backgrounds */
    .bulb-glow {
        position: absolute;
        width: 500px;
        height: 500px;
        pointer-events: none;
        z-index: 1;
        filter: blur(50px);
        opacity: 0.5;
    }

    .bulb-glow--yellow {
        background: radial-gradient(circle, rgba(255, 200, 87, 0.035) 0%, transparent 70%);
        top: 5%;
        left: -10%;
    }

    .bulb-glow--blue {
        background: radial-gradient(circle, rgba(93, 156, 236, 0.025) 0%, transparent 70%);
        bottom: 15%;
        right: -10%;
    }

    .about-section {
        position: relative;
        z-index: 2;
        padding: var(--spacing-lg) 0;
    }

    /* Section Title Standard */
    .section-title {
        font-family: var(--font-display);
        font-size: clamp(2rem, 4vw, 2.8rem);
        color: var(--color-warm-cream);
        margin: 0 0 8px 0;
    }

    .section-desc {
        max-width: 600px;
        margin: 0 auto var(--spacing-lg) auto;
        color: var(--color-muted-text);
        font-size: 0.95rem;
    }

    /* Hero Opening Statement styling */
    .about-hero {
        padding: var(--spacing-md) 0 var(--spacing-lg) 0;
        position: relative;
        z-index: 2;
        background: 
            linear-gradient(rgba(10,15,29,0.6), rgba(10,15,29,0.8)),
            url('/images/hero/hero_about.webp') center/cover no-repeat;
    }

    .about-main-title {
        font-size: clamp(2.6rem, 6vw, 4.2rem);
        line-height: 1.1;
        margin-bottom: var(--spacing-sm);
        font-family: var(--font-display);
        color: var(--color-warm-cream);
    }

    .about-subtitle {
        max-width: 700px;
        margin: 0 auto;
        color: var(--color-muted-text);
        font-size: 1.05rem;
        line-height: 1.6;
    }

    .badge-accent {
        font-family: var(--font-body);
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--color-warm-gold);
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: var(--spacing-xs);
    }

    /* Hanging Edison bulb illustration styling */
    .hanging-bulb-art {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: var(--spacing-xs);
        position: relative;
        height: 120px;
    }

    .hanging-bulb-art .wire {
        width: 1.5px;
        height: 80px;
        background: linear-gradient(to bottom, var(--color-muted-text), var(--color-warm-gold));
    }

    .hanging-bulb-art .bulb {
        width: 16px;
        height: 22px;
        background: var(--color-warm-gold);
        border-radius: 50% 50% 30% 30%;
        margin-top: -1px;
        position: relative;
        z-index: 2;
    }

    .hanging-bulb-art .glow {
        position: absolute;
        bottom: 10px;
        width: 40px;
        height: 40px;
        background: var(--color-warm-gold);
        filter: blur(20px);
        border-radius: 50%;
        opacity: 0.65;
        z-index: 1;
        animation: glow-pulse 3s infinite ease-in-out;
    }

    @keyframes glow-pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 0.8; }
    }

    /* ==========================================
       Zigzag Timeline Styling
       ========================================== */
    .zigzag-timeline {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
        margin-top: var(--spacing-md);
    }

    .zigzag-row {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: var(--spacing-md);
        align-items: center;
    }

    .zigzag-row--reverse {
        grid-template-columns: 0.8fr 1.2fr;
    }

    .zigzag-content {
        padding: var(--spacing-lg) !important;
        background: rgba(16, 24, 48, 0.4) !important;
    }

    .zigzag-visual {
        height: 100%;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(16, 24, 48, 0.4) !important;
        border-color: rgba(255, 200, 87, 0.15) !important;
        padding: 0 !important;
        overflow: hidden;
    }

    .about-zigzag-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--duration-slow) var(--easing-smooth);
        display: block;
    }

    .zigzag-visual:hover .about-zigzag-img {
        transform: scale(1.04);
    }

    .zigzag-row--reverse .zigzag-content {
        grid-column: 2;
    }

    .zigzag-row--reverse .zigzag-visual {
        grid-column: 1;
        grid-row: 1;
    }

    @media (max-width: 991px) {
        .zigzag-row, .zigzag-row--reverse {
            grid-template-columns: 1fr;
            gap: var(--spacing-sm);
        }

        .zigzag-row--reverse .zigzag-content {
            grid-column: 1;
        }

        .zigzag-row--reverse .zigzag-visual {
            grid-column: 1;
            grid-row: auto;
        }

        .zigzag-visual {
            min-height: 180px;
        }
    }

    .timeline-year {
        font-family: var(--font-display);
        font-size: 2.2rem;
        color: var(--color-warm-gold);
        line-height: 1;
        display: block;
        margin-bottom: 6px;
    }

    .timeline-title {
        font-family: var(--font-display);
        font-size: 1.6rem;
        color: var(--color-warm-cream);
        margin-bottom: var(--spacing-xs);
    }

    .timeline-text {
        font-size: 0.9rem;
        color: var(--color-muted-text);
        line-height: 1.6;
        margin-bottom: var(--spacing-xs);
    }

    .timeline-text:last-of-type {
        margin-bottom: 0;
    }

    .visual-art-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: var(--spacing-md);
    }

    /* ==========================================
       Horizontal values scroll
       ========================================== */
    .horizontal-scroll-container {
        width: 100%;
        overflow-x: auto;
        scrollbar-width: none; /* Firefox */
        padding: var(--spacing-xs) var(--spacing-md);
    }

    .horizontal-scroll-container::-webkit-scrollbar {
        display: none; /* Safari & Chrome */
    }

    .values-scroll-strip {
        display: flex;
        gap: var(--spacing-md);
        width: max-content;
        padding-bottom: 10px;
    }

    .value-scroll-card {
        width: 290px;
        background: rgba(16, 24, 48, 0.45) !important;
        padding: var(--spacing-md) !important;
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
        transition: border-color var(--duration-fast) var(--easing-smooth),
                    transform var(--duration-fast) var(--easing-smooth);
    }

    .value-scroll-card:hover {
        border-color: var(--color-sky-blue) !important;
        transform: translateY(-2px);
    }

    .scroll-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
    }

    .scroll-card-title {
        font-family: var(--font-display);
        font-size: 1.25rem;
        color: var(--color-warm-cream);
    }

    .scroll-card-text {
        font-size: 0.85rem;
        color: var(--color-muted-text);
        line-height: 1.5;
    }

    /* ==========================================
       Stats display KPI counters
       ========================================== */
    .stats-counter-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--spacing-md);
        background: linear-gradient(90deg, rgba(93, 156, 236, 0.02) 0%, rgba(255, 200, 87, 0.02) 100%);
        padding: var(--spacing-lg) var(--spacing-md);
        border: 1px solid rgba(255, 255, 255, 0.02);
        border-top-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    @media (max-width: 768px) {
        .stats-counter-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-sm);
        }
    }

    .stat-counter-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stat-number {
        font-family: var(--font-display);
        font-size: clamp(2rem, 5vw, 3.2rem);
        color: var(--color-warm-gold);
        text-shadow: 0 0 15px rgba(255, 200, 87, 0.2);
        line-height: 1;
        margin: 0 0 4px 0;
    }

    .stat-label {
        font-size: 0.82rem;
        color: var(--color-muted-text);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ==========================================
       Branch card details
       ========================================== */
    .branch-card {
        background: rgba(16, 24, 48, 0.4) !important;
    }

    .branch-flex-layout {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        min-height: 360px;
    }

    .branch-stats-info {
        flex: 1.2;
        min-width: 320px;
        padding: var(--spacing-lg);
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
    }

    .branch-map-embed {
        flex: 0.8;
        min-width: 320px;
        position: relative;
        background: #060913;
        overflow: hidden;
    }

    .branch-sub {
        font-size: 0.72rem;
        font-weight: 800;
        color: var(--color-warm-gold);
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 2px;
        display: block;
    }

    .branch-title {
        font-family: var(--font-display);
        font-size: 1.8rem;
        color: var(--color-warm-cream);
        margin: 0 0 6px 0;
    }

    .branch-address {
        font-size: 0.88rem;
        color: var(--color-muted-text);
        margin-bottom: var(--spacing-md);
        line-height: 1.5;
    }

    .amenities-grid-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: var(--spacing-md);
    }

    @media (max-width: 576px) {
        .amenities-grid-list {
            grid-template-columns: 1fr;
        }
    }

    .amenity-item {
        font-size: 0.82rem;
        color: var(--color-muted-text);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .amenity-item::before {
        content: '•';
        color: var(--color-sky-blue);
        font-weight: 800;
        font-size: 1.1rem;
    }

    .btn-branch-cta {
        display: inline-block;
        padding: 0.7rem 1.6rem;
        background: var(--color-warkop-red);
        color: var(--color-warm-cream);
        font-family: var(--font-body);
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        border-top-left-radius: 8px;
        border-bottom-right-radius: 8px;
        box-shadow: 0 4px 12px rgba(230, 57, 70, 0.2);
        transition: all var(--duration-fast) var(--easing-smooth);
    }

    .btn-branch-cta:hover {
        background: var(--color-warm-gold);
        color: var(--color-midnight-bg);
        box-shadow: 0 4px 12px rgba(255, 200, 87, 0.3);
        transform: translateY(-2px);
    }

    /* ==========================================
       Closing CTA convert card
       ========================================== */
    .closing-cta-card {
        background: radial-gradient(circle at center, rgba(16, 24, 48, 0.7) 0%, rgba(6, 10, 20, 0.95) 100%) !important;
        border: 1px solid rgba(93, 156, 236, 0.15) !important;
        padding: var(--spacing-xl) var(--spacing-md) !important;
    }

    .closing-title {
        font-family: var(--font-display);
        font-size: clamp(1.8rem, 4vw, 2.6rem);
        color: var(--color-warm-cream);
        margin: 0 0 6px 0;
    }

    .closing-text {
        max-width: 550px;
        margin: 0 auto var(--spacing-md) auto;
        color: var(--color-muted-text);
        font-size: 0.95rem;
    }

    .closing-btn-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
</style>

    <!-- JSON-LD Breadcrumb Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "{{ config('app.url') }}"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "Tentang Kami",
          "item": "{{ url()->current() }}"
        }
      ]
    }
    </script>
@endsection
