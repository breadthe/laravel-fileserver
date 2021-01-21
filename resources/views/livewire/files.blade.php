<div>
    <x-alert type="info" />

    <livewire:file-upload />

    <div class="divide-y">
        @forelse($files as $file)
            <livewire:file :file="$file" :key="$file->id"/>
        @empty
            <div class="text-center p-8">
                <span>No files yet</span>
            </div>
        @endforelse
    </div>
</div>

<script>
    async function copy(text, uuid) {
        if (!navigator.clipboard) {
            return;
        }

        try {
            // copy the URL to the clipboard
            await navigator.clipboard.writeText(text);

            // show Copied! message near its file
            const clipMsg = document.querySelector(`#clipMsg-${uuid}`);
            clipMsg.innerText = 'Copied!'
            clipMsg.classList.remove("hidden");
            clipMsg.classList.add("block");

            // hide the message after x ms
            setTimeout(() => {
                clipMsg.classList.remove("flex");
                clipMsg.classList.add("hidden");
            }, 2000);
        } catch (error) {
            console.error("copy failed", error);
        }
    }
</script>
