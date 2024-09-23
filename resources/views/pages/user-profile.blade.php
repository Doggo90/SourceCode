@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
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

                                <span class="ms-2">Total Reputation: {{ $user->total_reputation }}</span>
                            </li>
                            <li class="nav-item mb-0 px-0 py-1 d-flex align-items-center justify-content-center ">
                                <i class="fa fa-folder-open"></i>
                                <span class="ms-2">Posts: {{ $user->posts()->count() }}</span>
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
                            <div class="h6 mb-0">
                                {{ $user->organizations->name ?? 'This user has yet to set their org.' }}
                            </div>
                            <div class="h6">
                                <strong>({{ $user->organizations->nickname ?? 'This user has yet to set their org.' }})
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
                                            <textarea class="form-control" type="text" name="bio" id="bio"
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
        <div class="row justify-content-center mt-2">
            <div class="col-md-8 align-items-center">
                <div class="card card-header">
                    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3 mt-3">
                        <h3 class="text-2xl"><strong>Posts</strong> </h3>
                    </div>
                    <div class="card-body pt-0">
                        @php $posts = $user->posts; @endphp
                        @foreach ($posts as $post)
                        <div class="row">
                            <div class="d-flex justify-content-between mx-auto">
                                <a href="/post/{{ $post->id }}" class="d-flex justify-content-between w-100">
                                    <div class="d-flex justify-content-start p-2">
                                        <span class="text-lg font-weight-bolder">{{ \Illuminate\Support\Str::limit($post->title, $limit = 30, $end = '...') }}</span>
                                        <small class="ps-2 ms-2">{{ $post->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="d-flex justify-content-end hidden-lg-down d-none d-sm-inline-flex">
                                        <p class="mb-0 p-2">
                                            <i class="fa fa-arrow-up text-success me-2"></i>
                                            <span class="font-weight-bold">{{ $post->likes()->count() }}</span>
                                        </p>
                                        <p class="mb-0 p-2">
                                            <i class="fa fa-comment text-success me-2"></i>
                                            <span class="font-weight-bold">{{ $post->comments()->count() }}</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- USERS POSTS LIST/HISTORY END --}}
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
