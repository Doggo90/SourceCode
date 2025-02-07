<section>
    <div class="bg-light mt-2 ms-4" style="flex-grow: 1;">
        <!-- Comment form-->
        @auth
            <form wire:submit="createReply" class="row g-3 mb-4" action="">
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
                                case (auth()->user()->reputation >= 500):
                                    $badge = 'Expert';
                                    $badgeColor = '#FFD700'; // Gold
                                    $textColor = 'black';
                                    break;
                                case (auth()->user()->reputation >= 200):
                                    $badge = 'Active Contributor';
                                    $badgeColor = '#28a745'; // Green
                                    $textColor = 'white';
                                    break;
                                case (auth()->user()->reputation >= 100):
                                    $badge = 'Researcher';
                                    $badgeColor = '#00008B'; // Dark Blue
                                    $textColor = 'white';
                                    break;
                                case (auth()->user()->reputation >= 50):
                                    $badge = 'Mentor';
                                    $badgeColor = '#800080'; // Purple
                                    $textColor = 'white';
                                    break;
                                case (auth()->user()->reputation >= 10):
                                    $badge = 'Collaborator';
                                    $badgeColor = '#FF8C00'; // Orange
                                    $textColor = 'white';
                                    break;
                                case (auth()->user()->reputation >= 0):
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
                        <span class="absolute bottom-0 right-0 rounded-full border-2 border-white flex items-center justify-center text-xs font-bold"
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
                    <form wire:submit="createReply">
                        @csrf
                        <textarea class="form-control" rows="1" name="body" id="body" wire:model.live="body"
                            wire:model.live.debounce.500ms="search" @keydown.="handleKeydown"
                            placeholder="Join the discussion and leave a reply!" wire:keydown.enter="createReply" maxlength='200'
                            minlength='1'>
                        </textarea>
                        <div x-show="open" @click.away="open = false" x-cloak class="card">
                            <ul class="mt-0 margin-auto card-header" style="list-style-type: none">
                                @php
                                    preg_match_all('/\@\w+/', $body, $matches);
                                    if (count($matches[0]) > 1) {
                                        $matches[0] = [end($matches[0])]; // Keep only the last element in the array
                                    }
                                    $search = implode(' ', $matches[0]);
                                    $results = App\Models\User::where('name', 'like', '%' . substr($search, 1) . '%')
                                        ->orWhere('email', 'like', '%' . substr($search, 1) . '%')
                                        ->get();
                                @endphp

                                {{-- <h1>{{ substr($search, 1) }}</h1> --}}
                                @foreach ($results as $result)
                                    {{-- <h1>{{ $search }}</h1> --}}
                                    <div class="random">
                                        <li>
                                            <a wire:click="addMentionedUser('{{ $result->email }}'),open = false"
                                                href="#" class="d-flex align-items-center">
                                                <img class="img-fluid rounded-circle me-3"
                                                    style="width: 2rem; height: 2rem;"
                                                    src="{{ !empty($result->photo) ? url($result->photo) : url('/img/no-image.png') }}"
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
                        <button type="submit" class="py-2 px-2 position-absolute bottom-0 end-0 mb-2 me-4 justify-items-center focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm  dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                              </svg>
                              </span>
                        </button>
                    </form>
                    @error('body')
                        <p class="p text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </form>
        @else
            <p>You need to log in to reply. <a href="/login">Click here.</a></p>

        @endauth

        {{-- REPLIES FOREACH LOOPS --}}
        @if ($replyCount > 0)
            @foreach ($replies as $reply)
                @if ($reply->comment->id === $this->comment->id)
                    {{-- @if ($reply->pivot->reply_id === $reply->id) --}}
                    <div class="d-flex align-items-start">
                        <div class="position-absolute" style="width: 3rem;">
                            <a href="/profile/{{ $reply->author->id }}">
                                <div style="position: relative; display: inline-block;">
                                    <img class="img-fluid rounded-circle" style="width: 3rem; height: 3rem;"
                                        src="{{ !empty($reply->author->photo) ? url($reply->author->photo) : url('/img/no-image.png') }}"
                                        alt="{{ $reply->author->name }}">

                                    {{--  Badge based on reputation  --}}
                                    @php
                                        $badge = '';
                                        switch (true) {
                                            case ($reply->author->reputation >= 1000):
                                                $badge = 'Expert';
                                                $badgeColor = '#FFD700';
                                                $textColor = 'black';
                                                break;
                                            case ($reply->author->reputation >= 200):
                                                $badge = 'Active Contributor';
                                                $badgeColor = '#28a745';
                                                $textColor = 'white';
                                                break;
                                            case ($reply->author->reputation >= 100):
                                                $badge = 'Researcher';
                                                $badgeColor = '#00008B';
                                                $textColor = 'white';
                                                break;
                                            case ($reply->author->reputation >= 50):
                                                $badge = 'Mentor';
                                                $badgeColor = '#800080';
                                                $textColor = 'white';
                                                break;
                                            case ($reply->author->reputation >= 10):
                                                $badge = 'Collaborator';
                                                $badgeColor = '#FF8C00';
                                                $textColor = 'white';
                                                break;
                                            case ($reply->author->reputation >= 0):
                                                $badge = 'Newcomer';
                                                $badgeColor = '#87CEEB';
                                                $textColor = 'white';
                                                break;
                                            default:
                                                $badge = '';
                                        }
                                    @endphp
                                    @if ($badge)
                                        <span style="position: absolute; bottom: -5px; right: -5px; background-color: {{ $badgeColor }}; color: {{ $textColor }}; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; border: 2px solid white;">
                                            {{ substr($badge, 0, 1) }} <!-- Display first letter of the badge -->
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <div class="ms-5 p-2">
                            <a href="/profile/{{ $reply->author->id }}">
                                <div class="fw-bold">{{ $reply->author->name }}</div>
                            </a>
                            <p class="mb-0">
                                @php
                                    // preg_match_all(
                                    //     '/(?:^|\s)@(\w+)|(?:^|\s)(\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b)/',
                                    //     $reply->body,
                                    //     $matches,
                                    // );
                                    // $users = array_unique($matches[1]);
                                    // $matchedUsers = \App\Models\User::where(function ($query) use ($users) {
                                    //     foreach ($users as $user) {
                                    //         $query
                                    //             ->orWhere('name', 'like', "%$user%")
                                    //             ->orWhere('email', 'like', "%$user%");
                                    //     }
                                    // })->get();
                                    $modifiedCommentBody = $reply->body;
                                    $pastUser = '';
                                    $replacementCounts = [];
                                    $mentionedUsers = $reply->mentionsRelationship()->get();

                                    foreach ($mentionedUsers as $user) {
                                        $username = $user->name;

                                        if (!isset($replacementCounts[$username])) {
                                            $replacementCounts[$username] = 0;
                                        }

                                        $profileLink = route('profile', ['id' => $user->id]);
                                        $uniqueUsername = $username . $replacementCounts[$username];

                                        $modifiedCommentBody = preg_replace(
                                            '/@' . preg_quote($username, '/') . '\b/',
                                            "<a href='$profileLink'>@$uniqueUsername</a>",
                                            $modifiedCommentBody,
                                            1,
                                            $count,
                                        );

                                        // Update the replacement count for this username
                                        $replacementCounts[$username] += $count;
                                    }
                                @endphp
                                {{-- @php
                                    $modifiedCommentBody = $reply->body;
                                    $pastUser = '';
                                    // $reply = Reply::find($reply->id);
                                    $mentionedUsers = $reply->mentionsRelationship()->get();
                                    $profileLink = '';
                                @endphp

                                @foreach ($mentionedUsers as $key => $user)
                                    @php
                                        $username = $user->name;
                                        $uID = $user->id;
                                        $profileLink = route('profile', ['id' => $uID]);
                                        // $profileLink = route('profile', ['id' => $uID]);
                                        // $username = App\Models\User::where('email', $user->email)->value('name');
                                        // $uID = App\Models\User::where('email', $user->email)->value('id');

                                        // $profileLink = route('profile', ['id' => $uID]);
                                        if (isset($mentionedUsers[$key + 1])) {
                                            $nextUser = $mentionedUsers[$key + 1];

                                            if ( $username === $nextUser->name && $uID !== $nextUser->id) {
                                                $counter = 0;
                                                $username = $username . '(' . $counter . ')';
                                                dd($username);
                                                $counter ++;
                                                // $profileLink = route('profile', ['id' => $user->id]);
                                            }
                                        }
                                        // Replace all occurrences of @username with the link
                                        $modifiedCommentBody = preg_replace(
                                            '/@' . preg_quote($username, '/') . '/',
                                            '<a href="' . $profileLink . '">@' . $username . '</a>',
                                            $modifiedCommentBody,
                                        );
                                    @endphp
                                    <h1>{{ $modifiedCommentBody }}</h1>
                                @endforeach --}}
                                {!! $modifiedCommentBody !!}
                            </p>
                            <div class="mt-0">
                                <small>
                                    {{ $reply->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                @endif
            @endforeach
        @else
            <p>No replies yet.</p>
        @endif
    </div>
</section>
