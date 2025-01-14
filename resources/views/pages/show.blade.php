@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid">
        <div class="row">

            {{-- START POSTS LOOPINGS --}}
            <div class="col-lg-9 mb-lg-0 mb-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Post title-->
                                <h2 class="fw-bolder mb-1">{{$post->title}}</h2>
                                {{-- @php
                                    dd($post1);
                                @endphp --}}
                                <ul class="flex list-inline mb-0">
                                    @foreach($post1->categories as $category)
                                    <li class="badge bg-secondary text-decoration-none link-light list-inline-item">
                                        <a href="/category/{{$category->id}}" style="text-decoration: none; color:white; ">
                                        {{$category->name}}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <livewire:archive-button :post="$post" />
                                <!-- Post meta content-->
                                <div class="mt-0 pt-0">
                                    <small>Tags: </small>
                                    @foreach ($tags as $tag)
                                    <a href="/tag/{{ $tag }}">
                                        <span>
                                            {{ $tag }}
                                        </span>
                                    </a>,
                                    @endforeach
                                </div>
                                <div class="text-muted fst-italic mb-2">{{$post->created_at->diffForHumans()}} by
                                    <a href="/profile/{{$post->author->id}}">
                                        {{ \Illuminate\Support\Str::limit(explode(' ', $post->author->name)[0], $limit = 15, $end = ''). ' '}}<i class="fa fa-star"></i>{{$post->author->reputation}}</a>
                                </div>
                                <!-- Post categories-->
                                    {{-- <x-post-tags :tagsCsv="$post->tags"/> --}}

                            </div>
                            <div class="card-body">
                                <p class="fs-5 mb-4">
                                    {{$post->body}}
                                </p>
                            </div>
                            <div class="card-footer p-3" style="max-height: 60px; ">
                                <div class="d-flex align-items-center gap-2">
                                    <livewire:upvote :key="$post->id" :$post />

                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
                                      </svg>


                                    <!-- Comments Count -->
                                    <span class="font-weight-bold">{{ $post->comments->count() }}</span>
                                </div>

                            </div>
                            <br>
                        </div>
                        <!-- Comments section-->

                        <livewire:comment-section :key="$post->id" :$post />

                    </div>
                </div>

            </div>
            {{-- END POSTS LOOPINGS --}}

            {{-- RIGHT SIDE COLUMN (ANNOUNCEMENTS AND CATEGORIES ETC.) --}}
            <div class="col-lg-3">
                @include('components.announcements')
            </div>


        </div>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
            </div>
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


