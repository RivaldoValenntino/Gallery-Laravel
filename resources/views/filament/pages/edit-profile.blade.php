<x-filament-panels::page>
<x-filament-panels::form wire:submit="save">
    @foreach ($this->form->getComponents() as $component)
        {{ $component->render() }}

        @if ($component instanceof \Filament\Forms\Components\TextInput)
            @if ($errors->has($component->getName()))
                <small style="color: #ef4444;">{{ $errors->first($component->getName()) }}</small>
            @endif
        @endif
    @endforeach

    <x-filament-panels::form.actions
        :actions="$this->getFormActions()"
    />
</x-filament-panels::form>
</x-filament-panels::page>