@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        {{-- START FEATURED POSTS || ANNOUCEMENTS --}}

        <div class="row">
            <div class="col-lg-3">


                @php
                    use App\Models\Post;
                    $mostLikedPost = Post::withCount('likes')
                        ->where('is_archived', false)
                        ->orderBy('likes_count', 'desc')
                        ->first();
                    $hottestPost = Post::withCount('comments')
                        ->where('is_archived', false)
                        ->orderBy('comments_count', 'desc')
                        ->first();
                    // dd($hottestPost);
                    // dd($mostLikedPost);
                @endphp
                <div class="mb-2">
                    <a href="/post/{{ $mostLikedPost->id }}">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Most Upvoted Post</p>
                                            <h5 class="font-weight-bolder">
                                                {{ $mostLikedPost->title }}

                                            </h5>
                                            <p class="mb-0">
                                                <i class="fa fa-arrow-up text-success me-2"></i>
                                                <span class="font-weight-bold">{{ $mostLikedPost->likes()->count() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-success shadow-primary text-center rounded-circle">
                                            <i class="ni ni-like-2 text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mb-2">
                    <a href="/post/{{ $hottestPost->id }}">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase font-weight-bold">HOTTEST POST</p>
                                            <h5 class="font-weight-bolder">
                                                {{ $hottestPost->title }}
                                            </h5>
                                            <p class="mb-0">
                                                <i class="fa fa-comment text-success me-2"></i>
                                                <span
                                                    class="font-weight-bold">{{ $hottestPost->comments()->count() }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div
                                            class="icon icon-shape bg-gradient-success shadow-danger text-center rounded-circle">
                                            <i class="ni ni-chat-round text-lg opacity-10" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @include('components.categories')
            </div>
            {{-- END FEATURED POSTS || ANNOUCEMENTS --}}
            <div class="col-lg-6 mb-lg-0 mb-0">
                @auth
                    <livewire:create-post />
                @endauth
                {{-- START POSTS LOOPINGS --}}
                @livewire('sort-button', ['posts' => $allposts])
                {{-- END POSTS LOOPINGS --}}
            </div>

            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND WHATNOT) --}}
            <div class="col-lg-3">
                @include('components.announcements')
                <div class="card mt-2 ">
                    <div class="card-header">
                        <h5 class="text-center text-bold text-xl">Rankings (Reputation)</h5>
                    </div>
                        <a href="/profile/{{ $first->id }}">
                            <div class="card-body d-flex justify-content-between pb-0"
                                style="padding-bottom: 0; padding-top: 0;">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ !empty($first->photo) ? url($first->photo) : url('/img/no-image.png') }}"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4"
                                        width="40" height="40">
                                        <span >
                                            <img src="/img/first.png"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4 pt-2 me-2"
                                        width="40" height="40">
                                        </span>
                                    <p class="text-bold ms-0 mb-0 pt-3">
                                        {{ \Illuminate\Support\Str::limit(explode(' ', $first->name)[0], $limit = 15, $end = '...') }}
                                        <span>
                                            ({{ $first->organizations->nickname }})
                                        </span>

                                    </p>
                                </div>
                                <p class="text-bold">{{ $first->reputation }}</p>
                            </div>
                        </a>
                        <a href="/profile/{{ $second->id }}">
                            <div class="card-body d-flex justify-content-between pb-0"
                                style="padding-bottom: 0; padding-top: 0;">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ !empty($second->photo) ? url($second->photo) : url('/img/no-image.png') }}"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4"
                                        width="40" height="40">
                                        <span >
                                            <img src="/img/second.png"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4 pt-2 me-2"
                                        width="30" height="30">
                                        </span>
                                    <p class="text-bold ms-0 mb-0 pt-3">
                                        {{ \Illuminate\Support\Str::limit(explode(' ', $second->name)[0], $limit = 15, $end = '...') }}
                                        <span>
                                            ({{ $second->organizations->nickname }})
                                        </span>

                                    </p>
                                </div>
                                <p class="text-bold">{{ $second->reputation }}</p>
                            </div>
                        </a>

                        <a href="/profile/{{ $third->id }}">
                            <div class="card-body d-flex justify-content-between pb-0"
                                style="padding-bottom: 0; padding-top: 0;">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ !empty($third->photo) ? url($third->photo) : url('/img/no-image.png') }}"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4"
                                        width="40" height="40">
                                        <span >
                                            <img src="/img/third.png"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4 pt-2 me-2"
                                        width="30" height="30">
                                        </span>
                                    <p class="text-bold ms-0 mb-0 pt-3">
                                        {{ \Illuminate\Support\Str::limit(explode(' ', $third->name)[0], $limit = 15, $end = '...') }}
                                        <span>
                                            ({{ $third->organizations->nickname }})
                                        </span>

                                    </p>
                                </div>
                                <p class="text-bold">{{ $third->reputation }}</p>
                            </div>
                        </a>
                    @foreach ($topRep as $top)
                        <a href="/profile/{{ $top->id }}">
                            <div class="card-body d-flex justify-content-between pb-0"
                                style="padding-bottom: 0; padding-top: 0;">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ !empty($top->photo) ? url($top->photo) : url('/img/no-image.png') }}"
                                        alt="profile_image" class="rounded-circle img-fluid border-white pb-4"
                                        width="40" height="40">
                                    <p class="text-bold ms-3">
                                        {{ \Illuminate\Support\Str::limit(explode(' ', $top->name)[0], $limit = 15, $end = '...') }}
                                        <span>
                                            ({{ $top->organizations->nickname }})
                                        </span>
                                    </p>
                                </div>

                                <p class="text-bold">{{ $top->reputation }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
        </div><br><br><br>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
