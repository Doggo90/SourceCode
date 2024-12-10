@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

    @php
        // dd($user->likes()->count());
        // dd($user->comment()->count());
    @endphp

    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    {{-- REPUTATION DISPLAY AND POSTS COUNT START --}}
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-lg-12 col-md-12 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item mb-0 px-0 py-1 active d-flex align-items-center justify-content-center ">
                                <i class="fa fa-star"></i>
                                <span class="ms-2">Reputation: {{ $user->reputation }}</span>


                            </li>
                            <li class="nav-item mb-0 px-0 py-1 active d-flex align-items-center justify-content-center ">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.395a.75.75 0 0 1 0 1.422l-1.183.395c-.447.15-.799.5-.948.948l-.395 1.183a.75.75 0 0 1-1.422 0l-.395-1.183a1.5 1.5 0 0 0-.948-.948l-1.183-.395a.75.75 0 0 1 0-1.422l1.183-.395c.447-.15.799-.5.948-.948l.395-1.183A.75.75 0 0 1 16.5 15Z" clip-rule="evenodd" />
                                  </svg>

                                  <div x-data="{ open: false }">
                                      <button x-on:click="open = !open">
                                        <span class="ms-2">Total Reputation: {{ $user->total_reputation }}</span>
                                    </button>

                                    <span x-show="open">
                                        <div class="d-flex align-content-start">
                                            <span class="ms-2 d-flex justify-items-between">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                  </svg>
                                                <p><strong>{{ $user->posts()->count() }}</strong> from posts.</p>
                                            </span>
                                        </div>
                                        <div class="d-flex align-content-start">
                                            <span class="ms-2 d-flex justify-items-between">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                                  </svg>

                                                <p><strong>{{ $user->likes()->count() }}</strong> from upvotes.</p>
                                            </span>
                                        </div>
                                        <div class="d-flex align-content-start">
                                            <span class="ms-2 d-flex justify-items-between">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-6" width="10" height="10">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                                      </svg>

                                                <p> <strong>{{ $user->comment()->count() }}</strong> from comments.</p>
                                            </span>
                                        </div>
                                    </span>
                                </div>
                            </li>

                                <li class="nav-item mb-0 px-0 py-1 d-flex align-items-center justify-content-center ">
                                    <i class="fa fa-folder-open"></i>
                                    <a href="#user_posts">
                                    <span class="ms-2">Posts: {{ $user->posts()->count() }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- REPUTATION DISPLAY AND POSTS COUNT END --}}
    <div id="alert">
        @include('components.alert')
    </div>
    <br>
    <div class="container-fluid py-4">
        {{-- USER DETAILS START --}}
        <div class="row justify-content-center">
            <div class="col-md-8 align-items-center">
                <div class="card card-profile ">
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2 d-flex justify-content-center align-items-center">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <img src="{{ !empty($user->photo) ? url($user->photo) : url('/img/no-image.png') }}"
                                    alt="profile_image" class="rounded-circle img-fluid border border-2 border-white"
                                    width="200" height="200">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h5>
                                {{ $user->name }}
                            </h5>
                            <div class="h6 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ $user->email }}
                            </div>
                            <div>
                                <strong>Organization</strong>
                            </div>
                            <div class="h6">
                                <strong>@if(!$userOrgs){
                                    ''
                                }
                                @else
                                    @foreach ($userOrgs as $org )
                                        {{ $org->name }} ({{ $org->nickname }}),<br>
                                    @endforeach
                                @endif
                                </strong>
                            </div>
                            <div>
                                <strong>Bio</strong>
                            </div>
                            <div class="h6">
                                {{ $user->bio ?? 'This user has yet to set their bio.' }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- USER DETAILS END --}}


        {{-- USER DETAILS FORM START --}}
        <div class="row justify-content-center mt-2">
            <div class="col-md-8 align-items-center">

                @if (auth()->user()->id == $user->id)
                    <div class="card">
                        <form role="form" method="POST" action="{{ route('profile.update', ['id' => $user->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-profile pb-0 text-center">
                                <div class="card-header">
                                    <p class="mb-0 text-xl"><strong>Edit Profile</strong></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase text-m">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label text-sm">Name</label>
                                            <input class="form-control" type="text" name="name" id="name"
                                                value="{{ old('name', auth()->user()->name) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label text-sm">Email address</label>
                                            <input class="form-control" type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                {{-- <p class="text-uppercase text-m">Contact Information</p> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- <div class="form-group">
                                            <label for="example-text-input" class="form-control-label text-sm">Address</label>
                                            <input class="form-control" type="text" name="address"
                                                value="{{ old('address', auth()->user()->address) }}">
                                        </div> --}}
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone</label>
                                            <input class="form-control" type="number" name="phone" value="{{ old('phone', auth()->user()->phone)}}">
                                        </div>
                                    </div> --}}
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-m">About me</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label text-sm">Bio</label>
                                            <textarea maxlength="500" class="form-control" type="text" name="bio" id="bio"
                                                value="{{ old('bio', auth()->user()->bio) }}" placeholder="Please enter something about yourself."></textarea>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-m px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><strong>Save</strong></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

        </div>
        {{-- USER DETAILS FORM END --}}

        {{-- USERS POSTS LIST/HISTORY START --}}
        {{-- @php
        use App\Models\Post;
        $posts = $user->posts;
        @endphp --}}
        <div class="row justify-content-center mt-2">
            <div class="col-md-8 align-items-center">
                <div class="card card-header">
                    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3 mt-3">
                        <h3 class="text-2xl"><strong>Posts</strong> </h3>
                    </div>
                    @if ($posts->count() < 1)
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="d-flex justify-content-center mx-auto">
                                    <h1>No posts found.</h1>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                        </div>
                    @else
                        <div class="card-body pt-0">
                            @foreach ($posts as $post)
                                <div class="row">
                                    <div class="d-flex justify-content-between p-2">
                                        <a href="/post/{{ $post->id }}" class="d-flex justify-content-between w-100">
                                                <div class="col-12 col-sm-4 d-flex align-items-center ">
                                                    <span
                                                        class="text-lg font-weight-bolder">{{ \Illuminate\Support\Str::limit($post->title, $limit = 30, $end = '...') }}</span>
                                                </div>
                                                <div
                                                    class="col-12 col-sm-4 d-flex align-items-center justify-content-center">
                                                    <small
                                                        class="ps-2 ms-2">{{ $post->created_at->diffForHumans() }}</small>
                                                </div>
                                                <div class="col-12 col-sm-4 d-flex justify-content-end align-items-center">
                                                    <p class="mb-0 p-2">
                                                        <i class="fa fa-arrow-up text-success me-2"></i>
                                                        <span
                                                            class="font-weight-bold">{{ $post->likes()->count() }}</span>
                                                    </p>
                                                    <p class="mb-0 p-2">
                                                        <i class="fa fa-comment text-success me-2"></i>
                                                        <span
                                                            class="font-weight-bold">{{ $post->comments()->count() }}</span>
                                                    </p>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            {{-- USERS POSTS LIST/HISTORY END --}}
        </div>
        @include('layouts.footers.auth.footer')
    </div>

	<script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>
@endsection
