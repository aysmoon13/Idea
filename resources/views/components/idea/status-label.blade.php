@props(['status' => 'pending'])

@php
    $classes = 'inline-block rounded-full border px-2 py-1 text-sm font-medium';

    if ($status === 'pending') {
        $classes .= ' bg-yellow-500/10 text-yellow-500 border-yellow-500/20';
    }

    if ($status === 'in_progress') {
        $classes .= ' bg-blue-500/10 text-blue-500 border-blue-500/20';
    }

    if ($status === 'completed') {
        $classes .= ' bg-primary/10 text-primary border-primary/20';
    }
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

{{-- //File resources/views/components/card.blade.php \
<a href="{{route('ideas.show', $idea->id)}}" {{ $attributes(['class'=>'border border-border rounded-lg bg-card p-4 md:text-sm'])}} >
    <h3 class="text-foreground text-lg">{{$idea->title}}</h3>

    <x-idea.status-label :status="$idea->status" />

    <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
    <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
</a> --}}