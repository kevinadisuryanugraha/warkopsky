@props(['seo' => []])

@php
    $title       = $seo['title']       ?? env('SEO_DEFAULT_TITLE', config('app.name'));
    $description = $seo['description'] ?? env('SEO_DEFAULT_DESC');
    $url         = $seo['url']         ?? url()->current();
    $image       = $seo['image']       ?? asset('images/og-default.jpg');
    $type        = $seo['type']        ?? 'website';
@endphp

{{-- Primary --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $url }}">

{{-- Open Graph (Facebook, WhatsApp preview) --}}
<meta property="og:type"        content="{{ $type }}">
<meta property="og:title"       content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url"         content="{{ $url }}">
<meta property="og:image"       content="{{ $image }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height"content="630">
<meta property="og:site_name"   content="Warkop Sky">
<meta property="og:locale"      content="id_ID">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image"       content="{{ $image }}">

{{-- Geo (local SEO) --}}
<meta name="geo.region"      content="ID-JB">
<meta name="geo.placename"   content="Jatiasih, Bekasi">
<meta name="geo.position"    content="-6.3297;106.9951">
<meta name="ICBM"            content="-6.3297, 106.9951">
