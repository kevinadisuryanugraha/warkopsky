<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
