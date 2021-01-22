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
    <form wire:submit.prevent="save" class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-4 space-y-4 sm:space-y-0">
        <div>
            <input type="file" wire:model="file" id="{{ $inputId }}">

            @error('file') <span class="error text-red-700">{{ $message }}</span> @enderror
        </div>

        @if($file)
            <div class="flex-1 flex flex-col-reverse sm:flex-row items-stretch justify-end sm:items-center sm:space-x-4">
                <div class="flex items-center justify-around sm:space-y-0 space-y-4">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="animate-spin h-8 w-8 text-gray-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        wire:loading
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <button
                        type="button"
                        class="px-4 py-2 text-red-700 underline"
                        wire:click="cancel"
                    >Cancel</button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-700 text-white border border-blue-700"
                        x-cloak
                        wire:loading.class.remove="bg-blue-700"
                        wire:loading.class="bg-blue-200 cursor-not-allowed"
                        wire:loading.attr="disabled"
                    >Save file</button>
                </div>

                <div class="flex flex-row sm:flex-col justify-between">
                    <label class="space-x-1">
                        <select wire:model="storageDisk">
                            <option value="local">local</option>
                            <option value="b2">Backblaze B2</option>
                        </select>
                    </label>

                    <label class="space-x-1 py-2">
                        <input type="checkbox" wire:model="isPublic" />
                        <span>Public</span>
                    </label>
                </div>
            </div>
        @endif
    </form>

    <!-- Progress Bar -->
    <div x-show="isUploading" x-cloak class="w-full h-2">
        <progress max="100" x-bind:value="progress" class="w-full"></progress>
    </div>
</div>

