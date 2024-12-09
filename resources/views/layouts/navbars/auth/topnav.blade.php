<!-- Navbar -->
<nav style="margin: 0; padding:0;" class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
    id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-0 px-3 d-flex justify-content-between">
        <div class="d-flex align-items-center"> <!-- Adjust alignment as needed -->
            <a href="/dashboard" style="text-decoration: none; color:black;">
                <img src="{{ asset('/img/logo.png') }}" alt="CVSU Forum logo" style="max-height: 50px;">
            </a>
            <a href="/dashboard" style="text-decoration: none; color:black;">
                <img src="{{ asset('/img/title.png') }}" alt="CVSU Forum logo" style="max-height: 50px;">
            </a>
        </div>
        {{-- <div class="container-fluid d-flex justify-content-between align-items-center mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar"> --}}

        <div class="d-flex align-items-center me-5" >
            <div class=" me-1 ms-2">
                <livewire:notif-button />
            </div>
            <div class="d-flex align-items-center dropdown btn-group mt-3 me-1">
                <button type="button" class="position-absolute focus:outline-none bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-md text-white px-3 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ \Illuminate\Support\Str::limit(explode(' ', auth()->user()->name)[0], $limit = 15, $end = '...') }}
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/profile/{{ auth()->user()->id }}">Profile</a></li>
                    @if (auth()->user()->role == 'admin')
                        <li><a class="dropdown-item" href="{{ route('archives') }}">Archived Posts</a></li>
                    @endif
                    <li>
                        <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="nav-link dropdown-item text-black">
                                Log Out
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
            </div>
        {{-- </div> --}}
    </div>
</nav>
<!-- End Navbar -->
