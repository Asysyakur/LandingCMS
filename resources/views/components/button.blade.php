@props([
    'variant' => 'solid', // solid, soft, outline, transparent
    'size'    => 'lg',    // lg, md, sm
    'color'   => 'primary', // primary, secondary, danger (error), dark (black)
    'type'    => 'button',
    'iconLeft' => null,
    'iconRight' => null,
    'class'   => '',
])

@php
    // 1. Map Colors (Tailwind names -> Bootstrap names)
    $bsColor = match($color) {
        'black' => 'dark',
        'error' => 'danger',
        'white' => 'light',
        default => $color,
    };

    // 2. Base Classes (rounded-pill matches your rounded-full)
    $classes = "btn rounded-pill d-inline-flex align-items-center justify-content-center gap-2 transition-all $class";

    // 3. Size Logic
    if ($size === 'lg') $classes .= " btn-lg px-4";
    if ($size === 'sm') $classes .= " btn-sm px-3";

    // 4. Variant Logic
    switch ($variant) {
        case 'solid':
            $classes .= " btn-{$bsColor} text-white shadow-sm";
            break;
        case 'outline':
            $classes .= " btn-outline-{$bsColor}";
            break;
        case 'soft':
            $classes .= " btn-light text-{$bsColor} border-0";
            break;
        case 'transparent':
            $classes .= " btn-link text-decoration-none text-{$bsColor}";
            break;
        default:
            $classes .= " btn-{$bsColor}";
    }
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($iconLeft)
        <i class="{{ $iconLeft }}"></i>
    @endif

    <span>{{ $slot }}</span>

    @if($iconRight)
        <i class="{{ $iconRight }}"></i>
    @endif
</button>