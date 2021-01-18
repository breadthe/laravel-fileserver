<div
    x-data="{ isUploading: false, progress: 0, isUploaded: false }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false; isUploaded = true;"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <!-- File Input -->
    <form wire:submit.prevent="save" class="p-8">
        <input type="file" wire:model="file">

        @error('file') <span class="error text-red-700">{{ $message }}</span> @enderror

        <button
            type="submit"
            class="px-4 py-2 bg-blue-700 text-white"
            x-show="isUploaded"
            x-cloak
        >Save file</button>
    </form>

    <!-- Progress Bar -->
    <div x-show="isUploading" x-cloak class="w-full h-2">
        <progress max="100" x-bind:value="progress" class="w-full"></progress>
    </div>

    <!-- File stored -->
    <div>
        {{ $uploadedFileInfo }}
    </div>
</div>

