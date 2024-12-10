<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/logo.png">
    <title>
        Acad Forum
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/css/argon-dashboard.css')}}" rel="stylesheet" />
    @livewireStyles

    @vite('resources/css/app.css')

    <style>
        [x-cloak]{
            display: none;
        }
        @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .ease-in {
      animation: fadeIn 0.5s ease-in;
    }
    </style>
</head>

<body class="{{ $class ?? '' }}">
    <style>
        main{
            /* background-image: url('https://i.postimg.cc/jqDcHdyc/cropbg.jpg'); */
            background-image: url('https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDI0LTAyL3Jhd3BpeGVsX29mZmljZV8yNF9taW5pbWFsX2Fic3RyYWN0X2dyYWluX2dyYWRpZW50X3Zpc3VhbGl6ZXJfZ180ODg1MjYyYy02NmYyLTQzZTgtYTkwNy03NjBlY2RkNTEwM2ZfMS5qcGc.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
        @guest
        {{-- <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
            <span class="mask bg-success opacity-6"></span></div> --}}
            @yield('content')
        @endguest
        @auth
            {{-- <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://scontent.fmnl9-3.fna.fbcdn.net/v/t39.30808-6/308968418_576850790900568_2676254410150830803_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=783fdb&_nc_ohc=5EcUOz4jRh4AX_FLQIl&_nc_ht=scontent.fmnl9-3.fna&oh=00_AfBAQXeRc3rTZ3VF9gundMJAU7eY4ouaPX-K6A1FGBbVuw&oe=65B3798C'); background-position-y: 50%; background-repeat: no-repeat; background-size: cover, contain; background-position: center top;">
                <span class="mask bg-success opacity-6"></span></div> --}}
            <main class="main-content ease-in" style="width: 100%">
                @yield('content')
            </main>
        @endauth


    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{asset('assets/js/argon-dashboard.js')}}"></script>
    @stack('js')
    @livewireScripts

</body>

</html>
