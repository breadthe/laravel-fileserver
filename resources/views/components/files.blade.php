<div class="divide-y">
    @forelse($files as $file)
        <x-file :file="$file"/>
    @empty
        <div class="flex justify-between">
            <span>No files yet</span>
            <a href="{{ route('upload') }}" title="Upload files" class="text-blue-700 underline">Upload</a>
        </div>
    @endforelse
</div>
