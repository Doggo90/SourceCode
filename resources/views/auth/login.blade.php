@extends('layouts.app')

@section('content')
    <main class="main-content">
        <section>
            <div class="bg-image img-fluid"
                style="background-image: url('https://i.postimg.cc/QNwBjv5s/blurbg.jpg');
        height: 100vh;
        background-size: cover;">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 d-flex" style="padding: 12%">
                            <div class="bg-white rounded-start shadow-lg p-3 col-12 col-md-6">
                                <div class="p-2">
                                    <h2 class="display-6">WELCOME TO</h2>
                                    <h1 class="display-6">CvSU TANZA</h1>
                                    <h1 class="display-6 padding-bottom: 5%;">ACADEMIC FORUM</h1>
                                    <a href="/auth/google/redirect" class="btn btn-info">
                                        <i class="fa fa-google"></i>
                                        Sign in with Google
                                    </a>
                                    <h4 class="fs-6 fs-sm-5">
                                        <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i>
                                        Please use your CvSU email to login
                                    </h4>
                                </div>
                            </div>
                            <div class="rounded-end d-none d-md-block"
                                style="background-image: url('https://cvsu.edu.ph/wp-content/uploads/2022/08/Tanza-Campus-scaled.jpg?fbclid=IwAR2UebcUksX9Ai1VenNWZo9orsWpU-I-NIE3S5F-MBpFYeWOUYUvuX135FI'); background-size: cover; background-position: center; background-repeat: no-repeat; width: 50%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
