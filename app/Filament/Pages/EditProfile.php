<?php

namespace App\Filament\Pages;

use App\Models\User;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EditProfile extends Page
{
    use InteractsWithForms;

    public User $user;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.pages.edit-profile';

    protected static ?string $title = 'User Profile';


    public function mount(): void
    {
        $this->user = Auth::user();
        $this->data = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'username' => $this->user->username,
            'avatar' => $this->user->avatar
        ];
        $this->form->fill($this->data);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
             Section::make()->schema([TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('username')
                    ->required(),
                FileUpload::make('avatar')
                    ->image()
                    ->avatar()
                    ->default(auth()->user()->avatar)
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('profile-photos')
                    ->disk('public')
                    ->optimize('webp')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->maxSize(1024),
             ])
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->user = Auth::user();

        // Memeriksa keunikan email
        if ($data['email'] !== $this->user->email && User::where('email', $data['email'])->exists()) {
            throw ValidationException::withMessages(['email' => __('The email has already been taken')]);
        }


        // Memeriksa keunikan username
        if ($data['username'] !== $this->user->username && User::where('username', $data['username'])->exists()) {
            throw ValidationException::withMessages(['username' => __('The username has already been taken')]);
        }
        $this->user->update($data);

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }
}