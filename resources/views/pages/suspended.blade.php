@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mb-lg-0 mb-4">
                <h1 class="text-center">Your Account has been suspended!</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
            @include('layouts.footers.auth.footer')
        </div>
    </div>
@endsection
