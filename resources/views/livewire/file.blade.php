<div
    class="p-2"
    x-data="{ isShowing: false, isDeleting: false }"
    x-on:mouseover="isShowing = true"
    x-on:mouseout="isShowing = false"
>
    {{-- Confirm deletion --}}
    <div
        class="w-full text-center"
        x-show="isDeleting"
        x-cloak
    >
        <span>Are you sure you want to delete <strong>{{ $file->name }}</strong>?</span>
        <div class="flex justify-center space-x-8">
            <form wire:submit.prevent="$emit('deleteFile', {{ $file }})" class="">
                <button type="submit" x-on:click="isDeleting = false" class="text-red-700">delete</button>
            </form>

            <button type="button" x-on:click="isDeleting = false" class="text-blue-700">cancel</button>
        </div>
    </div>

    <div class="flex justify-between items-center w-full" x-show="!isDeleting" x-cloak>
        <div class="flex items-center space-x-8">
            <div class="flex flex-col">
                <div class="flex items-center space-x-1">
                    <a
                        href="{{ route('download', $file->uuid) }}"
                        class="text-blue-700 underline"
                        download
                    >
                        {{ $file->name }}
                    </a>
                    <button
                        type="button"
                        class="text-xs rounded-full px-1 {{ $file->public ? 'text-gray-600': 'text-white bg-blue-700' }}"
                        title="Click to toggle file visibility"
                        wire:click="toggleFileVisibility()"
                    >
                        {{ $file->public ? 'public': 'private' }}
                    </button>
                </div>

                <div class="flex items-center divide-x divide-gray-300 -mx-2">
                    <span class="px-2 text-xs font-black text-{{ $file->disk }}" title="Storage disk - {{ $file->disk }}">
                        {{ $file->disk }}
                    </span>

                    <span class="px-2 text-xs text-gray-600" title="{{ $file->created_at }}">
                        Uploaded: {{ $file->created_at->diffForHumans() }}
                    </span>

                    @if($file->downloads_count)
                        <span class="px-2 text-xs text-gray-600" title="How many times the file was downloaded">
                            Downloads: <span
                                class="rounded-full text-xs text-blue-700 font-bold">
                                {{ $file->downloads_count }}
                            </span>
                        </span>
                    @endif
                </div>

            </div>

            <a
                href="{{ route('download', $file->uuid) }}"
                class="text-blue-700 underline"
                title="{{ $file->name }}"
                download
                x-show="isShowing"
            >
                <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                    <path d="M7.5 10.5l-3.25-3m3.25 3l3-3m-3 3V1m6 6v6.5h-12V7" stroke="currentColor"></path>
                </svg>
            </a>

            <button
                type="button"
                class="text-blue-700"
                title="Copy file URL"
                x-show="isShowing"
                x-on:click="copy(`{{ route('download', $file->uuid) }}`, `{{ $file->uuid }}`)"
                x-cloak
            >
                <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                    <path
                        d="M4.5 6.5L1.328 9.672a2.828 2.828 0 104 4L8.5 10.5m2-2l3.172-3.172a2.829 2.829 0 00-4-4L6.5 4.5m-2 6l6-6"
                        stroke="currentColor"></path>
                </svg>
            </button>

            <button
                type="button"
                class="text-red-700"
                title="Delete file"
                x-show="isShowing"
                x-on:click="isDeleting = true"
                x-cloak
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <div id="clipMsg-{{ $file->uuid }}" class="hidden font-bold"></div>

        <span>{{ formatBytes($file->size) }}</span>
    </div>

</div>
