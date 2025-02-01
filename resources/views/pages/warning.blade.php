@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-lg-2 mt-0">

            </div>
            {{-- START ANNOUNCEMENT CONTENT --}}
            <div class="col-lg-8 mb-lg-0 mb-4 text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                            </div>

                                {{--                WARNING BODY                  --}}

                            <div class="card-body">
                                @if($user->warnings == 1)
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{ asset('/img/first-offence.png' ) }}">
                                    <img src="{{ asset('/img/first-offence.png') }}" alt="">
                                    </a>
                                </div>
                                @endif
                                @if($user->warnings == 2)
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{ asset('/img/second-offence.png' ) }}">
                                    <img src="{{ asset('/img/second-offence.png') }}" alt="">
                                    </a>
                                </div>
                                @endif
                            </div>
                            <br>
                        </div>
                        <!-- Comments section OMITTED DUE TO LIVEWIRE CONFLICTS -->
                        {{-- <livewire:comment-section :key="$post->id" :$post /> --}}
                    </div>
                </div>
            </div>
            {{-- END ANNOUNCEMENT CONTENT --}}
            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND CATEGORIES ETC.) --}}
            <div class="col-lg-2 mt-0">

            </div>
        </div>


    </div>
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
        </div>
    </div><br><br><br>
    @include('layouts.footers.auth.footer')
    </div>
@endsection

