@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active fw-medium border-start border-3 border-primary bg-light'
            : 'nav-link text-muted fw-medium border-start border-3 border-transparent';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
