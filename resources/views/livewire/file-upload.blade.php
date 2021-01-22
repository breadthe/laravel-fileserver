<div
    x-data="{ isUploading: false, progress: 0, isUploaded: false }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false; isUploaded = true;"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
    class="border-b"
>
    <x-alert type="success" />

    <!-- File Input -->
    <form wire:submit.prevent="save" class="flex justify-between items-center p-8">
        <input type="file" wire:model="file" id="{{ $inputId }}">

        @error('file') <span class="error text-red-700">{{ $message }}</span> @enderror

        @if($file)
            <div class="space-x-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    wire:loading
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-700 text-white"
                    x-cloak
                    wire:loading.class.remove="bg-blue-700"
                    wire:loading.class="bg-blue-200 cursor-not-allowed"
                    wire:loading.attr="disabled"
                >Save file</button>

                <label class="space-x-1">
                    <select wire:model="storageDisk">
                        <option value="local">local</option>
                        <option value="b2">Backblaze B2</option>
                    </select>
                </label>

                <label class="space-x-1">
                    <input type="checkbox" wire:model="isPublic" />
                    <span>Public</span>
                </label>
            </div>
        @endif
    </form>

    <!-- Progress Bar -->
    <div x-show="isUploading" x-cloak class="w-full h-2">
        <progress max="100" x-bind:value="progress" class="w-full"></progress>
    </div>
</div>

