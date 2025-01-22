<div class="pb-0" x-data="{ open: false, hide: false }" >

    <div class="card z-index-2 mb-2 mt-2 " style="max-height: 200px; overflow: hidden;">
        <p class="h4 text-bold text-center mt-2">Announcements</p>
        <a href="/announcement/{{ $latestAnn->id }}">
            <div class="card-body pb-0 pt-2 bg-transparent ">
                <p class="text-uppercase fw-bold">
                    {{ \Illuminate\Support\Str::limit(explode('å', $latestAnn->title)[0], $limit =40, $end = '...') }}
                </p>
                <p class="text-uppercase fw-bold">
                    {{ \Illuminate\Support\Str::limit(explode('å', $latestAnn->overview)[0], $limit =80, $end = '...') }}
                </p>
                <p class="text-sm mb-0">
                    <i class="fa fa-clock text-success"></i>
                    <span class="font-weight-bold">{{ $latestAnn->created_at->diffForHumans() }}</span>
                </p>
            </div>
            <div class="card-footer px-4 pt-0 pb-2">
                <small>Click here for info.</small>
            </div>
        </a>
    </div>
    <div class="card z-index-2 mb-2 mt-2 text-center" style="max-height: 200px; overflow: hidden;">
        <a href="#" x-on:click="open = !open, hide=!hide" x-show="!open"><strong><i>Show All Announcements</i></strong> </a>
    </div>
    <div x-show="open" x-cloak class="ease-in">
        @foreach ($announcements as $announcement)
            <div class="card z-index-2 mb-2 mt-2 " style="max-height: 200px; overflow: hidden;">
                <a href="/announcement/{{ $announcement->id }}">
                    <div class="card-body pb-0 pt-2 bg-transparent ">
                        <p class="text-uppercase fw-bold">
                            {{ \Illuminate\Support\Str::limit(explode('å', $announcement->overview)[0], $limit =40, $end = '...') }}
                        </p><p class="text-uppercase fw-bold">
                            {{ \Illuminate\Support\Str::limit(explode('å', $announcement->overview)[0], $limit =80, $end = '...') }}
                        </p>
                        <p class="text-sm mb-0">
                            <i class="fa fa-clock text-success"></i>
                            <span class="font-weight-bold">{{ $announcement->created_at->diffForHumans() }}</span>
                        </p>
                    </div>
                    <div class="card-footer px-4 pt-0 pb-2">
                        <small>Click here for info.</small>
                    </div>
                </a>
            </div>
        @endforeach
        <div class="card z-index-2 mb-2 mt-2 text-center" style="max-height: 200px; overflow: hidden;">

            <a href="#" x-on:click="open = !open, hide=!hide"><strong><i>Show less Announcements</i></strong></a>
        </div>
    </div>
</div>
