<div>
    @if (session()->has('message'))
        <div class="alert alert-success bg-green-100 text-green-900 text-center py-2">
            {{ session('message') }}
        </div>
    @endif

    <livewire:file-upload />

    <div id="clipboardMessage" class="hidden p-2 text-center font-bold border-b"></div>

    <div class="divide-y">
        @forelse($files as $file)
            <x-file :file="$file" :key="$file->id"/>
        @empty
            <div class="flex justify-between p-8">
                <span>No files yet</span>
                <a href="{{ route('upload') }}" title="Upload files" class="text-blue-700 underline">Upload</a>
            </div>
        @endforelse
    </div>
</div>
