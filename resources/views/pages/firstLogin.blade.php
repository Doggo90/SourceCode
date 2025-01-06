@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    {{-- REPUTATION DISPLAY AND POSTS COUNT START --}}
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-lg-12 col-md-12 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav  nav-fill p-1" role="tablist">
                            <li class="nav-item mb-0 px-0 py-1 active d-flex align-items-center justify-content-center ">
                                <span class="text-bold">One last thing before joining the community.
                                    Please check if your account details are correct.
                                </span>

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
        <br><br>
        {{-- USER DETAILS END --}}


        {{-- USER DETAILS FORM START --}}
        <div class="row justify-content-center">
            <livewire:organization-selector :user-id="auth()->user()->id" />

        </div>
        {{-- USER DETAILS FORM END --}}
        {{-- USERS POSTS LIST/HISTORY START --}}

        @include('layouts.footers.auth.footer')
    </div>
@endsection
