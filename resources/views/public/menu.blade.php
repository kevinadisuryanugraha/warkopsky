@extends('layouts.app')

@section('title', 'Daftar Menu Lezat & Segar | Warkop Sky')

@section('meta_description', 'Jelajahi menu kuliner Warkop Sky: Es Teh Gentong, Sate Maranggi, Dimsum Chilli Oil pedas gurih, Pisang Goreng Keju melimpah, dan Kopi Susu tradisional. Murah dan nikmat!')

@section('content')
    <div style="min-height: 80vh; background-color: var(--color-midnight-bg); padding-bottom: var(--spacing-xl);">
        <!-- Livewire MenuList Component -->
        <livewire:menu-list />
    </div>

    <!-- JSON-LD Menu & Breadcrumb Schemas -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Menu",
      "name": "Menu Warkop Sky",
      "url": "{{ config('app.url') }}/menu",
      "description": "Daftar makanan dan minuman khas Warkop Sky Jatiasih",
      "hasMenuSection": {
        "@@type": "MenuSection",
        "name": "Pilihan Menu",
        "description": "Makanan dan minuman autentik Warkop Sky"
      }
    }
    </script>
    
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
          "name": "Menu",
          "item": "{{ url()->current() }}"
        }
      ]
    }
    </script>
@endsection
