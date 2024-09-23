
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
            <div class="card z-index-2" style="max-height: 200px; overflow: hidden;"    >
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">
                        <img class="img-fluid rounded-circle" style="width: 2rem; height: 2rem;" src="{{ (!empty($post->author->photo)) ? url($post->author->photo) : url('/img/no-image.png')}}" alt="profile">

                        {{$post->author->name}}</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-clock text-success"></i>
                        <span class="font-weight-bold"> {{$post->created_at->diffForHumans()}}</span>
                    </p>
                </div>
                <div class="card-body p-3" style="max-height: 100px; overflow: hidden;">
                    <h4 class="text-uppercase fw-bold">{{$post->title}}</h4>
                </div>
                <div class="card-footer p-3" style="max-height: 100px;">
                    <p>
                        <i class="fa fa-arrow-up text-success me-2"></i>
                        <span class="font-weight-bold">{{$post->likes()->count()}}</span>
                        <i class="fa fa-comment text-success ms-3 me-2"></i>
                        <span class="font-weight-bold">{{$post->comments_count}}</span>
                    </p>
                </div>
            </div>
        </a>
        <br>
    @endif

@endforeach


</div>
