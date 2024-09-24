
<div class="card">
    <br>
    <div class="container-fluid d-flex justify-content-center">
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
            <label class="btn btn-outline-success" for="btnradio1" wire:click="setSortBy('created_at')">Latest</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
            <label class="btn btn-outline-success" for="btnradio2" wire:click="setSortBy('likes_count')">Upvotes</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
            <label class="btn btn-outline-success" for="btnradio3" wire:click="setSortBy('body')">Comments</label>
          </div>
    </div>
@foreach($posts as $post)
    @if ($post->is_archived == 1)
        <a href="/post/{{$post->id}}">
            <div class="card z-index-2 mb-2" style="max-height: 200px; overflow: hidden;">
                <div class="card-header pb-0 pt-3 bg-transparent d-flex justify-content-start mx-3">
                    <div class=" d-flex justify-content-between">
                        <img class="img-fluid rounded-circle" style="width: 2rem; height: 2rem;"
                            src="{{ !empty($post->author->photo) ? url($post->author->photo) : url('/img/no-image.png') }}"
                            alt="profile">
                        <p class="text-capitalize text-bold ps-2">{{ $post->author->name }}</p>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between mx-4  py-2" style="max-height: 100px; overflow: hidden; margin-bottom: 0; margin-left: 0; margin-right: 0;">
                        <p class="text-uppercase fw-bold">
                            {{ \Illuminate\Support\Str::limit(explode('å', $post->title)[0], $limit =40, $end = '...') }}
                        </p>

                </div>
                <div class="card-footer d-flex justify-content-between p-3 mx-4 mt-0 mb-2 py-0" style="max-height: 100px; padding-top: 0; margin-top: 0;">
                    <div class="d-flex">
                        <i class="fa fa-arrow-up text-success me-3"></i>
                        <span class="font-weight-bold">{{ $post->likes()->count() }}</span>
                        <i class="fa fa-comment text-success ms-3 me-3"></i>
                        <span class="font-weight-bold">{{ $post->comments->count() }}</span>
                    </div>
                    <div class="ms-5 d-flex">
                        <i class="fa fa-clock text-success"></i>
                        <span class="font-weight-bold text-sm mb-0 ms-2"> {{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </a>
    @endif

@endforeach


</div>
