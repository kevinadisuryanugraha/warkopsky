<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = [
            ['url' => '/',         'priority' => '1.0',  'freq' => 'weekly'],
            ['url' => '/menu',     'priority' => '0.9',  'freq' => 'daily'],
            ['url' => '/galeri',   'priority' => '0.7',  'freq' => 'weekly'],
            ['url' => '/stories',  'priority' => '0.7',  'freq' => 'weekly'],
            ['url' => '/tentang',  'priority' => '0.6',  'freq' => 'monthly'],
            ['url' => '/kontak',   'priority' => '0.8',  'freq' => 'monthly'],
        ];

        $lastmod = Carbon::now()->toAtomString();

        return response()
            ->view('sitemap', compact('pages', 'lastmod'))
            ->header('Content-Type', 'application/xml');
    }
}
