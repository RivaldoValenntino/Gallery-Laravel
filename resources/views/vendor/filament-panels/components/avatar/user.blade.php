@props([
    'user' => filament()->auth()->user(),
])

@if(auth()->user()->avatar)
    <x-filament::avatar
        :src="auth()->user()->avatar"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->class(['fi-user-avatar'])
        "
    />
@else
     <x-filament::avatar
        :src="asset('logo/default-avatar.png')"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->class(['fi-user-avatar'])
        "
    />
@endif

