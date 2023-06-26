@props([
    'isHtml' => true,
    'content' => null,
])

@if ($content)
    @if ($isHtml)
        {!! $content !!}
    @else
        {{ $content }}
    @endif
@endif
