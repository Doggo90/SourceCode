@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        <div class="row">
            {{-- START POSTS LOOPINGS --}}
            <div class="col-lg-9 mb-lg-0 mb-4 mt-2">
                <livewire:create-post />
                <livewire:archived-posts />

            </div>
            {{-- END POSTS LOOPINGS --}}


            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND WHATNOT) --}}
            <div class="col-lg-3 ">
            @include('components.announcements')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
        </div><br><br><br>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
