<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Photo;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PhotoResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;


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
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->searchable(),
                TextColumn::make('tags')
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->limit(20)
                    ->searchable(),
                TextColumn::make('likes_count')->counts('likes')
                    ->label('Likes')
                    ->sortable(),
                ImageColumn::make('gambar')
                    ->searchable(),
                ToggleColumn::make('status')
                    ->label('Privacy')
                    ->onIcon('heroicon-s-eye')
                    ->offIcon('heroicon-s-lock-closed')
                    ->onColor('success')
                    ->offColor('danger'),
                TextColumn::make('created_at')
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
            'view' => Pages\ViewPhoto::route('/{record}'),
            'edit' => Pages\EditPhoto::route('/{record}/edit'),
        ];
    }
}
