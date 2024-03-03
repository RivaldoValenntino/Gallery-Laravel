@props([
    'user' => filament()->auth()->user(),
])

<x-filament::avatar
    :src="auth()->user()->avatar"
    :attributes="
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->class(['fi-user-avatar'])
    "
/>
