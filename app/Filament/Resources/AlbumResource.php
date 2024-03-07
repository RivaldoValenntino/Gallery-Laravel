<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Album;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AlbumResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AlbumResource\RelationManagers;
use App\Models\Photo;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\ToggleColumn;

class AlbumResource extends Resource
{
    protected static ?string $model = Album::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $title = 'Manage Album';

    protected static ?string $navigationLabel = 'Manage Album';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('nama_album')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set('slug', Str::slug($state));
                        }),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Album::class, 'slug', ignoreRecord: true),
                    Textarea::make('deskripsi')
                        ->label('Description')
                    ->maxLength(255)
                        ->required(),
                    FileUpload::make('cover')
                        ->label('Cover')
                        ->image()
                        ->required()
                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg'])
                        ->maxSize(1024)
                        ->disk('public')
                        ->optimize('webp')
                        ->directory('albums'),
                    Select::make('category_id')
                    ->relationship('category', 'name') // 'categories' adalah nama relasi yang ditentukan di dalam model Photo, 'name' adalah kolom yang ingin ditampilkan dalam dropdown
                    ->required()
                    ->label('Category'),
                    Toggle::make('status')
                        ->label('Status')
                        ->inline(false)
                        ->default(1)
                        ->onIcon('heroicon-s-eye')
                        ->offIcon('heroicon-s-lock-closed')
                        ->onColor('success')
                        ->offColor('danger'),
                    Hidden::make('user_id')
                        ->default(auth()->id()),
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
                TextColumn::make('nama_album')
                    ->label('Nama Album')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->searchable()
            ->limit(20)
                    ->sortable(),
                ToggleColumn::make('status')
                    ->onIcon('heroicon-s-eye')
                    ->offIcon('heroicon-s-lock-closed')
                    ->onColor('success')
                    ->offColor('danger'),
                ImageColumn::make('cover')
                    ->searchable(),
                TextColumn::make('photos_count')
                    ->label('Photos')
                    ->getStateUsing(fn (Album $record) => $record->photos->count()),
                // TextColumn::make('last_photo_created_at')
                // ->label('Last Photo Created At')
                // ->getStateUsing(fn (Album $record) => $record->photos->sortByDesc('created_at')->first()?->created_at),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlbums::route('/'),
            'create' => Pages\CreateAlbum::route('/create'),
            'view' => Pages\ViewAlbum::route('/{record}'),
            'edit' => Pages\EditAlbum::route('/{record}/edit'),
        ];
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
               ImageEntry::make('photos.gambar')
            ]);
    }
}