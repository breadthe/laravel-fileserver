<div class="flex justify-between items-center w-full p-2">
    <div class="flex flex-col">
        <a
            href="{{ route('download', $file->uuid) }}"
            class="text-blue-700 underline"
        >
            {{ $file->name }}
        </a>
        <span class="text-xs text-gray-600">Uploaded: {{ $file->created_at }}</span>
    </div>

    <span>{{ formatBytes($file->size) }}</span>
</div>
