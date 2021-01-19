<div
    x-data="{ isUploading: false, progress: 0, isUploaded: false }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false; isUploaded = true;"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
    class="border-b"
>
    @if (session()->has('message'))
        <div class="alert alert-info bg-blue-100 text-blue-900 text-center py-2">
            {{ session('message') }}
        </div>
    @endif

    <!-- File Input -->
    <form wire:submit.prevent="save" class="p-8">
        <input type="file" wire:model="file" id="{{ $inputId }}">

        @error('file') <span class="error text-red-700">{{ $message }}</span> @enderror

        @if($file)
            <button
                type="submit"
                class="px-4 py-2 bg-blue-700 text-white"
                x-cloak
            >Save file</button>
        @endif
    </form>

    <!-- Progress Bar -->
    <div x-show="isUploading" x-cloak class="w-full h-2">
        <progress max="100" x-bind:value="progress" class="w-full"></progress>
    </div>
</div>

