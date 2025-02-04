<section class="mb-5">

    <div class="card bg-light">
        <div class="card-body">
            <!-- Comment form-->
            @auth

                <form wire:submit="createComment" class="row g-3 mb-4" action="">
                    @csrf
                    <div class="col-auto">
                        <a href="/profile/{{ auth()->user()->id }}" class="relative inline-block">
                            <!-- User Image -->
                            <img class="img-fluid rounded-circle" style="width: 3rem; height: 3rem;"
                                src="{{ !empty(auth()->user()->photo) ? url(auth()->user()->photo) : url('/img/no-image.png') }}"
                                alt="profile">

                            <!-- Badge based on reputation -->
                            @php
                                $badge = '';
                                switch (true) {
                                    case auth()->user()->reputation >= 500:
                                        $badge = 'Expert';
                                        $badgeColor = '#FFD700'; // Gold
                                        $textColor = 'black';
                                        break;
                                    case auth()->user()->reputation >= 200:
                                        $badge = 'Active Contributor';
                                        $badgeColor = '#28a745'; // Green
                                        $textColor = 'white';
                                        break;
                                    case auth()->user()->reputation >= 100:
                                        $badge = 'Researcher';
                                        $badgeColor = '#00008B'; // Dark Blue
                                        $textColor = 'white';
                                        break;
                                    case auth()->user()->reputation >= 50:
                                        $badge = 'Mentor';
                                        $badgeColor = '#800080'; // Purple
                                        $textColor = 'white';
                                        break;
                                    case auth()->user()->reputation >= 10:
                                        $badge = 'Collaborator';
                                        $badgeColor = '#FF8C00'; // Orange
                                        $textColor = 'white';
                                        break;
                                    case auth()->user()->reputation >= 0:
                                        $badge = 'Newcomer';
                                        $badgeColor = '#87CEEB'; // Light Blue
                                        $textColor = 'white';
                                        break;
                                    default:
                                        $badge = '';
                                }
                            @endphp

                            <!-- Badge Circle -->
                            @if ($badge)
                                <span
                                    class="absolute bottom-0 right-0 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold"
                                    style="background-color: {{ $badgeColor }}; color: {{ $textColor }}; transform: translate(25%, 25%); width: 20px; height: 20px;">
                                    {{ substr($badge, 0, 1) }} <!-- Display first letter of the badge -->
                                </span>
                            @endif
                        </a>
                    </div>
                    <div class="col position-relative" x-data="{
                        open: false,
                        handleKeydown(event) {
                            if (event.key == '@') {
                                this.open = true;
                            }
                            if (event.keyCode == 27) {
                                this.open = false;
                            }
                        }
                    }">
                        <div class="position-relative">
                            <textarea class="form-control pr-10" rows="2" name="comment_body" id="comment_body" wire:model="comment_body"
                                wire:model.live.debounce.500ms="search" @keydown="handleKeydown"
                                placeholder="Join the discussion and leave a comment!" wire:keydown.enter="createComment" maxlength='200'
                                minlength='2'>
                            </textarea>
                            <button type="submit"
                                class="position-absolute bottom-0 end-0 px-3 py-2  me-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                style="top: 50%; transform: translateY(-50%);">
                                <span class="d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-4">
                                        <path
                                            d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div x-show="open" @click.away="open = false" x-cloak class="card">
                            <ul class="mt-0 margin-auto card-header" style="list-style-type: none">
                                @php
                                    preg_match_all('/\@\w+/', $comment_body, $matches);
                                    if (count($matches[0]) > 1) {
                                        $matches[0] = [end($matches[0])]; // Keep only the last element in the array
                                    }
                                    $search = implode(' ', $matches[0]);
                                    $results = App\Models\User::where('name', 'like', '%' . substr($search, 1) . '%')
                                        ->orWhere('email', 'like', '%' . substr($search, 1) . '%')
                                        ->get();
                                @endphp

                                @foreach ($results as $result)
                                    <div class="random">
                                        <li>
                                            <a wire:click="addMentionedUser('{{ $result->email }}'),open = false"
                                                href="#" class="d-flex align-items-center">
                                                <img class="img-fluid rounded-circle me-3"
                                                    style="width: 2rem; height: 2rem;" src="/img/no-image.png"
                                                    alt="commenter img">
                                                <div class="pl-2 flex-grow-1">
                                                    <div class="text-gray-500 text-sm mb-1 dark-text-black-400">
                                                        <span
                                                            class="font-semibold text-black-600 dark-text-black">{{ $result->name }}</span>
                                                    </div>
                                                    <div class="text-xs text-blue-600 dark-text-blue-500">
                                                        {{ $result->email }}</div>
                                                </div>
                                            </a>
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                        @error('comment_body')
                            <p class="p text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <br>
                </form>
            @else
                <p>You need to log in to comment. <a href="/login">Click here.</a></p>

            @endauth {{-- (auth()->user()) END IF ^^^ --}}
            {{--  Comment with nested comments --}}
            <div class="row">
                <h3>Comments ({{ $post->comments->count() }})</h3>
            </div>

            {{-- ------------------------------------------------HELPFUL COMMENT----------------------------------------- --}}
            @foreach ($comments as $comment)
                @if ($post->id == $comment->post_id)
                    @if ($comment->is_helpful == 1)
                        @php
                            $flag = true;
                            preg_match_all(
                                '/(?:^|\s)@(\w+)|(?:^|\s)(\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b)/',
                                $comment->comment_body,
                                $matches,
                            );
                            $users = array_unique($matches[1]);
                            $matchedUsers = \App\Models\User::where(function ($query) use ($users) {
                                foreach ($users as $user) {
                                    $query->orWhere('name', 'like', "%$user%");
                                }
                            })->get();
                            // dd($users);
                        @endphp
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="text-center">
                                    This comment is marked as helpful by the author.
                                </h5>
                            </div>
                            <div class="card-body d-flex justify-content-center">
                                <div class="d-flex mb-4">
                                    <!-- Parent comment-->
                                    <a href="/profile/{{ $comment->author->id }}">
                                        <div class="flex-shrink-0"><img class="img-fluid rounded-circle"
                                                style="width: 3rem; height: 3rem;"
                                                src="{{ !empty($comment->author->photo) ? url($comment->author->photo) : url('/img/no-image.png') }}"
                                                alt="..."></div>
                                    </a>
                                    <div class="ms-3">
                                        <a href="/profile/{{ $comment->author->id }}">
                                            <div class="fw-bold">{{ $comment->author->name }}</div>
                                            <livewire:is-helpful :comment="$comment" />
                                        </a>

                                        <p class="text-bold">
                                            @foreach ($matchedUsers as $user)
                                                @php
                                                    $username = $user->name;
                                                    $profileLink = $user->profile_link;
                                                    $commentBody = str_replace(
                                                        '@' . $username,
                                                        '<a href="' . $profileLink . '">@' . $username . '</a>',
                                                        $comment->comment_body,
                                                    );
                                                @endphp
                                            @endforeach
                                            {!! $commentBody !!}
                                        </p>

                                        <!-- Child comment -->
                                        <div>
                                            <small>
                                                {{ $comment->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
            {{-- ------------------------------------------------REST OF COMMENTS----------------------------------------- --}}
            {{-- @php
                dd($flag);
            @endphp --}}
            @foreach ($comments as $comment)
                @if ($comment->post_id === $this->post->id)
                    @if ($comment->is_helpful == 0)
                        <div x-data="{ open: false }" class="d-flex flex-column">
                            <div class="flex-shrink-0 position-absolute">
                                <a href="/profile/{{ $comment->author->id }}">
                                    <div style="position: relative; display: inline-block;">
                                        <img class="img-fluid rounded-circle" style="width: 3rem; height: 3rem;"
                                            src="{{ !empty($comment->author->photo) ? url($comment->author->photo) : url('/img/no-image.png') }}"
                                            alt="{{ $comment->author->name }}">

                                        {{--  Badge based on reputation  --}}
                                        @php
                                            $badge = '';
                                            switch (true) {
                                                case $comment->author->reputation >= 1000:
                                                    $badge = 'Expert';
                                                    $badgeColor = '#FFD700';
                                                    $textColor = 'black';
                                                    break;
                                                case $comment->author->reputation >= 200:
                                                    $badge = 'Active Contributor';
                                                    $badgeColor = '#28a745';
                                                    $textColor = 'white';
                                                    break;
                                                case $comment->author->reputation >= 100:
                                                    $badge = 'Researcher';
                                                    $badgeColor = '#00008B';
                                                    $textColor = 'white';
                                                    break;
                                                case $comment->author->reputation >= 50:
                                                    $badge = 'Mentor';
                                                    $badgeColor = '#800080';
                                                    $textColor = 'white';
                                                    break;
                                                case $comment->author->reputation >= 10:
                                                    $badge = 'Collaborator';
                                                    $badgeColor = '#FF8C00';
                                                    $textColor = 'white';
                                                    break;
                                                case $comment->author->reputation >= 0:
                                                    $badge = 'Newcomer';
                                                    $badgeColor = '#87CEEB';
                                                    $textColor = 'white';
                                                    break;
                                                default:
                                                    $badge = '';
                                            }
                                        @endphp
                                        @if ($badge)
                                            <span
                                                style="position: absolute; bottom: -5px; right: -5px; background-color: {{ $badgeColor }}; color: {{ $textColor }}; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; border: 2px solid white;">
                                                {{ substr($badge, 0, 1) }} <!-- Display first letter of the badge -->
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <div class="ms-5 p-2 mt-0 d-flex flex-column w-100">
                                <div>
                                    <a href="/profile/{{ $comment->author->id }}">
                                        <div class="fw-bold">{{ $comment->author->name }}</div>
                                        @if ($flag == false)
                                            <livewire:is-helpful :comment="$comment" />
                                        @endif
                                    </a>
                                </div>
                                <div>
                                    <p class="mb-0">
                                        @php
                                            preg_match_all(
                                                '/(?:^|\s)@(\w+)|(?:^|\s)(\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b)/',
                                                $comment->comment_body,
                                                $matches,
                                            );
                                            $users = array_unique($matches[1]);
                                            $matchedUsers = \App\Models\User::where(function ($query) use ($users) {
                                                foreach ($users as $user) {
                                                    $query
                                                        ->orWhere('name', 'like', "%$user%")
                                                        ->orWhere('email', 'like', "%$user%");
                                                }
                                            })->get();
                                            // dd($matchedUsers);
                                            $modifiedCommentBody = $comment->comment_body;
                                            //    dd($users);
                                            $pastUser = '';
                                            $replacementCounts = [];

                                            foreach ($matchedUsers as $user) {
                                                $username = $user->name;

                                                if (!isset($replacementCounts[$username])) {
                                                    $replacementCounts[$username] = 0;
                                                }

                                                $profileLink = route('profile', ['id' => $user->id]);
                                                $uniqueUsername = $username . $replacementCounts[$username];

                                                $modifiedCommentBody = preg_replace(
                                                    '/@' . preg_quote($username, '/') . '\b/',
                                                    "<a href='$profileLink'>@" . $username . '</a>',
                                                    $modifiedCommentBody,
                                                    1,
                                                    $count,
                                                );

                                                $replacementCounts[$username] += $count;
                                            }
                                            // dd($comment->post_id);
                                        @endphp

                                        {!! $modifiedCommentBody !!}

                                    </p>
                                </div>
                                <div>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <div x-on:click="open = !open">
                                    <i class="fa fa-arrow-right ms-3 me-2"></i>
                                    <span>
                                        <small>
                                            <a href="#">
                                                Replies ({{ $comment->reply->count() }})
                                            </a>
                                        </small>
                                    </span>
                                </div>
                            </div>
                            <!-- Replies section -->
                            <div x-show="open" x-cloak class="ms-2 w-100">
                                <livewire:reply-section :key="$comment->id" :$comment />
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        <script>
            // Watch for changes in the query and remove the first slash
            $watch('query', (value) => {
                if (value.startsWith('/')) {
                    query = value.substring(1);
                }
            });
        </script>
</section>
