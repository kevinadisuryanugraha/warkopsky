@props([
    'href' => null,
    'variant' => 'primary', // primary, outline, red
])

@php
    $class = 'btn-warkop';
    if ($variant === 'outline') {
        $class .= ' btn-warkop-outline';
    } elseif ($variant === 'red') {
        $class .= ' btn-warkop-red';
    }
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
