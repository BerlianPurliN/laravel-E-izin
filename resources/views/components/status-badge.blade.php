@props(['status'])
@php
    $styles = [
        'Pending' => 'bg-amber-100 text-amber-800',
        'Approved' => 'bg-green-100 text-green-800',
        'Rejected' => 'bg-red-100 text-red-800',
    ];
    $labels = [
        'Pending' => 'Menunggu',
        'Approved' => 'Diterima',
        'Rejected' => 'Ditolak',
    ];
    $class = $styles[$status] ?? 'bg-slate-100 text-slate-700';
    $label = $labels[$status] ?? $status;
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $class"]) }}>
    {{ $label }}
</span>
