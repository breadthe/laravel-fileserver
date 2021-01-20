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
