@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row mt-4">

            {{-- START ANNOUNCEMENT CONTENT --}}
            <div class="col-lg-9 mb-lg-0 mb-4 text-center">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                {{--                ANNNOUNCEMENT TITLE                  --}}
                                <h2 class="fw-bolder mb-1 text-3xl">{{ $announcement->title }}</h2>
                                <div class="text-muted fst-italic mb-2">
                                    {{ $announcement->created_at->diffForHumans() }} by
                                    <a href="/profile/{{ $announcement->author->id }}">
                                        {{ $announcement->author->name }}
                                        <i class="fa fa-star"></i>
                                        {{ $announcement->author->reputation }}
                                    </a>
                                </div>
                            </div>

                                {{--                ANNNOUNCEMENT BODY                  --}}
                            <div class="card-body d-flex justify-items-center">

                                    <img class="img-fluid d-flex" src="/storage/{{ $announcement->image }}" alt="" style="max-width: 100%; ">
                                    <br><br><br>
                            </div>
                            <div>

                                <p class="fs-5 mb-4">{{ $announcement->body }}</p>
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
            <div class="col-lg-3 mt-0">
                @include('components.announcements')
                {{-- CATEGORIES CARD --}}
                <div class="card">
                    @include('components.categories')
                </div>
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

@push('js')
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
