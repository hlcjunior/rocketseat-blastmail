@props([
    'secondary' => null,
    'color' => 'gray',
])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest
    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';

    if ($secondary) {
        $colorClasses = "bg-white dark:bg-gray-800 border-{$color}-300 dark:border-{$color}-500 text-{$color}-600
        dark:text-gray-300 shadow-sm hover:bg-{$color}-50 dark:hover:bg-{$color}-700 hover:text-{$color}-700
        disabled:opacity-25";
    } else {
        $colorClasses = "bg-gray-800 dark:bg-gray-200 border-transparent text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300";
    }
@endphp

<a {{ $attributes->class([
    $baseClasses,
    $colorClasses,
]) }}>
    {{ $slot }}
</a>
