@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-12 mb-xl-0 mb-4">

            </div>
            <div class="col-lg-6 mb-lg-0 mb-4">
                @auth
                    <livewire:create-post />
                @endauth
                {{-- START POSTS LOOPINGS --}}
                <style>
                    .custom-button {
                        margin: 0;
                    }
                </style>
                <br>
                <div class="card">
                    <div class="card-header d-flex justify-content-center pb-0">
                        <h4 class="text-bold uppercase text-2xl">{{ $tag }}</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($posts as $post)
                            @if ($post->is_archived == 0 && $post->is_approved)
                                <a href="/post/{{ $post->id }}">
                                    <div class="card z-index-2" style="max-height: 200px; overflow: hidden;">
                                        <div class="card-header pb-0 pt-3 bg-transparent d-flex justify-content-start mx-3">
                                            <div class=" d-flex justify-content-between">
                                                <img class="img-fluid rounded-circle" style="width: 2rem; height: 2rem;"
                                                    src="{{ !empty($post->author->photo) ? url($post->author->photo) : url('/img/no-image.png') }}"
                                                    alt="profile">
                                                <p class="text-capitalize text-bold ps-2">{{ $post->author->name }}</p>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex justify-content-between mx-4  py-2"
                                            style="max-height: 100px; overflow: hidden; margin-bottom: 0; margin-left: 0; margin-right: 0;">
                                            <p class="text-uppercase fw-bold">
                                                {{ \Illuminate\Support\Str::limit(explode('å', $post->title)[0], $limit = 40, $end = '...') }}
                                            </p>

                                        </div>
                                        <div class="card-footer d-flex justify-content-between p-3 mx-4 mt-0 mb-2 py-0"
                                            style="max-height: 100px; padding-top: 0; margin-top: 0;">
                                            <div class="d-flex">
                                                <i class="fa fa-arrow-up text-success me-3"></i>
                                                <span class="font-weight-bold">{{ $post->likes()->count() }}</span>
                                                <i class="fa fa-comment text-success ms-3 me-3"></i>
                                                <span class="font-weight-bold">{{ $post->comments->count() }}</span>
                                            </div>
                                            <div class="ms-5 d-flex">
                                                <i class="fa fa-clock text-success"></i>
                                                <span class="font-weight-bold text-sm mb-0 ms-2">
                                                    {{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <br>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center inline-block">
                            {{ $posts->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
                <br>
                {{-- END POSTS LOOPINGS --}}
            </div>
            @livewireScripts

        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection
