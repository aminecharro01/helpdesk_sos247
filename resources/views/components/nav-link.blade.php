@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active fw-medium'
            : 'nav-link text-muted fw-medium';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
