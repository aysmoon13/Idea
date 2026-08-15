@props(['name', 'title'])


<div 
    x-data="{show: false, name: @js($name)}"
    x-show="show"
    @open-modal.window="if($event.detail === name) show = true;"
    @keydown.escape.window ="show = false"
    @close-modal.window="show = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs"
    x-transition:enter="ease-out duration-250"
    x-transition:enter-start="opacity-0 -translate-y-24 -translate-x-24"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-250"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 -translate-y-4"
    style="display:none"
    role="dialog"
    aria-modal="true"
    aria-label="modal-{{ $name }}-title"
    :aria-hidden="!show"
    tabindex="-1"
        
    >
    <x-card @click.away="show = false" class="shadow-xl max-w-2xl w-full max-h-[80dvh] overflow-auto">
        <div class="flex justify-between items-center">
            <h2 id="modal-{{ $name }}-title" class="text-2xl font-bold">{{ $title }}</h2>

            <button @click="show = false; restoreFocus();" aria-label="Close Modal">
                <x-icons.close />
            </button>
        </div>
        <div class="mt-4">
            {{ $slot }}
        </div>
    </x-card>
</div>