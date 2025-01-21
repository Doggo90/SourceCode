@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row mt-4">
            {{-- START POSTS LOOPINGS --}}
            <div class="col-lg-12 mb-lg-0 mb-4">
                <br><br>
                @auth
                <livewire:create-post />
                @endauth
                <br>
                <livewire:archived-posts />

            </div>
            {{-- END POSTS LOOPINGS --}}


            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND WHATNOT) --}}
            <div class="col-lg-3 ">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
        </div><br><br><br>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
