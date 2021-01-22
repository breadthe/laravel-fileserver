@if (session()->has('message'))
    <div
        id="alert"
        class="alert alert-{{ $type }} text-center py-2"
        x-init="isShowing = true; setTimeout(() => isShowing = false, 2000)"
        x-data="{ isShowing: false }"
        x-show="isShowing"
        x-cloak
    >
        {{ session('message') }}
    </div>
@endif

@if (session()->has('error'))
    <div
        id="alert"
        class="alert alert-error flex items-center justify-between text-center py-2"
        x-init="isShowing = true"
        x-data="{ isShowing: false }"
        x-show="isShowing"
        x-cloak
    >
        <span class="flex-1">
            {{ session('error') }}
        </span>
        <button
            type="button"
            class="p-2"
            x-on:click="isShowing = false"
        >
            <svg viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" width="24" height="24"><path d="M4.5 4.5l6 6m-6 0l6-6" stroke="currentColor"></path></svg>
        </button>
    </div>
@endif
