<x-layout>
    <div >
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2"> Capture your thoughts. Make a plan.</p>

            <x-card
                is="button"
                x-data
                @click="$dispatch('open-modal', 'create-idea')"
                type="button"
                data-test="create-idea-button"
                class="mt-10 cursor-pointer h-32 w-full text-left">
            <p>whats the idea</p>
        </x-card>
        </header>

        <div>
            <a href="/ideas" class="btn {{ request()->has('status')?'btn-outlined' : '' }}">All</a>
            @foreach (App\IdeaStatus::cases() as $status)
                    <a 
                        href="/ideas?status={{ $status->value }}" 
                        class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}"
                        >
                        
                        {{ $status->label() }} 
                        <span 
                            class="bg-primary text-primary-foreground px-2 py-1 rounded-full text-xs">
                            {{ $statusCounts->get($status->value) }}
                        </span>
                    </a>
            @endforeach
            <input type="hidden" name="status" id="status" x-bind:value="status" />
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)

                    <x-card href="{{ route('idea.show', $idea) }}">
                        @if ( $idea->image_path )
                            <div class="mb-4 -mx-4 -mt-4 overflow-hidden rounded-t-lg">
                                <img src="{{ asset('storage/'.$idea->image_path) }}" alt="Idea Image" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        @endif                        
                        <h3 class="text-foreground text-lg">{{$idea->title}}</h3>

                        <div class="mt-1">
                            <x-idea.status-label status="{{ $idea->status }}">
                                {{ $idea->status->label() }}
                            </x-idea.status-label>
                        </div>

                        <div class="mt-5 line-clamp-3">{{$idea->description}}</div>
                        <div class="mt-4 ">{{$idea->created_at->diffForHumans()}}</div>


                    </x-card>
                    
                    
                @empty
                <x-card>
                    <h2 class="text-4xl font-bold  ">No ideas at this time</h2>
                </x-card>
                    
                @endforelse
            </div>
        </div>
        <!-- modal; -->
        <x-idea.modal />

    </div>
</x-layout>
