<button wire:click="toggleUpvote()" type="button"
    class="btn {{(Auth::user()?->hasUpvoted($this->post)) ? ' focus:out bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800' : 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm py-2.5 mb-2 dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700'}} d-flex align-items-center gap-2"
    data-bs-toggle="button" aria-pressed="false">

    <!-- SVG Icon -->
    <span class="{{(Auth::user()?->hasUpvoted($this->post)) ? 'text-white' : 'text-green-700'}}">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
            <path fill-rule="evenodd" d="M11.47 2.47a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06l-6.22-6.22V21a.75.75 0 0 1-1.5 0V4.81l-6.22 6.22a.75.75 0 1 1-1.06-1.06l7.5-7.5Z" clip-rule="evenodd" />
        </svg>
    </span>

    <!-- Like Count -->
    <span class="font-weight-bold">{{$this->post->likes()->count()}}</span>
</button>
