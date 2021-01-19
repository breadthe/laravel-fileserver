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
        <div class="flex">
            <div class="flex flex-col">
                <a
                    href="{{ route('download', $file->uuid) }}"
                    class="text-blue-700 underline"
                >
                    {{ $file->name }}
                </a>
                <span class="text-xs text-gray-600">Uploaded: {{ $file->created_at }}</span>
            </div>
            <button
                type="button"
                class="text-red-700 px-2 ml-4"
                title="Delete file"
                x-show="isShowing"
                x-on:click="isDeleting = true"
                x-cloak
            >
                delete
            </button>
        </div>

        <span>{{ formatBytes($file->size) }}</span>
    </div>

</div>
