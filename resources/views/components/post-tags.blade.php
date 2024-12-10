@props(['tagsCsv'])

@php

    $tags = explode(',', $tagsCsv);

@endphp

<ul class="flex list-inline">
    @foreach($tags as $tag)
    <li class="badge bg-secondary text-decoration-none link-light list-inline-item">
        <a href="/index?tag={{$tag}}" style="text-decoration: none; color:white; ">{{$tag}}</a>
    </li>
    @endforeach
</ul>
