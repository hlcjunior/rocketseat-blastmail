@props([
    'color' => 'gray',
])

@php
    $baseClasses = [
        'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm
        focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150',
    ];

    $colorClasses = [
        "bg-white",
        "dark:bg-gray-800",
        "border-{$color}-300",
        "dark:border-{$color}-500",
        "text-{$color}-600",
        "dark:text-{$color}-300",
        "hover:bg-{$color}-50",
        "dark:hover:bg-{$color}-700",
        "hover:text-{$color}-700",
        "focus:ring-{$color}-500",
        "dark:focus:ring-{$color}-600",
    ];

    $allClasses = implode(' ', array_merge($baseClasses, $colorClasses));
@endphp

<button
        {{ $attributes->merge([
            'type' => 'button',
            'class' => $allClasses,
        ]) }}
>
    {{ $slot }}
</button>

