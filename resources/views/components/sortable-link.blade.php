@props(['column', 'label'])
@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
    
    $direction = 'asc';
    if ($currentSort === $column && $currentDirection === 'asc') {
        $direction = 'desc';
    }
    
    $url = request()->fullUrlWithQuery([
        'sort' => $column,
        'direction' => $direction,
    ]);
@endphp
<a href="{{ $url }}" class="group inline-flex items-center gap-1.5 hover:text-slate-200 transition-colors">
    {{ $label }}
    @if ($currentSort === $column)
        <i class="fas fa-chevron-{{ $currentDirection === 'asc' ? 'up' : 'down' }} text-[10px] text-sky-400"></i>
    @else
        <i class="fas fa-sort text-[10px] opacity-0 group-hover:opacity-100 transition-opacity"></i>
    @endif
</a>
