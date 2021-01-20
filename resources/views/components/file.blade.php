<div
    class="p-2"
    x-data="{ isShowing: false, isDeleting: false }"
    x-on:mouseover="isShowing = true"
    x-on:mouseout="isShowing = false"
>
    <div
        class="w-full text-center"
        x-show="isDeleting"
        x-cloak
    >
        <span>Are you sure you want to delete <strong>{{ $file->name }}</strong>?</span>
        <div class="flex justify-center space-x-8">
            <form wire:submit.prevent="delete({{ $file }})" class="">
                <button type="submit" x-on:click="isDeleting = false" class="text-red-700">delete</button>
            </form>

            <button type="button" x-on:click="isDeleting = false" class="text-blue-700">cancel</button>
        </div>
    </div>

    <div class="flex justify-between items-center w-full" x-show="!isDeleting">
        <div class="flex space-x-4">
            <div class="flex flex-col">
                <a
                    href="{{ route('download', [$file->uuid, $file->name]) }}"
                    class="text-blue-700 underline"
                    download
                >
                    {{ $file->name }}
                </a>
                <span class="text-xs text-gray-600" title="{{ $file->created_at }}">
                    Uploaded: {{ $file->created_at->diffForHumans() }}
                </span>
            </div>
            <button
                type="button"
                class="text-red-700 px-2"
                title="Delete file"
                x-show="isShowing"
                x-on:click="isDeleting = true"
                x-cloak
            >
                delete
            </button>

            <button
                type="button"
                class="text-blue-700 px-2"
                title="Copy file URL"
                x-show="isShowing"
                x-on:click="copy(`{{ route('download', [$file->uuid, $file->name]) }}`, `{{ $file->uuid }}`)"
                x-cloak
            >
                <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path d="M4.5 6.5L1.328 9.672a2.828 2.828 0 104 4L8.5 10.5m2-2l3.172-3.172a2.829 2.829 0 00-4-4L6.5 4.5m-2 6l6-6" stroke="currentColor"></path></svg>
            </button>
        </div>

        <div id="clipMsg-{{ $file->uuid }}" class="hidden font-bold"></div>

        <span>{{ formatBytes($file->size) }}</span>
    </div>

</div>
