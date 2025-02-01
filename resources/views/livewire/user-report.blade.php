<div x-data="{ open: false }">
    <!-- Report Button -->
    <button type="button" @click="open = true"
    class="focus:outline-none bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
    <span class="text-white">
        <i class="fa fa-flag"></i>
    </span>
</button>


    <!-- MODAL -->
    <div x-show="open" x-cloak @keydown.escape.window="open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="z-index: 1000;">
        <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-md">
            <!-- Modal Header -->
            <div class="relative flex justify-between items-center border-b pb-4">
                <h1 class="text-lg font-semibold text-center w-full">REPORT USER</h1>
                <button @click="open = false"
                    class="absolute right-0 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                    X
                </button>
            </div>

            <!-- Modal Body / Form -->
            <form wire:submit.prevent="reportPost" class="mt-4" @submit="open = false">
                @csrf
                <div class="mb-4">
                    <input type="text" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        name="reason" id="reason" wire:model="reason"
                        placeholder="Please state the reason for the report." required>
                    @error('reason')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button (at the bottom) -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-3 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                        Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
