{{-- NOTIF BUTTON WHEN NOTIF COUNT > 0 START --}}
<div class="btn-group mt-3">
    <button type="button"
        class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-bell"></i>
        @if (Auth::user()?->unreadNotifications->count())
            <span
                class="position-absolute top-0 end-0 badge bg-danger small rounded-pill">{{ Auth::user()->unreadNotifications->count() }}</span>
        @endif
        <style>
            .btn-success.dropdown-toggle::after {
                content: none;
            }

            ,
        </style>
    </button>
    @auth
        @if (Auth::user()?->unreadNotifications->count())
            <ul class="dropdown-menu mt-0 margin-auto dropdown-menu-end"
                style="width: max-content; border-radius: 10px; border: 4px solid #b7bbb9; margin-left: 20%;">
                @foreach (Auth::user()?->unreadNotifications as $notification)
                    @php
                        $notificationType = $notification->type;
                    @endphp
                    {{-- ------------------ NOTIF FOR COMMENTS ---------------------- --}}
                    @if ($notificationType === 'App\Notifications\CommentNotif')
                        <li class="divide-y divide-green-100 dark:divide-green-400">
                            <a wire:click="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['link'] }}"
                                class="d-flex p-2 hover-bg-green-100 dark-hover-bg-green-400 align-items-center">
                                <img class="img-fluid rounded-circle me-3" style="width: 2rem; height: 2rem;"
                                    src="{{ !empty($notification->data['photo']) ? url($notification->data['photo']) : url('/img/no-image.png') }}"
                                    alt="commenter img">
                                <div class="pl-2 flex-grow-1">
                                    <div class="text-gray-500 text-sm mb-1 dark-text-black-400">
                                        <span class="font-semibold text-black-600 dark-text-black">
                                            <strong>{{ $notification->data['user'] }}</strong>
                                        </span>
                                        commented on your post. <span class="font-medium text-blue-500"
                                            href=""></span>
                                    </div>
                                    <div class="text-xs text-blue-600 dark-text-blue-500">
                                        {{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                    @endif
                    {{-- ------------------ NOTIF FOR REPLIES ---------------------- --}}
                    @if ($notificationType === 'App\Notifications\ReplyNotif')
                        <li class="divide-y divide-green-100 dark:divide-green-400">
                            <a wire:click="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['link'] }}"
                                class="d-flex  p-2 hover-bg-green-100 dark-hover-bg-green-400 align-items-center">
                                <img class="img-fluid rounded-circle me-3" style="width: 2rem; height: 2rem;"
                                    src="{{ !empty($notification->data['photo']) ? url($notification->data['photo']) : url('/img/no-image.png') }}"
                                    alt="commenter img">
                                <div class="pl-2 flex-grow-1">
                                    <div class="text-gray-500 text-sm mb-1 dark-text-black-400">
                                        <span class="font-semibold text-black-600 dark-text-black">
                                            <strong>{{ $notification->data['user'] }}</strong>
                                        </span>
                                        replied to your comment. <span class="font-medium text-blue-500"
                                            href=""></span>
                                    </div>
                                    <div class="text-xs text-blue-600 dark-text-blue-500">
                                        {{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                    @endif
                    {{-- ------------------ NOTIF FOR COMMENT MENTIONS ---------------------- --}}
                    @if ($notificationType === 'App\Notifications\MentionNotif')
                        <li class="divide-y divide-green-100 dark:divide-green-400">
                            <a wire:click="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['link'] }}"
                                class="d-flex p-2 hover-bg-green-100 dark-hover-bg-green-400 align-items-center">
                                <img class="img-fluid rounded-circle me-3" style="width: 2rem; height: 2rem;"
                                    src="{{ !empty($notification->data['photo']) ? url($notification->data['photo']) : url('/img/no-image.png') }}"
                                    alt="commenter img">
                                <div class="pl-2 flex-grow-1">
                                    <div class="text-gray-500 text-sm mb-1 dark-text-black-400">
                                        <span class="font-semibold text-black-600 dark-text-black">
                                            <strong>{{ $notification->data['user'] }}</strong>
                                        </span>
                                        mentioned you to their comment/reply. <span class="font-medium text-blue-500"
                                            href=""></span>
                                    </div>
                                    <div class="text-xs text-blue-600 dark-text-blue-500">
                                        {{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                    @endif
                    {{-- ------------------ NOTIF FOR REPLY MENTIONS ---------------------- --}}
                    @if ($notificationType === 'App\Notifications\ReplyMention')
                        <li class="divide-y divide-green-100 dark:divide-green-400">
                            <a wire:click="markAsRead('{{ $notification->id }}')" href="{{ $notification->data['link'] }}"
                                class="d-flex p-2 hover-bg-green-100 dark-hover-bg-green-400 align-items-center">
                                <img class="img-fluid rounded-circle me-3" style="width: 2rem; height: 2rem;"
                                    src="{{ !empty($notification->data['photo']) ? url($notification->data['photo']) : url('/img/no-image.png') }}"
                                    alt="commenter img">
                                <div class="pl-2 flex-grow-1">
                                    <div class="text-gray-500 text-sm mb-1 dark-text-black-400">
                                        <span class="font-semibold text-black-600 dark-text-black">
                                            <strong>{{ $notification->data['user'] }}</strong>
                                        </span>
                                        mentioned you to their comment/reply. <span class="font-medium text-blue-500"
                                            href=""></span>
                                    </div>
                                    <div class="text-xs text-blue-600 dark-text-blue-500">
                                        {{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @else
            <ul class="dropdown-menu mt-0 margin-auto dropdown-menu-end">
                <li class="divide-y divide-green-100 dark:divide-green-400">
                    <div class="pl-2 flex-grow-1 pe-1">
                        <div class="text-gray-900 text-sm mb-1 dark-text-black-900 ms-4 ">
                            <span class="font-bold text-black-600 dark-text-black ">No notifications yet.</span>
                        </div>
                    </div>
                    </a>
                </li>
            </ul>
        @endif
    @endauth
</div>


{{-- NOTIF BUTTON WHEN NOTIF COUNT > 0 END --}}
