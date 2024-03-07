<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Photo;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PhotoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PhotoResource\Pages\EditPhoto;
use App\Filament\Resources\PhotoResource\Pages\ViewPhoto;
use App\Filament\Resources\PhotoResource\Pages\ListPhotos;
use App\Filament\Resources\PhotoResource\RelationManagers;
use App\Filament\Resources\PhotoResource\Pages\CreatePhoto;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';


    public static function canViewAny(): bool
    {
        return auth()->user()->roles == 'user';
    }
    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('slug', Str::slug($state));
                        }),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Photo::class, 'slug', ignoreRecord: true),
                    Textarea::make('deskripsi')
                        ->required()
                ->maxLength(150),
                    TagsInput::make('tags')
                        ->required()
                        ->columns(2),
                    Select::make('category_id')
                        ->relationship('categories', 'name') // 'categories' adalah nama relasi yang ditentukan di dalam model Photo, 'name' adalah kolom yang ingin ditampilkan dalam dropdown
                ->required() 
                        ->label('Category'),
                    Select::make('album_id')
                        ->options(fn () => auth()->user()->albums->pluck('nama_album', 'id'))
                    ->default(fn () => auth()->user()->albums->first()?->id)
                        ->label('Album'),
                    Hidden::make('user_id')
                        ->default(auth()->id()),
                    FileUpload::make('gambar')
                        ->required()
                        ->image()
                    ->optimize('jpg')
                        ->maxSize(2048)
                        ->label('Upload Photo')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/gif'])
                        ->directory('uploaded-photos')
                        ->disk('public'),
                    Toggle::make('status')
                        ->label('Status')
                        ->inline(false)
                        ->default(1)
                        ->onIcon('heroicon-s-eye')
                        ->offIcon('heroicon-s-lock-closed')
                        ->onColor('success')
                        ->offColor('danger'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();
        $user_id = $user->id;
        return $table
            ->modifyQueryUsing(function (Builder $query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tags')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->limit(20)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('gambar')
                    ->searchable(),
                ToggleColumn::make('status')
                    ->label('Privacy')
                    ->onIcon('heroicon-s-eye')
                    ->offIcon('heroicon-s-lock-closed')
                    ->onColor('success')
                    ->offColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make()->after(function (Collection $records) {
                //         foreach ($records as $key => $value) {
                //             if ($value->gambar) {
                //                 Storage::disk('public')->delete($value->gambar);
                //             }
                //         }
                //     }),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {

        return [
            'index' => Pages\ListPhotos::route('/'),
            'create' => Pages\CreatePhoto::route('/create'),
            'view' => Pages\ViewPhoto::route('/{record}', function (Photo $photo) {
                if ($photo->user_id !== Auth::id()) {
                    abort(403, 'Unauthorized');
                }
                return $photo;
            }),
            'edit' => Pages\EditPhoto::route('/{record}/edit', function (Photo $photo) {
                if ($photo->user_id !== Auth::id()) {
                    abort(403, 'Unauthorized');
                }
                return $photo;
            }),
        ];
    }
}