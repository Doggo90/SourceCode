@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        <div class="row">

            {{-- START POSTS LOOPINGS --}}
            <div class="col-lg-9 mb-lg-0 mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Post title-->
                                <h2 class="fw-bolder mb-1">{{$post->title}}</h2>
                                {{-- @php
                                    dd($post1);
                                @endphp --}}
                                <ul class="flex list-inline mb-0">
                                    @foreach($post1->categories as $category)
                                    <li class="badge bg-secondary text-decoration-none link-light list-inline-item">
                                        <a href="/category/{{$category->id}}" style="text-decoration: none; color:white; ">
                                        {{$category->name}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <livewire:archive-button :post="$post" />
                                <!-- Post meta content-->
                                <div class="mt-0 pt-0">
                                    <small>Tags: </small>
                                    @foreach ($tags as $tag)
                                    <a href="/tag/{{ $tag }}">
                                        <span>
                                            {{ $tag }}
                                        </span>
                                    </a>,
                                    @endforeach
                                </div>
                                <div class="text-muted fst-italic mb-2">{{$post->created_at->diffForHumans()}} by
                                    <a href="/profile/{{$post->author->id}}">
                                        {{ \Illuminate\Support\Str::limit(explode(' ', $post->author->name)[0], $limit = 15, $end = ''). ' '}}<i class="fa fa-star"></i>{{$post->author->reputation}}</a>
                                </div>
                                <!-- Post categories-->
                                    {{-- <x-post-tags :tagsCsv="$post->tags"/> --}}

                            </div>
                            <div class="card-body">
                                <p class="fs-5 mb-4">
                                    {{$post->body}}
                                </p>
                            </div>
                            <div class="card-footer p-3" style="max-height: 60px; ">
                                <p>
                                    <livewire:upvote :key="$post->id" :$post />
                                    <i class="fa fa-comment text-success ms-3 me-2"></i>
                                    <span class="font-weight-bold">{{ $post->comments->count()}}</span>
                                </p>
                            </div>
                            <br>
                        </div>
                        <!-- Comments section-->

                        <livewire:comment-section :key="$post->id" :$post />

                    </div>
                </div>

            </div>
            {{-- END POSTS LOOPINGS --}}

            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND CATEGORIES ETC.) --}}
            <div class="col-lg-3">
                @include('components.announcements')
            </div>


        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection



