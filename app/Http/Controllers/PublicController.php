<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\CustomerStory;
use App\Models\Event;
use App\Services\SeoService;

class PublicController extends Controller
{
    public function home(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Warkop Sky Jatiasih — Ngopi 24 Jam di Bawah Langit',
            'description' => 'Warung kopi dan kuliner autentik Jatiasih Bekasi. Buka 24 jam, suasana cozy cabin, harga merakyat. Reservasi mudah via WhatsApp.',
            'image'       => asset('images/og-home.jpg'),
        ])->toArray();

        return view('public.home', [
            'seoData'        => $seoData,
            'featuredMenus'  => MenuItem::with('category')
                                ->where('is_available', true)
                                ->inRandomOrder()->limit(4)->get(),
            'latestStories'  => CustomerStory::where('status', 'approved')
                                ->latest()->limit(2)->get(),
            'galleryPreviews' => GalleryItem::limit(8)->get(),
        ]);
    }

    public function menu(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Menu Makanan & Minuman — Warkop Sky Jatiasih',
            'description' => 'Lihat lengkap menu Warkop Sky: es teh, sate, dimsum, kopi, dan 50+ pilihan kuliner autentik. Buka 24 jam di Jatiasih Bekasi.',
            'image'       => asset('images/og-menu.jpg'),
        ])->toArray();

        $categories = MenuCategory::orderBy('sort_order')->get();
        return view('public.menu', compact('categories', 'seoData'));
    }

    public function gallery(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Galeri Foto — Suasana Warkop Sky Jatiasih',
            'description' => 'Lihat foto ambiance Warkop Sky Jatiasih. Spot foto estetik, suasana malam cozy, cocok untuk nongkrong dan foto Instagram.',
        ])->toArray();

        $categories = GalleryCategory::with(['items' => function($q) {
            $q->orderBy('id', 'desc');
        }])->orderBy('sort_order')->get();
        
        return view('public.gallery', compact('categories', 'seoData'));
    }

    public function stories(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Ulasan Pelanggan — Warkop Sky Jatiasih',
            'description' => 'Baca cerita dan ulasan pelanggan setia Warkop Sky. Rating tinggi, pengalaman nyata dari komunitas ngopi Jatiasih Bekasi.',
        ])->toArray();

        $avgRating = CustomerStory::where('status', 'approved')->avg('rating') ?: 5.0;
        $totalReviews = CustomerStory::where('status', 'approved')->count() ?: 0;

        $stories = CustomerStory::where('status', 'approved')
            ->latest()->paginate(9);
        return view('public.stories', compact('stories', 'seoData', 'avgRating', 'totalReviews'));
    }

    public function about(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Tentang Kami — Warkop Sky, Dari Langit Jatiasih',
            'description' => 'Kisah di balik Warkop Sky Jatiasih. Warung kopi autentik yang lahir dari semangat merakyat, kini melayani ribuan pelanggan 24 jam.',
        ])->toArray();

        return view('public.about', compact('seoData'));
    }

    public function contact(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Reservasi & Kontak — Warkop Sky Jatiasih',
            'description' => 'Reservasi meja Warkop Sky Jatiasih mudah via form atau WhatsApp. Alamat, jam buka, dan peta lokasi tersedia di sini.',
        ])->toArray();

        return view('public.contact', compact('seoData'));
    }

    public function events(SeoService $seo)
    {
        $seoData = $seo->set([
            'title'       => 'Events & Agenda — Warkop Sky Jatiasih',
            'description' => 'Cek agenda terbaru Warkop Sky: NOBAR, Live Music, Bakar-Bakaran, Promo spesial, dan masih banyak lagi. Jangan sampai ketinggalan!',
        ])->toArray();

        $events = Event::visible()->get();

        $allEvents = Event::orderBy('event_date', 'desc')->get();

        return view('public.events', compact('events', 'allEvents', 'seoData'));
    }
}

