@props(['idea' => new \App\Models\Idea()])
<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
            <form 
                x-data="
                    { status: @js(old('status',$idea->status->value)),
                     newLink: '',
                     links: @js(old('links',$idea->links ?? [])),
                     newStep: '',
                     steps: @js(old('steps',$idea->steps->map->only(['id','description','completed'])))
                    }"
                method="POST" 
                action="{{ $idea->exists ? route('idea.update',$idea) : route('idea.store') }}"
                enctype="multipart/form-data"
                >
                @csrf

                @if ($idea->exists)
                    @method('PATCH')
                @endif

                <div class="space-y-6">
                    <x-form.field
                        label="Title"
                        name="title"
                        placeholder="Enter an idea for your title"
                        autofocus
                        required
                        :value="$idea->title"
                    />

                    <div class="space-y-2">
                        <label for="status" class="label">Status</label>
                        <div class="flex gap-x-3">
                            @foreach (App\IdeaStatus::cases() as $status)
                                <button
                                    type="button"
                                    @click.prevent="status = @js($status->value)"
                                    data-test="button-status-{{ $status->value }}"
                                    class="btn flex-1 h-10"
                                    :class="status === @js($status->value) ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground'"
                                >
                                    {{ $status->label() }}
                                </button>
                            @endforeach
                             <input type="hidden" name="status" x-model="status">

                        </div>

                            <x-form.error name="status"/>


                    </div>

                    <x-form.field
                        label="Description"
                        name="description"
                        type="textarea"
                        placeholder="Describe here your idea ...."
                        :value="$idea->description"

                    />

                    <div class="space-y-2">
                        <label for="image" class="label">Featured Image</label>
                        @if($idea->image_path)
                            <div class="space-y-2">
                                <img 
                                    src="{{ asset('storage/'.$idea->image_path) }}" 
                                    alt="Idea Image" 
                                    class="w-full h-48 object-cover rounded-lg">

                                <button 
                                    type="submit" 
                                    class="btn btn-outlined h-10 mt-2 w-full"
                                    form="delete-image-form"
                                    >
                                    Remove Image
                                </button>
                            </div>
                        @endif
                        <input type="file" name="image" accept="image" />
                        <x-form.error name="image" />
                    </div>

                     <div>
                        <fieldset class="space-y-3">
                            <legend class="label">Actionable Steps</legend>


                            <template x-for="(step, index) in steps" :key="step.id ?? `${index}-${step.description}`">
                                <div class="flex gap-x-3 items-center">
                                    <input :name="`steps[${index}][description]`" x-model="step.description" class="input"/>
                                    <input type="hidden" :name="`steps[${index}][completed]`" :value="step.completed ? '1' : '0'" class="input"/>

                                    <button 
                                    type="button"
                                    aria-label="Remove step"
                                    @click="steps.splice(index,1)"
                                    class="form-muted-icon"
                                    >
                                    <x-icons.close  />
                                </button>
                                </div>

                            </template>

                            <div class="flex gap-x-3 items-center">
                                <input 
                                    x-model="newStep"
                                    id="new-step" 
                                    data-test="new-step"
                                    placeholder="What is the next step" 
                                    class="input flex-1" 
                                    spellcheck="false"
                                    />
                                <button 
                                    type="button"
                                    class="btn btn-outlined"
                                    @click="
                                    steps.push({description: newStep.trim(),completed:false}); 
                                    newStep = '';
                                    "
                                    data-test="submit-new-step-button"
                                    :disabled="!newStep.trim()"
                                    aria-label="Add Step"
                                    class="form-muted-icon"

                                    >
                                    <x-icons.close class="rotate-45" />
                                </button>
                            </div>
                            
                        </fieldset>
                    </div>

                    <div>
                        <fieldset class="space-y-3">
                            <legend class="label">links</legend>


                            <template x-for="(link, index) in links" :key="link">
                                <div class="flex gap-x-3 items-center">
                                    <input name="links[]" x-model="link" class="input"/>

                                    <button 
                                    type="button"
                                    aria-label="Remove link"
                                    @click="links.splice(index,1)"
                                    class="form-muted-icon"
                                    >
                                    <x-icons.close  />
                                </button>
                                </div>

                            </template>

                            {{-- <legend class="label">links</legend> --}}
                            <div class="flex gap-x-3 items-center">
                                <input 
                                    x-model="newLink"
                                    type="url" 
                                    id="new-link" 
                                    data-test="new-link"
                                    placeholder="Enter a link" 
                                    autocomplete="url"
                                    class="input flex-1" 
                                    spellcheck="false"
                                    />
                                <button 
                                    type="button"
                                    class="btn btn-outlined"
                                    @click="links.push(newLink.trim());newLink = '';"
                                    data-test="submit-new-link-button"
                                    :disabled="!newLink.trim()"
                                    aria-label="Add link"
                                    class="form-muted-icon"

                                    >
                                    <x-icons.close class="rotate-45" />
                                </button>
                            </div>
                            
                        </fieldset>
                    </div>

                    <div class="flex justify-end gap-x-5 mt-4 pr-4">
                    <button type="button"  @click="$dispatch('close-modal')"
                            class="btn btn-outlined font-bold hover:text-red-500/70 hover:font-extrabold">
                        Cancel
                    </button>
                    <button type="submit" class="btn">{{$idea->exists ? 'Update' : 'Create'}}</button>
                </div>
                </div>

                


            </form>

            @if($idea->image_path)
                <form method="POST" action="{{ route('idea.image.destroy',$idea) }}" id="delete-image-form">
                    @csrf
                    @method('DELETE') 
                </form>
            @endif
            
        </x-modal>