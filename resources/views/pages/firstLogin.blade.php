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
            <div class="col-md-8 align-items-center">

                @if (auth()->user()->id == $user->id)
                    <div class="card">
                        <form role="form" method="POST" action={{ route('welcome.update') }}
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Edit Profile</p>
                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-uppercase text-sm">User Information</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Name</label>
                                            <input class="form-control" type="text" name="name" id="name"
                                                value="{{ old('name', auth()->user()->name) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Email address</label>
                                            <input class="form-control" type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">Contact Information</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Address</label>
                                            <input class="form-control" type="text" name="address"
                                                value="{{ old('address', auth()->user()->address) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Phone <span class="font-weight-light">(optional)</span></label>
                                            <input class="form-control" type="number" name="phone"
                                                value="{{ old('phone', auth()->user()->phone) }}">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="text-uppercase text-sm">About me</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Bio</label>
                                            <textarea class="form-control" type="text" name="bio" id="bio"
                                                value="{{ old('bio', auth()->user()->bio) }}" placeholder="Please enter something about yourself."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Organization</label>
                                            <select class="form-select" aria-label="Default select example">
                                                @foreach ($organizations as $organization)
                                                    <option value="{{ $organization->id }}">{{ $organization->nickname }}</option>
                                                @endforeach
                                              </select>

                                        </div>
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
        <div class="row justify-content-center">
            <div class="col-md-8 align-items-center">
                <div class="card card-profile">
                    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3 mt-3">
                       <a href="/dashboard" class="btn btn-success px-4 py-3">Join the Community.</a>
                    </div>
                </div>
            </div>
            {{-- USERS POSTS LIST/HISTORY END --}}
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
