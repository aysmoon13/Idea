<x-layout>
    <div class="py-8 max-w-4xl mx-auto ">

        <div class="flex justify-between items-center">
            <a href="{{route('idea.index')}}" class="flex items-center gap-2 text-sm font-medium">
                <x-icons.arrow-back />
                Back to Ideas
            </a>

            
            <div class="gap-x-3 flex items-center">
                <button 
                    x-data
                    class="btn btn-outlined"
                    data-test="edit-idea-button"
                    @click="$dispatch('open-modal', 'edit-idea')"
                    >
                    <x-icons.external />
                    Edit
                </button>

                <form method="POST" action="{{ route('idea.destroy',$idea)}}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outlined text-red-500">
                        Delete
                    </button>
                </form>

                
            </div>

        </div>

        <div class="mt-8 space-y-6">
            @if ( $idea->image_path )
            <div class="overflow-hidden rounded-lg">
                <img src="{{ asset('storage/'.$idea->image_path) }}" alt="Idea Image" class="w-full h-98 object-cover rounded-lg">
            </div>
            @endif
            <h1 class="font-bold text-4xl">{{$idea->title}}</h1>

            <div class="flex items-center gap-2">
                <x-idea.status-label :status="$idea->status->value">
                    {{ $idea->status->label() }}
                </x-idea.status-label>
                <p class="text-xs text-muted-foreground">{{ $idea->created_at->diffForHumans() }}</p>
            </div>

            @if($idea->description)
                <x-card class="mt-6">
                    <div class="text-foreground max-w-none cursor-pointer">{{$idea->description}}</div>
                </x-card>
            @endif

            @if($idea->steps->count())
               <div>
                    <h3 class="font-bold text-xl mt-6">
                        Steps                    
                    </h3>

                    <div class="mt-3 space-y-2">
                        @foreach ($idea->steps as $step )
                            <x-card >
                                <form method="POST" action="{{ route('step.update',$step) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="flex items-center gap-x-3">
                                        <button 
                                            type="submit"
                                            role="checkbox"
                                            class="
                                                size-5 
                                                flex items-center justify-center rounded-lg 
                                                text-primary-foreground 
                                                {{ $step->completed ? 'bg-primary' :'border border-primary' }}
                                                ">&check;</button>
                                        <span
                                            class="{{ $step->completed ? 'line-through text-muted-foreground' : 'text-foreground' }}">
                                            {{$step->description}}</span>
                                    </div>
                                </form>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($idea->links->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">
                        links 
                    </h3>

                    <div class="mt-3 space-y-2">
                        @foreach ($idea->links as $link )
                            <x-card :href="$link " class="text-primary font-medium flex gap-x-3 items-center">
                                <x-icons.external />
                                {{$link}}
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <x-idea.modal :idea="$idea" />
        
    </div>

</x-layout>

