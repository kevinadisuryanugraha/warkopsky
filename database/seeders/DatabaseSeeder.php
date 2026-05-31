<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;
use App\Models\User;
use App\Models\MenuItem;
use App\Models\GalleryCategory;
use App\Models\GalleryItem;
use App\Models\CustomerStory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::create([
            'name' => 'Warkop Sky Admin',
            'email' => 'admin@warkopsky.id',
            'password' => Hash::make('password'),
        ]);

        /* ==========================================
           SELECTION A — MENU MAKANAN (Food)
           ========================================== */
        
        // 1. Ayam Goreng Category
        $catAyam = MenuCategory::create([
            'name' => 'Ayam Goreng',
            'slug' => 'ayam-goreng',
            'column_position' => 'left',
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catAyam->id,
            'name' => 'Ayam Goreng Sambal Matah',
            'description' => 'Ayam goreng krispi renyah disajikan dengan siraman sambal matah khas Bali pedas segar aromatik serai.',
            'price' => 15000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catAyam->id,
            'name' => 'Ayam Goreng Asam Manis',
            'description' => 'Ayam goreng krispi renyah dilumuri saus asam manis segar dengan taburan bawang bombay.',
            'price' => 16000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catAyam->id,
            'name' => 'Ayam Goreng Mentega',
            'description' => 'Ayam goreng renyah disiram dengan saus mentega kental manis gurih wangi harum aromatik.',
            'price' => 16000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catAyam->id,
            'name' => 'Ayam Goreng Lada Hitam',
            'description' => 'Ayam goreng gurih berbalur saus lada hitam pekat yang hangat, pedas, dan beraroma kuat.',
            'price' => 16000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $catAyam->id,
            'name' => 'Ayam Goreng Sky Signature',
            'description' => 'Ayam goreng renyah bumbu rahasia signature khas Warkop Sky, gurih hingga ke tulang.',
            'price' => 16000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 5,
        ]);

        // 2. Nasi & Mie Category
        $catNasiMie = MenuCategory::create([
            'name' => 'Nasi & Mie',
            'slug' => 'nasi-mie',
            'column_position' => 'left',
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catNasiMie->id,
            'name' => 'Nasi Goreng Sky',
            'description' => 'Nasi goreng khas Warkop Sky yang kaya rempah disajikan hangat dengan cita rasa gurih lezat.',
            'price' => 13000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catNasiMie->id,
            'name' => 'Nasi Goreng Hongkong',
            'description' => 'Nasi goreng oriental warna putih bersih bercampur orak-arik telur gurih gurih asin pas.',
            'price' => 12000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catNasiMie->id,
            'name' => 'Mie Goreng Sky',
            'description' => 'Mie goreng kenyal bumbu kecap manis gurih warkop lengkap dengan sayuran segar.',
            'price' => 12000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        // 3. Kulit Goreng Category
        $catKulit = MenuCategory::create([
            'name' => 'Kulit Goreng',
            'slug' => 'kulit-goreng',
            'column_position' => 'left',
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catKulit->id,
            'name' => 'Kulit Goreng Sky Signature',
            'description' => 'Kulit ayam krispi super renyah bumbu signature wangi gurih renyah garing disukai semua kalangan.',
            'price' => 15000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catKulit->id,
            'name' => 'Kulit Goreng Mentega',
            'description' => 'Kulit ayam krispi dibalut saus mentega karamelisasi gurih manis aromatik.',
            'price' => 15000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catKulit->id,
            'name' => 'Kulit Goreng Sambal Matah',
            'description' => 'Kulit ayam renyah krispi dipadukan dengan kesegaran irisan sambal matah merah merona.',
            'price' => 14000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catKulit->id,
            'name' => 'Kulit Goreng Asam Manis',
            'description' => 'Kulit ayam renyah dilumuri saus asam manis segar bercita rasa khas.',
            'price' => 15000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $catKulit->id,
            'name' => 'Kulit Goreng Lada Hitam',
            'description' => 'Kulit ayam krispi berbalur saus lada hitam pedas hangat aromatik.',
            'price' => 15000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 5,
        ]);

        // 4. Indomie Category
        $catIndomie = MenuCategory::create([
            'name' => 'Indomie',
            'slug' => 'indomie',
            'column_position' => 'left',
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $catIndomie->id,
            'name' => 'Indomie',
            'description' => 'Indomie warkop legendaris disajikan hangat pas kematangannya.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catIndomie->id,
            'name' => 'Indomie Double',
            'description' => 'Porsi ganda Indomie warkop buat kamu yang kelaparan di tengah malam.',
            'price' => 12000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catIndomie->id,
            'name' => 'Topping Telur',
            'description' => 'Tambahan telur rebus atau mata sapi hangat untuk pelengkap Indomie Anda.',
            'price' => 4000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        // 5. Tahu Category
        $catTahu = MenuCategory::create([
            'name' => 'Tahu',
            'slug' => 'tahu',
            'column_position' => 'left',
            'sort_order' => 5,
        ]);

        MenuItem::create([
            'category_id' => $catTahu->id,
            'name' => 'Tahu Lada Garam',
            'description' => 'Tahu krispi potong dadu digoreng garing lalu ditumis dengan cabai, bawang, dan bumbu lada garam gurih pedas.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catTahu->id,
            'name' => 'Tahu Daun Jeruk',
            'description' => 'Tahu krispi wangi ditumis garing bersama irisan daun jeruk aromatik harum pedas tipis.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        // 6. Manis Category
        $catManis = MenuCategory::create([
            'name' => 'Manis',
            'slug' => 'manis',
            'column_position' => 'left',
            'sort_order' => 6,
        ]);

        MenuItem::create([
            'category_id' => $catManis->id,
            'name' => 'Kue Cubit',
            'description' => 'Kue cubit legendaris lumer manis legit khas warkop, lumer cokelat di tengahnya.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catManis->id,
            'name' => 'Pisang Goreng',
            'description' => 'Pisang goreng hangat renyah manis gurih bertabur tepung krispi.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catManis->id,
            'name' => 'Topping Keju',
            'description' => 'Tambahan parutan keju gurih melimpah untuk hidangan manis Anda.',
            'price' => 3000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catManis->id,
            'name' => 'Topping Coklat',
            'description' => 'Tambahan meises cokelat manis melimpah untuk hidangan manis Anda.',
            'price' => 3000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $catManis->id,
            'name' => 'Topping Coklat Keju',
            'description' => 'Kombinasi melimpah meises cokelat manis dan parutan keju gurih.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 5,
        ]);

        MenuItem::create([
            'category_id' => $catManis->id,
            'name' => 'Topping Chocomaltin',
            'description' => 'Topping cokelat krispi Chocomaltine yang crunchy manis lezat.',
            'price' => 6000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 6,
        ]);

        // 7. Ramean Category
        $catRamean = MenuCategory::create([
            'name' => 'Ramean',
            'slug' => 'ramean',
            'column_position' => 'left',
            'sort_order' => 7,
        ]);

        MenuItem::create([
            'category_id' => $catRamean->id,
            'name' => 'Mix Platter Ramean',
            'description' => 'Kombinasi tahu garing, sosis sapi panggang, kentang goreng krispi, dan kulit tortilla renyah bumbu gurih.',
            'price' => 17000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        // 8. Dimsum Category
        $catDimsum = MenuCategory::create([
            'name' => 'Dimsum',
            'slug' => 'dimsum',
            'column_position' => 'right',
            'sort_order' => 8,
        ]);

        MenuItem::create([
            'category_id' => $catDimsum->id,
            'name' => 'Dimsum Original',
            'description' => 'Siomay ayam udang kukus padat empuk disajikan dengan saus cocolan asam pedas.',
            'price' => 15000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catDimsum->id,
            'name' => 'Dimsum Mentai',
            'description' => 'Siomay kukus hangat dilapisi saus mentai gurih creamy lalu di-torch wangi aromatik.',
            'price' => 18000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        // 9. Kentang Category
        $catKentang = MenuCategory::create([
            'name' => 'Kentang',
            'slug' => 'kentang',
            'column_position' => 'right',
            'sort_order' => 9,
        ]);

        MenuItem::create([
            'category_id' => $catKentang->id,
            'name' => 'Kentang Goreng Original',
            'description' => 'French fries renyah bertabur garam gurih cemilan nongkrong asik.',
            'price' => 8000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catKentang->id,
            'name' => 'Kentang Goreng Variant Keju',
            'description' => 'French fries krispi berbalur saus keju creamy gurih melimpah.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catKentang->id,
            'name' => 'Kentang Goreng Variant Mozzarela',
            'description' => 'French fries diselimuti keju mozarela molor mulur gurih mulur hangat di mulut.',
            'price' => 12000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);


        /* ==========================================
           SELECTION B — MENU MINUMAN (Beverages)
           ========================================== */
        
        // 10. Kopi Category
        $catKopi = MenuCategory::create([
            'name' => 'Kopi',
            'slug' => 'kopi',
            'column_position' => 'left',
            'sort_order' => 10,
        ]);

        MenuItem::create([
            'category_id' => $catKopi->id,
            'name' => 'Kopi Susu Warsky',
            'description' => 'Kopi susu signature Warkop Sky, kental creamy manis pas dapet pilar robusta legendaris.',
            'price' => 13000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catKopi->id,
            'name' => 'Kopi Susu Aren',
            'description' => 'Kopi susu tradisional berpadu legitnya sirup gula aren asli menyegarkan dahaga.',
            'price' => 9000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catKopi->id,
            'name' => 'Americano',
            'description' => 'Seduhan espresso murni dingin tanpa gula bagi pecinta kopi hitam sejati.',
            'price' => 6000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catKopi->id,
            'name' => 'Kopi Bakar',
            'description' => 'Kopi susu dengan foam gula aren dibakar torch di atasnya memicu wangi karamel bakar eksotis.',
            'price' => 14000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 4,
        ]);

        // 11. Teh Category
        $catTeh = MenuCategory::create([
            'name' => 'Teh',
            'slug' => 'teh',
            'column_position' => 'left',
            'sort_order' => 11,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Es Teh Manis Gentong',
            'description' => 'Es teh manis wangi melati otentik disajikan segar di dalam gentong tanah liat mini.',
            'price' => 6000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Es Teh Tawar Gentong',
            'description' => 'Es teh tawar dingin segar yang disajikan melimpah.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Es Teh Leci',
            'description' => 'Es teh manis dipadu buah leci kaleng manis wangi segar menggoda.',
            'price' => 9000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Es Teh Apel',
            'description' => 'Es teh manis dingin segar dengan aroma dan rasa sari apel manis.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Es Teh Lemon',
            'description' => 'Es teh hitam segar dipadu perasan jeruk lemon asli asam manis segar dahsyat.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 5,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Teh Manis Panas',
            'description' => 'Teh melati hangat manis yang diseduh sempurna penenang suasana.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 6,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Teh Tawar Panas',
            'description' => 'Seduhan teh melati hangat tanpa gula yang menyejukkan hati.',
            'price' => 4000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 7,
        ]);

        MenuItem::create([
            'category_id' => $catTeh->id,
            'name' => 'Teh Lemon Panas',
            'description' => 'Seduhan teh hangat berpadu asam manis perasan jeruk lemon asli.',
            'price' => 6000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 8,
        ]);

        // 12. Mocktail Category
        $catMocktail = MenuCategory::create([
            'name' => 'Mocktail',
            'slug' => 'mocktail',
            'column_position' => 'left',
            'sort_order' => 12,
        ]);

        MenuItem::create([
            'category_id' => $catMocktail->id,
            'name' => 'Sky Mocktail',
            'description' => 'Racikan mocktail soda biru cerah berpadu sirup lemon segar sebiru langit siang.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catMocktail->id,
            'name' => 'Sunshine',
            'description' => 'Perpaduan soda lemon kuning jingga beraroma jeruk nipis ceria layaknya matahari terbit.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        // 13. Blend Category
        $catBlend = MenuCategory::create([
            'name' => 'Blend',
            'slug' => 'blend',
            'column_position' => 'left',
            'sort_order' => 13,
        ]);

        MenuItem::create([
            'category_id' => $catBlend->id,
            'name' => 'Es Coklat',
            'description' => 'Minuman cokelat blend kental pekat dengan topping whipped cream kental.',
            'price' => 13000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => true,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catBlend->id,
            'name' => 'Milo Dino',
            'description' => 'Milo blended cokelat lezat berhias bubuk milo melimpah layaknya bukit dinosaurus.',
            'price' => 13000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catBlend->id,
            'name' => 'Matcha',
            'description' => 'Matcha green tea blended lembut creamy wangi teh hijau jepang otentik.',
            'price' => 11000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        // 14. Add On Category
        $catAddOn = MenuCategory::create([
            'name' => 'Add On',
            'slug' => 'add-on',
            'column_position' => 'right',
            'sort_order' => 14,
        ]);

        MenuItem::create([
            'category_id' => $catAddOn->id,
            'name' => 'Es Batu',
            'description' => 'Ekstra es batu dingin menyegarkan dalam gelas terpisah.',
            'price' => 2000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catAddOn->id,
            'name' => 'Susu Kental Manis',
            'description' => 'Ekstra siraman SKM putih / cokelat creamy manis lezat.',
            'price' => 4000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        // 15. Warkop Category
        $catWarkop = MenuCategory::create([
            'name' => 'Warkop',
            'slug' => 'warkop',
            'column_position' => 'right',
            'sort_order' => 15,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Good Day All Variant',
            'description' => 'Sajian kopi saset legendaris Good Day aneka rasa hangat atau dingin.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 1,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Good Day Freeze',
            'description' => 'Seduhan es kopi dingin menyegarkan dan memanjakan lidah.',
            'price' => 8000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 2,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Good Day Cappucino',
            'description' => 'Kopi instan Good Day Cappuccino dengan taburan choco granule di atasnya.',
            'price' => 6000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 3,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Kapal Api Mix/Hitam',
            'description' => 'Seduhan kopi hitam legendaris Kapal Api mantap dan beraroma harum.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 4,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Extra Joss',
            'description' => 'Seduhan minuman energi saset Extra Joss dingin menyegarkan.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 5,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Extra Joss Susu',
            'description' => 'Kombinasi legendaris minuman energi Extra Joss dan kental manis susu.',
            'price' => 8000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 6,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Kukubima',
            'description' => 'Seduhan minuman energi saset Kukubima aneka rasa dingin segar.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 7,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Kukubima Susu',
            'description' => 'Kombinasi legendaris minuman energi Kukubima dingin dan kental manis susu.',
            'price' => 8000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 8,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Dancow',
            'description' => 'Seduhan susu Dancow putih / cokelat hangat yang bernutrisi tinggi.',
            'price' => 8000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 9,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Teh Tarik Maxtea',
            'description' => 'Teh tarik Maxtea manis lembut berbusa disajikan hangat atau dingin.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 10,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Nutrisari All Variant',
            'description' => 'Seduhan Nutrisari aneka rasa jeruk segar disajikan dingin manis alami.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 11,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Air Mineral',
            'description' => 'Air mineral botol dingin atau netral kualitas prima pembasuh tenggorokan.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 12,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Energen',
            'description' => 'Seduhan minuman sereal Energen aneka rasa hangat pengisi energi lambung.',
            'price' => 6000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 13,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Susu Jahe',
            'description' => 'Seduhan susu hangat dengan jahe merah segar yang menghangatkan tubuh.',
            'price' => 5000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 14,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Soda Gembira',
            'description' => 'Sirup coco pandan merah disiram susu kental manis and air soda dingin gembira ria.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 15,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Soda Susu',
            'description' => 'Seduhan air soda dingin bercampur manis gurih susu kental manis.',
            'price' => 10000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 16,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Beng-Beng',
            'description' => 'Seduhan minuman cokelat Beng-beng cokelat drink legit melimpah.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 17,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Chocolatos',
            'description' => 'Seduhan minuman cokelat Chocolatos kental gurih manis wangi cokelat asli.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 18,
        ]);

        MenuItem::create([
            'category_id' => $catWarkop->id,
            'name' => 'Chocolatos Matcha',
            'description' => 'Seduhan minuman matcha Chocolatos hijau wangi aromatik lembut di mulut.',
            'price' => 7000,
            'image_path' => null,
            'is_available' => true,
            'is_favorite' => false,
            'sort_order' => 19,
        ]);

        // 3. Seed Gallery Categories & Items
        $gcat1 = GalleryCategory::create([
            'name' => 'Suasana',
            'slug' => 'suasana',
            'sort_order' => 1,
        ]);

        GalleryItem::create([
            'category_id' => $gcat1->id,
            'image_path' => 'gallery_suasana_1.webp',
            'title' => 'Vibe Senja Outdoor',
            'description' => 'Pemandangan asri area duduk outdoor Warkop Sky di bawah terpaan langit senja golden hour.',
        ]);

        GalleryItem::create([
            'category_id' => $gcat1->id,
            'image_path' => 'gallery_suasana_2.webp',
            'title' => 'Lesehan Malam Hangat',
            'description' => 'Glow lampu Edison menggantung di ruang lesehan indoor semi-terbuka yang nyaman.',
        ]);

        $gcat2 = GalleryCategory::create([
            'name' => 'Menu Utama',
            'slug' => 'menu-utama',
            'sort_order' => 2,
        ]);

        GalleryItem::create([
            'category_id' => $gcat2->id,
            'image_path' => 'gallery_menu_1.webp',
            'title' => 'Sajian Dimsum Original',
            'description' => 'Porsi dimsum ayam udang hangat bertabur wijen dengan cocolan sambal lezat.',
        ]);

        GalleryItem::create([
            'category_id' => $gcat2->id,
            'image_path' => 'gallery_menu_2.webp',
            'title' => 'Kue Cubit Matang Sempurna',
            'description' => 'Piring kue cubit hangat dengan taburan keju mesis cokelat di atasnya.',
        ]);

        $gcat3 = GalleryCategory::create([
            'name' => 'Event',
            'slug' => 'event',
            'sort_order' => 3,
        ]);

        GalleryItem::create([
            'category_id' => $gcat3->id,
            'image_path' => 'gallery_event_1.webp',
            'title' => 'Malam Akustik Musik',
            'description' => 'Kemeriahan live music performance yang menghibur nongkrong malam para pengunjung setia.',
        ]);

        // 4. Seed Customer Stories (Reviews)
        CustomerStory::create([
            'author' => 'Wynne',
            'instagram_handle' => 'wynne.yk',
            'quote' => 'Kopi Susu Warsky & Kue Cubit Lumer Juara!',
            'text' => 'POV pas lagi lemes digempur tugas terus, untungnya langsung diredakan sama segelas kopi susu warsky dingin yang legit bgt. Kue cubit setengah matang-nya lumer cokelat gurih di lidah!',
            'rating' => 5,
            'media_path' => null,
            'media_type' => 'none',
            'status' => 'approved',
        ]);

        CustomerStory::create([
            'author' => 'Jefri Nichol KW',
            'instagram_handle' => 'jefri.nichol.kw',
            'quote' => 'Tempat nongkrong anti-bokek terfavorit',
            'text' => 'Asli ini warkop nyaman banget, apalagi buka 24 jam jadi bebas ngobrol sampe subuh. Harga menu-menunya gila murah banget rata-rata di bawah 15 ribuan aja!',
            'rating' => 5,
            'media_path' => null,
            'media_type' => 'none',
            'status' => 'approved',
        ]);

        CustomerStory::create([
            'author' => 'Adisurya',
            'instagram_handle' => 'adisurya.n',
            'quote' => 'Vibe Outdoor Adem Pol!',
            'text' => 'Malam hari nongkrong di bagian outdoor-nya anginnya sepoi-sepoi dan lampunya estetik banget. Cocok buat bawa laptop sambil nugas ato sekedar ngobrol santai bareng pacar.',
            'rating' => 4,
            'media_path' => null,
            'media_type' => 'none',
            'status' => 'approved',
        ]);

        $this->call(PageViewSeeder::class);

        /* ==========================================
           SELECTION C — EVENTS (Agenda)
           ========================================== */
        
        Event::create([
            'title' => 'NOBAR Final Liga Champions PSG vs Arsenal',
            'slug' => Str::slug('NOBAR Final Liga Champions PSG vs Arsenal'),
            'category' => 'nobar',
            'description' => 'Saksikan pertandingan sengit Final Liga Champions antara PSG vs Arsenal. Tempat terbatas, ayo datang lebih awal atau reservasi meja dari sekarang! Tersedia doorprize menarik.',
            'event_date' => '2026-05-30',
            'event_time_start' => '23:00:00',
            'event_time_end' => null,
            'location' => 'Warkop Sky Jatiasih',
            'poster_image' => null,
            'is_featured' => true,
            'status' => 'upcoming',
        ]);

        Event::create([
            'title' => 'Bakar-Bakaran Bareng Warkop Sky',
            'slug' => Str::slug('Bakar-Bakaran Bareng Warkop Sky'),
            'category' => 'special_event',
            'description' => 'Setiap pembelian di Warkop Sky bakal dapet sate GRATIS yang langsung kita bakar di tempat. Dateng, nongkrong, makan, terus nikmatin aroma sate bakar yang bikin susah move on!',
            'event_date' => '2026-05-27',
            'event_time_start' => '19:00:00',
            'event_time_end' => null,
            'location' => 'Warkop Sky Jatiasih',
            'poster_image' => null,
            'is_featured' => false,
            'status' => 'completed',
        ]);

        Event::create([
            'title' => 'Live Music Warkop Sky Bernyanyi',
            'slug' => Str::slug('Live Music Warkop Sky Bernyanyi'),
            'category' => 'live_music',
            'description' => 'Warkop Sky siap nemenin weekend kalian jadi tambah berwarna! Jangan lupa mampir ya Skyzen, kita seru-seruan bareng nyanyi bareng band lokal kece.',
            'event_date' => '2026-06-06',
            'event_time_start' => '20:00:00',
            'event_time_end' => '23:00:00',
            'location' => 'Warkop Sky Jatiasih',
            'poster_image' => null,
            'is_featured' => true,
            'status' => 'upcoming',
        ]);
    }
}
